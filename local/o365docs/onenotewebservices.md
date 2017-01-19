Class Notebook Add-In for OneNote and Moodle
============================================
In order to use the Class Notebook Add-In for OneNote you must enable Office 365 web services.

Setup
-----

1. Enable web services.
  1. Go to `Site administration > Advanced features`. Check the box next to "Enable webservices" and click "Save changes"
2. Enable the REST web services protocol
  1. Go to the web services "Manage protocols" page: `Site administration > Plugins > Web services > Manage protocols`.
  2. If the icon in the "Enable" column for the "REST protocol" row has a slash through it, click the icon to enable the protocol.
  3. Click Save changes
3. Enable the "Microsoft Office 365 Webservices" service.
  1. Go to the web services "External services" page: `Site administration > Plugins > Web services > External services`.
  2. Find "Moodle Office 365 Webservices" in the "Built-in services" list, and click the "Edit" link in that row.
  3. Ensure the "Enabled" setting is checked (check it if it is not), and click "Save changes".
4. Create a "webservices" role that allows users to use the REST webservice protocol.
  1. Go to the "Define roles" page: `Site administration > Users > Permissions > Define roles`
  2. Click "Add a new role"
  3. Choose "No role" for "Use role or archetype", click "Continue"
  4. Enter "rest_webservice_user" as the role short name, and "REST Webservice User" as the custom full name.
  5. Allow this role to be assigned at the system context.
  6. Search for `webservice/rest:use` in the list of permissions, and check the "Allow" box in that row.
  7. Scroll to the bottom of the page and click "Create this role"
5. Assign each of the users you want to use the webservice this "REST Webservice User" role.
  1. Go to the "Assign system roles" page: `Site administration > Users > Permissions > Assign system roles`.
  2. Click the "REST Webservice User" link.
  3. Choose each user you want to assign from the right menu (you may have to search for each user individually), and click "Add" to assign them to the role.
6. Create a token for each user you want to be able to use the webservice.
  1. Go to the web service "Manage tokens" page: `Site administration > Plugins > Web services > Manage tokens`
  2. Click the "Add" link.
  3. Choose the user you want to create a token for from the "User" list.
  4. Choose "Moodle Office 365 Webservices" from the "Service" list.
  5. Click "Save changes"

Making a webservice call
------------------------
Now that webservices are set up on your Moodle site, you can begin making webservice calls.

All webservice calls:
- are POST requests made to `[moodle]/webservice/rest/server.php`
- use URL encoded parameters in the body of the post request.
- require (at minimum) three parameters:
  - `wstoken` This is the token you created for the user in the "setup" section above.
  - `wsfunction` This is the name of the function you are calling.
  - `moodlewsrestformat` This is the format you expect the response in, we will use "json"

For example, a request to get a list of a teacher's courses:
```
POST http://example.com/webservice/rest/server.php
Content-Type: application/x-www-form-urlencoded

wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_get_teachercourses&moodlewsrestformat=json
```

Service reference
-----------------

#### Get courses of a teacher
This function gets a list of courses that the requesting user is a teacher in. "Teacher" in this case is defined as a user with the `moodle/grade:edit` capability.

**Function:** local_o365_get_teachercourses

**Parameters:** none

**Response:** array of objects, each containing:
- `id` *int* The course ID.
- `shortname` *string* The shortname of the course.
- `fullname` *string* The full name of the course.
- `idnumber` *string* The course ID number.
- `visible` *int* Whether the course is visible. 1 or 0, 1 being visible, 0 being hidden.
- `format` *string* The course format.
- `showgrades` *int* Whether grades are shown.
- `lang` *string* The course language.
- `enablecompletion` *int* Whether completion is enabled.


#### Get users by course ID
This function gets a list of user enrolled in a given course. This will only return information for courses the requesting user can access.

**Function:** local_o365_get_course_users

**Parameters:**
- `courseid` *int* The ID of the course

**Response:** array of objects, each containing:
- `id` *int* The user's ID.
- `fullname` *string* The user's full name.
- `firstname` *string* The user's first name.
- `lastname` *string* The user's last name.
- `email` *string* The user's email address.
- `profileimageurlsmall` *string* A URL to a small version of the user's profile photo.
- `profileimageurl` *string* A URL to the user's profile photo.


#### Create OneNote Assignment
This function will create a new OneNote assignment in a given course.

