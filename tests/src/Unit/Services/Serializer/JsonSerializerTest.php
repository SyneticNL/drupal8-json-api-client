<?php

namespace Drupal\json_api_client\Services\Serializer;

use Drupal\jms_serializer\Interfaces\SerializableInterface;
use Drupal\jms_serializer\Services\Serializer\JsonSerializer;
use Drupal\jms_serializer\Services\Serializer\SerializerFactory;
use Drupal\json_api_client\Interfaces\JsonApiModelInterface;
use JMS\Serializer\Serializer;
use Prophecy\Prophet;

class JsonSerializerTest extends \PHPUnit_Framework_TestCase {

  /**
   * The serializer factory.
   *
   * @var Prophet|SerializerFactory
   */
  private $factory;

  /**
   * The serializer.
   *
   * @var Prophet|Serializer
   */
  private $serializer;

  /**
   * Setup the test environment.
   */
  public function setUp() {
    $this->prophecy = new Prophet();
    $this->factory = $this->prophesize(SerializerFactory::class);
    $this->serializer = $this->prophesize(Serializer::class);
  }

  /**
   * Test serializer.
   */
  public function testSerialize() {
    $expected = json_encode(
      [
        'test' => 'array',
      ]
    );
    $model = $this->prophecy->prophesize(SerializableInterface::class);
    $stub = $model->reveal();

    $this->factory->createSerializer()->shouldBeCalled()->willReturn(
      $this->serializer
    );
    $this->serializer->serialize($stub, 'json')->shouldBeCalled()->willReturn(
      $expected
    );

    $serializer = new JsonSerializer($this->factory->reveal());
    $result = $serializer->serialize($stub);

    $this->assertSame(
      $expected,
      $result
    );
  }

  /**
   * Test deserialize.
   */
  public function testDeserialize() {
    $data = json_encode(
      [
        'test' => 'data',
      ]
    );

    $type = 'test';

    $model = $this->prophecy->prophesize(JsonApiModelInterface::class);
    $stub = $model->reveal();

    $this->factory->createSerializer()->shouldBeCalled()->willReturn(
      $this->serializer
    );
    $this->serializer->deserialize($data, $type, 'json')
      ->shouldBeCalled()
      ->willReturn($stub);

    $serializer = new JsonSerializer($this->factory->reveal());
    $result = $serializer->deserialize($data, $type);

    $this->assertSame(
      $stub,
      $result
    );
  }

}
