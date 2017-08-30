<?php


namespace Drupal\json_api_client\Interfaces;

use Drupal\json_api_client\Model\JsonApiMetaData;

/**
 * Interface JsonApiModelMetaDataInterface.
 *
 * @package Drupal\json_api_client\Interfaces
 */
interface JsonApiModelMetaDataInterface {

  /**
   * Get the json api meta data model.
   *
   * @return JsonApiMetaData
   *   Json api meta data model.
   */
  public function getJsonApiMetaData(): JsonApiMetaData;

  /**
   * Set the json api meta data model.
   *
   * @param JsonApiMetaData $jsonApiMetaData
   *   The json api meta data model to use.
   */
  public function setJsonApiMetaData(JsonApiMetaData $jsonApiMetaData);

}
