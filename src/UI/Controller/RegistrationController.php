<?php

namespace App\UI\Controller;

use App\UI\Viewer\Viewer;
use App\UI\Form\RegistrationType;
use App\UI\Viewer\ViewerInterface;
use Domain\Auth\UseCase\Registration;
use App\UI\Presenter\RegistrationPresenter;
use Domain\Auth\Request\RegistrationRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Infra\Security\Guard\WebAuthenticator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController
{
  private FormFactoryInterface $formFactory;
  private ViewerInterface $viewer;
  private UrlGeneratorInterface $urlGenerator;
  private GuardAuthenticatorHandler $guardHandler;
  private WebAuthenticator $authenticator;

  public function __construct(
    FormFactoryInterface $formFactory,
    Viewer $viewer,
    UrlGeneratorInterface $urlGenerator,
    GuardAuthenticatorHandler $guardHandler,
    WebAuthenticator $authenticator
  ) {
    $this->formFactory = $formFactory;
    $this->viewer = $viewer;
    $this->urlGenerator = $urlGenerator;
    $this->guardHandler = $guardHandler;
    $this->authenticator = $authenticator;
  }

  public function index(
    Request $request,
    Registration $registration,
    RegistrationPresenter $registrationPresenter
  ): Response {

    $form = $this->formFactory->create(RegistrationType::class)->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $registrationRequest = RegistrationRequest::create(
        $form->getData()->getEmail(),
        $form->getData()->getPseudo(),
        $form->getData()->getPlainPassword()
      );
      $registration->execute($registrationRequest, $registrationPresenter);

      return $this->guardHandler->authenticateUserAndHandleSuccess(
        $registrationPresenter->getViewModel()->getUser(),
        $request,
        $this->authenticator,
        'main'
      );
    }

    return new Response($this->viewer->render("registration", [
      "form" => $form->createView()
    ]));
  }
}