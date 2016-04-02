Office 365 Integration Local Plugin
===================================

Settings
--------

#### Health Check

If you are experiencing problems with any Office 365 / Moodle features, click the **Health Check** link to run tests on your system and look for potential problems.

#### User Matching

This is a tool that allows an administrator to link Moodle and Office 365 users by uploading a CSV containing Moodle usernames and Office 365 usernames.

#### Maintenance Tools

This link provides access to various tools that can help automatically solve problems with your integration. Do not run these tools unless you are familiar with the effects, or are instructed by a developer or support technician.

#### Sync users with Azure AD

This controls how users are synced from Azure AD to Moodle. This can create or delete users in Moodle, match them with Azure users, and assign them to Azure applications. See the [User Sync](#user-sync) section below for more information.

#### User Creation Restriction

During user sync, by default, all users from Azure AD will be created in Moodle. This setting allows you to set a required field and value that a user must have in Azure to have an account created in Moodle. For example, if you wanted to only have users from the "IT" department syncing into Moodle, you would choose the "Department" field, and enter "IT".

#### User Field Mapping

This controls how information is synced from Azure AD to Moodle. The first column lists Azure fields, the second column lists Moodle fields, and the third column controls when information is synced. To create mappings:

1.  Click "Add Mapping"
2.  In the row that appears, select an Azure field to bring into Moodle.
3.  In the second column on the same row, select a Moodle field to copy the value into.
4.  In the third colum on the same row, choose whether this only happens on user creation, on user login, or both.
5.  Click "Save Changes" at the bottom of the page.

To Delete A Mapping

1.  Click the "X" button at the end of the row you want to delete.
2.  Click "Save changes" at the bottom of the page.
3.  Note this will only prevent future information syncing, it will not undo past operations.

#### Office 365 for China

Office 365 in China differs slightly in some technical aspects. If you are using Office 365 for China, select this box to ensure everything will work properly.

#### Enable Microsoft Graph API

The Microsoft Graph API is a new API that provides some new features like the "Create user groups" setting below. It will eventually replace the existing Office APIs, however some features used are still in preview and are subject to change without notice, which may break some functionality.

To enable the Microsoft Graph API:

1.  Enable this setting and click "Save changes" at the bottom of the page.
2.  Add the "Microsoft Graph" to your application in Azure.
3.  Return to Moodle and to this plugin's settings page.
4.  Run the "Azure Setup" tool.

#### Create User Groups

-   See the [Office365\#User\_Groups](Office365#User_Groups "wikilink") section below.

#### Record debug messages

If you experience problems using any Office 365 features in Moodle, enable this setting. Once enabled, errors will be recorded to the Moodle log for review. These errors can help you or the plugin developers debug and fix the problem. The error log can be viewed by navigating to Site Administation \> Reports \> Logs, changing the "All activities" select box to "Site errors", and clicking "Get these logs".


Calendar sync
-------------

This feature allows users to sync their Moodle calendars with Office 365. Users can have events in their Moodle calendar appear in any Office 365 calendar, and have events created in Office 365 synced back to Moodle.

To use this feature:

1.  Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
2.  As a user connected to Office 365, visit a page where the Microsoft block is visible.
3.  Click the "Configure Outlook sync" link in the Microsoft block.
4.  From here, you should see a list of your available Moodle calendars. Click the checkmark next to the ones you'd like to sync.
    1.  ![Calendar sync selection page](images/localo365calsyncindex.png "fig:Calendar sync selection page")
    2.  By default, the calendars will sync with your Office 365 "primary" calendar. You can choose a different calendar to sync with using the "Sync with" select box.
    3.  ![Calendar sync options](images/localo365calsynccalselected.png "fig:Calendar sync options")

5.  You can also choose to sync from Office 365 in to Moodle (or both from Moodle to Office 365 and from Office 365 to Moodle). This is done using the "Sync behavior" select box.
6.  Once you're subscribed to a calendar, wait for the site's cron function to run to sync older calendar events. However, new events should sync right away.


User sync
---------

Users from AzureAD can be automatically created in Moodle using the user sync option. This creates a Moodle account for every user in the connected Active Directory allowing you to manage and enrol users in Moodle without the user having to log in first. When the user does log in using the OpenID Connect authentication plugin and their Office 365 account, they will be logged in to the account created for them during the user sync.

**To enable:**

1.  Visit the plugin's settings page (Site Administration \> Plugins \> Local plugins \> Microsoft Office 365 Integration).
2.  Under the "Options" section, look for the "Sync users from AzureAD" setting.
3.  Check the checkbox beside each user sync option that you want to use.
4.  Click Save Changes.
5.  Run the Moodle cron to run the user sync process.

**Notes:**

-   The sync job runs in the Moodle cron, and syncs 1000 users at a time.
-   By default, this runs once per day at 1:00 AM in the time zone local to your server.
-   To sync large sets of users more quickly, you can increase the freqency of the Sync users with Azure AD task using the Scheduled tasks management page. See [Scheduled\_tasks](Scheduled_tasks "wikilink").

There are four options that affect user sync:

##### Create accounts in Moodle for users in Azure AD

This will create users in Moodle from each user in the linked Azure Active Directory. Only users which do not currently have Moodle accounts will have accounts created. New accounts will be set up to use their Office 365 credentials to log in to Moodle (using the OpenID Connect authentication plugin), and will be able to use all the features of the Office 365 plugin set.

##### Delete previously synced accounts in Moodle when they are deleted from Azure AD

This will delete users from Moodle if they are marked as deleted in Azure AD. The Moodle account will be deleted and all associated user information will be removed from Moodle. Be careful!

##### Match preexisting Moodle users with same-named accounts in Azure AD

This will look at the each user in the linked Azure Active Directory and try to match them with a user in Moodle. This looks for matching usernames in Azure AD and Moodle. Matches are case-insentitive and ignore the Office 365 tenant. For example, "BoB.SmiTh" in Moodle would match "bob.smith@example.onmicrosoft.com". Users who are matched will have their Moodle and Office accounts connected and will be able to use all Office 365/Moodle integration features. The user's authentication method will not change unless the setting below is enabled.

##### Switch matched users to Office 365 (OpenID Connect) authentication

This requires the "Match" setting above to be enabled. When a user is matched, enabling this setting will switch their authentication method to OpenID Connect. They will then log in to Moodle with their Office 365 credentials. Note: Please ensure the OpenID Connect authentication plugin is enabled if you want to use this setting.


SharePoint Connection
---------------------

SharePoint sites can be created for each course on your Moodle site. You will provide a parent SharePoint site and subsites for each course will be automatically created. The document library for each of these subsites can then be accessed by teachers using the OneDrive for Business repository. This provides a shared store of files for a course, allowing teachers to collaborate on documents and share resources.

-   Any AzureAD-connected Moodle user with the **moodle/course:managefiles** capability in a course will be able to access the document library from the repository.

### Setting up the SharePoint connection

1.  Visit the plugin's settings page (Site Administration \> Plugins \> Local plugins \> Microsoft Office 365 Integration).
2.  Under the **Setup** section, look for the **SharePoint Link** setting.
3.  Type in the URL of the parent SharePoint site you'd like to use for the course subsites.
    1.  This should be the entire URL to the SharePoint site - for example: **<https://contoso.sharepoint.com/moodle>**.
    2.  This site must be accessible to the **System API user**

4.  When you are done typing in the URL, the URL will be checked for suitability.
    1.  If the valid is invalid, you will see a red box and the text "This is not a usable SharePoint site."
    2.  If the site already exists, you will see a blue box and the text "This site is usable, but already exists". You can use this site, but conflicts can arise. It's recommended to use a URL to a SharePoint site that doesn't yet exist. The site will be created during initialization.
    3.  If the site does not exist but can be created, you will see a green box and the text "This SharePoint site will be created by Moodle and used for Moodle content.". This SharePoint site will be created by Moodle during initialization.

5.  Click **Save changes** at the bottom of the settings page.
6.  You will see a spinning icon below the SharePoint Link setting, and the text "Moodle is setting up this SharePoint site.". **This will not automatically update - refresh the page to check if the connection has been set up.**.
7.  The SharePoint Link is set up during the Moodle cron, so ensure your Moodle cron is set up and running.


User Groups
-----------

User groups provide an easy way to share documents will all users of a course. For example, a teacher can share a document from OneDrive with all of their students by choosing the user group for their course - they don't have to choose each student individually.

You can have groups created and maintained automatically in Office 365 by enabling the "Create User Groups" setting. Once enabled, new groups will be created every cron run for any course that doesn't have a group set up. Once groups are set up, membership will be maintained automatically whenever someone joins or leaves a Moodle course.

To setup navigate to Site administration / Plugins / Local plugins / Microsoft Office 365 Integration and check "Create User Groups" in the Options section.
