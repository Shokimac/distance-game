import { Construct } from "constructs";
import * as cdk from "aws-cdk-lib";
import * as ec2 from "aws-cdk-lib/aws-ec2";
import * as iam from "aws-cdk-lib/aws-iam";
import * as rds from "aws-cdk-lib/aws-rds";

const VPC_CIDER = "192.168.0.0/16";

export class InfrastructureStack extends cdk.Stack {
	constructor(scope: Construct, id: string, props?: cdk.StackProps) {
		super(scope, id, props);

		const vpc = new ec2.Vpc(this, "DistanceGameVPC", {
			ipAddresses: ec2.IpAddresses.cidr(VPC_CIDER),
			vpcName: "distance-game-vpc",
			maxAzs: 2,
			subnetConfiguration: [
				{
					cidrMask: 24,
					name: "d-game-public-subnet",
					subnetType: ec2.SubnetType.PUBLIC,
				},
				{
					cidrMask: 24,
					name: "d-game-private-subnet",
					subnetType: ec2.SubnetType.PRIVATE_ISOLATED,
				},
			],
		});

		const ec2SecurityGroup = new ec2.SecurityGroup(this, "EC2SecurityGroup", {
			vpc: vpc,
			securityGroupName: "d-game-ec2-security-group",
		});

		ec2SecurityGroup.addIngressRule(
			ec2.Peer.anyIpv4(),
			ec2.Port.tcp(80),
			"Allow inbound HTTP"
		);
		ec2SecurityGroup.addIngressRule(
			ec2.Peer.anyIpv4(),
			ec2.Port.tcp(443),
			"Allow inbound HTTPS"
		);
		ec2SecurityGroup.addIngressRule(
			ec2.Peer.anyIpv4(),
			ec2.Port.tcp(22),
			"Allow ssh access from the world"
		);

		const instanceRole = new iam.Role(this, "DitstanceGameRole", {
			assumedBy: new iam.ServicePrincipal("ec2.amazonaws.com"),
			managedPolicies: [
				iam.ManagedPolicy.fromAwsManagedPolicyName(
					"AmazonSSMManagedInstanceCore"
				),
			],
			description: "distance-game-ec2-instance-role",
		});

		const createInstance = (
			id: string,
			name: string,
			subnet: ec2.SubnetSelection
		): ec2.Instance => {
			return new ec2.Instance(this, id, {
				vpc,
				vpcSubnets: subnet,
				instanceType: new ec2.InstanceType(
					this.node.tryGetContext("instanceType")
				),
				machineImage: ec2.MachineImage.latestAmazonLinux({
					generation: ec2.AmazonLinuxGeneration.AMAZON_LINUX_2,
				}),
				securityGroup: ec2SecurityGroup,
				role: instanceRole,
				instanceName: name,
			});
		};

		const ec2Instance = createInstance(
			"DistanceGameEC2",
			"distance-game-instance",
			vpc.selectSubnets({
				subnetType: ec2.SubnetType.PUBLIC,
			})
		);

		const rdsSubnetGroup = new rds.SubnetGroup(this, "d-game-rds-subnet", {
			description: "d-game rds subnetGroup",
			vpc,
			vpcSubnets: vpc.selectSubnets({
				subnetType: ec2.SubnetType.PRIVATE_ISOLATED,
			}),
		});

		const dbUser = "d_game_user";
		const dbName = "d_game_db";
		const rdsCredentials = rds.Credentials.fromGeneratedSecret(dbUser, {
			secretName: "/d-game/rds/",
		});

		const rdsSecutiryGroup = new ec2.SecurityGroup(this, "rds-secutiry-group", {
			vpc,
			securityGroupName: "d-game-rds-secutiry-group",
			allowAllOutbound: true,
		});

		rdsSecutiryGroup.addIngressRule(
			ec2SecurityGroup,
			ec2.Port.tcp(3306),
			"Allow 3306 access from EC2"
		);

		const rdsInstance = new rds.DatabaseInstance(this, "d-game-rds", {
			engine: rds.DatabaseInstanceEngine.MYSQL,
			credentials: rdsCredentials,
			databaseName: dbName,
			subnetGroup: rdsSubnetGroup,
			instanceType: ec2.InstanceType.of(
				ec2.InstanceClass.T2,
				ec2.InstanceSize.MICRO
			),
			vpc,
			publiclyAccessible: false,
			securityGroups: [rdsSecutiryGroup],
		});

		new cdk.CfnOutput(this, "VPC", { value: vpc.vpcId });
		new cdk.CfnOutput(this, "Security Group", {
			value: ec2SecurityGroup.securityGroupId,
		});
		new cdk.CfnOutput(this, "EC2Instance1", { value: ec2Instance.instanceId });
		new cdk.CfnOutput(this, "RDSInstance", { value: rdsInstance.instanceArn });
	}
}
