<?php


namespace Drupal\json_api_client\Iterator;


use Drupal\json_api_client\Interfaces\JsonApiModelInterface;
use Drupal\json_api_client\Traits\JsonApiModelTrait;

class JsonApiModelIterator implements \Iterator, \Countable,
  JsonApiModelInterface {

  use JsonApiModelTrait;

  /** @var int */
  protected $index = 0;

  /** @var JsonApiModelInterface[] */
  protected $models = [];

  /**
   * CcsModelIterator constructor.
   *
   * @param JsonApiModelInterface[] $models
   */
  public function __construct(array $models) {
    foreach ($models as $model) {
      $this->addModel($model);
    }
  }

  /**
   * @param JsonApiModelInterface $model
   */
  protected function addModel(JsonApiModelInterface $model) {
    $this->models[] = $model;
  }

  public function current() {
    return $this->models[$this->index];
  }

  public function next() {
    $this->index++;
  }

  public function key() {
    return $this->index;
  }

  public function valid() {
    return isset($this->models[$this->index]);
  }

  public function rewind() {
    $this->index = 0;
  }

  public function count() {
    return count($this->models);
  }
}
