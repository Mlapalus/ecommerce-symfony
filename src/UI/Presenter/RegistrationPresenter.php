<?php

namespace App\UI\Presenter;

use App\UI\ViewModel\RegistrationViewModel;
use Domain\Auth\Presenter\RegistrationPresenterInterface;
use Domain\Auth\Response\RegistrationResponse;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class RegistrationPresenter implements RegistrationPresenterInterface
{
  private RegistrationViewModel $viewModel;
  private UserProviderInterface $userProvider;

  public function __construct(UserProviderInterface $userProvider)
  {
    $this->userProvider = $userProvider;
  }

  public function present(RegistrationResponse $response): void
  {
    $this->viewModel = new RegistrationViewModel(
      $this->userProvider->loadUserByUsername($response->getEmail())
    );
  }

  public function getViewModel(): RegistrationViewModel
  {
    return $this->viewModel;
  }
}