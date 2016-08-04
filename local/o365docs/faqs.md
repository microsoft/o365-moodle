Frequently Asked Questions
==========================

1. How to I get Moodle to appear in the Office 365 app launcher?

Moodle will appear in a user's Office 365 app launcher if they are assigned to the application you created in Azure for Moodle. See the "Assign Users to your Azure Active Directory Application" section in setup. The integration local plugin also provides an option to automatically assign users to your Azure application. See "User Sync".

2. I got an "Error in API call" error message - what do I do?

If the error is reproducible, enable the "Record debug messages" settings in both OpenID Connect and the integration local plugin (Site Administration > Plugins > Authentication > OpenID Connect, and Site Administration > Plugins > Local plugins > Microsoft Office 365 Integration > Options tab > Advanced settings). Reproduce the error with these settings enabled, and view your Moodle logs (Click the "View recorded log messages" link next to the Record debug messages setting in the integration local plugin). If you see an entry for Office 365, the log item may provide information on what went wrong. If the problem is not clear, please open an issue in our GitHub repository (https://github.com/Microsoft/o365-moodle) and we'll take a look at it.

3. Where is the Microsoft block?

The Microsoft block is not added to a Moodle page automatically. Once installed, navigate to the Moodle page you want to add the block to and click the "Customise this page" button. Look for the "Add a block" block and choose "Microsoft" from the dropdown. The Microsoft block will be added to the current page and can be managed like any other Moodle block.
