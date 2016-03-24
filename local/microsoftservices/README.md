# Moodle Plugins for Microsoft Services
*including* **Office 365** *and other Microsoft services*

## Microsoft Services Local Plugin

This plugin is a shell plugin that has dependencies on all Microsoft Services plugins. This helps keep related plugins together.

This plugin requires all Microsoft Services plugins:
  - [moodle-block_microsoft](https://github.com/Microsoft/moodle-block_microsoft)
  - [moodle-local_msaccount](https://github.com/Microsoft/moodle-local_msaccount)
  - [moodle-local_onenote](https://github.com/Microsoft/moodle-local_onenote)
  - [moodle-assignfeedback_onenote](https://github.com/Microsoft/moodle-assignfeedback_onenote)
  - [moodle-assignsubmission_onenote](https://github.com/Microsoft/moodle-assignsubmission_onenote)
  - [moodle-repository_onenote](https://github.com/Microsoft/moodle-repository_onenote)
  - [moodle-filter_oembed](https://github.com/Microsoft/moodle-filter_oembed)

This is part of the suite of Microsoft Services plugins for Moodle.

This repository is updated with stable releases. To follow active development, see: https://github.com/Microsoft/o365-moodle

## Installation.

1. Unpack the plugin into /local/microsoftservices within your Moodle install.
2. From the Moodle Administration block, expand Site Administration and click "Notifications".
3. Follow the on-screen instuctions to attempt to install the plugins.
4. You'll see a list of missing dependencies needed to complete the installation. Each of these is also available from Github at the links above. Install each of the dependencies. When complete, you'll have the entire set of plugins installed and this plugin's install can complete.

For more documentation, visit https://docs.moodle.org/30/en/Office365

# Contributing

Before we can accept your pull request, you'll need to electronically complete Microsoft's [Contributor License Agreement](https://cla.microsoft.com/). If you've done this for other Microsoft projects, then you're already covered.

[Why a CLA?](https://www.gnu.org/licenses/why-assign.html) (from the FSF)

# Copyright

&copy; Microsoft, Inc.  Code for this plugin is licensed under the GPLv3 license.

Any Microsoft trademarks and logos included in these plugins are property of Microsoft and should not be reused, redistributed, modified, repurposed, or otherwise altered or used outside of this plugin.