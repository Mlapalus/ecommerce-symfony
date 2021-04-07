<?php

use Behat\Behat\Context\Context;
use App\Tests\domain\Auth\Mailer;
use App\Tests\domain\Auth\UrlGenerator;
use Domain\Auth\UseCase\AskPasswordReset;
use Domain\Auth\Request\AskPasswordResetRequest;
use App\Tests\domain\Auth\AskPasswordResetPresenter;
use App\Tests\domain\Auth\UserRepository;

class AskPasswordResetContext implements Context
{
  private AskPasswordResetRequest $goodRequest;
  private AskPasswordResetPresenter $presenter;
  private AskPasswordReset $askPasswordReset;
  private Mailer $mailer;
  private UrlGenerator $urlGenerator;
  private UserRepository $gateaway;

  public function __construct()
  {
    $this->presenter = new AskPasswordResetPresenter();
    $this->gateaway = new UserRepository();
    $this->mailer = new Mailer();
    $this->urlGenerator = new UrlGenerator();
    $this->askPasswordReset = new AskPasswordReset($this->gateaway, $this->mailer, $this->urlGenerator);
  }
  /**
   * @Given Iam a User
   */
  public function iamAUser()
  {
  }

  /**
   * @When I put my email and ask the reset of my password
   */
  public function iPutMyEmailAndAskTheResetOfMyPassword()
  {
    $this->goodRequest = new AskPasswordResetRequest('ok@email.com');
  }

  /**
   * @Then I received a mail to reset my password
   */
  public function iReceivedAMailToResetMyPassword()
  {
    $this->askPasswordReset->execute($this->goodRequest, $this->presenter);
  }
}