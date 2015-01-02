Microsoft Account API Local Plugin
==================================

TLDR
----

This plugin provides a simple client API for OAuth2-based authentication and token management for Microsoft Account. It also provides some helper functions for making REST API calls to services that use the Microsoft Account.


Usage
-----

Instantiation:
    $msaccountapi = msaccount_api::getinstance();

Logging the user in:    
        $msaccount_api->is_logged_in();

Making a REST API call:
        $response = $msaccount_api->myget($url);


Design details
--------------

There are several parts that make up the Microsoft Account API plugin.

### Configuration
This allows an administrator to specify OAuth2 settings such as client id and secret for the Microsoft Account application associated with this Moodle installation.

### msaccount_api class
This is a singleton class that provides simple wrappers for various methods provided by the msaccount_client class. Please use this class for accessing all the functionality provided by the msaccount_client class.

### msaccount_client class
Note: Please do not use this class directly. Instead, use the msaccount_api class described above.

This class is derived from Moodle's oauth2_client class and:
- adds support for retrieving and saving refresh tokens and logging in using the refresh token if the main token expires.
- this also becomes useful for automated unit testing because we can use the refresh tokens to log users in automatically.
- works around an issue in the oauth2_client where it sets the token in the header only if it thinks that it is making a post request, but the Microsoft Account REST API needs auth token in the header for get as well as post requests.
