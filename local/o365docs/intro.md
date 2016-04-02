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
