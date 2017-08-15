<?php


namespace Drupal\json_api_client\Model;


use Drupal\json_api_client\Interfaces\JsonApiModelInterface;
use JMS\Serializer\Annotation as Serializer;

class JsonApiMetaData implements JsonApiModelInterface {
  /**
   * @Serializer\Type("array")
   * @Serializer\Accessor(setter="setRelationships")
   * @Serializer\SerializedName("relationships")
   */
  protected $relationships;

  /**
   * @var array
   *
   * @Serializer\Type("array")
   * @Serializer\Accessor(setter="setLinks")
   * @Serializer\SerializedName("links")
   */
  protected $links;

  /**
   * @var array
   *
   * @Serializer\Type("array")
   * @Serializer\Accessor(setter="setIncluded")
   * @Serializer\SerializedName("included")
   */
  protected $included;

  /**
   * @return array
   */
  public function getRelationships() {
    return $this->relationships;
  }

  /**
   * @param array $relationships
   */
  public function setRelationships(array $relationships) {
    $this->relationships = $relationships;
  }

  /**
   * @return array
   */
  public function getLinks() {
    return $this->links;
  }

  /**
   * @param array $links
   */
  public function setLinks(array $links) {
    $this->links = $links;
  }

  /**
   * @return array
   */
  public function getIncluded() {
    return $this->included;
  }

  /**
   * @param array $included
   */
  public function setIncluded(array $included) {
    $this->included = $included;
  }

  public function getUniqueIdentifier(): string {
    return 'meta-data';
  }
}
