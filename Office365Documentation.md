Introduction
============

Office 365 and Active Directory plugins for Moodle provide a more coherent and synchronous experience for teachers and students using both Moodle and Office 365. In order to be used, an Moodle administrator with Office 365 administrator privileges must configure the plugins for the Moodle site.

Differences from Moodle Core
----------------------------

Although Moodle core now provides Office 365 authentication and basic OneDrive repository support, the Office 365 plugin suite provides a much wider set of features.

A few key features only found in the Office 365 plugin suite:

-   User sync from Office 365/Azure AD to Moodle
-   Automatic and manual user matching from Office 365/Azure AD to Moodle
-   Calendar sync
-   Course to Office 365 group sync and shared file repositories
-   OneNote assignment submission and feedback types
-   Office document embedding using Office web apps
-   Fully customizable sign-in experience

Requirements
============

To use the Office 365 plugins, you need the following:

-   An Office 365 subscription.
-   A Microsoft Azure subscription.
-   Moodle version 3.1 or above.

Please note no paid Azure services are required to use the plugins. In particular, Azure Active Directory (also known as Azure AD or AAD) comes in three editions: Free, Basic, and Premium. The Free edition is all that is needed for use of the plugins. You can access the Azure Active Directory associated with your Office 365 tenant from the Office 365 Admin Settings.

Plugins & Features
==================

The Office 365 set of plugins contains 5 core plugins, and 3 optional plugins, which provide a wide variety of features to enhance your Moodle instance.

-   **Office 365 Local Plugin** (local\_office365)
    -   This is a shell plugin which has dependencies on the current version of each of the 5 plugins that make up the complete set. Installing this plugin ensures you have the current version of each of the functional plugins installed.

<!-- -->

-   **OpenID Connect Authentication Plugin** (auth\_oidc)
    -   This plugin allows users to log in to Moodle using their Office 365 accounts.
    -   Users with existing Moodle accounts can switch to using this authentication plugin, and new users can log in with this plugin and have an account created for them.
    -   If the administrator allows, users can also choose to disconnect from OpenID Connect and revert their previous login method, or to a username/password.
    -   Features
        -   Standards-Compliant OpenID Connect Authentication
        -   Supports authorization code or resource-owner credentials grants
            -   Users can log in to Moodle by clicking the identity provider on the login page, or by entering their OpenID Connect credentials.
        -   Customizable Icon + Identity Provider name
            -   The icon and identity provider name shown on the Moodle login page can be customized. A number of prechosen icons are available, as well as the ability to upload your own.
        -   Provides hooks to link OpenID Connect accounts to Moodle accounts
            -   If you do not want to change your users' login method, you can still connect to an OpenID Connect provider. The plugin provides code-level hooks to link a Moodle account to an OpenID Connect account without changing the Moodle user's authentication method. This means you can obtain tokens from an OpenID Connect service in the background.
        -   Optional user-self-service connection and disconnection
            -   A user-facing page is available for users to switch to and from OpenID Connect authentication. Access to this page and feature is controlled by a capability so administrators can disable it.

<!-- -->

-   **Microsoft Block** (block\_microsoft)
    -   This block provides a user-facing menu to access various Office 365 integration features, resources, and settings.
    -   Links to Office 365 Resources associated with Moodle Courses (including Course SharePoint sites and Course Office 365 Groups) as well as a user's personal Office 365 Resources (including OneDrive for Business, Sways, Docs.com, Delve, Forms & OneNote Notebook).
        -   Contains Settings for settings such as Outlook Calendar sync preferences.
        -   Shows connection status to Office 365 and user photo from Outlook.

<!-- -->

-   **Microsoft Office 365 Integration Local plugin** (local\_o365)
    -   This plugin provides most of the Office 365 integration back-end. This provides shared code to communicate with Office 365, and powers the calendar sync.
    -   Features
        -   Calendar sync from/to Office 365 Outlook.
            -   Users can sync site events, course events, assignment due dates, and their personal Moodle calendar to their Outlook calendar.
        -   User Sync and Matchign
            -   Users can be synced from Azure AD, or matched with existing users.
        -   Office 365 Groups for each Moodle course
            -   You can create Office 365 groups for each course in your Moodle instance (or you can select which courses are used). Links to Office 365 group resources such as Files, Conversations, and Calendar will be accessible from the Microsoft Block in each course. Moreover, the group files from each course group is accessible through the Office 365 repository. The group files is accessible by course teachers and students, serving as a place for teachers and students to share documents. Group membership is kept up-to-date with Moodle enrolments.
        -   SharePoint sites for each Moodle course (Deprecated)
            -   You can connect your Moodle instance to a SharePoint subsite. Sites below this will be created for each course in your Moodle instance, and the document library from each course subsite is accessible through the OneDrive for Business repository. The course subsite document library is accessible by course teachers, serving as a place for teachers to share documents.
            -   This feature is now deprecated. It is mainly used to provide shared document repositories for courses, which can now be accomplished by course groups.

<!-- -->

-   **OneDrive for Business Repository** (repository\_office 365)
    -   This is a repository plugin that allows users to access Office 365 resources in Office 365 services such as OneDrive for Business, SharePoint, and Office Video directly from the Moodle file-picker.
    -   Features:
        -   Import files into Moodle from Office 365.
        -   Upload files into Office 365 services from within Moodle.
        -   Link to resources in Office 365 so users always get the most up-to-date version.
        -   Embed Office 365 resources into Moodle courses so users can view them directly on the site.

Optional Plugins
----------------

These 3 plugins provide support for OneNote assignment submission and feedback. While they are not required, they provide a powerful way to submit and review assignments.

-   **OneNote support plugin** (local\_onenote)
    -   This provides supporting and shared code used by all other OneNote plugins. Does not have an user interface or configuration by itself.

<!-- -->

-   **OneNote Assignment Feedback** (assignfeedback\_onenote)
    -   Allows teachers to leave feedback for students using OneNote.

<!-- -->

-   **OneNote Assignment Submission** (assignsubmission\_onenote)
    -   Allows students to submit assignments using OneNote.

3rd Party Plugins
-----------------

