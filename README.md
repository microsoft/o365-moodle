# Moodle Plugins for Microsoft Services
*including* **Office 365** *and other Microsoft services*

This repo is where work on all Moodle plugins related to Microsoft services takes place. At designated intervals, updated versions of these plugins are pushed to individual repos and updated in the [moodle.org listings](https://moodle.org/plugins).

Currently the following plugins are developed here:

- [moodle-auth_oidc](https://github.com/Microsoft/moodle-auth_oidc)
- [moodle-block_microsoft](https://github.com/Microsoft/moodle-block_microsoft)
- [moodle-block_onenote](https://github.com/Microsoft/moodle-block_onenote)
- [moodle-filter_oembed](https://github.com/Microsoft/moodle-filter_oembed)
- [moodle-local_msaccount](https://github.com/Microsoft/moodle-local_msaccount)
- [moodle-local_o365](https://github.com/Microsoft/moodle-local_o365)
- [moodle-local_onenote](https://github.com/Microsoft/moodle-local_onenote)
- [moodle-assignfeedback_onenote](https://github.com/Microsoft/moodle-assignfeedback_onenote)
- [moodle-assignsubmission_onenote](https://github.com/Microsoft/moodle-assignsubmission_onenote)
- [moodle-repository_office365](https://github.com/Microsoft/moodle-repository_office365)
- [moodle-repository_onenote](https://github.com/Microsoft/moodle-repository_onenote)
- [moodle-profilefield_o365](https://github.com/Microsoft/moodle-profilefield_o365)
- [moodle-profilefield_oidc](https://github.com/Microsoft/moodle-profilefield_oidc)

The following plugins are "parent" plugins which install the above plugins as a collection:

- [moodle-local_office365](https://github.com/Microsoft/moodle-local_office365)
- [moodle-local_microsoftservices](https://github.com/Microsoft/moodle-local_microsoftservices)

# About this repository
The master branch of this repository contains the most up-to-date code. As issues are completed and new features are added, they are immediately added to master. Master should be fairly stable, however it is the absolute newest code and not intended for production systems. Periodically (about every two weeks), all completed issues are packaged into releases and added to the STABLE branches. You'll find a stable branch for each version of Moodle supported - MOODLE_27_STABLE would be for Moodle 2.7, for example. These branches contain production-ready, stable code.

# Installation
1. The file structure of this repository mimics that of a Moodle install, so the /auth/oidc folder in this repository would go in the /auth/oidc folder of your Moodle install, for example. Place each folder of this repository in your Moodle install according to the folder structure of this repository.
2. From the Moodle Administration block, expand Site Administration and click "Notifications".
3. Follow the on-screen instuctions to install each plugin.

# Documentation

The documentation for installing, configuring, and using these plugins is available here: https://docs.moodle.org/27/en/Office365.

# Contributing

Before we can accept your pull request, you'll need to electronically complete Microsoft's [Contributor License Agreement](https://cla.microsoft.com/). If you've done this for other Microsoft projects, then you're already covered.

[Why a CLA?](https://www.gnu.org/licenses/why-assign.html) (from the FSF)

# Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.
