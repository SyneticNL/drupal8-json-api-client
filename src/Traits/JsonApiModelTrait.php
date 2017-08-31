<?php


namespace Drupal\json_api_client\Traits;


use Drupal\json_api_client\Model\JsonApiMetaData;

trait JsonApiModelTrait {

  /**
   * The json api metadata.
   *
   * @var JsonApiMetaData
   *
   * @Serializer\Exclude()
   */
  protected $jsonApiMetaData;

  /**
   * Get the json api metadata.
   *
   * @return JsonApiMetaData
   *   The json api metadata.
   */
  public function getJsonApiMetaData(): JsonApiMetaData {
    return $this->jsonApiMetaData;
  }

  /**
   * Set the json api metadata.
   *
   * @param JsonApiMetaData $jsonApiMetaData
   *   The json api metadata.
   */
  public function setJsonApiMetaData(JsonApiMetaData $jsonApiMetaData) {
    $this->jsonApiMetaData = $jsonApiMetaData;
  }

}
