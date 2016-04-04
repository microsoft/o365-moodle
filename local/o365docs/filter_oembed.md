oEmbed Filter
=============

This filter allows users to embed documents from various online sources to be embedded into Moodle content. The user only has to enter the URL to the document and the filter takes care of converting the URL into an embeddable IFRAME. This filter has a white list of services it supports. The list of supported services can be seen and selectively enabled or disabled in the settings page for this filter.

Embedding Power BI Reports
--------------------------

This filter allows users to embed Power BI items into a course.

1. If you have upgraded filter plugin recently, clear the Moodle cache first then go to filter plugin settings and esure that the PowerBI filter is enabled.

2. In the Azure Portal (https://manage.windowsazure.com) go to your AD application, then inside 'Permissions to other applications' click Add Application.

3. Select Power BI Service, save, then set Delegated permissions as follows:
    1. View all reports(preview)
    2. Read and Write all Datasets
    3. View all Datasets
    4. View all Dashboards(preview)

4. Click on Save

5. Login to Office 365 and go to the Power BI app.

6. The menu on the left hand side contains the Reports section. Select the report you want to embed. (Note that the filter only works for Reports, not for Tiles.)

7. Copy the URL & paste it into Moodle content where you would like to embed the report.

8. Save the Moodle content and view it. You should see the URL you entered get converted into an IFRAME with the report showing inside it.
