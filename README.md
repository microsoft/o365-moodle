# Office 365 and Azure Active Directory Plugins for Moodle
*includes support for* **Office 365 Education**, **Office 365 Enterprise** *and* **Azure Active Directory**

This repo is where development on all Office 365 and Azure Active Directory plugins for Moodle takes place. After every release, updated versions of these plugins are pushed to the [Office 365 plugin set](https://moodle.org/plugins/browse.php?list=set&id=72) available in the [Moodle plugins directory.](https://moodle.org/plugins)

The following plugins are **actively maintained and required** for new installations and provide the core functionality of the integration:

- [moodle-auth_oidc](https://github.com/Microsoft/moodle-auth_oidc)
- [moodle-local_o365](https://github.com/Microsoft/moodle-local_o365)
- [moodle-block_microsoft](https://github.com/Microsoft/moodle-block_microsoft)
- [moodle-repository_office365](https://github.com/Microsoft/moodle-repository_office365)

The plugins below are *optional* for new installations:

- [moodle-filter_oembed](https://github.com/PoetOS/moodle-filter_oembed)
- [moodle-block_skypeweb](https://github.com/Microsoft/moodle-block_skypeweb)

### Supported Moodle versions
The plugins currently support Moodle 2.7 through 3.4. Support for newer releases of Moodle typically comes a few weeks after the release.

### How this repository is structured
The master branch of this repository contains the most up-to-date code. As issues are completed and new features are added, they are immediately added to master. Master should be fairly stable, however it is the absolute newest code and not intended for production systems. Periodically completed issues are packaged into releases and added to the STABLE branches. You'll find a stable branch for each version of Moodle supported - MOODLE_27_STABLE would be for Moodle 2.7, for example. These branches contain production-ready, stable code.

## Installation of the plugins
You can find informations on how to install Moodle plugins [here](https://docs.moodle.org/34/en/Installing_plugins). The simplest option is to install directly from the Moodle plugins directory. You can find all the plugins required for the installation in the [Office 365 plugin set](https://moodle.org/plugins/browse.php?list=set&id=72).

Alternatively you might choose to manually install the plugins from Github. If doing so please note the following:

1. The file structure of this repository mimics that of a Moodle install, so the /auth/oidc folder in this repository would go in the /auth/oidc folder of your Moodle install, for example. Place each folder of this repository in your Moodle install according to the folder structure of this repository.
2. From the Moodle Administration block, expand Site Administration and click "Notifications".
3. Follow the on-screen instuctions to install each plugin.

## Documentation
The documentation for installing, configuring, and using these plugins is available here: https://docs.moodle.org/34/en/Office365.
You can submit changes to the documentation at any time here: https://github.com/Microsoft/o365-moodle/tree/master/local/o365docs

## Support
We do not provide any SLA on the use of these plugins.  If you are experiencing problems, have a feature request, or have a question, please open an issue on Github at https://github.com/Microsoft/o365-moodle.

## Reporting Issues
To help the community triage and debug problems, please include the following in all issues:
- Plugin versions.
- Moodle version.
- PHP version.
- Database software and versions.
- Detailed instructions of what went wrong and how to reproduce the problem. (Screenshots are always helpful!)
- Any error messages encountered and recorded debug messages

Please note that without this information it is often impossible for us to fully investigate your issue. 

## Contributing
We're looking for community contributions! Feel free to submit pull requests, but please do so against the development repository at https://github.com/Microsoft/o365-moodle. Pull requests submitted to individual plugin repositories cannot be accepted.

Please be sure to submit an issue via the Github Issue Tracker before working on any pull requests.

### Needed Contributions
Smaller issues that developers cannot address right away will be labeled with "Help Wanted" in the issue tracker in the development repository at https://github.com/Microsoft/o365-moodle/issues. These are only suggestions - we can also accept pull requests fixing other bugs, or even adding new features.

Pull requests adding new features are much appreciated but note that they may be rejected (even if technically sound) if they do not match the direction of the project. If you want to add a new feature, it's best to open an issue outlining your idea first, and get feedback from the maintainers.

Contributions to our documentation are especially appreciated! All documentation lives in the /local/o365docs folder of the development repository (https://github.com/Microsoft/o365-moodle). Updates to this documentation can be sent via pull request like any other contributions.

### Code Review
All pull requests go through a thorough examination from maintainers before they are merged. Please read our [development guide](https://github.com/Microsoft/o365-moodle/blob/master/local/o365docs/devguide.md) and ensure your code adheres to the coding standard before submitting. A maintainer may respond with changes that are needed before a pull request can be accepted and it is up to the submitter to make those changes. If accepted, your commit will remain as-is to ensure you get credit, but maintainers may modify solutions slightly in subsequent commits.

### CLA
Finally, before we can accept your pull request, you'll need to electronically complete Microsoft's [Contributor License Agreement](https://cla.microsoft.com/). If you've done this for other Microsoft projects, then you're already covered.

[Why a CLA?](https://www.gnu.org/licenses/why-assign.html) (from the FSF)

# Code of Conduct
This project has adopted the [Microsoft Open Source Code of Conduct](https://opensource.microsoft.com/codeofconduct/). For more information see the [Code of Conduct FAQ](https://opensource.microsoft.com/codeofconduct/faq/) or contact [opencode@microsoft.com](mailto:opencode@microsoft.com) with any additional questions or comments.

# Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.
