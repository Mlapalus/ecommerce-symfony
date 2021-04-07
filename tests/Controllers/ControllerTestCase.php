<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

/**
 * Class IntegrationTestCase
 * @package App\Tests\IntegrationTests
 */
class ControllerTestCase extends WebTestCase
{
  /**
   * @inheritDoc
   */
  protected static function createClient(array $options = [], array $server = [])
  {
    return parent::createClient(array_merge($options, ["environment" => "test"]), $server);
  }
}