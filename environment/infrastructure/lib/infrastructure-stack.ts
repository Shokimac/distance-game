import { Construct } from "constructs";
import * as cdk from "aws-cdk-lib";
import * as ec2 from "aws-cdk-lib/aws-ec2";
import * as iam from "aws-cdk-lib/aws-iam";
// import * as sqs from 'aws-cdk-lib/aws-sqs';

export class InfrastructureStack extends cdk.Stack {
	constructor(scope: Construct, id: string, props?: cdk.StackProps) {
		super(scope, id, props);

		const vpc = new ec2.Vpc(this, "DistanceGameVPC", {
			ipAddresses: ec2.IpAddresses.cidr("10.0.0.0/16"),
			vpcName: "distance-game-vpc",
		});

		const securityGroup = new ec2.SecurityGroup(
			this,
			"DistanceGameSecurityGroup",
			{
				vpc: vpc,
				securityGroupName: "distance-game-security-group",
			}
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
				securityGroup,
				role: instanceRole,
				instanceName: name,
			});
		};

		const instance = createInstance(
			"DistanceGameEC2",
			"distance-game-instance",
			vpc.selectSubnets({
				subnetType: ec2.SubnetType.PUBLIC,
			})
		);

		new cdk.CfnOutput(this, "VPC", { value: vpc.vpcId });
		new cdk.CfnOutput(this, "Security Group", {
			value: securityGroup.securityGroupId,
		});
		new cdk.CfnOutput(this, "EC2Instance1", { value: instance.instanceId });

		// The code that defines your stack goes here

		// example resource
		// const queue = new sqs.Queue(this, 'InfrastructureQueue', {
		//   visibilityTimeout: cdk.Duration.seconds(300)
		// });
	}
}
