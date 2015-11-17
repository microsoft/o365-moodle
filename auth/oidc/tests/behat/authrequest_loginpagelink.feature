Feature: Authorization request login link.
    The authorization request login flow places a link on the login page.
    The link redirects the user to the configured login page.
    The link is preceeded by a customization icon.
    The link only appears when OpenID Connect is configured and enabled.
    The link only appears when using the authorization request login flow.

  Scenario: Link is not shown when the plugin is not configured.
    Given the plugin is not configured
     When I view the Moodle login page
     Then there should not be an identity provider link on the login page

  Scenario: Link is not shown when using the Username/Password Authentication login flow
    Given the plugin is configured
      And the plugin is using the "Username/Password Authentication" login flow
     When I view the Moodle login page
     Then there should not be an identity provider link on the login page

  Scenario: Link is shown when using the Authorization Request login flow
    Given the plugin is configured
      And the plugin is using the "Authorization Request" login flow
     When I view the Moodle login page
     Then there should be an identity provider link on the login page

  Scenario: Link should use the configured Provider Name
    Given the plugin is configured
      And the plugin is using the "Authorization Request" login flow
      And the plugin's "Provider Name" setting is "TestProviderName"
     When I view the Moodle login page
     Then there should be an identity provider link on the login page
      And the identity provider link text should be "TestProviderName"

  Scenario: Link should use the
    Given the plugin is configured
      And the plugin is using the "Authorization Request" login flow
      And the plugin's "Provider Name" setting is "TestProviderName"
     When I view the Moodle login page
     Then there should be an identity provider link on the login page
      And the identity provider link text should be "TestProviderName"