**Function:** local_o365_create_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `name` *string* The name of the assignment.
  - `course` *int* The ID of the course to create the assignment in.
  - `intro` *string* (Optional) A description of the assignment. Default is an empty string.
  - `section` *int* The ID of the course section to create the assignment in.
  - `visible` *int* (Optional) Whether to make the assignment visible or hidden. 1 to make visible, 0 to make hidden. Default is 0 (hidden).

**Response:**
- `data` *array* Array of objects, each containing:
  - `course` *int* The ID of the course the assignment was created in.
  - `coursemodule` *int* The course module ID.
  - `instance` *int* The assignment ID.
  - `name` *string* The name of the created assignment.
  - `intro` *string* The description of the created assignment.
  - `section` *string* The ID of the course section the assignment was created in.
  - `visible` *int* Whether the assignment is visible or hidden. 1 = visible, 0 = hidden.


#### Get information about a OneNote assignment
This function will return information about a OneNote assignment given a course module ID and course ID.

**Function:** local_o365_get_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `coursemodule` *int* The course module ID.
  - `course` *int* The ID of the course the assignment is in.

**Response:**
- `data` *array* Array of objects, each containing:
  - `course` *int* The ID of the course the assignment is in.
  - `coursemodule` *int* The course module ID.
  - `instance` *int* The assignment ID.
  - `name` *string* The name of the assignment.
  - `intro` *string* The description of the assignment.
  - `section` *string* The ID of the course section the assignment is in.
  - `visible` *int* Whether the assignment is visible or hidden. 1 = visible, 0 = hidden.


#### Update a OneNote assignment
This function will allow you to update various attributes of a OneNote assignment.

**Function:** local_o365_get_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `coursemodule` *int* The course module ID.
  - `course` *int* The ID of the course the assignment is in.
  - `name` *string* (Optional) The new assignment name to set.
  - `intro` *string* (Optional) The new description to set.
  - `section` *string* (Optional) The ID of the course section to move the assignment to.
  - `visible` *int* (Optional) The assignment's new visibility status. 1 = visible, 0 = hidden.

**Response:**
- `data` *array* Array of objects, each containing:
  - `course` *int* The ID of the course the assignment is in.
  - `coursemodule` *int* The course module ID.
  - `instance` *int* The assignment ID.
  - `name` *string* The name of the assignment.
  - `intro` *string* The description of the assignment.
  - `section` *string* The ID of the course section the assignment is in.
  - `visible` *int* Whether the assignment is visible or hidden. 1 = visible, 0 = hidden.


#### Delete a OneNote assignment
This function will allow you to remove a OneNote assignment.

**Function:** local_o365_delete_onenoteassignment

**Parameters:**
- `data` *array* An wrapper array containing:
  - `coursemodule` *int* The course module ID.
  - `course` *int* The ID of the course the assignment is in.

**Response:**
- `result` *bool* Whether the operation was successful (true), or not (false).


Example use case: Teacher managing assignments
----------------------------------------------

1. Get a list of the teacher's courses

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_get_teachercourses&moodlewsrestformat=json
  ```
  Response:
  ```
  [
    {
      "id":3,
      "shortname":"PSYCH102",
      "fullname":"Introductory Psychology 2",
      "idnumber":"",
      "visible":1,
      "format":"weeks",
      "showgrades":true,
      "lang":"",
      "enablecompletion":false
    },
    {
      "id":2,
      "shortname":"PSYCH101",
      "fullname":"Introductory Psychology 1",
      "idnumber":"",
      "visible":1,
      "format":"weeks",
      "showgrades":true,
      "lang":"",
      "enablecompletion":false
    }
  ]
  ```
2. Get a list of users for PSYCH101.

  This uses the 'id' parameter for the PSYCH101 course returned above as the 'courseid' parameter.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_get_course_users&moodlewsrestformat=json&courseid=2
  ```
  Response:
  ```
  [
    {
      "id":175,
      "fullname":"John Smith",
      "firstname":"John",
      "lastname":"Smith",
      "email":"john.smith@example.com",
      "profileimageurlsmall":"http:\/\/example.com\/theme\/image.php\/clean\/core\/1459671559\/u\/f2",
      "profileimageurl":"http:\/\/example.com\/theme\/image.php\/clean\/core\/1459671559\/u\/f1"
    },
    {
      "id":176,
      "fullname":"Jane Smith",
      "firstname":"Jane",
      "lastname":"Smith",
      "email":"jane.smith@example.com",
      "profileimageurlsmall":"http:\/\/example.com\/pluginfile.php\/24\/user\/icon\/clean\/f2?rev=469",
      "profileimageurl":"http:\/\/example.com\/pluginfile.php\/24\/user\/icon\/clean\/f1?rev=469"
    },
  ]
  ```
