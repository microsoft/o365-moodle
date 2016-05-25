Instructions for setting up Office Mix as an External Tool
==========================================================

Register your Moodle installation with Office Mix
-------------------------------------------------

  * Go to https://mix.office.com/lti/.
  * Click Register an LMS.
  * If you are not already signed in, you will need to sign in with an appropriate account.
  * Type a name to describe your Moodle installation.
  * Select the checkbox indicating that you agree to allow Office Mix to pass data to your Moodle installation.
  * Click Save.
  * Make note of the Consumer Key, Shared Secret, and Launch URL that will be displayed on the page. You will need these in the subsequent steps below.
  * To retrieve these at a later time, you can return to https://mix.office.com/lti/ and click Manage Your Registrations.

Adding Office Mix as an External Tool in Moodle
----------------------------------------------

  * Log in to Moodle using your administrator account.
  * Go to Site Administration.
  * Go to Plugins > Activity modules > LTI > Manage external tool types.
  * Select Active.
  * Click Add external tool configuration.
  * In the Tool name box, type an appropriate name, such as "Office Mix".
  * In the Tool base URL box, enter the Launch URL obtained above.
  * In the Consumer key and Shared secret boxes, enter the values obtained above.
  * Check the "Show tool type when creating tool instances" checkbox.
  * Configure Privacy settings according to your requirements.

      Note: Sending the Name of the user will allow Office Mix to display rich analytics and question responses. 
      If you do not send any user information, then Office Mix will not be able restore a student's answers 
      if they view the content on a subsequent visit.

  * Click Save changes.

Now that Office Mix has been configured, teachers or admins can follow the instructions in the next section to embed a Mix into course content.

Embedding a Mix into course content
-----------------------------------

  * Log in to Moodle as a Teacher or Admin.
  * Select the course you'd like to work with.
  * Click Turn editing on.
  * Locate the section that you'd like to modify and click Add an activity or resource.
  * Select External tool.
  * Click Add.
  * In the General settings:
  * In the Activity name box, type a name for your activity.
  * Select Office Mix from the External tool type list.
  * Set your Privacy and Grade settings.
  * Click Save and display. At this point, you should see a placeholder for your activity.
  * In the embedded activity, use one of these methods to select a mix:
  
    * Using URL: A simple way to select a mix is to visit the Office Mix website, select the mix you want to include in the course, copy the URL from the browser address bar and paste it in the dialog. This method makes it easy to include mixes that have been created by other people.

    * Using My Mixes: You can also select a mix from your My Mixes page from the Office Mix website. In order to prevent students from having to sign in to view a mix, only those mixes with permissions set to Unlisted or Public are shown.

  * After you have selected a mix, click Yes to confirm that this is the mix you'd like to use.
  * At this point, you should see the mix embedded within your course.

Additional Resources
====================

You may also refer to these Office Mixes for more information

  * <https://mix.office.com/en-us/Lti/UsingMoodle>
  * <https://mix.office.com/en-us/Lti/SetupMoodle>
