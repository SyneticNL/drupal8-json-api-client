<?php

namespace Drupal\json_api_client\Services\Serializer;

use Prophecy\Prophet;

class SerializerFactoryTest extends \PHPUnit_Framework_TestCase {

  /** @var Prophet * */
  protected $prophecy;

  public function setUp() {
    $this->prophecy = new Prophet();

    if ( ! defined('DRUPAL_ROOT')) {
      define('DRUPAL_ROOT', '/tmp/test');
    }
  }

  public function testCreateSerializer()
  {
    $factory = new SerializerFactory();
    $serializer = $factory->createSerializer();

    $this->assertInstanceOf(
      \JMS\Serializer\Serializer::class,
      $serializer
    );
  }
}