-   **oEmbed Filter** (filter\_oembed)
    -   This filter converts links to a variety of sites into oembed-powered interactions.
    -   Provides [Office Mix](https://mix.office.com/) support for Moodle, allowing you to embed Office Mixes directly into any text within Moodle.

Resources
=========

Tooling and guidance on deploying Scalable Moodle Clusters on Azure

-   <https://github.com/azure/moodle>

Setup
=====

Installation
------------

The packages are available from:

-   The [Moodle Plugins directory](https://moodle.org/plugins/)
    -   [Office 365 Plugin Set](https://moodle.org/plugins/browse.php?list=set&id=72)
-   GitHub
    -   <http://github.com/microsoft/o365-moodle>

When you log back in to your Moodle instance, you are presented with the all the plugin configuration options. Save the settings without configuring them for now, you will come back to them later.

For information on installing plugins in Moodle see [Installing plugins](Installing_plugins "wikilink")

Configuration
-------------

After you have the plugins installed in your Moodle instance, you'll need to do a bit of setup before you can use and configure additional plugin settings including User Sync, SharePoint, etc. For more information on these additional settings see Microsoft Office 365 Integration Local plugin.

### Enable the OpenID Connect Authentication Plugin

1.  Navigate to **Site Administration &gt; Plugins &gt; Authentication** and click **Manage authentication**
2.  Locate the OpenID Connect authentication plugin and click the eye icon to enable
3.  Click the Settings link for the plugin.
4.  Verify the Authorization and Token endpoints. These should be set by default but if not, set the endpoints to the following:
    1.  **Authorization Endpoint:** <https://login.microsoftonline.com/common/oauth2/authorize>
    2.  **Token Endpoint:** <https://login.microsoftonline.com/common/oauth2/token>

5.  Note the Redirect URI. This should be the URI of your Moodle instance followed by /auth/oidc/. You will need to enter this value into Azure AD later, so note this value and put it aside.
    1.  For example, <https://www.example.com/auth/oidc/>
    2.  Notes:
        1.  This is a fixed value that is derived from your Moodle site's configured URL (wwwroot). You cannot change this value directly. If you need to change it for any of the following reasons, you must change your Moodle site's configured domain name ($CFG-&gt;wwwroot).
        2.  This URL must be a fully qualified domain name pointing to your Moodle instance.
        3.  If your Moodle installation is configured with an IP address pointing to your instance, you must change $CFG-&gt;wwwroot in your config.php to a fully-qualified domain name.
        4.  This domain name does not need to be publicly accessible (i.e. internet-wide), but does need to be accessible to users of your Moodle instance. So, for example, you can use a intranet-only domain name.

### Register your Moodle instance as an Application in Azure Active Directory

#### Prepare your Office 365 account for single sign-on with your Moodle installation

You will need an Azure subscription. If you do not have one, you can create one by visiting [http://azure.microsoft.com/en-us/pricing/free-trial/ Microsoft Azure Sign Up](http://azure.microsoft.com/en-us/pricing/free-trial/_Microsoft_Azure_Sign_Up "wikilink")

To use Moodle with Office 365 for SSO, you must [configure Microsoft Azure](https://manage.windowsazure.com) to manage your Office 365 Microsoft Azure Active Directory:

1.  Create a new Active Directory.
2.  Select Use existing directory.
3.  Select **I am ready to be signed out now** and click the check mark.
4.  Sign in with your Office 365 subscription credentials.
5.  Click **Continue**.
6.  Log out and sign back in to your Azure account.

**Note**: In order to sign-up for an Azure subscription, you are required to enter a credit card and phone number. If only use the subscription to access the Azure Active Directory associated with your Office 365 subscription and enable no other paid services such as Virtual Machines, you will not be charged for the subscription.

#### Register your Moodle instance as an Application

1.  Sign in to the [Microsoft Azure Management Portal](https://portal.azure.com).
2.  Click on the **Azure Active Directory** link on the left menu, then **App Registrations**.
3.  Click **New application registration** on the top menu.
4.  Enter a name for your application (can be anything you want, but should let you know this is for Moodle).
5.  Choose **Web app/ API** for the Application Type.
6.  The **Sign-on URI** is the Redirect URI you from the OpenID Connect authentication plugin configuration. **Ensure there is a trailing slash for this URL - i.e. <https://example.com/auth/oidc/>**
7.  Click **Create**.
8.  You now have an application registered in Azure for Moodle. Move on to the next section to properly configure it.

#### Configure your Application Permissions

1.  Sign in to the [Microsoft Azure Management Portal](https://portal.azure.com).
2.  Click on the **Azure Active Directory** link on the left menu, then **App Registrations**.
3.  Click on the App you created for Moodle.
    1.  You may need to change the dropdown from "My apps" to "All apps"

4.  Locate the **Application ID**, note this value (write it down or copy it somewhere), and set it aside. You'll need it later.
5.  Click on "Settings"
6.  Create a client secret key.
    1.  Click the **Keys** link, under "API Access".
    2.  Enter a description, and select a duration for "Expires"
    3.  Click **Save**
    4.  A value will appear under **Value**, note this key value (write it down or copy it somewhere) and set it aside. You'll need later.

7.  Configure Permissions
    1.  Click the **Required Permissions** link under **API Access**.
    2.  Click **Add** at the top of the pane.
    3.  Click **Select an API**, choose "Microsoft Graph", then click **Select**.
    4.  Click the checkbox for the following permissions in each of the "Application" and "Delegated" permissions sections:

| Type                                             | Name                                                                                           | Use                                                                                            |
|--------------------------------------------------|------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------|
| Application Permissions                          | **Read and write domains**                                                                     | Required to automatically detect your Office 365 tenant during setup.                          |
|| **Read and write all users' full profiles**      | Required to sync user information between Moodle and Office 365.                               |
|| **Read and write all OneNote notebooks**         | Required for the OneNote integration to create notebooks, sections, and pages for assignments. |
|| **Read and write all groups**                    | Required for course group integration.                                                         |
|| **Read directory data**                          | Required for setup detection and verification.                                                 |
|| **Read and write calendars in all mailboxes**    | Required for calendar event sync.                                                              |
|| **Read and write files in all site collections** | Required for the Office 365 repository to access, download, and upload files to OneDrive.      |
| Delegated Permissions                            | **Read and write all OneNote notebooks that user can access**                                  | Required for the OneNote integration to create notebooks, sections, and pages for assignments. |
|| **Sign in and read user profile**                | Required to sign users in using Office 365, and to access Office 365 APIs.                     |
|| **Read and write all users' full profiles**      | Required to sync user information between Moodle and Office 365.                               |
|| **Read and write all groups**                    | Required for course group integration.                                                         |
|| **Read and write directory data**                | Required for setup detection and verification.                                                 |
|| **Access directory as the signed in user**       | Required to access Office 365 APIs.                                                            |
|| **Have full access to user calendars**           | Required for calendar event sync.                                                              |
|| **Have full access to user files**               | Required for the Office 365 repository to access, download, and upload files to OneDrive.      |
|| **Read items in all site collections**           | Required for SharePoint integration (deprecated)                                               |
|| **Sign users in**                                | Required to sign users in using Office 365 (required for all integration).                     |

**When you're done, click save at the top of the screen.**

#### Assign Users

1.  Sign in to the [Microsoft Azure Management Portal](https://portal.azure.com).
2.  Click on the **Azure Active Directory** link on the left menu, then **App Registrations**.
3.  Click on the App you created for Moodle.
    1.  You may need to change the dropdown from "My apps" to "All apps"

4.  Click the name of the app under **Managed application in local directory**
5.  Click **Users and groups** under the **Manage** section.
6.  Add users to your application using the **Add user** button.

The application will appear in the [My apps](https://portal.office.com/myapps) page of the application launcher on the Office 365 portal for the users which have been assigned.

### Configure the Setup tab in the Microsoft Office 365 Integration plugin

Navigate to **Site Administration &gt; Plugins &gt; Local plugins**. Click **Microsoft Office 365 Integration**. Under the **Setup** tab, complete each of the following steps:

1.  Register Moodle and Azure AD (see above section)
    1.  Copy the client ID and key from Azure AD into the appropriate fields.
    2.  Click "Save changes" at the bottom of the screen.

2.  **Choose connection method**
    1.  Choose the method you want to use to connect to Office 365. Unless you have a special reason to use the System API user, choose **Application access**.
    2.  Click **Save changes**

3.  **Admin consent & additional information**
    1.  **Admin consent:** Every time you change a **Requires admin** permission in Azure, you will need an administrator to provide consent to use the permission. Clicking the **Provide admin consent** button will take you to a log in screen on Office 365. An administrator will have to log in, and then will be given the option to approve the new permissions.
    2.  **Azure AD Tenant:** This is the domain name that identifies your Office 365 subscription, for example "contoso.onmicrosoft.com". If you know it, enter it in this box, if not, click the "Detect" button to attempt to detect the correct value.
    3.  **OneDrive for Business URL:** This is the URL that your users use to access OneDrive for Business. This can usually be determined from your AzureAD tenant, for example, if your tenant is "contoso.onmicrosoft.com", your OneDrive for Business URL is "contoso-my.sharepoint.com." If you know the URL, enter it here, otherwise click "Detect" to attempt to detect the correct value. Only enter the domain name, do not include "<http://>", "www." or any trailing slashes. For example "contoso-my.sharepoint.com", not "<https://contoso-my.sharepoint.com/>"
    4.  Click Save changes.

4.  **Verify Setup**
    1.  This tool verifies that Azure has been correctly set up. Click the "Update" button to check setup.
    2.  If the tool reports any missing permissions, return to Azure and ensure that all required permissions have been added to your configured application for Moodle.

Connecting users to Office 365
------------------------------

To use any Office 365 features, a Moodle user must be connected to an Office 365 user that has an active Office 365 subscription. There are two ways to connect a Moodle user to an Office 365 user.

### Switch the user to use OpenID Connect authentication.

With this method, the user will log in to Moodle using their Office 365 account credentials.

-   Users who do not yet have a Moodle account can simply follow the normal OpenID Connect login process (see: [Office365\#Basic\_Usage](Office365#Basic_Usage "wikilink")). If a Moodle account is not found for a user logging in with OpenID Connect, an account will be created for them.
-   To migrate an existing Moodle user to OpenID Connect authentication, see [Office365\#Switching\_existing\_Moodle\_users\_to\_use\_Office\_365\_to\_log\_in](Office365#Switching_existing_Moodle_users_to_use_Office_365_to_log_in "wikilink").

### Link a Moodle user to an Office 365 user.

Users in Moodle can also be linked to Office 365 users without changing the Moodle user's authentication method. Users will be able to log in as they always have, and still use all the Office 365 features.

1.  Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
2.  As the user to link to Office 365, visit a page that has the Microsoft block visible.
3.  Click the **Connect to Office 365** link in the Microsoft block.
4.  You will be brought to the **Office 365 / Moodle Control Panel**.
5.  There will be a "Connection Status" indicator box on the right side of the screen, click the "Click here to connect" link.
6.  You will be brought to the AzureAD authentication screen. Log in with the Office 365 user's credentials you'd like to connect to the Moodle user you are logged in as.
7.  If login was successful, you will be brought back to the **Office 365 / Moodle Control Panel** page, where the Office 365 connection indicator should now read **Active**.
8.  This user is now connected to the Office 365 user.

Microsoft Office 365 Integration Local Plugin
=============================================

This plugin contains several configuration options and can be located under **Site Administration &gt; Plugins &gt; Local plugins &gt; Microsoft Office 365 Integration**. It is organized into three tabs:

1.  **Setup**. Configuration settings are outlined under the Setup section.
2.  **Options** Contains various configuration options. Includes:
    1.  User Sync
    2.  Integration Settings
    3.  Advanced Settings

3.  **Tools**
    1.  Health Check
    2.  User Matching Tool

Options
-------

### User Sync

This controls how users are synced from Azure AD to Moodle. This can create or delete users in Moodle, match them with Azure Active Directory users, and assign them to Azure Active Directory applications.

The main benefit of using this option, compared to having accounts created as users log in using OpenID Connect, is that you can manage and enrol users before they first log in, so everything is ready to go the first time they access Moodle.

#### Sync users with Azure AD

Users from Azure AD can be automatically created in Moodle using the user sync option. This creates a Moodle account for every user in the connected Active Directory allowing you to manage and enrol users in Moodle without the user having to log in first. When the user does log in using the OpenID Connect authentication plugin and their Office 365 account, they will be logged in to the account created for them during the user sync.

**To enable:**

1.  Check the checkbox beside each user sync option that you want to use.
2.  Click Save Changes.
3.  Run the Moodle cron to run the user sync process.

**Notes:**

-   The sync job runs in the Moodle cron, and syncs 1000 users at a time.
-   By default, this runs once per day at 1:00 AM in the time zone local to your server.
-   To sync large sets of users more quickly, you can increase the frequency of the Sync users with Azure AD task using the Scheduled tasks management page. See [Scheduled\_tasks](Scheduled_tasks "wikilink").

There are several options that affect user sync:

##### Create accounts in Moodle for users in Azure AD

This will create users in Moodle from each user in the linked Azure Active Directory. Only users which do not currently have Moodle accounts will have accounts created. New accounts will be set up to use their Office 365 credentials to log in to Moodle (using the OpenID Connect authentication plugin), and will be able to use all the features of the Office 365 plugin set.

##### Delete previously synced accounts in Moodle when they are deleted from Azure AD

This will delete users from Moodle if they are marked as deleted in Azure AD. The Moodle account will be deleted and all associated user information will be removed from Moodle. Be careful!

##### Match preexisting Moodle users with same-named accounts in Azure AD

This will look at the each user in the linked Azure Active Directory and try to match them with a user in Moodle. This looks for matching usernames in Azure AD and Moodle. Matches are case-insensitive and ignore the Office 365 tenant. For example, "BoB.SmiTh" in Moodle would match "bob.smith@example.onmicrosoft.com". Users who are matched will have their Moodle and Office accounts connected and will be able to use all Office 365/Moodle integration features. The user's authentication method will not change unless the setting below is enabled.

##### Switch matched users to Office 365 (OpenID Connect) authentication

This requires the "Match" setting above to be enabled. When a user is matched, enabling this setting will switch their authentication method to OpenID Connect. They will then log in to Moodle with their Office 365 credentials. Note: Please ensure the OpenID Connect authentication plugin is enabled if you want to use this setting.

##### Assign users to application during sync

This will assign Azure AD users to the Moodle application in Azure. This will add the Moodle tile to the user's app launcher, and enable Moodle access if the "User assignment required to access app" setting is enabled in the Azure application.

##### Sync Office 365 profile photos to Moodle in cron job

This will sync users' profile photos into Moodle and set the Moodle user's profile photo to that image. Note that this can increase the time it takes to run user sync significantly.

##### Sync Office 365 profile photos to Moodle on login

If enabled, the user's Office 365 profile photo will be synced upon their log in to Moodle. This can be a more performant solution than (6) but users may experience a slightly delay in seeing profile photo updates.

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

### Integration Features

This section controls the various main features of the plugin suite, including what kind of Office 365 resources you want to create and associate with a Moodle Course. You have the option to create either a SharePoint subsite for your course and/or an Office 365 Group. **Please Note** If a SharePoint Site is not needed for your Course, and you are merely looking to have a SharePoint subsite for your course in order to have access to a document library accessible by all students and teachers associated with the course, it is recommended you enable only User Groups rather than the SharePoint connection.

#### Course Groups

User Groups (i.e. Office 365 groups) can be created for each course on your Moodle site giving users the ability to access Group resources such as Conversations, Group Files, and Calendar directly from the Microsoft Block via the Course Group link. The Group Files for each of these of these Office 365 groups can then be accessed by members using the Office 365 repository under "Groups (Courses)". Similar to the SharePoint link, this provides a shared store of files for a course, allowing students and teachers the ability to collaborate on documents and share resources.

Features:

-   Once enabled, new groups will be created every cron run for any course that doesn't have an Office 365 group set up for it.
-   Group membership is kept up-to-date with enrolments in Moodle.
-   Provides an easy was to address all users in a course from Office 365. For example, a teacher can share a document from OneDrive with all of their students by choosing the user group for their course - they don't have to choose each student individually.
-   Course group file stores are accessible from the Office 365 Moodle file repository plugin, allowing users to access group files from Moodle.
-   By default the Office 365 group will be set as "Private" and the Moodle Admin will be set as an owner of the group.
-   The Office 365 group Calendar is automatically synced with the Moodle Course calendar

**Setting up User Groups (i.e. Office 365 groups)**

1.  In the \*User Groups\* setting select from the following choices:
    1.  **Disable:** This is the default setting. Leaving this box check will mean no Office 365 groups will be created.
    2.  **Custom:** This allows you to select which Moodle courses for which you create a Moodle course and which group resources (i.e. Conversations, Group Files, Calendar etc.) are displayed in the Microsoft block. Once an Office 365 groups is created for a Moodle course, it is not deleted when a Course is unselected. Moreover, unselecting items such as Conversations, Group Files, etc. only remove links to those resources from the Microsoft block. They remain accessible from Office 365 for members of the group.
    3.  **All Features Enabled:** This enables Office 365 groups for all Moodle courses and lists all group resources (i.e. Conversations, Group Files, Calendar, etc.) in the Microsoft block from the Course Group link.

#### SharePoint

**This feature is deprecated and is likely to be removed in a future version.**

SharePoint sites can be created for each course on your Moodle site. You will provide a parent SharePoint site and subsites for each course will be automatically created. The document library for each of these subsites can then be accessed by teachers using the Office 365 repository under "SharePoint (Courses)" . This provides a shared store of files for a course, allowing students and teachers the ability to collaborate on documents and share resources. In addition, this provides a SharePoint site that can be customized for the course and linked to from the Microsoft block. **Note** Any Azure AD connected Moodle user with the **moodle/course:managefiles** capability in a course will be able to access the document library from the repository.

**Setting up the SharePoint connection**

1.  In the **SharePoint Link** setting, type in the URL of the parent SharePoint site you'd like to use for the course subsites. As you type, Moodle will verify the URL.
    1.  This should be the entire URL to the SharePoint site - for example: **&lt;<https://contoso.sharepoint.com/moodle>&gt;**.
    2.  This site must be accessible to the **System API user**

2.  When you are done typing in the URL, the URL will be checked for suitability.
    1.  If the valid is invalid, you will see a red box and the text "This is not a usable SharePoint site."
    2.  If the site already exists, you will see a blue box and the text "This site is usable, but already exists". You can use this site, but conflicts can arise. It's recommended to use a URL to a SharePoint site that doesn't yet exist. The site will be created during initialization.
    3.  If the site does not exist but can be created, you will see a green box and the text "This SharePoint site will be created by Moodle and used for Moodle content.". This SharePoint site will be created by Moodle during initialization.

3.  Choose which courses you want to sync.
    1.  Beneath the SharePoint link setting, you will see a "SharePoint course selection" setting. This allows you to choose which courses will have a SharePoint site created.
    2.  "None" will not create any SharePoint sites.
    3.  "Custom" will allow you to choose which courses have a SharePoint site created. A "customize" link will appear after you choose this link and click "Save changes".
    4.  "Sync All" will create a SharePoint site for every Moodle course.

4.  Click **Save changes** at the bottom of the settings page.
5.  You will see a spinning icon below the SharePoint Link setting, and the text "Moodle is setting up this SharePoint site.". **This will not automatically update - refresh the page to check if the connection has been set up.**
6.  The SharePoint Link is set up during the Moodle cron, so ensure your Moodle cron is set up and running.

### Advanced Settings

#### Office 365 for China

Office 365 in China differs slightly in some technical aspects. If you are using Office 365 for China, select this box to ensure everything will work properly.

#### Enable preview features

From time-to-time, we add features that use brand-new APIs or are slightly experimental in some way. These features often become part of our regular feature offering once they mature, but if you want to see the latest features we're working on, you can enable this setting to enable all preview features. Be careful though! These features do break from time to time.

#### Record debug messages

If you experience problems using any Office 365 features in Moodle, enable this setting. Once enabled, errors will be recorded to the Moodle log for review. These errors can help you or the plugin developers debug and fix the problem. The error log can be viewed by navigating to Site Administation &gt; Reports &gt; Logs, changing the "All activities" select box to "Site errors", and clicking "Get these logs".

#### Minimum inexact username length to switch to Office 365

When using automatic user matching, this setting can be used to exclude accounts with short names. The intended use of this is to avoid matching generic accounts like "admin". This setting is the minimum length of a username required for automatic matching to match users.

#### Profile photo refresh time

The number of hours to wait before refreshing a user's profile photo.

Tools
-----

### Tenants

This tool allows you to add additional Office 365 tenants to be used with Moodle. Users from additional tenants can log-in to Moodle using their Office 365 account, and use features like calendar sync and the OneDrive repository.

### Health Check

If you are experiencing problems with any Office 365 / Moodle features, click the **Health Check** link to run tests on your system and look for potential problems.

### Connections

This tool allows administrators to see and manage the connections between their Moodle users and Office 365 accounts. Each user in the system is listed alongside the Office 365 username the user is connected to, if any. Administrators can choose to manually connect or disconnect each user.

### User Matching

This tool allows administrators to manually match Moodle and Office 365 users using a CSV file. Administrators can upload a CSV file containing, on each line, a Moodle username, and Office 365 username, and a 1 or 0 indicating whether to enable Office 365 login for that user.

Once uploaded, the file is processed in batches during the Moodle cron. The tool page will display the progress of this process.

### Maintenance Tools

These tools perform maintenance tasks that can help solve problems which may crop up from time to time. Generally, users should not need these tools unless they encounter the specific situation these tools are designed to solve.

#### Resync users in groups for courses

Course group membership is kept up-to-date as users are enrolled and un-enrolled from courses in Moodle. If this membership gets out-of-date for whatever reason, this tool will force a resync of group membership.

#### Recreate deleted Office 365 groups

Course groups are created from Moodle courses when using the course group feature. If a group is manually deleted from the Office 365 administrator panel, this tool will recreate it.

#### Generate debug data package

This tool will generate a package of information that can be sent to the plugin suite maintainers to help debug problems in environment and setup. While no API keys are present, this information does contain a lot about your environment and setup, so please be careful about who you send this information to.

User Features
-------------

### Calendar sync

This feature allows users to sync their Moodle calendars with Office 365. Users can have events in their Moodle calendar appear in any Office 365 calendar, and have events created in Office 365 synced back to Moodle.

To use this feature:

1.  Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
2.  As a user connected to Office 365, visit a page where the Microsoft block is visible.
3.  Click the "Configure Outlook sync" link in the Microsoft block.
4.  From here, you should see a list of your available Moodle calendars. Click the checkmark next to the ones you'd like to sync.
    1.  By default, the calendars will sync with your Office 365 "primary" calendar. You can choose a different calendar to sync with using the "Sync with" select box.

5.  You can also choose to sync from Office 365 in to Moodle (or both from Moodle to Office 365 and from Office 365 to Moodle). This is done using the "Sync behavior" select box.
6.  Once you're subscribed to a calendar, wait for the site's cron function to run to sync older calendar events. However, new events should sync right away.

Microsoft Block
===============

The Microsoft block provides the ability for users to quickly link off to Office 365 services.

-   Course Group
-   Course SharePoint site
-   My Delve
-   My Docs.com
-   My OneNote Notebook
-   My OneDrive
-   Settings
    -   Outlook Calendar Sync settings
    -   Office 365 Connection settings

You can configure which of the following items show up in the plugins using the configuration settings under **Site Administration \\&gt; Plugins \\&gt; Blocks \\&gt; Microsoft**. A few important items to note:

-   All settings besides Course Group and Course SharePoint site are evergreen, meaning they can be accessed at any time from any page on which the Microsoft block has been added to a page in Moodle
-   If enabled, Course SharePoint site and Course Group only appear once the user is inside a Moodle course for which they are enrolled
-   Course SharePoint site and Course Group cannot be disabled from the Microsoft block. They can only be enabled/disabled from the the Microsoft Office 365 Integration plugin.

Outlook Calendar sync
---------------------

This feature allows users to sync their Moodle calendars with Office 365. Users can have events in their Moodle calendar events appear in any Office 365 calendar, and have events created in Office 365 synced back to Moodle.

To use this feature:

1.  Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
2.  As a user connected to Office 365, visit a page where the Microsoft block is visible.
3.  Click the "Outlook Calendar Sync settings" link in the Microsoft block.
4.  From here, you should see a list of your available Moodle calendars. Click the checkmark next to the ones you'd like to sync.
    1.  By default, the calendars will sync with your Office 365 "primary" calendar typically named "Calendar". You can choose a different calendar to sync with using the "Sync with" select box.

5.  You can also choose to sync from Office 365 in to Moodle (or both from Moodle to Office 365 and from Office 365 to Moodle). This is done using the "Sync behavior" select box.
6.  Once you're subscribed to a calendar, wait for the site's cron function to run to sync older calendar events. However, new events should sync right away.

OpenID Connect Authentication Plugin
====================================

Basic Usage
-----------

Once configured, you should see a link named "OpenID Connect" on the Moodle login page. Clicking this link will redirect the browser to the identity provider. Users will log in there, and will be redirected back to Moodle. If they have logged in to Moodle using OpenID Connect before, they will be logged in to their existing Moodle account. If they have not logged in to Moodle with OpenID Connect before, an account will be created for them.

Note: If the "Prevent account creation when authenticating" setting is enabled in Moodle, new accounts will not be created.

Settings
--------

There are a number of options you can use to customize how the plugin behaves. To configure the plugin, visit the plugin's settings page. (Site Administration &gt; Plugins &gt; Authentication &gt; OpenID Connect)

#### Provider Name

The name entered here will be used through the OpenID Connect plugin and the Office 365 plugins to refer to the system used to log users in. For example, if your users are used to calling their Azure AD account their "School" account, you enter "School account" here, and all references to authentication will be "Log in with your School account".

#### Client ID

Enter the Client ID obtained from Azure when you created the application for your Moodle installation.

#### Client Secret

Enter the Key obtained from Azure when you created the application for your Moodle installation.

#### Authorization Endpoint and Token Endpoint

You can use the default values for these.

#### Resource

You can use the default value for this.

#### Auto-Append

When using the "Resource Owner Password Credentials" authentication method, this setting with automatically append a given string to an entered username. This is useful in Azure AD usernames, where a single domain name is often used for every user - i.e. \[user\]@contoso.onmicrosoft.com. Users would normally have to enter this entire username to successfully log in to Moodle, but in this example, entering "@contoso.onmicrosoft.com" here means users would only have to enter their unique username, i.e. "bob.smith", instead of "bob.smith@contoso.onmicrosoft.com".

#### Domain Hint

If users have several different Azure AD accounts with different tenants (i.e. @contoso.onmicrosoft.com, @example.onmicrosoft.com), but Moodle only uses one of these tenants, you can enter that tenant in this box to have the Azure AD login screen only ever suggest accounts from that tenant.

#### Authentication methods

This setting changes how users log in to Moodle using the plugin. You can redirect users to the OpenID Connect provider's login page, or have users enter their credentials directly into Moodle. See the "Authentication methods" section below for further information.

#### User Restrictions

This setting allows you to restrict the users that can log in to Moodle using OpenID Connect (Azure AD).

Once you've entered at least one user restriction, users logging in to Moodle must match at least one entered pattern.

How to use user restrictions:

1.  Enter a regular expression pattern that matches the usernames of users you want to allow.
2.  Enter one pattern per line
3.  If you enter multiple patterns a user will be allowed if they match ANY of the patterns.
4.  The character "/" should be escaped with "\\".
5.  If you don't enter any restrictions above, all users that can log in to the OpenID Connect provider will be accepted by Moodle.
6.  Any user that does not match any entered pattern(s) will be prevented from logging in using OpenID Connect.

#### Record debug messages

If you experience problems using OpenID Connect, enable this setting. Once enabled, errors will be recorded to the Moodle log for review. These errors can help you or the plugin developers debug and fix the problem. The error log can be viewed by navigating to Site Administation &gt; Reports &gt; Logs, changing the "All activities" select box to "Site errors", and clicking "Get these logs".

#### Custom Icon

This setting allows you to choose from a selection of predefined icons to appear next to the identity provider link on the login page. You can also upload your own icon.

1.  Visit the plugin settings page (Site Administration &gt; Plugins &gt; Authentication &gt; OpenID Connect)
2.  Locate the "Icon" section of the settings page.
3.  There are several predefined icons to choose from, clicking an icon will use that icon on the login page.
4.  To use a custom icon, use the file picker below the "Icon" setting.
    1.  This image will not be resized on the login page, so we recommend uploading an image no bigger than 35x35 pixels.
    2.  If you have uploaded a custom icon and want to go back to one of the stock icons, click the custom icon in the file picker and click "Delete", then "OK", then "Save Changes" at the bottom of the settings page. The selected stock icon will now appear on the Moodle login page.

Authentication methods
----------------------

This plugin supports two different methods for users to log in: Authorization Code and Resource Owner Password Credentials Authentication

### Authorization Code Flow (recommended)

This method redirects the user to Office 365 to log in and are then brought back to Moodle logged in.

Using this method:

1.  The user clicks the name of the identity provider (What you entered in the "Provider Name" box at the top of the settings page.) on the Moodle login page.
2.  The user is redirected to Office 365 to log in.
3.  Once successfully logged in, the user is redirected back to Moodle where the Moodle login takes place transparently.

### Resource Owner Password Credentials Grant

This method works like a classic username and password, except the user uses their Office 365 account information.

Using this method:

1.  The user enters their Office 365 username and password directly into the Moodle login form.
2.  Their credentials are securely sent to Office 365 for verification.
3.  If the credentials are verified, the user is logged in to Moodle.

Switching existing Moodle users to use Office 365 to log in
-----------------------------------------------------------

If a user logs in to Moodle using OpenID Connect but does not have a Moodle account, one will be created for them. However, existing Moodle users can be migrated to use OpenID Connect and provide a connection to Office 365.

1.  Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
2.  Log in as the user to be migrated, visit a page that has the Microsoft block visible.
3.  Click the **Connect to Office 365** link in the Microsoft block.
4.  You will be brought to the **Office 365 / Moodle Control Panel**.
5.  Click the *'Office 365 Login* link under **Office 365 Features**
6.  Click the "Start using Office 365 to log in to Moodle." link.
7.  You will be redirected to Office 365 to log in. Log in with the account you'd like to link to the Moodle account you're using.
    1.  **NOTE:** If you're already logged in to Office 365, you will not have to enter your credentials on the Office 365 login page. This Office 365 account will be linked to the Moodle account. Ensure you are logged in to the correct account, or log out of Office 365 first to show the Office 365 login screen.

8.  The Moodle account will now use Office 365 to log in. **The previous login method will not work.**
9.  The Moodle user can now use any of the Office 365 features in Moodle.

Connecting existing Moodle users to Office 365 without changing login method
----------------------------------------------------------------------------

1.  Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
2.  Log in as the user to be migrated, visit a page that has the Microsoft block visible.
3.  Click the **Connect to Office 365** link in the Microsoft block.
4.  You will be brought to the **Office 365 / Moodle Control Panel**.
5.  There will be a "Connection Status" indicator box on the right side of the screen, click the "Click here to connect" link.
6.  You will be brought to the AzureAD authentication screen. Log in with the Office 365 user's credentials you'd like to connect to the Moodle user you are logged in as.
    1.  **NOTE:** If you're already logged in to Office 365, you will not have to enter your credentials on the Office 365 login page. This Office 365 account will be linked to the Moodle account. Ensure you are logged in to the correct account, or log out of Office 365 first to show the Office 365 login screen.

7.  If login was successful, you will be brought back to the **Office 365 / Moodle Control Panel** page, where the Office 365 connection indicator should now read **Active**.
8.  The Moodle account is now linked to the Office 365 account and can use Office 365 features as that user.
9.  The Moodle user's login method will not change, the user will log in to Moodle as they always have.

Office 365 Repository
=====================

The Office 365 repository allows users using the Office 365 integration plugins to connect to various file stores within Office 365, including their personal OneDrive for Business, as a Moodle repository. You can configure which Office 365 services are available via the Moodle file-picker in the Office 365 repository settings page. Currently the services available are:

**OneDrive** contains all documents in your personal OneDrive for Business **SharePoint (Courses)** will list all SharePoint document libraries associated with Moodle Courses that you have access to. **Group Files (Courses)** will list all the Office 365 Group File folders associated with Moodle Courses that you have access to.

Downloading and linking files
-----------------------------

1.  When using a file-picker anywhere in Moodle, you'll see a list of repositories on the left side of the popup. Look for and click on "Office 365".
2.  If you are a regular user within Moodle, you will see folders for the services that have been enabled for you.
3.  You will now see a list of all the files and folders in your OneDrive. If you want to download files from the "SharePoint (Courses)" or "Groups Files(Courses)", you'll click on the respective folder then click the folder for the course you want to access.
4.  Navigate and click the file you want to download into Moodle.
5.  Choose to "Make a copy of the file", or "Create an alias/shortcut to the file."
    1.  If you want to download a copy of the file as it is now, choose "Make a cope of the file". This will copy the file into Moodle, and will then use the local Moodle copy when the file is accessed from within Moodle. Any changes to the file in OneDrive will not be seen in Moodle.
    2.  If you want to link a file choose "Create an alias/shortcut to the file". This will create a link in Moodle to the file in OneDrive, and the file will be accessed from OneDrive directly. Any changes to the file in OneDrive will be seen when accessing the file from Moodle.

6.  You can change other file information like the filename or author name using the respective text fields. This information is only applicable to the Moodle side of the file, and will not transfer to OneDrive.
7.  Click "Select this file".

Uploading files
---------------

You can upload files into Office 365 from the Moodle file-picker interface.

1.  When accessing a Office 365 folder (for example, OneDrive) from a file picker, you will see an "Upload New File" item in the list of files and folders.
2.  Click the "Upload new file" item.
3.  Choose the file you want to upload and click "Upload this file".
4.  The file will be uploaded to OneDrive and selected for the file picker.

Embedding Office documents
--------------------------

This repository allows users to embed Office documents from OneDrive into a course and have the live version viewable using Office web apps.

1.  Start as a user connected to Office 365 and who has access to modify a course.
2.  Turn on editing for the course and choose "Add an activity or resource" for the section of the course you want to add the document.
3.  Choose the "File" resource to add to the course.
4.  In the "Content" section of the file resource settings page, click the "Add" button in the filepicker
5.  Choose the "OneDrive for Business" repository and choose your Office document.
6.  When you select a file, make sure "Create an alias/shortcut to the file" is selected, the click "Select this file"
7.  Expand the "Appearance" section, and choose "Embed" for the "Display" select box.
8.  Click "Save and display"
9.  You should see the file embedded into the page.

OneNote
=======

If you have installed all the plugins (for example, by installing [1](https://moodle.org/plugins/view/local_office365)) then you already have the OneNote plugins installed. To access OneNote using your Office 365 subscription, add OneNote to the list of applications in your Azure application. This is done the same way you configured Azure permissions, above. Note that OneNote is still in preview, and may not be available to everyone yet. If you don't see OneNote in the list of applications to add to your Azure application, you can try logging in to a desktop OneNote application using an administrator account in your Office 365 tenant. This sometimes expedites to the process of adding the OneNote preview to your tenant.

Frequently Asked Questions
==========================

How to I get Moodle to appear in the Office 365 app launcher?
-------------------------------------------------------------

Moodle will appear in a user's Office 365 app launcher if they are assigned to the application you created in Azure for Moodle. See the "Assign Users to your Azure Active Directory Application" section in setup. The integration local plugin also provides an option to automatically assign users to your Azure application. See "User Sync".

I got an "Error in API call" error message - what do I do?
----------------------------------------------------------

If the error is reproducible, enable the "Record debug messages" settings in both OpenID Connect and the integration local plugin (Site Administration &gt; Plugins &gt; Authentication &gt; OpenID Connect, and Site Administration &gt; Plugins &gt; Local plugins &gt; Microsoft Office 365 Integration &gt; Options tab &gt; Advanced settings). Reproduce the error with these settings enabled, and view your Moodle logs (Click the "View recorded log messages" link next to the Record debug messages setting in the integration local plugin). If you see an entry for Office 365, the log item may provide information on what went wrong. If the problem is not clear, please open an issue in our GitHub repository (https://github.com/Microsoft/o365-moodle) and we'll take a look at it.

Where is the Microsoft block?
-----------------------------

The Microsoft block is not added to a Moodle page automatically. Once installed, navigate to the Moodle page you want to add the block to and click the "Customise this page" button. Look for the "Add a block" block and choose "Microsoft" from the dropdown. The Microsoft block will be added to the current page and can be managed like any other Moodle block.

Troubleshooting
===============

Having trouble? Here are a few things to check, and how to proceed.
1. Have you upgraded to the latest version of the plugins? Issues that encountered by others by already be fixed. Be sure to get the latest version of the plugins before anything else.
2. Does your system meet the server minimum requirements? The plugins have the same minimum requirements as core Moodle. Please ensure your environment meets these requirements.
3. Have you enabled the plugins you want? OpenID Connect and the Office 365 repository are not enabled by default. Be sure you have enabled these plugins through the Moodle administration interface.
4. Are your permissions in Azure AD correct? From time to time these permissions may change. Check the Setup section of these docs to get the current list. You can also run the Azure AD Setup verification tool on the "Setup" tab of the local plugin settings page.
5. Enable "Record debug messages" from the local plugin settings page then reproduce the error. The "View recorded log messages." link from the "Record debug messages" setting will show you any recorded logs. These often contain useful information that may point to the problem.
6. Still having trouble? Submit an issue at https://github.com/Microsoft/o365-moodle/issues/. Please include:
    1. Your Moodle version
    2. The version of: auth_oidc, local_o365, repository_office365, and any other optional Office 365 plugins you have installed.
    3. Any debug messages recorded (see above).
Thanks!

Any further questions?
======================

For support, please open an issue on Github at [2](https://github.com/Microsoft/o365-moodle/issues)

For community discussion, please post in the [Moodle office tool integrations forum](https://moodle.org/mod/forum/view.php?id=8273) on moodle.org. Note: developers may or may not see questions in this forum thread.

Appendix: Office 365 LTI integrations for Moodle
================================================

The Office 365 LTI integrations for Moodle do not require that you setup the Office 365 plugins to use and can be used independently or in conjucntion of the Office 365 plugins.

Office Mix
----------

#### Instructions for setting up Office Mix as an External Tool in Moodle

1. Register your Moodle installation with Office Mix

  * Go to https://mix.office.com/lti/.
  * Click Register an LMS.
  * If you are not already signed in, you will need to sign in with an appropriate account.
  * Type a name to describe your Moodle installation.
  * Select the checkbox indicating that you agree to allow Office Mix to pass data to your Moodle installation.
  * Click Save.
  * Make note of the Consumer Key, Shared Secret, and Launch URL that will be displayed on the page. You will need these in the subsequent steps below.
  * To retrieve these at a later time, you can return to https://mix.office.com/lti/ and click Manage Your Registrations.

2.  Add Office Mix as an External Tool in Moodle

  * Log in to Moodle using your administrator account.
  * Go to Site Administration.
  * Go to Plugins > Activity modules > LTI > Manage external tool types.
  * Select Active.
  * Click Add external tool configuration.
  * In the Tool name box, type an appropriate name, such as "Office Mix".
  * In the Tool base URL box, enter the Launch URL obtained above.
  * In the Consumer key and Shared secret boxes, enter the values obtained above.
  * Check the "Show tool type when creating tool instances" checkbox.
  * Configure Privacy settings according to your requirements.

      Note: Sending the Name of the user will allow Office Mix to display rich analytics and question responses.
      If you do not send any user information, then Office Mix will not be able restore a student's answers
      if they view the content on a subsequent visit.

  * Click Save changes.

Now that Office Mix has been configured, teachers or admins can follow the instructions in the next section to embed a Mix into course content:

  * Log in to Moodle as a Teacher or Admin.
  * Select the course you'd like to work with.
  * Click Turn editing on.
  * Locate the section that you'd like to modify and click Add an activity or resource.
  * Select External tool.
  * Click Add.
  * In the General settings:
  * In the Activity name box, type a name for your activity.
  * Select Office Mix from the External tool type list.
  * Set your Privacy and Grade settings.
  * Click Save and display. At this point, you should see a placeholder for your activity.
  * In the embedded activity, use one of these methods to select a mix:

    * Using URL: A simple way to select a mix is to visit the Office Mix website, select the mix you want to include in the course, copy the URL from the browser address bar and paste it in the dialog. This method makes it easy to include mixes that have been created by other people.

    * Using My Mixes: You can also select a mix from your My Mixes page from the Office Mix website. In order to prevent students from having to sign in to view a mix, only those mixes with permissions set to Unlisted or Public are shown.

  * After you have selected a mix, click Yes to confirm that this is the mix you'd like to use.
  * At this point, you should see the mix embedded within your course.

** Additional Resources**
You may also refer to these Office Mixes for more information

  * <https://mix.office.com/en-us/Lti/UsingMoodle>
  * <https://mix.office.com/en-us/Lti/SetupMoodle>

OneNote Class Notebook
----------------------

#### Instructions for setting up OneNote Class Notebook as an External Tool


1.  Register your Moodle installation with OneNote Class Notebook

  * Go to https://www.onenote.com/lti.
  * If you are not already signed in, you will need to sign in with an appropriate account.
  * On the "Register Your LMS" page, enter a name to describe your Moodle installation.
  * Click "Register".
  * Make note of the Consumer Key, Shared Secret, and Launch URL that will be displayed on the page. You will need these in the subsequent steps below.
  * To retrieve these at a later time, you can return to https://www.onenote.com/lti/ and click View/Manage Your Registration.

2.  Add OneNote Class Notebook as an External Tool in Moodle

  * Log in to Moodle using your Moodle administrator account.
  * Go to Site Administration.
  * Go to Plugins > Activity modules > LTI > Manage external tool types.
  * Select Active.
  * Click Add external tool configuration.
  * In the Tool name box, type an appropriate name, such as "OneNote Class Notebook".
  * In the Tool base URL box, enter the Launch URL obtained above.
  * In the Consumer key and Shared secret boxes, enter the values obtained above.
  * Check the "Show tool type when creating tool instances" checkbox.
  * Configure Privacy settings according to your requirements.
  * Click Save changes.

Now that OneNote Class Notebook has been configured, teachers or admins can follow the instructions in the next section to embed a Class Notebook into course content by following the steps below:

  * Log in to Moodle as a Teacher or Admin.
  * Select the course you'd like to work with.
  * Click Turn editing on.
  * Locate the section that you'd like to modify and click Add an activity or resource.
  * Select External tool.
  * Click Add.
  * In the General settings:
  * In the Activity name box, type a name for your activity.
  * Select "OneNote Class Notebook" from the External tool type list.
  * Set your Privacy and Grade settings.
  * Click Save and display. At this point, you should see a placeholder for your activity.
  * At this point, you should see the Notebook embedded within your course.
  * You will be guided through a sequence of dialogs to set up your notebook. Unless you want to change something, you can simply click Next on each one of them.
  * At the end, a notebook will be added to your course.

**Additional Resources**
You may also refer to this Office Mix presentation for more information: <https://mix.office.com/watch/hg1qya375vxx>

Appendix: Class Notebook Add-in for OneNote and Moodle
======================================================

In order to use the Class Notebook Add-In for OneNote you must enable Office 365 web services.

Setup
-----

1. Enable web services.
  1. Go to `Site administration > Advanced features`. Check the box next to "Enable webservices" and click "Save changes"
2. Enable the REST web services protocol
  1. Go to the web services "Manage protocols" page: `Site administration > Plugins > Web services > Manage protocols`.
  2. If the icon in the "Enable" column for the "REST protocol" row has a slash through it, click the icon to enable the protocol.
  3. Click Save changes
3. Enable the "Microsoft Office 365 Webservices" service.
  1. Go to the web services "External services" page: `Site administration > Plugins > Web services > External services`.
  2. Find "Moodle Office 365 Webservices" in the "Built-in services" list, and click the "Edit" link in that row.
  3. Ensure the "Enabled" setting is checked (check it if it is not), and click "Save changes".
4. Create a "webservices" role that allows users to use the REST webservice protocol.
  1. Go to the "Define roles" page: `Site administration > Users > Permissions > Define roles`
  2. Click "Add a new role"
  3. Choose "No role" for "Use role or archetype", click "Continue"
  4. Enter "rest_webservice_user" as the role short name, and "REST Webservice User" as the custom full name.
  5. Allow this role to be assigned at the system context.
  6. Search for `webservice/rest:use` in the list of permissions, and check the "Allow" box in that row.
  7. Scroll to the bottom of the page and click "Create this role"
5. Assign each of the users you want to use the webservice this "REST Webservice User" role.
  1. Go to the "Assign system roles" page: `Site administration > Users > Permissions > Assign system roles`.
  2. Click the "REST Webservice User" link.
  3. Choose each user you want to assign from the right menu (you may have to search for each user individually), and click "Add" to assign them to the role.
6. Create a token for each user you want to be able to use the webservice.
  1. Go to the web service "Manage tokens" page: `Site administration > Plugins > Web services > Manage tokens`
  2. Click the "Add" link.
  3. Choose the user you want to create a token for from the "User" list.
  4. Choose "Moodle Office 365 Webservices" from the "Service" list.
  5. Click "Save changes"

Making a webservice call
------------------------
Now that webservices are set up on your Moodle site, you can begin making webservice calls.

All webservice calls:
- are POST requests made to `[moodle]/webservice/rest/server.php`
- use URL encoded parameters in the body of the post request.
- require (at minimum) three parameters:
  - `wstoken` This is the token you created for the user in the "setup" section above.
  - `wsfunction` This is the name of the function you are calling.
  - `moodlewsrestformat` This is the format you expect the response in, we will use "json"

For example, a request to get a list of a teacher's courses:
```
POST http://example.com/webservice/rest/server.php
Content-Type: application/x-www-form-urlencoded

wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_get_teachercourses&moodlewsrestformat=json
```

Service reference
-----------------

#### Get courses of a teacher
This function gets a list of courses that the requesting user is a teacher in. "Teacher" in this case is defined as a user with the `moodle/grade:edit` capability.

**Function:** local_o365_get_teachercourses

**Parameters:** none

**Response:** array of objects, each containing:
- `id` *int* The course ID.
- `shortname` *string* The shortname of the course.
- `fullname` *string* The full name of the course.
- `idnumber` *string* The course ID number.
- `visible` *int* Whether the course is visible. 1 or 0, 1 being visible, 0 being hidden.
- `format` *string* The course format.
- `showgrades` *int* Whether grades are shown.
- `lang` *string* The course language.
- `enablecompletion` *int* Whether completion is enabled.


#### Get users by course ID
This function gets a list of user enrolled in a given course. This will only return information for courses the requesting user can access.

**Function:** local_o365_get_course_users

**Parameters:**
- `courseid` *int* The ID of the course

**Response:** array of objects, each containing:
- `id` *int* The user's ID.
- `fullname` *string* The user's full name.
- `firstname` *string* The user's first name.
- `lastname` *string* The user's last name.
- `email` *string* The user's email address.
- `profileimageurlsmall` *string* A URL to a small version of the user's profile photo.
- `profileimageurl` *string* A URL to the user's profile photo.


#### Create OneNote Assignment
This function will create a new OneNote assignment in a given course.

**Function:** local_o365_create_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `name` *string* The name of the assignment.
  - `course` *int* The ID of the course to create the assignment in.
  - `intro` *string* (Optional) A description of the assignment. Default is an empty string.
  - `section` *int* The ID of the course section to create the assignment in.
  - `visible` *int* (Optional) Whether to make the assignment visible or hidden. 1 to make visible, 0 to make hidden. Default is 0 (hidden).

**Response:**
- `data` *array* Array of objects, each containing:
  - `course` *int* The ID of the course the assignment was created in.
  - `coursemodule` *int* The course module ID.
  - `instance` *int* The assignment ID.
  - `name` *string* The name of the created assignment.
  - `intro` *string* The description of the created assignment.
  - `section` *string* The ID of the course section the assignment was created in.
  - `visible` *int* Whether the assignment is visible or hidden. 1 = visible, 0 = hidden.


#### Get information about a OneNote assignment
This function will return information about a OneNote assignment given a course module ID and course ID.

**Function:** local_o365_get_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `coursemodule` *int* The course module ID.
  - `course` *int* The ID of the course the assignment is in.

**Response:**
- `data` *array* Array of objects, each containing:
  - `course` *int* The ID of the course the assignment is in.
  - `coursemodule` *int* The course module ID.
  - `instance` *int* The assignment ID.
  - `name` *string* The name of the assignment.
  - `intro` *string* The description of the assignment.
  - `section` *string* The ID of the course section the assignment is in.
  - `visible` *int* Whether the assignment is visible or hidden. 1 = visible, 0 = hidden.


#### Update a OneNote assignment
This function will allow you to update various attributes of a OneNote assignment.

**Function:** local_o365_get_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `coursemodule` *int* The course module ID.
  - `course` *int* The ID of the course the assignment is in.
  - `name` *string* (Optional) The new assignment name to set.
  - `intro` *string* (Optional) The new description to set.
  - `section` *string* (Optional) The ID of the course section to move the assignment to.
  - `visible` *int* (Optional) The assignment's new visibility status. 1 = visible, 0 = hidden.

**Response:**
- `data` *array* Array of objects, each containing:
  - `course` *int* The ID of the course the assignment is in.
  - `coursemodule` *int* The course module ID.
  - `instance` *int* The assignment ID.
  - `name` *string* The name of the assignment.
  - `intro` *string* The description of the assignment.
  - `section` *string* The ID of the course section the assignment is in.
  - `visible` *int* Whether the assignment is visible or hidden. 1 = visible, 0 = hidden.


#### Delete a OneNote assignment
This function will allow you to remove a OneNote assignment.

**Function:** local_o365_delete_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `coursemodule` *int* The course module ID.
  - `course` *int* The ID of the course the assignment is in.

**Response:**
- `result` *bool* Whether the operation was successful (true), or not (false).


Example use case: Teacher managing assignments
----------------------------------------------

1. Get a list of the teacher's courses

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_get_teachercourses&moodlewsrestformat=json
  ```
  Response:
  ```
  [
    {
      "id":3,
      "shortname":"PSYCH102",
      "fullname":"Introductory Psychology 2",
      "idnumber":"",
      "visible":1,
      "format":"weeks",
      "showgrades":true,
      "lang":"",
      "enablecompletion":false
    },
    {
      "id":2,
      "shortname":"PSYCH101",
      "fullname":"Introductory Psychology 1",
      "idnumber":"",
      "visible":1,
      "format":"weeks",
      "showgrades":true,
      "lang":"",
      "enablecompletion":false
    }
  ]
  ```
2. Get a list of users for PSYCH101.

  This uses the 'id' parameter for the PSYCH101 course returned above as the 'courseid' parameter.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_get_course_users&moodlewsrestformat=json&courseid=2
  ```
  Response:
  ```
  [
    {
      "id":175,
      "fullname":"John Smith",
      "firstname":"John",
      "lastname":"Smith",
      "email":"john.smith@example.com",
      "profileimageurlsmall":"http:\/\/example.com\/theme\/image.php\/clean\/core\/1459671559\/u\/f2",
      "profileimageurl":"http:\/\/example.com\/theme\/image.php\/clean\/core\/1459671559\/u\/f1"
    },
    {
      "id":176,
      "fullname":"Jane Smith",
      "firstname":"Jane",
      "lastname":"Smith",
      "email":"jane.smith@example.com",
      "profileimageurlsmall":"http:\/\/example.com\/pluginfile.php\/24\/user\/icon\/clean\/f2?rev=469",
      "profileimageurl":"http:\/\/example.com\/pluginfile.php\/24\/user\/icon\/clean\/f1?rev=469"
    },
  ]
  ```
3. Get a list of assignments for PSYCH101

  This uses the 'id' parameter for the PSYCH101 course returned in step 1 as the sole item in the 'courseids' parameter.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=mod_assign_get_assignments&moodlewsrestformat=json&courseids%5B%5D=2
  ```
  Response:
  ```
  {
    "courses":[
      {
        "id":2,
        "fullname":"Introductory Psychology",
        "shortname":"PSYCH101",
        "timemodified":1450214936,
        "assignments":[
          {
            "id":1,
            "cmid":2,
            "course":2,
            "name":"OneNote Test Assignment",
            "nosubmissions":0,
            "submissiondrafts":0,
            "sendnotifications":0,
            "sendlatenotifications":0,
            "sendstudentnotifications":1,
            "duedate":0,
            "allowsubmissionsfromdate":0,
            "grade":100,
            "timemodified":1447960195,
            "completionsubmit":0,
            "cutoffdate":0,
            "teamsubmission":0,
            "requireallteammemberssubmit":0,
            "teamsubmissiongroupingid":0,
            "blindmarking":0,
            "revealidentities":0,
            "attemptreopenmethod":"none",
            "maxattempts":-1,
            "markingworkflow":0,
            "markingallocation":0,
            "requiresubmissionstatement":0,
            "configs":[
              {
                "id":1,
                "assignment":1,
                "plugin":"file",
                "subtype":"assignsubmission",
                "name":"enabled",
                "value":"0"
              },
              {
                "id":2,
                "assignment":1,
                "plugin":"onlinetext",
                "subtype":"assignsubmission",
                "name":"enabled",
                "value":"0"
              },
              {
                "id":3,
                "assignment":1,
                "plugin":"onenote",
                "subtype":"assignsubmission",
                "name":"enabled",
                "value":"1"
              },
              ...
            ]
            "intro":"",
            "introformat":1
          }
        ]
      }
    ]
  }
  ```
4. Get existing grades for the "OneNote Test Assignment" in PSYCH101.

  This uses the 'id' parameter from the assignment we want from the 'assignments' object returned in the above step as the sole item in the 'assignmentids' parameter.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=mod_assign_get_grades&moodlewsrestformat=json&assignmentids%5B%5D=1
  ```
  Response:
  ```
  {
    "assignments":[
      {
        "assignmentid":1,
        "grades":[
          {
            "id":3,
            "userid":175,
            "attemptnumber":0,
            "timecreated":1459661701,
            "timemodified":1459662202,
            "grader":3,
            "grade":"88.00000"
          }
        ]
      }
    ],
    "warnings":[]
  }
  ```
  We can see here there is one grade present for this assignment, from user "John Smith" (ID 175 from step 2).
5. Create a new grade entry

  This request uses the assignment id found in step 3, the user id from step 2 and a the new grade to set.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_update_grade&moodlewsrestformat=json&assignmentid=1&userid=175&grade=78&attemptnumber=-1&addattempt=0&workflowstate=&applytoall=1&plugindata%5Bassignfeedbackcomments_editor%5D%5Btext%5D=&plugindata%5Bassignfeedbackcomments_editor%5D%5Bformat%5D=2&plugindata%5Bfiles_filemanager%5D=0
  ```

  This function should return null if it was successful. You can repeat step 4 to verify the grade was saved correctly.

6. Create a new OneNote assignment

  This will create a new assignment in a given course, with the OneNote assignment and feedback types enabled.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_create_onenoteassignment&moodlewsrestformat=json&data%5Bname%5D=A+new+test+onenote+assignment&data%5Bcourse%5D=2
  ```
  Response:
  ```
  {
    "data":[
      {
        "course":2,
        "coursemodule":91,
        "name":"A new test onenote assignment",
        "intro":"",
        "section":1,
        "visible":0,
        "instance":49
      }
    ]
  }
  ```
  Note that the "assignment id" referenced above for use with the grade-related functions is the "instance" attribute returned here. The "coursemodule" attribute is used with the other OneNote assignment functions (along with the course id) to get, update, or delete the assignment.

Appendix: oEmbed Filter
=======================

This filter allows users to embed documents from various online sources to be embedded into Moodle content. The user only has to enter the URL to the document and the filter takes care of converting the URL into an embeddable IFRAME. This filter has a white list of services it supports. The list of supported services can be seen and selectively enabled or disabled in the settings page for this filter.

Embedding Power BI Reports
--------------------------

This filter allows users to embed Power BI items into a course.

1. If you have upgraded filter plugin recently, clear the Moodle cache first then go to filter plugin settings and esure that the PowerBI filter is enabled.

2. In the Azure Portal (https://manage.windowsazure.com) go to your AD application, then inside 'Permissions to other applications' click Add Application.

3. Select Power BI Service, save, then set Delegated permissions as follows:
    1. View all reports(preview)
    2. Read and Write all Datasets
    3. View all Datasets
    4. View all Dashboards(preview)

4. Click on Save

5. Login to Office 365 and go to the Power BI app.

6. The menu on the left hand side contains the Reports section. Select the report you want to embed. (Note that the filter only works for Reports, not for Tiles.)

7. Copy the URL & paste it into Moodle content where you would like to embed the report.

8. Save the Moodle content and view it. You should see the URL you entered get converted into an IFRAME with the report showing inside it.

Appendix: Developer Documentation
=================================

Setting up a Moodle Dev Test with the Office 365 plugins in Azure using Azure Resource Manager Templates
--------------------------------------------------------------------------------------------------------

This document describes how to deploy Moodle and the Office 365 plugins quickly and easily on Microsoft Azure using an Azure Resource Manager (ARM) template. Azure Resource Manager (ARM) templates are declarative templates written in JSON that can be used to quickly create entire deployments consisting of VM's, databases, load balancers, network configuration etc. Please note that you need to have an Azure subscription to create these deployments. If you don't already have a subscription, you can get a free trial subscription here: https://azure.microsoft.com/en-us/pricing/free-trial/
* Go to the appropriate template on Github:
    * To create a single VM deployment on Ubuntu, go to https://github.com/Azure/azure-quickstart-templates/tree/master/moodle-singlevm-ubuntu
    * To create a clustered deployment on Ubuntu, go to https://github.com/Azure/azure-quickstart-templates/tree/master/moodle-cluster-ubuntu
* The readme describes the layout of the deployment that will be created and additional services you can set up after the deployment is done.
* Click on the "Deploy to Azure" button in the readme
* This will take you to the Azure portal with the template ready to be customized and deployed.
* You will need to enter the required parameters, specify a resource group, accept the legal terms, and start your deployment.
* When the deployment is complete, your Moodle instance will already be set up with the Office 365 plugins (if selected).

Setting up a development site
-----------------------------

While Moodle requires each plugin to be it's own repository, developing a set of dependant plugins can be made easier by using a single repository for all plugins and overlaying the repository on top of a Moodle repository. In this setup, two repositories live in the same directory using two different .git directories – usually .git and .mdlgit. Using repository-specific gitignore rules, each repository deals with it's own files – allowing you to manage files, change branches, and view status independently.

### Setup
1. Clone Moodle into a new directory (or use a clean existing site), and check out the branch you'll be using.
    ```
    git clone [repository] [directoryname]
    ```
2. Change directories to the cloned site
3. Check out the branch you'll be using.
    ```
    git checkout -t -b MOODLE_35_STABLE origin/MOODLE_35_STABLE
    ```
4. Rename the .git directory to .mdlgit
5. Clone the development repository into a bare repository within the checked out Moodle code git clone --bare [repository] .git
6. Add gitignore rules.
   1. Note: In a .git directory, repository-specific gitignore rules can be placed in info/exclude. Note that these rules will not be committed to the repository, so must be manually added for each new clone.
   2. Add the following to .git/info/exclude:
    ```
    **
    !auth
    !auth/oidc
    !auth/oidc/**
    !blocks
    !blocks/microsoft
    !blocks/microsoft/**
    !filter
    !filter/oembed
    !filter/oembed/**
    !local
    !local/o365
    !local/o365/**
    !local/office365
    !local/office365/**
    !local/onenote
    !local/onenote/**
    !mod
    !mod/assign
    !mod/assign/feedback
    !mod/assign/feedback/onenote
    !mod/assign/feedback/onenote/**
    !mod/assign/submission
    !mod/assign/submission/onenote
    !mod/assign/submission/onenote/**
    !repository
    !repository/office365
    !repository/office365/**
    ```
   3. Add the following to .mdlgit/info/exclude.
    ```
    .mdlgit
    auth/oidc
    blocks/microsoft
    filter/oembed
    local/o365
    local/office365
    local/onenote
    mod/assign/feedback/onenote
    mod/assign/submission/onenote
    repository/office365
    ```
7. Manually change the development repository into a normal repository
    ```
    git config core.bare false
    git config remote.origin.fetch "+refs/heads/*:refs/remotes/origin/*"
    git fetch
    git checkout [branch]
    ```
8. Check status
    ```
    git status
    git --git-dir=.mdlgit status
    ```

Coding Standards
----------------

### Code Style
- All changes must adhere to the Moodle coding style.
- All changes must pass a peer-review by a maintainer.
- Use the short-array syntax - [] instead of array()

### Code Documentation
1. All files must have the standard Moodle copyright notice at the top.
```php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.
```
2. All files must have a package, author, license, and copyright line.
```php
/**
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */
```
   1. The package must be the component name of the plugin the file is part of - local_o365, repository_office365, etc.
   2. The author line must be your full name and company email address.
   3. The license must be a GPLv3 or later line, shown above.
   4. The copyright line must be "[year] onwards Microsoft Open Technologies, Inc.", shown above.
3. All classes must have a doc block, explaining the purpose of the class.
4. All methods must have a complete doc block explaining the purpose of the method, all parameters, and return values.
5. All class properties must have a short doc block explaining the property type and the property's purpose.
   Ex.
   ```
   /** @var \local_o365\httpclientinterface An HTTP client to use for communication. */
   ```

### Autoloading
All new classes must be autoloadable and placed in the classes directory of the plugin. No exceptions.

### API Calls
1. All API calls must have their responses validated, with any errors logged. For classes that extend \local_o365\rest\o365api, you can use $this->process_apicall_response, which will detect standard error responses and allow you to specify required keys and values.
2. Use existing classes to manage and access tokens, http requests, and client data. They handle things like token refreshing, tokens for new resources, and http request quirks automatically.
3. Plugin code generally doesn't access the rest API classes directly, but calls higher-level functions in feature classes. These are located in classes\feature. This allows the underlying API to be switched out by only modifying the feature class. This is not a strict rule but should be done whenever possible.
4. When making an API call and fetching the token with \local_o365\oauth2\token::instance or \local_o365\oauth2\systemtoken::instance, check that you actually received a token object. This function will return null if it could not get a token for the specified user/resource, and this often happens when the plugins have not yet been configured, or configured incorrectly.
\local_o365\oauth2\clientdata::instance_from_oidc is a time-saving function that will construct a clientdata object from the configured values in auth_oidc. You should use this to keep code simple and ensure a proper object is constructed. However, it will throw an exception if auth_oidc is not configured, so your code needs to expect and handle that.

### Architecture
1. Feature Classes/Namespaces
   1. Plugin features, ex. Calendar sync, user sync, and user group creation, must be organized into "feature" namespaces within the \local_o365\feature namespace. Everything specific to a feature incl. event handlers, tasks, page classes, and general code must live somewhere within the feature namespace. This keeps feature-specific mode centralized and modular.
   2. "Features" often have "main" classes that are functionality abstractions that live between the main plugin code and the API classes. This is mainly done to gracefully handle API changes like the Graph API migration, but also keeps specific actions centralized and standardized.
   3. Main plugin code, i.e. user/admin control panel pages, must call a feature class instead of a specific API class. If we need to change the underlying API or change how an API call is handled, we can just update the feature class and not every API call.
2. API Classes
   1. All classes that call Office 365 APIs must live in the \local_o365\rest namespace. These must extend \local_o365\rest\o365api.
   2. All JSON API responses must be run through $this->process_apicall_response. This will check for error responses, and optional defined structure, and do required logging.
3. Utility Class
   1. \local_o365\utils provides a number of useful functions to perform common tasks in a standardized way.
      1. is_configured() - This determines whether the plugins are configured and active. Any plugin code that could run when the plugins are not configured, ex. event handlers and tasks, must use this function to check whether the plugins are configured and, if not, exit early before attempting any work.
      2. is_o365_connected() - Performs a number of checks to determine whether a user is connected to Office 365. This should be used to check whether to perform plugin-specific tasks for a user, ex. in event handlers and tasks.
4. Page Classes
   1. Any user-facing interface must use page classes, extending the \local_o365\page\base class.
   2. Page classes implement different views in "mode" functions within the class and are then run by instantiating the page class and running $page->run($mode).
   3. For example, if you run $page->run('calendar') the page class will run mode_calendar(). There is also a general "header()" function you can implement to run general page setup tasks. See \local_o365\page\ajax and \local_o365\page\ucp for examples of implemented page classes, and /local/o365/ajax.php and /local/o365/ucp.php for example of how to run a page class.

### Installs, Upgrades, Uninstalls
1. All upgrade steps must be able to be run more than once without damaging data. They should be written in a way to check whether the upgrade is needed, or to check for old data when migrating data. Remember that all upgrade steps will be run again when a user moves major Moodle versions - 2.7 to 2.8 for example, so be prepared!
2. Use db_manager functions like table_exists, field_exists, index_exists.
3. Check for existing values when setting default values.
