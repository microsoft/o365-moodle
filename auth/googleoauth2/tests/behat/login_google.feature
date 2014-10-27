@auth @auth_googleoauth2
Feature: Sign in with a Google account
  In order to login to the site
  As a user
  I sign in with my Google account
 
  @javascript
  Scenario: Sign in with a Google account
    When I follow "Log in"
    When I fill in "username" with "admin"
    And I fill in "password" with "admin"
    And I press "loginbtn"
    When I expand "Site administration" node
    When I expand "Plugins" node
    When I expand "Authentication" node
    When I follow "Manage authentication"
    When I click on "enable" "link" in the "Oauth2" table row
    When I click on "Settings" "link" in the "Oauth2" table row
    And I fill in "googleclientid" with "1234567890"
    And I fill in "googleclientsecret" with "1234567890"
    And I press "Save changes"
    When I expand "Appearance" node
    When I expand "Themes" node
    When I follow "Theme selector"
    When I click on "//*[@id=\"admindeviceselector\"]/tbody/tr[1]/td[3]/div/form/div/input[1]" "xpath_element"
    When I click on "//*[@id=\"adminthemeselector\"]/tbody/tr[16]/td[2]/div/form/div/input[1]" "xpath_element"
    When I follow "Log out"
    Then I should see "Home"
    When I follow "Log in"
    Then I should see "Sign-in with Google"
    #Then I follow "Sign-in with Google"
    #When I fill in "Email" with "1234567890"
    #And I fill in "Passwd" with "1234567890"
    #And I press "Sign in"
    #Then I should see "Log out"

