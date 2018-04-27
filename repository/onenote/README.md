# Moodle Plugins for Microsoft Services
*including* **Office 365** *and other Microsoft services*

## Microsoft OneNote Repository Plugin

This plugin allows the user to browse their OneNote Online content, such as notebooks, sections, and pages using the Moodle file picker UI. It also allows them to download the content of their OneNote page. It uses the Microsoft OneNote API Local plugin to do some of these things.

## Design details

### Basic design
This plugin uses the API exposed by the Microsoft OneNote API local plugin for logging in, getting the list of notebooks, sections, and pages; and also for downloading the page when needed.

### Plugin dependencies
repository_onenote => local_onenote => local_msaccount

### Configuration
None. This plugin depends upon the Microsoft Account local plugin to be configured for accessing the appropriate Microsoft Live application.


This is part of the suite of Microsoft Services plugins for Moodle.

This repository is updated with stable releases. To follow active development, see: https://github.com/Microsoft/o365-moodle

## Installation

1. Unpack the plugin into /repository/onenote within your Moodle install.
2. From the Moodle Administration block, expand Site Administration and click "Notifications".
3. Follow the on-screen instuctions to install the plugin.

For more documentation, visit https://docs.moodle.org/34/en/Office365

For more information including support and instructions on how to contribute, please see: https://github.com/Microsoft/o365-moodle/blob/master/README.md

# Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.
