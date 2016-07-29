Microsoft Office 365 Integration Local Plugin
=============================================
This plugin contains several configuration options and can be located under **Site Administration \> Plugins \> Local plugins**. It is organized into three tabs:

1.  **Setup**. Configuration settings are outlined under the Setup section.
2.  **Options** Contains various configuration options. Includes:
	1. User Sync
	2. Integration Settings
	3. Advanced Settings
3.  **Tools**
	1. Health Check
	2. User Matching Tool

User Sync
---------
This controls how users are synced from Azure AD to Moodle. This can create or delete users in Moodle, match them with Azure Active Directory users, and assign them to Azure Active Directory applications.

#### Sync users with Azure AD

Users from Azure AD can be automatically created in Moodle using the user sync option. This creates a Moodle account for every user in the connected Active Directory allowing you to manage and enrol users in Moodle without the user having to log in first. When the user does log in using the OpenID Connect authentication plugin and their Office 365 account, they will be logged in to the account created for them during the user sync.

**To enable:**

1. Check the checkbox beside each user sync option that you want to use.
2. Click Save Changes.
3. Run the Moodle cron to run the user sync process.

**Notes:**

-   The sync job runs in the Moodle cron, and syncs 1000 users at a time.
-   By default, this runs once per day at 1:00 AM in the time zone local to your server.
-   To sync large sets of users more quickly, you can increase the frequency of the Sync users with Azure AD task using the Scheduled tasks management page. See [Scheduled\_tasks](Scheduled_tasks "wikilink").

There are four options that affect user sync:

1. **Create accounts in Moodle for users in Azure AD**

This will create users in Moodle from each user in the linked Azure Active Directory. Only users which do not currently have Moodle accounts will have accounts created. New accounts will be set up to use their Office 365 credentials to log in to Moodle (using the OpenID Connect authentication plugin), and will be able to use all the features of the Office 365 plugin set.

2.  **Delete previously synced accounts in Moodle when they are deleted from Azure AD**

This will delete users from Moodle if they are marked as deleted in Azure AD. The Moodle account will be deleted and all associated user information will be removed from Moodle. Be careful!

3.  **Match preexisting Moodle users with same-named accounts in Azure AD**

This will look at the each user in the linked Azure Active Directory and try to match them with a user in Moodle. This looks for matching usernames in Azure AD and Moodle. Matches are case-insensitive and ignore the Office 365 tenant. For example, "BoB.SmiTh" in Moodle would match "bob.smith@example.onmicrosoft.com". Users who are matched will have their Moodle and Office accounts connected and will be able to use all Office 365/Moodle integration features. The user's authentication method will not change unless the setting below is enabled.

4.  **Switch matched users to Office 365 (OpenID Connect) authentication**

This requires the "Match" setting above to be enabled. When a user is matched, enabling this setting will switch their authentication method to OpenID Connect. They will then log in to Moodle with their Office 365 credentials. Note: Please ensure the OpenID Connect authentication plugin is enabled if you want to use this setting.


#### User Creation Restriction

During user sync, by default, all users from Azure AD will be created in Moodle. This setting allows you to set a required field and value that a user must have in Azure to have an account created in Moodle. For example, if you wanted to only have users from the "IT" department syncing into Moodle, you would choose the "Department" field, and enter "IT".

#### User Field Mapping

This controls how information is synced from Azure AD to Moodle. The first column lists Azure fields, the second column lists Moodle fields, and the third column controls when information is synced. To create mappings:

1.  Click "Add Mapping"
2.  In the row that appears, select an Azure field to bring into Moodle.
3.  In the second column on the same row, select a Moodle field to copy the value into.
4.  In the third column on the same row, choose whether this only happens on user creation, on user login, or both.
5.  Click "Save Changes" at the bottom of the page.

To Delete A Mapping

1.  Click the "X" button at the end of the row you want to delete.
2.  Click "Save changes" at the bottom of the page.
3.  Note this will only prevent future information syncing, it will not undo past operations.

Integration Options
---------------------
This controls what kind of Office 365 resources you want to create and associate with a Moodle Course. You have the option to create either a SharePoint subsite for your course and/or an Office 365 Group.
**Please Note** If a SharePoint Site is not needed for your Course, and you are merely looking to have a SharePoint subsite for your course in order to have access to a document library accessible by all students and teachers associated with the course, it is recommended you enable only User Groups rather than the SharePoint connection.

### SharePoint
SharePoint sites can be created for each course on your Moodle site. You will provide a parent SharePoint site and subsites for each course will be automatically created. The document library for each of these subsites can then be accessed by teachers using the Office 365 repository under "SharePoint (Courses)" . This provides a shared store of files for a course, allowing students and teachers the ability to collaborate on documents and share resources. In addition, this provides a SharePoint site that can be customized for the course and linked to from the Microsoft block.
**Note** Any Azure AD connected Moodle user with the **moodle/course:managefiles** capability in a course will be able to access the document library from the repository.

