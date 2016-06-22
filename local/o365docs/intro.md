Introduction
============
Office 365 and Active Directory plugins for Moodle provide a more coherent and synchronous experience for teachers and students using both Moodle and Office 365. In order to be used, an Moodle administrator with Office 365 administrator privileges must configure the plugins for the Moodle site.

Requirements
============

To use the Office 365 plugins, you need the following:

-   An Office 365 subscription.
-   A Microsoft Azure subscription.
-   Moodle version 2.7 or above.

Please note no paid Azure services are required to use the plugins. In particular, Azure Active Directory (also known as Azure AD or AAD) comes in three editions: Free, Basic, and Premium. The Free edition is all that is needed for use of the plugins. You can access the Azure Active Directory associated with your Office 365 tenant from the Office 365 Admin Settings.  

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
-   **Microsoft Block** (block\_microsoft)
    -   This block provides a user-facing menu to access various Office 365 integration features, resources, and settings.
    -   Links to Office 365 Resources associated with Moodle Courses (including Course SharePoint sites and Course Office 365 Groups) as well as a user's personal Office 365 Resources (including OneDrive for Business, Sways, Docs.com, Delve, Forms & OneNote Notebook). 
	-   Contains Settings for settings such as Outlook Calendar sync preferences.
	-   Shows connection status to Office 365 and user photo from Outlook.
-   **Microsoft Office 365 Integration Local plugin** (local\_o365)
    -   This plugin provides most of the Office 365 integration back-end. This provides shared code to communicate with Office 365, and powers the calendar sync.
    -   Features
        -   Calendar sync from/to Office 365 Outlook.
            -   Users can sync site events, course events, assignment due dates, and their personal Moodle calendar to their Outlook calendar.
        -   SharePoint sites for each Moodle course.
            -   You can connect your Moodle instance to a SharePoint subsite. Sites below this will be created for each course in your Moodle instance, and the document library from each course subsite is accessible through the OneDrive for Business repository. The course subsite document library is accessible by course teachers, serving as a place for teachers to share documents.
		-   Office 365 Groups for each Moodle course
			-	You can create Office 365 groups for each course in your Moodle instance. Links to Office 365 group resources such as Files, Conversations, and Calendar will be accessible from the Microsoft Block in each course. Moreover, the group files from each course group is accessible through the Office 365 repository. The group files is accessible by course teachers and students, serving as a place for teachers and students to share documents.
-   **OneNote Local plugin** (local\_onenote)
    -   This provides supporting and shared code used by all other OneNote plugins. Does not have an user interface or configuration by itself.
-   **OneNote Assignment Feedback** (assignfeedback\_onenote)
    -   Allows teachers to leave feedback for students using OneNote.
-   **OneNote Assignment Submission** (assignsubmission\_onenote)
    -   Allows students to submit assignments using OneNote.
-   **OneNote Repository** (repository\_onenote)
    -   Allows access to a user's OneNote files from the Moodle repository view.
-   **Office 365 Repository** (repository\_office 365)
    -   This is a repository plugin that allows users to access Office 365 resources in Office 365 services such as OneDrive for Business, SharePoint, and Office Video directly from the Moodle file-picker. 
    -   Features:
        -   Import files into Moodle from Office 365.
        -   Upload files into Office 365 services from within Moodle.
        -   Link to resources in Office 365 so users always get the most up-to-date version.
        -   Embed Office 365 resources into Moodle courses so users can view them directly on the site.
-   **oEmbed Filter** (filter\_oembed)
    -   This filter converts links to a variety of sites into oembed-powered interactions.
    -   Allows you to embed Office Mix, Sway, Docs.com, Office Video, Excel Power View, and Microsoft Forms content into your Moodle courses. 
