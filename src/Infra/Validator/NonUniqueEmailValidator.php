<?php

namespace App\Infra\Validator;

use Symfony\Component\Validator\Constraint;
use Domain\Auth\Gateway\UserGatewayInterface;
use Symfony\Component\Validator\ConstraintValidator;

class NonUniqueEmailValidator extends ConstraintValidator
{
  private UserGatewayInterface $userGateway;

  public function __construct(UserGatewayInterface $userGateway)
  {
    $this->userGateway = $userGateway;
  }

  public function validate($value, Constraint $constraint)
  {
    if (!$this->userGateway->isEmailUnique($value)) {
      $this->context->buildViolation($constraint->message)->addViolation();
    }
  }
}