<?php


namespace Drupal\json_api_client\Services\JsonApi;


use Drupal\json_api_client\Exception\JsonApiClientResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class JsonApiClient {
  const SERIALIZER_FORMAT = 'json';

  /** @var Client */
  private $httpClient;

  /** @var JsonApiResponseParser */
  private $apiResponseParser;

  /**
   * CcsWebEngineClient constructor.
   *
   * @param Client $httpClient
   * @param JsonApiResponseParser $apiResponseParser
   */
  public function __construct(
    Client $httpClient,
    JsonApiResponseParser $apiResponseParser
  ) {
    $this->httpClient = $httpClient;
    $this->apiResponseParser = $apiResponseParser;
  }

  /**
   * Get a single object from the external service.
   *
   * @param string $url
   * @param array $parameters
   *
   * @return Response
   */
  public function get(string $url, array $parameters): Response {
    return $this->executeRequest('get', $url, $parameters);
  }

  /**
   * Get a list of objects from the external service.
   *
   * @param string $url
   * @param array $parameters
   *
   * @return Response
   */
  public function getList(string $url, array $parameters): Response {
    return $this->executeRequest('get', $url, $parameters);
  }

  /**
   * Log all the errors.
   *
   * @param string $response
   */
  protected function logErrors(string $response) {
    $data = json_decode($response);

    foreach ($data->errors as $error) {
      \Drupal::logger(
        'ccs_webengine_client')->error(
        json_encode($error)
      );
    }
  }

  /**
   * Post a new object to the external service.
   *
   * @param string $url
   * @param array $parameters
   *
   * @return Response
   */
  public function post(string $url, array $parameters): Response {
    return $this->executeRequest('post', $url, $parameters);
  }

  /**
   * Put a new object to the external service.
   *
   * @param string $url
   * @param array $parameters
   *
   * @return Response
   */
  public function put(string $url, array $parameters): Response {
    return $this->executeRequest('put', $url, $parameters);
  }

  /**
   * Patch an object to the external service.
   *
   * @param string $url
   * @param array $parameters
   *
   * @return Response
   */
  public function patch(string $url, array $parameters): Response {
    return $this->executeRequest('patch', $url, $parameters);
  }

  /**
   * Delete an object from the remote service.
   *
   * @param string $url
   * @param array $parameters
   *
   * @return Response
   */
  public function delete(string $url, array $parameters): Response {
    return $this->executeRequest('delete', $url, $parameters);
  }

  /**
   * @param string $method
   * @param string $url
   * @param array $parameters
   *
   * @return Response
   */
  protected function executeRequest(string $method, string $url, array $parameters): Response {
    $response = $this->httpClient->request(
      $method,
      $url,
      $parameters
    );

    if ($this->apiResponseParser->doesResponseHaveErrors($response)) {
      $response->getBody()->rewind();
      $body = $response->getBody()->getContents();
      $this->logErrors($body);

      throw new JsonApiClientResponseException($this->apiResponseParser->getErrorSummaryString($response));
    }

    return $response;
  }
}