** Setting up the SharePoint connection **

1.  In the **SharePoint Link** setting, type in the URL of the parent SharePoint site you'd like to use for the course subsites.  As you type, Moodle will verify the URL.
    -	This should be the entire URL to the SharePoint site - for example: **<https://contoso.sharepoint.com/moodle>**.
	-	This site must be accessible to the **System API user**

2.  When you are done typing in the URL, the URL will be checked for suitability.
    1.  If the valid is invalid, you will see a red box and the text "This is not a usable SharePoint site."
    2.  If the site already exists, you will see a blue box and the text "This site is usable, but already exists". You can use this site, but conflicts can arise. It's recommended to use a URL to a SharePoint site that doesn't yet exist. The site will be created during initialization.
    3.  If the site does not exist but can be created, you will see a green box and the text "This SharePoint site will be created by Moodle and used for Moodle content.". This SharePoint site will be created by Moodle during initialization.

3.  Click **Save changes** at the bottom of the settings page.
4.  You will see a spinning icon below the SharePoint Link setting, and the text "Moodle is setting up this SharePoint site.". **This will not automatically update - refresh the page to check if the connection has been set up.**.
5.  The SharePoint Link is set up during the Moodle cron, so ensure your Moodle cron is set up and running.

#### User Groups

User Groups (i.e. Office 365 groups) can be created for each course on your Moodle site giving users the ability to access Group resources such as Conversations, Group Files, and Calendar directly from the Microsoft Block via the Course Group link. The Group Files for each of these of these Office 365 groups can then be accessed by members using the Office 365 repository under "Groups (Courses)". Similar to the SharePoint link, this provides a shared store of files for a course, allowing students and teachers the ability to collaborate on documents and share resources.
	-  Once enabled, new groups will be created every cron run for any course that doesn't have an Office 365 group set up for it.
	-  Office 365 groups created will have their membership maintained automatically whenever someone joins or leaves a Moodle course.
	-  By default the Office 365 group will be set as "Private" and the Moodle Admin will be set as an owner of the group.
	-  The Office 365 group Calendar is automatically synced with the Moodle Course calendar

** Setting up User Groups (i.e. Office 365 groups) **

1.  In the *User Groups* setting select from the following choices:
	-	**Disable** This is the default setting. Leaving this box check will mean no Office 365 groups will be created.
	-	**Custom.** This allows you to select which Moodle courses for which you create a Moodle course and which group resources (i.e. Conversations, Group Files, Calendar etc.) are displayed in the Microsoft block. Once an Office 365 groups is created for a Moodle course, it is not deleted when a Course is unselected. Moreover, unselecting items such as Conversations, Group Files, etc. only remove links to those resources from the Microsoft block. They remain accessible from Office 365 for members of the group.
	-	**All Features Enabled** This enables Office 365 groups for all Moodle courses and lists all group resources (i.e. Conversations, Group Files, Calendar, etc.) in the Microsoft block from the Course Group link.

Advanced Settings
-----------------

#### Office 365 for China

Office 365 in China differs slightly in some technical aspects. If you are using Office 365 for China, select this box to ensure everything will work properly.

#### Enable Microsoft Graph API

The Microsoft Graph API is a new API that provides some new features like the "User groups" setting. It will eventually replace the existing Office APIs, however some features used are still in preview and are subject to change without notice, which may break some functionality. It is enabled by default in the latest versions of the plugin.

To enable the Microsoft Graph API (for older installations of the plugins where the Microsoft Graph was not enabled by default):

1.  Enable this setting and click "Save changes" at the bottom of the page.
2.  Add the "Microsoft Graph" to your application in Azure.
3.  Return to Moodle and run through the steps in this plugin's "Setup" tab.

#### Record debug messages

If you experience problems using any Office 365 features in Moodle, enable this setting. Once enabled, errors will be recorded to the Moodle log for review. These errors can help you or the plugin developers debug and fix the problem. The error log can be viewed by navigating to Site Administration \> Reports \> Logs, changing the "All activities" select box to "Site errors", and clicking "Get these logs".

#### Photo time to live

Define how long between synchronization of a profile photo from Office 365 in hours
-----

#### Health Check

If you are experiencing problems with any Office 365 / Moodle features, click the **Health Check** link to run tests on your system and look for potential problems.

#### User Matching

This is a tool that allows an administrator to link Moodle and Office 365 users by uploading a CSV containing Moodle usernames and Office 365 usernames.

#### Maintenance Tools

This link provides access to various tools that can help automatically solve problems with your integration. Do not run these tools unless you are familiar with the effects, or are instructed by a developer or support technician.