3. Get a list of assignments for PSYCH101

  This uses the 'id' parameter for the PSYCH101 course returned in step 1 as the sole item in the 'courseids' parameter.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=mod_assign_get_assignments&moodlewsrestformat=json&courseids%5B%5D=2
  ```
  Response:
  ```
  {
    "courses":[
      {
        "id":2,
        "fullname":"Introductory Psychology",
        "shortname":"PSYCH101",
        "timemodified":1450214936,
        "assignments":[
          {
            "id":1,
            "cmid":2,
            "course":2,
            "name":"OneNote Test Assignment",
            "nosubmissions":0,
            "submissiondrafts":0,
            "sendnotifications":0,
            "sendlatenotifications":0,
            "sendstudentnotifications":1,
            "duedate":0,
            "allowsubmissionsfromdate":0,
            "grade":100,
            "timemodified":1447960195,
            "completionsubmit":0,
            "cutoffdate":0,
            "teamsubmission":0,
            "requireallteammemberssubmit":0,
            "teamsubmissiongroupingid":0,
            "blindmarking":0,
            "revealidentities":0,
            "attemptreopenmethod":"none",
            "maxattempts":-1,
            "markingworkflow":0,
            "markingallocation":0,
            "requiresubmissionstatement":0,
            "configs":[
              {
                "id":1,
                "assignment":1,
                "plugin":"file",
                "subtype":"assignsubmission",
                "name":"enabled",
                "value":"0"
              },
              {
                "id":2,
                "assignment":1,
                "plugin":"onlinetext",
                "subtype":"assignsubmission",
                "name":"enabled",
                "value":"0"
              },
              {
                "id":3,
                "assignment":1,
                "plugin":"onenote",
                "subtype":"assignsubmission",
                "name":"enabled",
                "value":"1"
              },
              ...
            ]
            "intro":"",
            "introformat":1
          }
        ]
      }
    ]
  }
  ```
4. Get existing grades for the "OneNote Test Assignment" in PSYCH101.

  This uses the 'id' parameter from the assignment we want from the 'assignments' object returned in the above step as the sole item in the 'assignmentids' parameter.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=mod_assign_get_grades&moodlewsrestformat=json&assignmentids%5B%5D=1
  ```
  Response:
  ```
  {
    "assignments":[
      {
        "assignmentid":1,
        "grades":[
          {
            "id":3,
            "userid":175,
            "attemptnumber":0,
            "timecreated":1459661701,
            "timemodified":1459662202,
            "grader":3,
            "grade":"88.00000"
          }
        ]
      }
    ],
    "warnings":[]
  }
  ```
  We can see here there is one grade present for this assignment, from user "John Smith" (ID 175 from step 2).
5. Create a new grade entry

  This request uses the assignment id found in step 3, the user id from step 2 and a the new grade to set.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_update_grade&moodlewsrestformat=json&assignmentid=1&userid=175&grade=78&attemptnumber=-1&addattempt=0&workflowstate=&applytoall=1&plugindata%5Bassignfeedbackcomments_editor%5D%5Btext%5D=&plugindata%5Bassignfeedbackcomments_editor%5D%5Bformat%5D=2&plugindata%5Bfiles_filemanager%5D=0
  ```

  This function should return null if it was successful. You can repeat step 4 to verify the grade was saved correctly.

6. Create a new OneNote assignment

  This will create a new assignment in a given course, with the OneNote assignment and feedback types enabled.

  Request:
  ```
  POST https://example.com/webservice/rest/server.php
  Content-Type: application/x-www-form-urlencoded

  wstoken=309ada75ccb5518f368d103b3c1fb0cb&wsfunction=local_o365_create_onenoteassignment&moodlewsrestformat=json&data%5Bname%5D=A+new+test+onenote+assignment&data%5Bcourse%5D=2
  ```
  Response:
  ```
  {
    "data":[
      {
        "course":2,
        "coursemodule":91,
        "name":"A new test onenote assignment",
        "intro":"",
        "section":1,
        "visible":0,
        "instance":49
      }
    ]
  }
  ```
  Note that the "assignment id" referenced above for use with the grade-related functions is the "instance" attribute returned here. The "coursemodule" attribute is used with the other OneNote assignment functions (along with the course id) to get, update, or delete the assignment.
