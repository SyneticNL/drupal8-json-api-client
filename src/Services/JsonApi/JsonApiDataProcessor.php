<?php


namespace Drupal\json_api_client\Services\JsonApi;


use Drupal\jms_serializer\Interfaces\SerializerInterface;
use Drupal\json_api_client\Interfaces\JsonApiModelInterface;
use Drupal\json_api_client\Iterator\JsonApiModelIterator;
use GuzzleHttp\Psr7\Response;

class JsonApiDataProcessor {

  const SERIALIZER_FORMAT = 'json';

  const JSON_API_MODEL_FIELDS = ['links', 'relationships', 'included'];

  const JSON_API_METADATA_TYPE = 'json_api_metadata';

  /** @var JsonApiObjectMapper */
  private $mapper;

  /** @var SerializerInterface */
  private $serializer;

  /** @var string */
  private $idField;

  /**
   * JsonApiDataProcessor constructor.
   *
   * @param JsonApiObjectMapper $mapper
   *   The json api object mapper.
   * @param SerializerInterface $serializer
   *   The serializer.
   * @param string $idField
   *   The id field to use in the responses.
   */
  public function __construct(
    JsonApiObjectMapper $mapper,
    SerializerInterface $serializer,
    string $idField
  ) {
    $this->mapper = $mapper;
    $this->serializer = $serializer;
    $this->idField = $idField;
  }

  /**
   * Create a Json api model from the guzzle response.
   *
   * @param Response $response
   *   The guzzle response.
   *
   * @return JsonApiModelInterface
   *   The json api model.
   */
  public function createModel(Response $response): JsonApiModelInterface {
    $response->getBody()->rewind();

    $body = $response->getBody()->getContents();
    $decoded = json_decode($body, TRUE);

    return $this->buildModel($decoded);
  }

  /**
   * Build the json api model.
   *
   * @param mixed $data
   *   The dataset to convert.
   *
   * @return JsonApiModelInterface
   *   The model.
   */
  protected function buildModel($data): JsonApiModelInterface {
    $model = $this->serializer->deserialize(
      json_encode(
        array_merge(
          [$this->idField => $data['data'][$this->idField]],
          $data['data']['attributes']
        )
      ),
      $this->mapper->getByRemoteDefinition($data['data']['type'])
    );

    if (!($model instanceof JsonApiModelInterface)) {
      return $model;
    }

    $metadata = $this->createJsonApiMetaDataModel($data);
    $model->setJsonApiMetaData($metadata);

    return $model;
  }

  /**
   * Create the json api metadata model.
   *
   * @param mixed $data
   *   The dataset to convert.
   *
   * @return JsonApiModelInterface
   *   The json api meta data.
   */
  protected function createJsonApiMetaDataModel($data): JsonApiModelInterface {
    $metaDataData = [];

    foreach (static::JSON_API_MODEL_FIELDS as $field) {
      if (!isset($data[$field]) || empty($data[$field])) {
        $metaDataData[$field] = [];
        continue;
      }

      /**
       * @TODO implement indiviual (de)serializing of objects contained
       * in metadata sets. So the metadata object contains iterator objects
       * with the nested models
       */

      $metaDataData[$field] = $data[$field];
    }

    $metaData = $this->serializer->deserialize(
      json_encode($metaDataData),
      $this->mapper->getByRemoteDefinition(self::JSON_API_METADATA_TYPE)
    );

    return $metaData;
  }

  /**
   * Convert a json api model to a request.
   *
   * @param JsonApiModelInterface $model
   *   The model to convert.
   *
   * @return array
   *    The request data.
   */
  public function createRequestBody(JsonApiModelInterface $model): array {
    return [
      static::SERIALIZER_FORMAT => [
        'data' => [
          [
            'type' => $this->mapper->getByLocalDefinition(get_class($model)),
            'id' => $model->getUniqueIdentifier(),
            'attributes' => json_decode(
              $this->serializer->serialize($model), TRUE
            ),
          ],
        ],
      ],
    ];
  }

  /**
   * Create a list of json api models.
   *
   * @param Response $response
   *   The guzzle response.
   *
   * @return JsonApiModelIterator
   *   The iterator.
   */
  public function createIterator(Response $response): JsonApiModelIterator {
    $response->getBody()->rewind();
    $body = $response->getBody()->getContents();

    $decoded = json_decode($body, TRUE);

    $modelList = array_map(
      function ($row) {
        if (!isset($row['data'])) {
          return $this->buildModel(['data' => $row]);
        }

        return $this->buildModel($row);
      }, $decoded['data']
    );

    $metadata = $this->createJsonApiMetaDataModel($decoded);

    $iterator = new JsonApiModelIterator($modelList);
    $iterator->setJsonApiMetaData($metadata);

    return $iterator;
  }

}
