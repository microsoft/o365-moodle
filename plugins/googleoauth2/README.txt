Oauth 2.0 authentication plugin for Moodle
==========================================

This plugin adds a Google/Facebook/Github/Linkedin/Windows Live button on the front page.
The first time the user clicks on the button, a new account is created.

Plugin installation:
--------------------
Since Moodle 2.5 you can automatically install the plugin from [Moodle.org](https://moodle.org/plugins/view.php?plugin=auth_googleoauth2). For manual installation or other versions, follow these steps:

1. add the plugin into /auth/googleoauth2/

2. in Moodle admin, enable the plugin (Admin block > Plugins > Auhtentication)

3. in the plugin settings, follow the instructions.

4. **[Moodle 2.5+]** install this theme extending bootstrap: https://github.com/mouneyrac/moodle-theme_oauth2easy/archive/oauth2easy.zip

    or
    
   **[All versions]** add the following code to your login page (For most of you copy it at the bottom of login/index_form.html. Some custom themes have their own login page. In this case you should find the login layout page indicated in the theme config.php file. Often the file location is something like /theme/YOURTHEME/layout/login.php.):

`<?php
require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');
auth_googleoauth2_display_buttons();
?>`


FAQ and Support
---------------

Read the [Wiki](https://github.com/mouneyrac/auth_googleoauth2/wiki).

You are welcome to send Pull Request and to report [issues](https://github.com/mouneyrac/auth_googleoauth2/issues).

Continuous testing is done with [Travis-ci](https://travis-ci.org/mouneyrac/moodle-auth_googleoauth2).

Credits
-------
* [Contributors](https://github.com/mouneyrac/auth_googleoauth2/graphs/contributors)
* [CSS social buttons](http://zocial.smcllns.com/)
