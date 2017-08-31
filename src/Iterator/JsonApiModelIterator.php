<?php


namespace Drupal\json_api_client\Iterator;


use Drupal\json_api_client\Interfaces\JsonApiModelInterface;
use Drupal\json_api_client\Traits\JsonApiModelTrait;

/**
 * Class JsonApiModelIterator
 *
 * @package Drupal\json_api_client\Iterator
 */
class JsonApiModelIterator implements \Iterator, \Countable, JsonApiModelInterface {

  use JsonApiModelTrait;

  /**
   * Iterator index.
   *
   * @var int
   */
  protected $index = 0;

  /**
   * The list of json api models.
   *
   * @var JsonApiModelInterface[]
   */
  protected $models = [];

  /**
   * CcsModelIterator constructor.
   *
   * @param JsonApiModelInterface[] $models
   *   The list of json api model interfaces.
   */
  public function __construct(array $models) {
    foreach ($models as $model) {
      $this->addModel($model);
    }
  }

  /**
   * Add a new json api model interface to the iterator.
   *
   * @param JsonApiModelInterface $model
   *   The model to add.
   */
  protected function addModel(JsonApiModelInterface $model) {
    $this->models[] = $model;
  }

  /**
   * Get the current model in the iterator.
   *
   * @return JsonApiModelInterface
   *   The json api model interface.
   */
  public function current() {
    return $this->models[$this->index];
  }

  /**
   * Increment the internal pointer.
   */
  public function next() {
    $this->index++;
  }

  /**
   * Get the current internal pointer.
   *
   * @return int
   *   The current pointer.
   */
  public function key() {
    return $this->index;
  }

  /**
   * Is the current pointer valid.
   *
   * @return bool
   *   Is the current pointer valid.
   */
  public function valid() {
    return isset($this->models[$this->index]);
  }

  /**
   * Reset the internal pointer.
   */
  public function rewind() {
    $this->index = 0;
  }

  /**
   * Count the number of items in the iterator.
   *
   * @return int
   *   The count
   */
  public function count() {
    return count($this->models);
  }

}
