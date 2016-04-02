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
    2.  Read and write users' calendars
    1.  Read users’ calendars
11. In the Delegated Permissions dropdown for Office 365 SharePoint Online select the following permissions:
    1.  Read and write user files
    2.  Read user files
    3.  Have full control of all site collections
    4.  Create or delete items and lists in all site collections
    5.  Read and write items in all site collections
    6.  Read items in all site collections
12. In the Delegated Permissions dropdown for Windows Azure Active Directory select the following permissions:
    1.  Read and write directory data.
    2.  Access the directory as the signed-in user.
    3.  Read directory data.
    4.  Read all users' full profiles
    5.  Sign in and read user profile.
13. In the Delegated Permissions dropdown for OneNote select the following permissions:
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

### Migrate the user to using their Office 365 credentials to log in to Moodle.

With this method, the user will log in to Moodle using their Office 365 account credentials.

- Users who do not yet have a Moodle account can simply follow the normal OpenID Connect login process (see: [OpenID Connect Authentication Usage](#openid-connect-authentication-plugin). If a Moodle account is not found for a user logging in with OpenID Connect, an account will be created for them.
- You can migrate existing Moodle users to Azure AD login by following the steps below:
  1. Ensure the user you want to migrate has the "auth/oidc:manageconnection" capability. Regular users do not have this capability by default.
  2. Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
  3. Log in as the user to be migrated, visit a page that has the Microsoft block visible.
  4. Click the **Connect to Office 365** link in the Microsoft block.
  5. You will be brought to the **Office 365 / Moodle Control Panel**.
  6. Click the *'Office 365 Connection* link under **Office 365 Features**
  7. Click the "Start using Office 365 to log in to Moodle." link.
  8. You will be redirected to Office 365 to log in. Log in to the Office 365 account you'd like to link the Moodle user to.
    1.  **NOTE:** If you are already logged in to Office 365, you will not have to enter your credentials on the Office 365 login page - the account you are logged in to will be linked to the Moodle account. Ensure you are logged in to the correct account, use a private browser window, or log out of Office 365 first to show the Office 365 login screen.
  9. You will be redirected back to Moodle to the Office 365 / Moodle control panel. The **Connection status** box on the side of the page should indicate that you are connected to Office 365 and that you are using Office 365 to log in to Moodle.
  10. The Moodle account will now use Office 365 to log in. **The previous Moodle login method will not work.**.
  11. The Moodle user can now use any of the Office 365 features in Moodle.

### Link a Moodle user to an Office 365 user.

This will allow you to connect a user to Office 365, enable all Office 365 features with this user, but not have to change their Moodle login method.

1. Ensure the Microsoft block has been added to a page in Moodle (for example, the Moodle dashboard).
2. Log in as the user to be migrated, visit a page that has the Microsoft block visible.
3. Click the **Connect to Office 365** link in the Microsoft block.
4. You will be brought to the **Office 365 / Moodle Control Panel**.
5. Click the *Office 365 Connection* link under **Office 365 Features**
6. Click the link that says **Link your Moodle account to an Office 365 account.**
7. You will be redirected to Office 365 to log in. Log in to the Office 365 account you'd like to link the Moodle user to.
  1.  **NOTE:** If you are already logged in to Office 365, you will not have to enter your credentials on the Office 365 login page - the account you are logged in to will be linked to the Moodle account. Ensure you are logged in to the correct account, use a private browser window, or log out of Office 365 first to show the Office 365 login screen.
8. You will be redirected back to Moodle to the Office 365 / Moodle control panel. The **Connection status** box on the side of the page should indicate that you are connected to Office 365 and that you are linked to an Office 365 account.
9. The Moodle account is now linked to the Office 365 account and can use Office 365 features as that user.
10. The Moodle user's login method will not change, the user will log in to Moodle as they always have.
11. If the user experiences any problems using Office 365 features, it's possible the token generated during this initial linking process has expired. Return to the **Office 365 / Moodle Control Panel** and click the **Refresh Connection** link in the Connection Status box. This will generate a new token.
