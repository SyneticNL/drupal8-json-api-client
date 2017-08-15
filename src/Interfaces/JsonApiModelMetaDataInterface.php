<?php


namespace Drupal\json_api_client\Interfaces;

use Drupal\json_api_client\Model\JsonApiMetaData;

interface JsonApiModelMetaDataInterface {

  /**
   * @return JsonApiMetaData
   */
  public function getJsonApiMetaData(): JsonApiMetaData;

  /**
   * @param JsonApiMetaData $jsonApiMetaData
   *
   * @return mixed
   */
  public function setJsonApiMetaData(JsonApiMetaData $jsonApiMetaData);
}
