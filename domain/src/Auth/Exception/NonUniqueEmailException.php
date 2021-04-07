<?php

namespace Domain\Auth\Exception;

use Assert\InvalidArgumentException;

class NonUniqueEmailException extends InvalidArgumentException
{
}