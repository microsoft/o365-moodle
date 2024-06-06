@editor @editor_tiny @tiny @tiny_teamsmeeting @javascript
Feature: Tiny editor admin settings for teamsmeeting plugin
  To be able to actually add a Microsoft Teams meeting in the editor, the capability must be given.

  Background:
    Given the following "courses" exist:
      | shortname | fullname |
      | C1        | Course 1 |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And the following "activities" exist:
      | activity | name      | intro     | introformat | course | content | contentformat | idnumber |
      | page     | PageName1 | PageDesc1 | 1           | C1     | Test    | 1             | 1        |

  @javascript
  Scenario: When a user does not have the teamsmeeting capability, they cannot create a Microsoft Teams meeting in TinyMCE
    Given the following "permission overrides" exist:
      | capability            | permission | role           | contextlevel | reference |
      | tiny/teamsmeeting:add | Prohibit   | editingteacher | Course       | C1        |
    When I am on the PageName1 "page activity editing" page logged in as teacher1
    Then "Teams Meeting" "button" should not exist

  @javascript
  Scenario: When a user does have the teamsmeeting capability, they can create a Microsoft Teams meeting in TinyMCE
    Given I am on the PageName1 "page activity editing" page logged in as teacher1
    Then "Teams Meeting" "button" should exist
