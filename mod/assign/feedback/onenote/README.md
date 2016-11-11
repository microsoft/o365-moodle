# Moodle Plugins for Microsoft Services
*including* **Office 365** *and other Microsoft services*

## Microsoft OneNote Assignment Feedback Plugin

This plugin provides the functionality related to teachers grading and providing feedback for OneNote assignment submissions. This includes viewing a student's submission in OneNote, creating a OneNote page associated with their feedback on the submission, saving that feedback from OneNote into Moodle as a zip package containing the HTML and any associated images contained in the submission, and recreating the OneNote page from the zip package saved in Moodle if necessary. It uses the Microsoft OneNote API Local plugin to do some of these things.


## Design details

### Basic design
This plugin follows a design similar to the File feedback plugin wherever possible. It uses the API exposed by the local_onenote plugin to perform most of the OneNote-related operations.
Note that the association between an assignment grade in Moodle and the associated feedback OneNote page is loose i.e. the OneNote page may get deleted and it will not affect Moodle since it keeps a copy of the page in a zip package and can always recreate the OneNote page from it.

### Use cases supported
- When a teacher wants to start grading an assignment which allows OneNote submissions, they click on a button in the plugin UI that creates a OneNote page for their feedback using the assignment submission zip package that was submitted by the student via Moodle. Thus, the feedback page starts out looking like a copy of the student's submission and the teacher can add their own annotations either on top of the submission or appending to it.
- When the teacher wants to save their feedback back in Moodle, they click on a save button in the plugin UI, which results in this plugin downloading the content of the OneNote page, including the HTML and any associated images and zipping them up as a single file and saving it in the Moodle database.
- If the OneNote page associated with an assignment feedback gets deleted, the teacher can still click one a button in the plugin UI that will recreate the OneNote page from the zip package that was saved in Moodle.

### Plugin dependencies
assignfeedback_onenote => local_onenote => local_msaccount

### Configuration
This plugin adds a radio button to the assignment creation form that allows a teacher to specify that the teacher may provide feedback on the assignment submission as a OneNote page.


This is part of the suite of Microsoft Services plugins for Moodle.

This repository is updated with stable releases. To follow active development, see: https://github.com/Microsoft/o365-moodle

## Installation

1. Unpack the plugin into /mod/assign/feedback/onenote within your Moodle install.
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
