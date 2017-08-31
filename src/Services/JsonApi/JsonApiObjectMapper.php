<?php


namespace Drupal\json_api_client\Services\JsonApi;


use Drupal\json_api_client\Exception\JsonApiObjectMappingDoesNotExistException;

class JsonApiObjectMapper {

  /**
   * The object map.
   *
   * @var array
   */
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
   * Get the local object type by the remote definition.
   *
   * @param string $definition
   *   The definition to lookup.
   *
   * @return string
   *   The return definition.
   */
  public function getByRemoteDefinition(string $definition): string {
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
   * Does the remote definition exist in the map.
   *
   * @param string $definition
   *   The definition to lookup.
   *
   * @return bool
   *   Does the definition exist.
   */
  public function hasRemoteDefinition(string $definition): bool {
    return isset($this->objectMap[$definition]);
  }

  /**
   * Get the remote definition by the local definition.
   *
   * @param string $definition
   *   The definition to lookup.
   *
   * @return string
   *   The remote definition.
   */
  public function getByLocalDefinition(string $definition): string {
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
   * Does the local definition exist.
   *
   * @param string $definition
   *   The definition to lookup.
   *
   * @return bool
   *   Does the definition exist.
   */
  public function hasLocalDefinition(string $definition): bool {
    return in_array($definition, $this->objectMap);
  }
}
