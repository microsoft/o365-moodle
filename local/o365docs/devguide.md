# Setting up a development site
While Moodle requires each plugin to be it's own repository, developing a set of dependant plugins can be made easier by using a single repository for all plugins and overlaying the repository on top of a Moodle repository. In this setup, two repositories live in the same directory using two different .git directories – usually .git and .mdlgit. Using repository-specific gitignore rules, each repository deals with it's own files – allowing you to manage files, change branches, and view status independently.

## Setup
1. Clone Moodle into a new directory (or use a clean existing site), and check out the branch you'll be using. 
    ```
    git clone [repository] [directoryname]
    ```
2. Change directories to the cloned site
3. Check out the branch you'll be using. 
    ```
    git checkout -t -b MOODLE_27_STABLE origin/MOODLE_27_STABLE
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
    !blocks/onenote
    !blocks/onenote/**
    !filter
    !filter/oembed
    !filter/oembed/**
    !local
    !local/microsoftservices
    !local/microsoftservices/**
    !local/msaccount
    !local/msaccount/**
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
    !repository/onenote
    !repository/onenote/**
    !repository/office365
    !repository/office365/**
    !user
    !user/profile
    !user/profile/field
    !user/profile/field/oidc
    !user/profile/field/oidc/**
    !user/profile/field/o365
    !user/profile/field/o365/**
    ```
   3. Add the following to .mdlgit/info/exclude.
    ```
    .mdlgit
    auth/oidc
    blocks/onenote
    blocks/microsoft
    filter/oembed
    local/microsoftservices
    local/msaccount
    local/o365
    local/office365
    local/onenote
    mod/assign/feedback/onenote
    mod/assign/submission/onenote
    repository/onenote
    repository/office365
    user/profile/field/oidc
    user/profile/field/o365
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

## Coding Standards

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
