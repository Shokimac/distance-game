import * as cdk from "aws-cdk-lib";
import * as ec2 from "aws-cdk-lib/aws-ec2";
import * as route53 from "aws-cdk-lib/aws-route53";
import * as route53_targets from "aws-cdk-lib/aws-route53-targets";
import * as elb from "aws-cdk-lib/aws-elasticloadbalancingv2";
import * as acm from "aws-cdk-lib/aws-certificatemanager";
import * as ec2_targets from "aws-cdk-lib/aws-elasticloadbalancingv2-targets";
import * as rds from "aws-cdk-lib/aws-rds";
import { version } from "process";

export class InfrastructureStack extends cdk.Stack {
	constructor(scope: cdk.App, id: string, props?: cdk.StackProps) {
		super(scope, id, props);

		// VPC定義
		const vpc = new ec2.Vpc(this, "distance", {
			ipAddresses: ec2.IpAddresses.cidr("10.0.0.0/16"),
			subnetConfiguration: [
				{
					cidrMask: 24,
					name: "public",
					subnetType: ec2.SubnetType.PUBLIC,
				},
				{
					cidrMask: 24,
					name: "private",
					subnetType: ec2.SubnetType.PRIVATE_ISOLATED,
				},
			],
			maxAzs: 2,
		});

		// Route53
		const hostedZone = route53.HostedZone.fromLookup(this, "HostedZone", {
			domainName: "d-game.net",
		});

		// ACM
		const certificate = new acm.Certificate(this, "dGameCertificate", {
			domainName: "d-game.net",
			validation: acm.CertificateValidation.fromDns(hostedZone),
		});

		const albSecurityGroup = new ec2.SecurityGroup(
			this,
			"dGameAlbSecurityGroup",
			{
				vpc,
				allowAllOutbound: true,
			}
		);

		// ELB
		const lb = new elb.ApplicationLoadBalancer(this, "dGameALB", {
			vpc,
			internetFacing: true,
			securityGroup: albSecurityGroup,
		});

		const listener = lb.addListener("Listener", {
			port: 443,
			certificates: [certificate],
		});

		new route53.ARecord(this, "AliasRecord", {
			zone: hostedZone,
			target: route53.RecordTarget.fromAlias(
				new route53_targets.LoadBalancerTarget(lb)
			),
		});

		// サーバー用セキュリティグループ
		const dGameAppSecurityGroup = new ec2.SecurityGroup(
			this,
			"dGameAppSecurityGroup",
			{
				vpc,
				description: "Allow ssh and https and http access to ec2 instances",
				allowAllOutbound: true,
			}
		);
		dGameAppSecurityGroup.addIngressRule(
			ec2.Peer.anyIpv4(),
			ec2.Port.tcp(22),
			"allow ssh access from the world"
		);
		dGameAppSecurityGroup.addIngressRule(
			albSecurityGroup,
			ec2.Port.tcp(80),
			"allow http access only ALB"
		);

		// EC2
		const cfnKeyPair = new ec2.CfnKeyPair(this, "dGameAppKeyPair", {
			keyName: "dgame-key-pair",
		});
		cfnKeyPair.applyRemovalPolicy(cdk.RemovalPolicy.DESTROY);

		new cdk.CfnOutput(this, "GetSSHKeyCommand", {
			value: `aws ssm get-parameter --name /ec2/keypair/${cfnKeyPair.getAtt(
				"KeyPairId"
			)} --region ${
				this.region
			} --with-decryption --query Parameter.Value --output text`,
		});

		const instance = new ec2.Instance(this, "dGameInstance", {
			vpc,
			vpcSubnets: { subnetType: ec2.SubnetType.PUBLIC },
			instanceType: ec2.InstanceType.of(
				ec2.InstanceClass.T3,
				ec2.InstanceSize.MICRO
			),
			machineImage: new ec2.AmazonLinuxImage({
				generation: ec2.AmazonLinuxGeneration.AMAZON_LINUX_2,
			}),
			securityGroup: dGameAppSecurityGroup,
			keyName: cdk.Token.asString(cfnKeyPair.ref),
		});

		// EIP
		const eip = new ec2.CfnEIP(this, "IP");
		new ec2.CfnEIPAssociation(this, "dGameEC2", {
			eip: eip.ref,
			instanceId: instance.instanceId,
		});

		listener.addTargets("Targets", {
			targets: [new ec2_targets.InstanceTarget(instance)],
			port: 80,
		});

		// RDS用セキュリティグループ
		const dGameRdsSecurityGroup = new ec2.SecurityGroup(
			this,
			"dGameRdsSecurityGroup",
			{
				vpc,
				description: "Allow db access from only app",
				allowAllOutbound: true,
			}
		);
		dGameRdsSecurityGroup.addIngressRule(
			dGameAppSecurityGroup,
			ec2.Port.tcp(3306),
			"allow mysql access from only ec2"
		);

		const rdsInstance = new rds.DatabaseInstance(this, "dGameRds", {
			databaseName: "dGameRds",
			engine: rds.DatabaseInstanceEngine.mysql({
				version: rds.MysqlEngineVersion.VER_8_0,
			}),
			instanceType: ec2.InstanceType.of(
				ec2.InstanceClass.T3,
				ec2.InstanceSize.MICRO
			),
			vpc,
			vpcSubnets: {
				subnetType: ec2.SubnetType.PRIVATE_ISOLATED,
			},
			securityGroups: [dGameRdsSecurityGroup],
			multiAz: false,
			credentials: rds.Credentials.fromGeneratedSecret("admin"),
		});
	}
}
