<?php


namespace Drupal\json_api_client\Services\JsonApi;


use Drupal\json_api_client\Exception\JsonApiObjectMappingDoesNotExistException;

class JsonApiObjectMapper {

  /** @var array */
  protected $objectMap = [];

  /**
   * JsonApiObjectMapper constructor.
   *
   * @param array $objectMap
   */
  public function __construct(array $objectMap) {
    $this->objectMap = $objectMap;
  }

  /**
   * @param $definition
   *
   * @return mixed
   */
  public function getByRemoteDefinition($definition) {
    if (!$this->hasRemoteDefinition($definition)) {
      throw new JsonApiObjectMappingDoesNotExistException(
        sprintf(
          'The object mapping for the remote definition [%s] does not exist',
          $definition
        )
      );
    }

    return $this->objectMap[$definition];
  }

  /**
   * @param $definition
   *
   * @return bool
   */
  public function hasRemoteDefinition($definition) {
    return isset($this->objectMap[$definition]);
  }

  /**
   * @param $definition
   *
   * @return false|int|string
   */
  public function getByLocalDefinition($definition) {
    if (!$this->hasLocalDefinition($definition)) {
      throw new JsonApiObjectMappingDoesNotExistException(
        sprintf(
          'The object mapping for the local definition [%s] does not exist',
          $definition
        )
      );
    }

    return array_search($definition, $this->objectMap);
  }

  /**
   * @param $definition
   *
   * @return bool
   */
  public function hasLocalDefinition($definition) {
    return in_array($definition, $this->objectMap);
  }
}
