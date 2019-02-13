# Shippify Plugin for Magento

In this repo you will find a back office integration of tools that enable merchants using Magento to ship orders through Shippify.

To test this module please clone the Magento environment in `https://github.com/shippify/docker-magento2`

# Installing Magento Shippify Module

- By Marketplace(Waiting for approval) 

- By Zip Module (Release section)

# How to Install Magento 2 Extension
  Step 1: Upload the extension to your Magento Server.
  
     https://github.com/shippify/shippify-magento-2/releases/tag/0.0.1-beta
  
  Step 2: Enter the following at the command line
  
     1 `bin/magento module:status` - This command shows a list of enabled/disabled modules.
     2 `bin/magento module:enable Shippify_ShippifyMagento` - Run this to enable the module.
     3 `bin/magento setup:upgrade` - This command will properly register the module with Magento.
     4 `bin/magento setup:di:compile` - This command compiles classes used in dependency injections.

## Development mode

Using the dockerized environment run the following comands to install:

  1 `bin/magento module:status` - This command shows a list of enabled/disabled modules.
  
  2 `bin/magento module:enable Shippify_ShippifyMagento` - Run this to enable the module.
  
  3 `bin/magento setup:upgrade` - This command will properly register the module with Magento.
  
  4 `bin/magento setup:di:compile` - This command compiles classes used in dependency injections.


# Collaborate

If you are collaborating with this repo. Please follow these suggested rules:
  - Fork this repo
  - Work in your own fork
  - Create commits with relevant information in the message
  - Create a pull request from your fork into this repo
  - Thanks for collaborating :)
