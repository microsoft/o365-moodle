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

For more documentation, visit https://docs.moodle.org/30/en/Office365

## Support

If you are experiencing problems, have a feature request, or have a question, please open an issue on Github at https://github.com/Microsoft/o365-moodle.

To help developers debug problems, please include the following in all issues:
- Plugin versions.
- Moodle version.
- Detailed instructions of what went wrong and how to reproduce the problem.
- Any error messages encountered.
- PHP version.
- Database software and versions.
- Any other environmental information available.

Note that developers will triage issues and deal with more serious problems first. All issues will be addressed but some may not be addressed immediately.

## Contributing

We're looking for community contributions! Feel free to submit pull requests, but please do so against the development repository at https://github.com/Microsoft/o365-moodle. Pull requests submitted to individual plugin repositories cannot be accepted.

### Needed Contributions
Smaller issues that developers cannot address right away will be labeled with "Help Wanted" in the issue tracker in the development repository at https://github.com/Microsoft/o365-moodle/issues. These are only suggestions - we can also accept pull requests fixing other bugs, or even adding new features.

Pull requests adding new features are much appreciated but note that they may be rejected (even if technically sound) if they do not match the direction of the project. If you want to add a new feature, it's best to open an issue outlining your idea first, and get feedback from the maintainers.

Contributions to our documentation are especially appreciated! All documentation lives in the /local/o365docs folder of the development repository (https://github.com/Microsoft/o365-moodle). Updates to this documentation can be sent via pull request like any other contributions.

### Code Review
All pull requests go through a thorough examination from developers before they are merged. Please read our [code review process](https://github.com/Microsoft/o365-moodle/tree/master/local/o365docs/codereview.md) and ensure your code is consistent before submitting. A developer may respond with changes that are needed before a pull request can be accepted and it is up to the submitter to make those changes. If accepted, your commit will remain as-is to ensure you get credit, but developers may modify solutions slightly in subsequent commits.

### CLA
Finally, before we can accept your pull request, you'll need to electronically complete Microsoft's [Contributor License Agreement](https://cla.microsoft.com/). If you've done this for other Microsoft projects, then you're already covered.

[Why a CLA?](https://www.gnu.org/licenses/why-assign.html) (from the FSF)

## Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.
