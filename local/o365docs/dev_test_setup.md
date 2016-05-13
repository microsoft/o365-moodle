Instructions for setting up a Moodle deployment including the Office 365 plugins
================================================================================

This document describes how to deploy Moodle and the Office 365 plugins quickly and easily on Microsoft Azure using an Azure Resource Manager (ARM) template.

* Azure Resource Manager (ARM) templates are declarative templates written in JSON that can be used to quickly create entire deployments consisting of VM's, databases, load balancers, network configuration etc.
* We have developed ARM templates for single VM as well as clustered deployments of Moodle that you can use to create development or test setups quickly.
* You need to have an Azure subscription to create these deployments. If you don't already have a subscription, you can get a free trial subscription here: https://azure.microsoft.com/en-us/pricing/free-trial/
* Go to the appropriate template on Github:
    * To create a single VM deployment on Ubuntu, go to https://github.com/Azure/azure-quickstart-templates/tree/master/moodle-singlevm-ubuntu
    * To create a clustered deployment on Ubuntu, go to https://github.com/Azure/azure-quickstart-templates/tree/master/moodle-cluster-ubuntu
* The readme describes the layout of the deployment that will be created and additional services you can set up after the deployment is done.
* Click on the "Deploy to Azure" button in the readme
* This will take you to the Azure portal with the template ready to be customized and deployed.
* You will need to enter the required parameters, specify a resource group, accept the legal terms, and start your deployment.
* When the deployment is complete, Moodle will already be set up with the Office 365 plugins (if selected).
