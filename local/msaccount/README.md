# Moodle Plugins for Microsoft Services
*including* **Office 365** *and other Microsoft services*

## Microsoft Account API Local Plugin

This plugin provides a simple client API for OAuth2-based authentication and token management for Microsoft Account. It also provides some helper functions for making REST API calls to services that use the Microsoft Account.

## Usage

Instantiation:
    $msaccountapi = \local_msaccount\api::getinstance();

Logging the user in:
        $msaccount_api->is_logged_in();

Making a REST API call:
        $response = $msaccount_api->myget($url);


## Design details

There are several parts that make up the Microsoft Account API plugin.

### Configuration
This allows an administrator to specify OAuth2 settings such as client id and secret for the Microsoft Account application associated with this Moodle installation.

### local_msaccount\api class
This is a singleton class that provides simple wrappers for various methods provided by the local_msaccount\client class. Please use this class for accessing all the functionality provided by the local_msaccount\client class.

### local_msaccount\client class
Note: Please do not use this class directly. Instead, use the local_msaccount\api class described above.

This class is derived from Moodle's oauth2_client class and:
- adds support for retrieving and saving refresh tokens and logging in using the refresh token if the main token expires.
- this also becomes useful for automated unit testing because we can use the refresh tokens to log users in automatically.
- works around an issue in the oauth2_client where it sets the token in the header only if it thinks that it is making a post request, but the Microsoft Account REST API needs auth token in the header for get as well as post requests.

This is part of the suite of Microsoft Services plugins for Moodle.

This repository is updated with stable releases. To follow active development, see: https://github.com/Microsoft/o365-moodle

## Installation

1. Unpack the plugin into /local/msaccount within your Moodle install.
2. From the Moodle Administration block, expand Site Administration and click "Notifications".
3. Follow the on-screen instuctions to install the plugin.

For more documentation, visit https://docs.moodle.org/34/en/Office365

For more information including support and instructions on how to contribute, please see: https://github.com/Microsoft/o365-moodle/blob/master/README.md

## Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.
