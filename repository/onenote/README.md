Microsoft OneNote Repository Plugin
=========================================

TLDR
----

This plugin allows the user to browse their OneNote Online content, such as notebooks, sections, and pages using the Moodle file picker UI. It also allows them to download the content of their OneNote page. It uses the Microsoft OneNote API Local plugin to do some of these things.


Design details
--------------

### Basic design
This plugin uses the API exposed by the Microsoft OneNote API local plugin for logging in, getting the list of notebooks, sections, and pages; and also for downloading the page when needed.
 
### Plugin dependencies
repository_onenote => local_onenote => local_msaccount

### Configuration
None. This plugin depends upon the Microsoft Account local plugin to be configured for accessing the appropriate Microsoft Live application.
