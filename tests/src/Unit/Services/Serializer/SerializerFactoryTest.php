<?php

namespace Drupal\json_api_client\Services\Serializer;

use Drupal\jms_serializer\Services\Serializer\SerializerFactory;
use JMS\Serializer\Serializer;

class SerializerFactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * Setup the test environment.
   */
  public function setUp() {
    if (!defined('DRUPAL_ROOT')) {
      define('DRUPAL_ROOT', '/tmp/test');
    }
  }

  /**
   * Test the creation of a serializer.
   */
  public function testCreateSerializer() {
    $factory = new SerializerFactory();
    $serializer = $factory->createSerializer();

    $this->assertInstanceOf(
      Serializer::class,
      $serializer
    );
  }

}
