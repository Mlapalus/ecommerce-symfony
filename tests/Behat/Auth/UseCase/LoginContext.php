<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class LoginContext implements Context
{

  public function __construct()
  {
  }

  /**
   * @Given I am a User who is Registred in the DaataBase
   */
  public function iAmAUserWhoIsRegistredInTheDaatabase()
  {
    throw new PendingException();
  }

  /**
   * @When I send my email and my password
   */
  public function iSendMyEmailAndMyPassword()
  {
    throw new PendingException();
  }

  /**
   * @Then I should be connected with my role
   */
  public function iShouldBeConnectedWithMyRole()
  {
    throw new PendingException();
  }
}