<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Domain\Auth\UseCase\Registration;
use App\Tests\domain\Auth\UserRepository;
use Domain\Auth\Request\RegistrationRequest;
use App\Tests\domain\Auth\RegistrationPresenter;
use Domain\Auth\Exception\NonUniqueEmailException;
use Domain\Auth\Exception\NonUniquePseudoException;

/**
 * Defines application features from the specific context.
 */
class RegistrationContext implements Context
{

  private RegistrationPresenter $goodPresenter;
  private UserRepository $gateaway;
  private Registration $goodRegistration;
  private RegistrationRequest $goodRequest;

  private Registration $alreadyRegisterRegistration;
  private RegistrationRequest $alreadyRegisterRequest;

  private Registration $badPasswordRegistration;
  private RegistrationRequest $badPasswordRequest;

  private Registration $emptyEmailRegistration;
  private RegistrationRequest $emptyEmailRequest;

  private Registration $badFormatEmailRegistration;
  private RegistrationRequest $badFormatEmailRequest;

  private Registration $emptyPasswordRegistration;
  private RegistrationRequest $emptyPasswordRequest;

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct()
  {
    $this->gateaway = new UserRepository();
    $this->goodPresenter = new RegistrationPresenter();
  }

  /**
   * @Given I am a new user
   */
  public function iAmANewUser()
  {
  }

  /**
   * @When I put my email and a password with :arg1 elements
   */
  public function iPutMyEmailAndAPasswordWithElements($arg1)
  {
    $this->goodRequest = new RegistrationRequest('new@email.fr', 'newPseudo', 'password-1');
    $this->goodRegistration = new Registration($this->gateaway);

    if ($arg1 < 8) {
      $this->badPasswordRequest = new RegistrationRequest('new@email.fr', 'newPseudo', '1234567');
      $this->badPasswordRegistration = new Registration($this->gateaway);
    }
  }

  /**
   * @Then I must be register in the DaataBase
   */
  public function iMustBeRegisterInTheDaatabase()
  {
    try {
      $this->goodRegistration->execute($this->goodRequest, $this->goodPresenter);
    } catch (Exception $e) {
      throw new Exception("Test Fail");
    }
  }

  /**
   * @Given I a user already register
   */
  public function iAUserAlreadyRegister()
  {
  }

  /**
   * @Then I have alert to tell me I have already register
   */
  public function iHaveAlertToTellMeIHaveAlreadyRegister()
  {
    $this->alreadyRegisterRegistration = new Registration($this->gateaway);
    $this->alreadyRegisterRequest = new RegistrationRequest('notNew@email.fr', 'newPseudo', 'password-1');

    try {
      $this->alreadyRegisterRegistration->execute($this->alreadyRegisterRequest, $this->goodPresenter);
    } catch (Exception $e) {
      if (!($e instanceof NonUniqueEmailException)) {
        throw new Exception($e);
      }
    }
  }

  /**
   * @Then I must be not register, and a alert tell me the error
   */
  public function iMustBeNotRegisterAndAAlertTellMeTheError()
  {
    try {
      $this->badPasswordRegistration->execute($this->badPasswordRequest, $this->goodPresenter);
    } catch (Exception $e) {
      if (!($e instanceof InvalidArgumentException)) {
        throw new Exception($e);
      }
    }
  }


  /**
   * @When I put a empty email and a good password
   */
  public function iPutAEmptyEmailAndAGoodPassword()
  {
    $this->emptyEmailRequest = new RegistrationRequest('', 'newPseudo', 'password-1');
    $this->emptyEmailRegistration = new Registration($this->gateaway);
  }

  /**
   * @Then I must be not register, and a alert tell me the empty mail error
   */
  public function iMustBeNotRegisterAndAAlertTellMeTheEmptyMailError()
  {
    try {
      $this->emptyEmailRegistration->execute($this->emptyEmailRequest, $this->goodPresenter);
    } catch (Exception $e) {
      if (!($e instanceof InvalidArgumentException)) {
        throw new Exception($e);
      }
    }
  }

  /**
   * @When I put a bad format email and a good password
   */
  public function iPutABadFormatEmailAndAGoodPassword()
  {
    $this->badFormatEmailRequest = new RegistrationRequest('toto', 'newPseudo', 'password-1');
    $this->badFormatEmailRegistration = new Registration($this->gateaway);
  }

  /**
   * @Then I must be not register, and a alert tell me the email has a bad format
   */
  public function iMustBeNotRegisterAndAAlertTellMeTheEmailHasABadFormat()
  {
    try {
      $this->badFormatEmailRegistration->execute($this->badFormatEmailRequest, $this->goodPresenter);
    } catch (Exception $e) {
      if (!($e instanceof InvalidArgumentException)) {
        throw new Exception($e);
      }
    }
  }

  /**
   * @When I put a good email and a empty password
   */
  public function iPutAGoodEmailAndAEmptyPassword()
  {
    $this->emptyPasswordRequest = new RegistrationRequest('new@email.fr', 'newPseudo', '');
    $this->emptyPasswordRegistration = new Registration($this->gateaway);
  }

  /**
   * @Then I must be not register, and a alert tell me the empty password error
   */
  public function iMustBeNotRegisterAndAAlertTellMeTheEmptyPasswordError()
  {
    try {
      $this->emptyPasswordRegistration->execute($this->emptyPasswordRequest, $this->goodPresenter);
    } catch (Exception $e) {
      if (!($e instanceof InvalidArgumentException)) {
        throw new Exception($e);
      }
    }
  }

  /**
   * @When I put a good email and a empty pseudo
   */
  public function iPutAGoodEmailAndAEmptyPseudo()
  {
    $this->emptyPseudoRequest = new RegistrationRequest('new@email.fr', '', '12345678');
    $this->emptyPseudoRegistration = new Registration($this->gateaway);
  }

  /**
   * @Then I must be not register, and a alert tell me the empty pseudo error
   */
  public function iMustBeNotRegisterAndAAlertTellMeTheEmptyPseudoError()
  {
    try {
      $this->emptyPseudoRegistration->execute($this->emptyPseudoRequest, $this->goodPresenter);
    } catch (Exception $e) {
      if (!($e instanceof InvalidArgumentException)) {
        throw new Exception($e);
      }
    }
  }

  /**
   * @When I put my email and my password and a pseudo already register
   */
  public function iPutMyEmailAndMyPasswordAndAPseudoAlreadyRegister()
  {
    $this->nonUniquePseudoRequest = new RegistrationRequest('new@email.fr', 'nonUnique', '12345678');
    $this->nonUniquePseudoRegistration = new Registration($this->gateaway);
  }

  /**
   * @Then I have alert to tell me I have non unique pseudo
   */
  public function iHaveAlertToTellMeIHaveNonUniquePseudo()
  {
    try {
      $this->nonUniquePseudoRegistration->execute($this->nonUniquePseudoRequest, $this->goodPresenter);
    } catch (Exception $e) {
      if (!($e instanceof NonUniquePseudoException)) {
        throw new Exception($e);
      }
    }
  }
}