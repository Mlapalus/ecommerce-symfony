Feature: Registration to the site
    In order to regitration to the site
    I must have a new password
    And a valid password

  Scenario: I want to register me to the site
    Given I am a new user
    When I put my email and a password with 8 elements
    Then I must be register in the DaataBase

  Scenario: I want to register me to the site with a bad password
    Given I am a new user
    When I put my email and a password with 7 elements
    Then I must be not register, and a alert tell me the error

  Scenario: I want to register me to the site with a empty email
    Given I am a new user
    When I put a empty email and a good password
    Then I must be not register, and a alert tell me the empty mail error

  Scenario: I want to register me to the site with a empty password
    Given I am a new user
    When I put a good email and a empty password
    Then I must be not register, and a alert tell me the empty password error

  Scenario: I want to register me to the site with a empty pseudo
    Given I am a new user
    When I put a good email and a empty pseudo
    Then I must be not register, and a alert tell me the empty pseudo error


  Scenario: I want to register me to the site with a bad format email
    Given I am a new user
    When I put a bad format email and a good password
    Then I must be not register, and a alert tell me the email has a bad format

  Scenario: I want to register me to the site, but i am already present in the database
    Given I a user already register
    When I put my email and my password
    Then I have alert to tell me I have already register

  Scenario: I want to register me to the site, but the pseudo is already present in the database
    Given I am a new user
    When I put my email and my password and a pseudo already register
    Then I have alert to tell me I have non unique pseudo