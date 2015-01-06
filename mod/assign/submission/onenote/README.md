Microsoft OneNote Assignment Submission Plugin
=========================================

TLDR
----

This plugin provides the functionality related to students working with an assignment in OneNote. This includes creating a OneNote page associated with an assignment submission, saving student's work from OneNote into Moodle as a zip package containing the HTML and any associated images contained in the submission, and recreating the OneNote page from the zip package saved in Moodle if necessary. It uses the Microsoft OneNote API Local plugin to do some of these things.


Design details
--------------

### Basic design
This plugin follows a design similar to the File submission plugin wherever possible. It uses the API exposed by the local_onenote plugin to perform most of the OneNote-related operations.
Note that the association between an assignment submission in Moodle and the associated OneNote page is loose i.e. the OneNote page may get deleted and it will not affect Moodle since it keeps a copy of the page in a zip package and can always recreate the OneNote page from it. 


### Use cases supported
- When a student wants to start working on an assignment which allows OneNote submissions, they click on a button in the plugin UI that creates a OneNote page for their submission from the title and prompt of the assignment.
- When the student wants to save their work back in Moodle, they click on a save button in the plugin UI, which results in this plugin downloading the content of the OneNote page, including the HTML and any associated images and zipping them up as a single file and saving it in the Moodle database.
- If the OneNote page associated with an assignment submission gets deleted, the student can still click one a button in the plugin UI that will recreate the OneNote page from the zip package that was saved in Moodle.  

### Plugin dependencies
assignsubmission_onenote => local_onenote => local_msaccount

### Configuration
This plugin adds a radio button to the assignment creation form that allows a teacher to specify that a student may submit their work as a OneNote page. 
This plugin also provides a setting for the maximum size in bytes of the OneNote submission. 
