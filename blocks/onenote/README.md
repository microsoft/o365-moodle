Microsoft OneNote Block
=======================

TLDR
----

This plugin provides a container for the Microsoft Account signin button and also Microsoft OneNote related action buttons.


Design details
--------------

There are several parts that make up the Microsoft OneNote Online API Local plugin.

### Configuration
None. This plugin depends upon the Microsoft Account local plugin to be configured for accessing the appropriate Microsoft Live application.
It is recommended that this block should be configured to appear on all pages throughout the entire site.

### get_content method
This is the standard block get_content method that returns either the Microsoft Account signin widget if the user hasn't signed in yet or the appropriate OneNote action button if so.
