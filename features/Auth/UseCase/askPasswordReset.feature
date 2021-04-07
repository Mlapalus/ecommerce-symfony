Feature: A User ask to reset his passWord
  In order a user forgeot his password
  If he want to connect to the appli
  He ask to reset his password

  Scenario: I want to reset my password
    Given Iam a User
    When I put my email and ask the reset of my password
    Then I received a mail to reset my password