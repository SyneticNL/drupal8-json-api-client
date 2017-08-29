<?php


namespace Drupal\json_api_client\Traits;


use Drupal\json_api_client\Model\JsonApiMetaData;

trait JsonApiModelTrait {

  /**
   * @var JsonApiMetaData
   *
   * @Serializer\Exclude()
   */
  protected $jsonApiMetaData;

  /**
   * @return JsonApiMetaData
   */
  public function getJsonApiMetaData(): JsonApiMetaData {
    return $this->jsonApiMetaData;
  }

  /**
   * @param JsonApiMetaData $jsonApiMetaData
   */
  public function setJsonApiMetaData(JsonApiMetaData $jsonApiMetaData) {
    $this->jsonApiMetaData = $jsonApiMetaData;
  }
}
