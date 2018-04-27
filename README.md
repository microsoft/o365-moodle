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
The documentation for installing, configuring, and using these plugins is available here: https://docs.moodle.org/34/en/Office365.
You can submit changes to the documentation at any time here: https://github.com/Microsoft/o365-moodle/tree/master/local/o365docs

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

Please be sure to submit an issue via the Github Issue Tracker before working on any pull requests.

### Needed Contributions
Smaller issues that developers cannot address right away will be labeled with "Help Wanted" in the issue tracker in the development repository at https://github.com/Microsoft/o365-moodle/issues. These are only suggestions - we can also accept pull requests fixing other bugs, or even adding new features.

Pull requests adding new features are much appreciated but note that they may be rejected (even if technically sound) if they do not match the direction of the project. If you want to add a new feature, it's best to open an issue outlining your idea first, and get feedback from the maintainers.

Contributions to our documentation are especially appreciated! All documentation lives in the /local/o365docs folder of the development repository (https://github.com/Microsoft/o365-moodle). Updates to this documentation can be sent via pull request like any other contributions.

### Code Review
All pull requests go through a thorough examination from developers before they are merged. Please read our [code review process](https://github.com/Microsoft/o365-moodle/tree/master/local/o365docs/codereview.md) and ensure your code is consistent before submitting. A developer may respond with changes that are needed before a pull request can be accepted and it is up to the submitter to make those changes. If accepted, your commit will remain as-is to ensure you get credit, but developers may modify solutions slightly in subsequent commits.

### CLA
Finally, before we can accept your pull request, you'll need to electronically complete Microsoft's [Contributor License Agreement](https://cla.microsoft.com/). If you've done this for other Microsoft projects, then you're already covered.

[Why a CLA?](https://www.gnu.org/licenses/why-assign.html) (from the FSF)

# Code of Conduct
This project has adopted the [Microsoft Open Source Code of Conduct](https://opensource.microsoft.com/codeofconduct/). For more information see the [Code of Conduct FAQ](https://opensource.microsoft.com/codeofconduct/faq/) or contact [opencode@microsoft.com](mailto:opencode@microsoft.com) with any additional questions or comments.

# Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.
