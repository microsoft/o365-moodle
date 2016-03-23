Introduction
============

Office 365 services complement the Moodle learning platform to provide a more productive experience for teachers and students.

Requirements
============

To use the Office 365 plugins, you need the following:

-   An Office 365 subscription.
-   A Microsoft Azure subscription.
-   Moodle version 2.7 or above.

Plugins & Features
==================

The Office 365 set of plugins contains 10 different plugins which provide a wide variety of features to enhance your Moodle instance.

-   **Office 365 Local Plugin** (local\_office365)
    -   This is a shell plugin which has dependencies on the current version of each of the 9 plugins that make up the complete set. Installing this plugin ensures you have the current version of each of the functional plugins installed.
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
-   **Microsoft Block**
    -   This block provides a user-facing menu to access various Office 365 integration features, resources, and preferences.
    -   Links to: Course SharePoint sites, Azure AD login preferences, Calendar sync preferences, OneNote notebooks, and the Office 365 integration user control panel.
-   **Office 365 support plugin** (local\_o365)
    -   This plugin provides most of the Office 365 integration back-end. This provides shared code to communicate with Office 365, and powers the calendar sync.
    -   Features
        -   Calendar sync from/to Office 365 Outlook.
            -   Users can sync site events, course events, assignment due dates, and their personal Moodle calendar to their Outlook calendar.
        -   SharePoint sites for each Moodle course.
            -   You can connect your Moodle instance to a SharePoint subsite. Sites below this will be created for each course in your Moodle instance, and the document library from each course subsite is accessible through the OneDrive for Business repository. The course subsite document library is accessible by course teachers, serving as a place for teachers to share documents.
-   **OneNote support plugin** (local\_onenote)
    -   This provides supporting and shared code used by all other OneNote plugins. Does not have an user interface or configuration by itself.
-   **OneNote Assignment Feedback** (assignfeedback\_onenote)
    -   Allows teachers to leave feedback for students using OneNote.
-   **OneNote Assignment Submission** (assignsubmission\_onenote)
    -   Allows students to submit assignments using OneNote.
-   **OneNote Repository** (repository\_onenote)
    -   Allows access to a user's OneNote files from the Moodle repository view.
-   **OneDrive for Business Repository** (repository\_office 365)
    -   This is a repository plugin that communicates with OneDrive for Business. If the SharePoint link is configured, this also provides access to Moodle course SharePoint sites' document libraries.
    -   Features
        -   Import files into Moodle from OneDrive for Business
        -   Upload files into OneDrive for Business from within Moodle
        -   Link to files in OneDrive for Business so users always get the most up-to-date version.
        -   Embed documents into Moodle courses so users can view documents directly on the site.
