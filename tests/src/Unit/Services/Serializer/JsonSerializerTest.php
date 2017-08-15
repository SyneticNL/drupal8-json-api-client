<?php

namespace Drupal\json_api_client\Services\Serializer;

use Drupal\json_api_client\Interfaces\JsonApiModelInterface;
use Drupal\json_api_client\Interfaces\SerializableInterface;
use JMS\Serializer\Serializer;
use Prophecy\Prophet;

class JsonSerializerTest extends \PHPUnit_Framework_TestCase {


  /** @var Prophet * */
  protected $prophecy;

  /** @var Prophet|SerializerFactory */
  private $factory;

  /** @var Prophet|Serializer */
  private $serializer;

  public function setUp() {
    $this->prophecy = new Prophet();
    $this->factory = $this->prophecy->prophesize(SerializerFactory::class);
    $this->serializer = $this->prophecy->prophesize(Serializer::class);
  }

  public function testSerialize()
  {
    $expected = json_encode([
      'test' => 'array'
    ]);
    $model = $this->prophecy->prophesize(SerializableInterface::class);
    $stub = $model->reveal();

    $this->factory->createSerializer()->shouldBeCalled()->willReturn($this->serializer);
    $this->serializer->serialize($stub, 'json')->shouldBeCalled()->willReturn($expected);

    $serializer = new JsonSerializer($this->factory->reveal());
    $result = $serializer->serialize($stub);

    $this->assertSame(
      $expected,
      $result
    );
  }

  public function testDeserialize()
  {
    $data = json_encode(
      [
        'test' => 'data'
      ]
    );

    $type = 'test';

    $model = $this->prophecy->prophesize(JsonApiModelInterface::class);
    $stub = $model->reveal();

    $this->factory->createSerializer()->shouldBeCalled()->willReturn($this->serializer);
    $this->serializer->deserialize($data, $type, 'json')->shouldBeCalled()->willReturn($stub);

    $serializer = new JsonSerializer($this->factory->reveal());
    $result = $serializer->deserialize($data, $type);

    $this->assertSame(
      $stub,
      $result
    );
  }
}
