# Office 365 Plugins for Moodle
*includes support for* **Office 365 Education**, **Office 365 Enterprise** *and* **Active Directory**

This repo is where development on all Office 365 plugins for Moodle takes place. At designated intervals, updated versions of these plugins are pushed to individual repos and updated in the [moodle.org listings](https://moodle.org/plugins).

Currently the following plugins are **actively maintained and required** for new installations and provide the core functionality of the integration:

- [moodle-auth_oidc](https://github.com/Microsoft/moodle-auth_oidc)
- [moodle-local_o365](https://github.com/Microsoft/moodle-local_o365)
- [moodle-block_microsoft](https://github.com/Microsoft/moodle-block_microsoft)
- [moodle-repository_office365](https://github.com/Microsoft/moodle-repository_office365)
- [moodle-filter_oembed](https://github.com/PoetOS/moodle-filter_oembed)

The plugins below are *optional* for new installations:

- [moodle-block_skypeweb](https://github.com/Microsoft/moodle-block_skypeweb)
- [moodle-assignfeedback_onenote](https://github.com/Microsoft/moodle-assignfeedback_onenote)
- [moodle-local_onenote](https://github.com/Microsoft/moodle-local_onenote)
- [moodle-assignsubmission_onenote](https://github.com/Microsoft/moodle-assignsubmission_onenote)

The plugins below are *deprecated* and not maintained. They are here only for historical purposes.

- [moodle-profilefield_oidc](https://github.com/Microsoft/moodle-profilefield_oidc)
- [moodle-local_msaccount](https://github.com/Microsoft/moodle-local_msaccount)
- [moodle-block_onenote](https://github.com/Microsoft/moodle-block_onenote)
- [moodle-repository_onenote](https://github.com/Microsoft/moodle-repository_onenote)

The following plugins are "parent" or "shell" plugins which install a *subset* of the above plugins as a collection. They are also *not required* for new installations:
- [moodle-local_office365](https://github.com/Microsoft/moodle-local_office365)
- [moodle-local_microsoftservices](https://github.com/Microsoft/moodle-local_microsoftservices)

# About this repository
The master branch of this repository contains the most up-to-date code. As issues are completed and new features are added, they are immediately added to master. Master should be fairly stable, however it is the absolute newest code and not intended for production systems. Periodically (about every two weeks), all completed issues are packaged into releases and added to the STABLE branches. You'll find a stable branch for each version of Moodle supported - MOODLE_27_STABLE would be for Moodle 2.7, for example. These branches contain production-ready, stable code.

# Installation
1. The file structure of this repository mimics that of a Moodle install, so the /auth/oidc folder in this repository would go in the /auth/oidc folder of your Moodle install, for example. Place each folder of this repository in your Moodle install according to the folder structure of this repository.
2. From the Moodle Administration block, expand Site Administration and click "Notifications".
3. Follow the on-screen instuctions to install each plugin.

# Documentation

The documentation for installing, configuring, and using these plugins is available here: https://docs.moodle.org/30/en/Office365.
You can submit changes to the documentation at any time here: https://github.com/Microsoft/o365-moodle/tree/master/local/o365docs

# Contributing
Please be sure to submit an issue via the Github Issue Tracker before working on any pull requests.

Before we can accept your pull request, you'll need to electronically complete Microsoft's [Contributor License Agreement](https://cla.microsoft.com/). If you've done this for other Microsoft projects, then you're already covered.

[Why a CLA?](https://www.gnu.org/licenses/why-assign.html) (from the FSF)

# Code of Conduct
This project has adopted the [Microsoft Open Source Code of Conduct](https://opensource.microsoft.com/codeofconduct/). For more information see the [Code of Conduct FAQ](https://opensource.microsoft.com/codeofconduct/faq/) or contact [opencode@microsoft.com](mailto:opencode@microsoft.com) with any additional questions or comments.

# Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.