-   **oEmbed Filter** (filter\_oembed)
    -   This filter converts links to a variety of sites into oembed-powered interactions.
    -   Provides [Office Mix](https://mix.office.com/) support for Moodle, allowing you to embed Office Mixes directly into any text within Moodle.

Resources
=========

Azure Resource Manager Templates These can be used to set up a quick & easy test enviroment in Azure.

-   <https://azure.microsoft.com/en-us/documentation/templates/moodle-singlevm-ubuntu/>
-   <https://azure.microsoft.com/en-us/documentation/templates/moodle-cluster-ubuntu/>

Setup
=====

Installation
------------

The packages are available from:

-   The [Moodle Plugins directory](https://moodle.org/plugins/)
    -   [Office 365 Plugin Set](https://moodle.org/plugins/browse.php?list=set&id=72)
-   GitHub
    -   <https://github.com/MSOpenTech/moodle-local_office365>
    -   <https://github.com/MSOpenTech/moodle-auth_oidc>
    -   <https://github.com/MSOpenTech/moodle-block_microsoft>
    -   <https://github.com/MSOpenTech/moodle-local_o365>
    -   <https://github.com/MSOpenTech/moodle-local_onenote>
    -   <https://github.com/MSOpenTech/moodle-assignfeedback_onenote>
    -   <https://github.com/MSOpenTech/moodle-assignsubmission_onenote>
    -   <https://github.com/MSOpenTech/moodle-repository_onenote>
    -   <https://github.com/MSOpenTech/moodle-repository_office365>
    -   <https://github.com/MSOpenTech/moodle-filter_oembed>

When you log back in to your Moodle instance, you are presented with the all the plugin configuration options. Save the settings without configuring them for now, you will come back to them later.

For information on installing plugins in Moodle see [Installing plugins](Installing plugins "wikilink")

Configuration
-------------

After you have the code installed in your Moodle instance, you'll need to do a bit of setup before you can use the plugins.

### Enable the OpenID Connect Authentication Plugin

1.  Navigate to **Site Administration \> Plugins \> Authentication** and click **Manage authentication**
2.  Locate the OpenID Connect authentication plugin and click the eye icon to enable
3.  Click the Settings link for the plugin.
4.  Verify the Authorization and Token endpoints. These should be set by default but if not, set the endpoints to the following:
    1.  **Authorization Endpoint:** <https://login.windows.net/common/oauth2/authorize>
    2.  **Token Endpoint:** <https://login.windows.net/common/oauth2/token>

5.  Note the Redirect URI. This should be the URI of your Moodle instance followed by /auth/oidc. You will need to enter this value into Azure AD later, so note this value and put it aside.
    1.  For example, <https://www.example.com/auth/oidc/>
    2.  Notes:
        1.  This is a fixed value that is derived from your Moodle site's configured URL (wwwroot). You cannot change this value directly. If you need to change it for any of the following reasons, you must change your Moodle site's configured domain name ($CFG-\>wwwroot).
        2.  This URL must be a fully qualified domain name pointing to your Moodle instance.
        3.  If your Moodle installation is configured with an IP address pointing to your instance, you must change $CFG-\>wwwroot in your config.php to a fully-qualified domain name.
        4.  This domain name does not need to be publicly accessible (i.e. internet-wide), but does need to be accessible to users of your Moodle instance. So, for example, you can use a intranet-only domain name.

### Prepare your Office 365 account for single sign-on with your Moodle installation

You will need an Azure subscription. If you do not have one, you can create one by visiting [http://azure.microsoft.com/en-us/pricing/free-trial/ Microsoft Azure Sign Up](http://azure.microsoft.com/en-us/pricing/free-trial/ Microsoft Azure Sign Up "wikilink")

To use Moodle with Office 365 for SSO, you must [configure Microsoft Azure](https://manage.windowsazure.com) to manage your Office 365 Microsoft Azure Active Directory:

1.  Create a new Active Directory.
2.  Select Use existing directory.

![Add directory dialog with creation options](images/AddDirectory1.png "fig:Add directory dialog with creation options")

3.  Select **I am ready to be signed out now** and click the check mark.

![Add directory dialog log out option](images/AddDirectory2.png "fig:Add directory dialog log out option")

4.  Sign in with your Office 365 subscription credentials.
5.  Click **Continue**.
6.  Log out and sign back in to your Azure account.

**Note**: During the setup, you are required to enter a credit card and phone number. If you do not setup virtual machines or use paid services on the subscription, and only use it to access the Azure Active Directory, you will not be charged for the subscription.

### Register Application in Azure

1.  Sign in to the [Microsoft Azure Management Portal](https://manage.windowsazure.com).
2.  Click on the **Active Directory** icon on the left menu, and then click on the desired Office 365 connected Azure AD.
3.  On the top menu, click **Applications**. If no apps have been added to your directory, this page will only show the **Add an App** link. Click on the link, or alternatively you can click on the **Add** button on the command bar.
4.  On the **What do you want to do** page, click on the link to **Add an application my organization is developing**.
5.  On the **Tell us about your application** page, you must specify a name for your application and indicate the type of application you are registering with Azure AD. Click **web application and/or web API** (default) and then click the arrow icon on the bottom-right corner of the page.
6.  On the App properties page, provide the **Sign-on URL** and **App ID URI** for your Moodle instance.
    1.  The Sign-on URI is the Redirect URI you from the OpenID Connect authentication plugin configuration. **Ensure there is a trailing slash for this URL - i.e. <https://example.com/auth/oidc/>**
    2.  The APP ID URI is the main URI of the Moodle instance.

7.  Click the checkbox in the bottom-right hand corner of the page and then click Ok to add your app to Azure Active Directory.
8.  There are a couple more values and changes you need to make and write down some values which you will need in the next section.

### Configure application

1.  Click on the **Active Directory** icon on the left menu, and then click on the desired Azure AD.
2.  Click the Applications tab at the top of the screen.
3.  Select your app.
4.  Click Configure at the top of the screen.
5.  Locate the **Client ID**, note this value (write it down or copy it somewhere), and set it aside. You'll need it later.
6.  Create a client secret key.
    1.  Locate the **keys** section of the page.
    2.  Select a duration for the validity of the key.
    3.  Click "Save" at the bottom of the screen. The page will reload and a key value will be shown in the keys section.
    4.  Note this key value (write it down or copy it somewhere) and set it aside. You'll need later.
    5.  ![OpenID Connect Settings](images/SettingOpenIDConnect.png "fig:OpenID Connect Settings")

7.  Locate the **Permissions to other applications** section.
8.  Click **Add application** click the plus sign to the right of **Office 365 Exchange Online**, **Office 365 SharePoint Online**, and **OneNote**. Note, the plus will appear when you hover over each of the items.
9.  Click the check mark at the bottom right of the dialog.
10. In the Delegated Permissions dropdown for Office 365 Exchange Online select the following permissions:
    1.  Read users’ calendars
    2.  Read and write users' calendars

11. In the Delegated Permissions dropdown for Office 365 SharePoint Online select the following permissions:
    1.  Read items in all site collections
    2.  Read and write items in all site collections
    3.  Create or delete items and lists in all site collections
    4.  Have full control of all site collections
    5.  Read user files
    6.  Read and write user files

12. In the Application Permissions dropdown for Windows Azure Active Directory select the following permissions:
    1.  Read directory data

13. In the Delegated Permissions dropdown for Windows Azure Active Directory select the following permissions:
    1.  Read directory data
    2.  Read all users' full profiles
    3.  Sign in and read user profile.

14. In the Delegated Permissions dropdown for OneNote select the following permissions:
    1.  Create pages in OneNote notebooks
    2.  View OneNote notebooks.
    3.  View and modify OneNote notebooks.

15. Click save at the bottom of the screen.

### Add a user to the app

1.  Click on the **Active Directory** icon on the left menu, and then click on the desired Azure AD.
2.  Click the Applications tab at the top of the screen.
3.  Select your app.
4.  Click the Users tab at the top of the screen.
5.  Select an Office 365 User to assign to assign to the App.
6.  Click Assign at the bottom of the screen.
7.  When prompted whether you are sure you want to enable access, click Yes.

The application will appear in the [My apps](https://portal.office.com/myapps) page of the application launcher on the o365 portal for the users which have been assigned.

### Enter Azure application credentials into Moodle

1.  Ensure you have enabled the **OpenID Connect** authentication plugin following the steps a few sections above.
2.  Navigate to the OpenID Connect authentication plugin's settings page (Site Administration \> Plugins \> Authentication \> OpenID Connect)
3.  Enter the "Client ID" value you noted earlier from Azure into the "Client ID" box on the screen.
4.  Enter the client secret key value you noted earlier from Azure into the "Client Secret" box on the screen.
5.  Click "Save changes" at the bottom of the screen.

### Configure the Office 365 support plugin

1.  Navigate to **Site Administration \> Plugins \> Local plugins**.
2.  Click **Microsoft Office 365 Integration**.
3.  Scroll down to the **Setup** section.
4.  Complete each of the setup settings as follows.
5.  Application Credentials
    1.  This should report that the credentials have been set. If not, you need to enter your Azure credentials by following the section above.

6.  System API User
    1.  This should report "No user set". Click "Set User"
    2.  You will be taken to an Office 365 login screen. Log in as a user that has administrator access in your Office 365 subscription.
    3.  This user is used for system operations that are not specific to a single user - i.e. user sync operations. This user needs to have administrator access to be able to access all needed information.
    4.  You can change this user later if needed.

7.  Azure AD Tenant
    1.  This is the domain name that identifies your Office 365 subscription, for example "contoso.onmicrosoft.com"
    2.  If you know it, enter it in this box, if not, click the "Detect" button to attempt to detect the correct value.

8.  OneDrive for Business URL
    1.  This is the URL that your users use to access OneDrive for Business. This can usually be determined from your AzureAD tenant, for example, if your tenant is "contoso.onmicrosoft.com", your OneDrive for Business URL is "contoso-my.sharepoint.com."
    2.  If you know the URL, enter it here, otherwise click "Detect" to attempt to detect the correct value.
    3.  Only enter the domain name, do not include "<http://>", "www." or any trailing slashes. For example "contoso-my.sharepoint.com", not "<https://contoso-my.sharepoint.com/>"

9.  Click Save changes.
10. Azure Setup
    1.  This tool verifies that Azure has been correctly set up. Click the "Update" button to check setup.
    2.  If the tool reports any missing permissions, return to Azure and ensure that all required permissions have been added to your configured application for Moodle.

11. SharePoint Link
    1.  If you want to connect your Moodle site to SharePoint, type the URL of a SharePoint site you'd like to use to connect to Moodle.
    2.  As you type, Moodle will verify the URL. You should type a complete URL of a SharePoint subsite. If the subsite does not exist, Moodle will attempt to create it.
    3.  For example: <http://contoso.sharepoint.com/moodle>

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

Office 365 Integration Local Plugin
===================================

Settings
--------

#### Health Check

If you are experiencing problems with any Office 365 / Moodle features, click the **Health Check** link to run tests on your system and look for potential problems.

#### Sync users with Azure AD

This controls how users are synced from Azure AD to Moodle. This can create or delete users in Moodle, match them with Azure users, and assign them to Azure applications. See the [Office365\#User\_sync](Office365#User_sync "wikilink") section below for more information.

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

OpenID Connect Authentication Plugin
====================================

Basic Usage
-----------

Once configured, you should see a link named "OpenID Connect" on the Moodle login page. Clicking this link will redirect the browser to the identity provider. Users will log in there, and will be redirected back to Moodle. If they have logged in to Moodle using OpenID Connect before, they will be logged in to their existing Moodle account. If they have not logged in to Moodle with OpenID Connect before, an account will be created for them.

Note: If the "Prevent account creation when authenticating" setting is enabled in Moodle, new accounts will not be created.

Settings
--------

There are a number of options you can use to customize how the plugin behaves. To configure the plugin, visit the plugin's settings page. (Site Administration \> Plugins \> Authentication \> OpenID Connect)

#### Provider Name

The name entered here will be used through the OpenID Connect plugin and the Office 365 plugins to refer to the system used to log users in. For example, if your users are used to calling their Azure AD account their "School" account, you enter "School account" here, and all references to authentication will be "Log in with your School account".

#### Auto-Append

When using the "Username/Password" login flow, this setting with automatically append a given string to an entered username. This is useful in Azure AD usernames, where a single domain name is often used for every user - i.e. [user]@contoso.onmicrosoft.com. Users would normally have to enter this entire username to successfully log in to Moodle, but in this example, entering "@contoso.onmicrosoft.com" here means users would only have to enter their unique username, i.e. "bob.smith", instead of "bob.smith@contoso.onmicrosoft.com".

#### Domain Hint

If users have several different Azure AD accounts with different tenants (i.e. @contoso.onmicrosoft.com, @example.onmicrosoft.com), but Moodle only uses one of these tenants, you can enter that tenant in this box to have the Azure AD login screen only ever suggest accounts from that tenant.

#### Login Flow

This setting changes how users log in to Moodle using the plugin. You can redirect users to the OpenID Connect provider's login page, or have users enter their credentials directly into Moodle. See the "Login Flows" section below for further information.

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

If you experience problems using OpenID Connect, enable this setting. Once enabled, errors will be recorded to the Moodle log for review. These errors can help you or the plugin developers debug and fix the problem. The error log can be viewed by navigating to Site Administation \> Reports \> Logs, changing the "All activities" select box to "Site errors", and clicking "Get these logs".

#### Custom Icon

This setting allows you to choose from a selection of predefined icons to appear next to the identity provider link on the login page. You can also upload your own icon.

1.  Visit the plugin settings page (Site Administration \> Plugins \> Authentication \> OpenID Connect)
2.  Locate the "Icon" section of the settings page.
3.  There are several predefined icons to choose from, clicking an icon will use that icon on the login page.
4.  To use a custom icon, use the file picker below the "Icon" setting.
    1.  This image will not be resized on the login page, so we recommend uploading an image no bigger than 35x35 pixels.
    2.  If you have uploaded a custom icon and want to go back to one of the stock icons, click the custom icon in the file picker and click "Delete", then "OK", then "Save Changes" at the bottom of the settings page. The selected stock icon will now appear on the Moodle login page.

Login flows
-----------

This plugin supports two different methods for users to log in: Authorization Request and Username/Password Authentication

### Authorization Request

This flow redirects the user to Office 365 to log in and are then brought back to Moodle logged in.

Using this flow:

1.  The user clicks the name of the identity provider (What you entered in the "Provider Name" box at the top of the settings page.) on the Moodle login page.
2.  The user is redirected to Office 365 to log in.
3.  Once successfully logged in, the user is redirected back to Moodle where the Moodle login takes place transparently.

### Username/Password Authentication

This login flow works like a classic username and password, except the user uses their Office 365 account information.

Using this flow:

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

OneDrive for Business Repository
================================

The OneDrive for Business repository allows users using the Office 365 integration plugins to connect to their OneDrive for Business as a Moodle repository.

Downloading and linking files
-----------------------------

1.  When using a filepicker anywhere in Moodle, you'll see a list of repositories on the left side of the popup. Look for and click on "OneDrive for Business".
2.  You'll see two folders - "My Files" and "Courses". Click the folder for the document library you want to access.
    1.  **My Files** contains all documents in your personal OneDrive for Business
    2.  **Courses** will list all Moodle course shared document libraries that you have access to. If you want to download files from one of these, you'll click "Courses", then click the folder for the course you want to access.

3.  You will now see a list of all the files and folders in your OneDrive.
4.  Click the file you want to download into Moodle.
5.  Choose to "Make a copy of the file", or "Create an alias/shortcut to the file."
    1.  If you want to download a copy of the file as it is now, choose "Make a cope of the file". This will copy the file into Moodle, and will then use the local Moodle copy when the file is accessed from within Moodle. Any changes to the file in OneDrive will not be seen in Moodle.
    2.  If you want to link a file choose "Create an alias/shortcut to the file". This will create a link in Moodle to the file in OneDrive, and the file will be accessed from OneDrive directly. Any changes to the file in OneDrive will be seen when accessing the file from Moodle.

6.  You can change other file information like the filename or author name using the respective text fields. This information is only applicable to the Moodle side of the file, and will not transfer to OneDrive.
7.  Click "Select this file".

Uploading files
---------------

You can upload files into both your personal OneDrive for Business document library and a course SharePoint document library from the filepicker interface.

1.  When accessing a OneDrive document library from a file picker, you will see an "Upload New File" item in the list of files and folders.
2.  Click the "Upload new file" item.
3.  Choose the file you want to upload and click "Upload this file".
4.  The file will be uploaded to OneDrive and selected for the file picker.

Embedding Office documents
--------------------------

This repository allows users to embed Office documents from OneDrive into a course and have the live version viewable using Office web apps.

1.  Start as a user connected to Office 365 and who has access to modify a course.
2.  Turn on editing for the course and choose "Add an activity or resource" for the section of the course you want to add the document.
    1.  ![Adding a course activity](images/repositoryoffice365addcourseactivity.png "fig:Adding a course activity")

3.  Choose the "File" resource to add to the course.
    1.  ![Adding a file resource to a course](images/repositoryoffice365choosefileresource.png "fig:Adding a file resource to a course")

4.  In the "Content" section of the file resource settings page, click the "Add" button in the filepicker
    1.  ![File resource settings page](images/repositoryoffice365addfile.png "fig:File resource settings page")

5.  Choose the "OneDrive for Business" repository and choose your Office document.
6.  When you select a file, make sure "Create an alias/shortcut to the file" is selected, the click "Select this file"
    1.  ![Selecting a file](images/repositoryoffice365choosefile.png "fig:Selecting a file")

7.  Expand the "Appearance" section, and choose "Embed" for the "Display" select box.
    1.  ![Display option for a file resource](images/repositoryoffice365chooseembed.png "fig:Display option for a file resource")

8.  Click "Save and display"
9.  You should see the file embedded into the page.
    1.  ![Office document embedded into page](images/repositoryoffice365embeddeddoc.png "fig:Office document embedded into page")

OneNote
=======

OneNote is now available through Office 365. If you have installed all the plugins (for example, by installing [1](https://moodle.org/plugins/view/local_office365)) then you already have the OneNote plugins installed. To access OneNote using your Office 365 subscription, add OneNote to the list of applications in your Azure application. This is done the same way you configured Azure permissions, above. Note that OneNote is still in preview, and may not be available to everyone yet. If you don't see OneNote in the list of applications to add to your Azure application, you can try logging in to a desktop OneNote application using an administrator account in your Office 365 tenant. This sometimes expedites to the process of adding the OneNote preview to your tenant. For more information on OneNote, see [MicrosoftServices\#Configuring\_OneNote](MicrosoftServices#Configuring_OneNote "wikilink")
