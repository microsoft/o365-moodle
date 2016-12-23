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

#### Client ID:

Enter the Client ID obtained from Azure when you created the application for your Moodle installation.

### Client Secret:

Enter the Key obtained from Azure when you created the application for your Moodle installation.

### Authorization Endpoint and Token Endpoint:

You can use the default values for these.

### Resource:

You can use the default value for this.

#### Auto-Append

When using the "Resource Owner Password Credentials" authentication method, this setting with automatically append a given string to an entered username. This is useful in Azure AD usernames, where a single domain name is often used for every user - i.e. [user]@contoso.onmicrosoft.com. Users would normally have to enter this entire username to successfully log in to Moodle, but in this example, entering "@contoso.onmicrosoft.com" here means users would only have to enter their unique username, i.e. "bob.smith", instead of "bob.smith@contoso.onmicrosoft.com".

#### Domain Hint

If users have several different Azure AD accounts with different tenants (i.e. @contoso.onmicrosoft.com, @example.onmicrosoft.com), but Moodle only uses one of these tenants, you can enter that tenant in this box to have the Azure AD login screen only ever suggest accounts from that tenant.

#### Authentication methods

This setting changes how users log in to Moodle using the plugin. You can redirect users to the OpenID Connect provider's login page, or have users enter their credentials directly into Moodle. See the [Authentication methods](#authentication-methods) section below for further information.

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


Authentication methods
----------------------

This plugin supports two different methods for users to log in: Authorization Request and Username/Password Authentication

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
