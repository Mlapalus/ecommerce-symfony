<?php

use App\Tests\domain\Auth\LoginPresenter;
use App\Tests\domain\Auth\UserRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Auth\Gateway\UserGatewayInterface;
use Domain\Auth\Request\LoginRequest;
use Domain\Auth\UseCase\Login;

class LoginContext implements Context
{

  private UserGatewayInterface $gateaway;
  private LoginPresenter $goodPresenter;
  private LoginPresenter $badEmailPresenter;
  private LoginPresenter $badPasswordPresenter;

  public function __construct()
  {
    $this->gateaway = new UserRepository();
    $this->goodPresenter = new LoginPresenter();
    $this->badEmailPresenter = new LoginPresenter();
    $this->badPasswordPresenter = new LoginPresenter();
  }

  /**
   * @Given I am a User who is Registred in the DaataBase
   */
  public function iAmAUserWhoIsRegistredInTheDaatabase()
  {
  }
  /**
   * @Given I am a User who is not Registred in the DaataBase
   */
  public function iAmAUserWhoIsNotRegistredInTheDaatabase()
  {
  }

  /**
   * @When I put my email and my password
   */
  public function iPutMyEmailAndMyPassword()
  {
    $request = new LoginRequest('ok@email.com', 'password-1');

    $login = new Login($this->gateaway);
    $login->execute($request, $this->goodPresenter);
  }

  /**
   * @When I put my a unknow email and my password
   */
  public function iPutMyAUnknowEmailAndMyPassword()
  {
    $request = new LoginRequest('bad@email.com', 'password-1');

    $login = new Login($this->gateaway);
    $login->execute($request, $this->badEmailPresenter);
  }


  /**
   * @When I put my good email and a bad password
   */
  public function iPutMyGoodEmailAndABadPassword()
  {
    $request = new LoginRequest('ok@email.com', 'badPassword');

    $login = new Login($this->gateaway);
    $login->execute($request, $this->badPasswordPresenter);
  }

  /**
   * @Then I should have a password valid
   */
  public function iShouldHaveAPasswordValid()
  {
    $response = $this->goodPresenter->getResponse();

    if (!$response->isPasswordValid()) {
      throw new Exception("Password is not valid");
    };
  }

  /**
   * @Then I should have a password not valid
   */
  public function iShouldHaveAPasswordNotValid()
  {
    $badEmailResponse = $this->badEmailPresenter->getResponse();

    if ($badEmailResponse) {
      if ($badEmailResponse->isPasswordValid()) {
        throw new Exception("Problem");
      };
    }


    $badPasswordResponse = $this->badPasswordPresenter->getResponse();

    if ($badPasswordResponse) {
      if ($badPasswordResponse->isPasswordValid()) {
        throw new Exception("Password is valid, and it should be not");
      };
    }
  }
}