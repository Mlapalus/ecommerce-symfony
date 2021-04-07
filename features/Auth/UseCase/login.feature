Feature: Login to the the site
  In order to connection to the site
  Users already registred
  Should be able to Login

  Scenario: Login if I am already registred in the DaataBase
    Given I am a User who is Registred in the DaataBase
    When I put my email and my password
    Then I should have a password valid

  Scenario: Not Login if I am not already registred in the DaataBase
    Given I am a User who is not Registred in the DaataBase
    When I put my a unknow email and my password
    Then I should have a password not valid

  Scenario: Not Login if I am already registred but i put a bad password
    Given I am a User who is Registred in the DaataBase
    When I put my good email and a bad password
    Then I should have a password not valid
