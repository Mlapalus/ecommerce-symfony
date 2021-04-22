<?php

namespace App\Infra\Validator;

use Domain\Auth\Gateway\UserGatewayInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NonUniquePseudoValidator extends ConstraintValidator
{
  private UserGatewayInterface $userGateway;

  public function __construct(UserGatewayInterface $userGateway)
  {
    $this->userGateway = $userGateway;
  }

  public function validate($value, Constraint $constraint)
  {
    if (!$this->userGateway->isPseudoUnique($value)) {
      $this->context->buildViolation($constraint->message)->addViolation();
    }
  }
}