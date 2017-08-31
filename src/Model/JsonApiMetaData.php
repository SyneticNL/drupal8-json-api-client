<?php


namespace Drupal\json_api_client\Model;


use Drupal\json_api_client\Interfaces\JsonApiModelInterface;
use JMS\Serializer\Annotation as Serializer;

class JsonApiMetaData implements JsonApiModelInterface {

  /**
   * The relationships metadata.
   *
   * @var array
   *
   * @Serializer\Type("array")
   * @Serializer\Accessor(setter="setRelationships")
   * @Serializer\SerializedName("relationships")
   */
  protected $relationships;

  /**
   * The links metadata.
   *
   * @var array
   *
   * @Serializer\Type("array")
   * @Serializer\Accessor(setter="setLinks")
   * @Serializer\SerializedName("links")
   */
  protected $links;

  /**
   * The included metadata.
   *
   * @var array
   *
   * @Serializer\Type("array")
   * @Serializer\Accessor(setter="setIncluded")
   * @Serializer\SerializedName("included")
   */
  protected $included;

  /**
   * Get the relationship data.
   *
   * @return array
   *   The relationship data.
   */
  public function getRelationships() {
    return $this->relationships;
  }

  /**
   * Set the relationship data.
   *
   * @param array $relationships
   *   The relationship data.
   */
  public function setRelationships(array $relationships) {
    $this->relationships = $relationships;
  }

  /**
   * Get the links.
   *
   * @return array
   *   The list of links.
   */
  public function getLinks() {
    return $this->links;
  }

  /**
   * Set the links.
   *
   * @param array $links
   *   The list of links.
   */
  public function setLinks(array $links) {
    $this->links = $links;
  }

  /**
   * Get the included data.
   *
   * @return array
   *   The included data.
   */
  public function getIncluded() {
    return $this->included;
  }

  /**
   * Set the included data.
   *
   * @param array $included
   *   The included data.
   */
  public function setIncluded(array $included) {
    $this->included = $included;
  }

  /**
   * Get the unique identifier.
   *
   * @return string
   *   The unique identifier.
   */
  public function getUniqueIdentifier(): string {
    return 'meta-data';
  }

}
