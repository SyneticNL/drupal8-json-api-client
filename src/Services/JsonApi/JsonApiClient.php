<?php


namespace Drupal\json_api_client\Services\JsonApi;


use Drupal\json_api_client\Exception\JsonApiClientResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class JsonApiClient {

  const SERIALIZER_FORMAT = 'json';

  /**
   * The guzzle http client.
   *
   * @var \GuzzleHttp\Client
   */
  private $httpClient;

  /**
   * The Json api response parser.
   *
   * @var JsonApiResponseParser
   */
  private $apiResponseParser;

  /**
   * CcsWebEngineClient constructor.
   *
   * @param Client $httpClient
   *   The guzzle http client.
   * @param JsonApiResponseParser $apiResponseParser
   *   The json api response parser.
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
   *   The url.
   * @param array $parameters
   *   The request parameters.
   *
   * @return Response
   *   Http guzzle response.
   */
  public function get(string $url, array $parameters): Response {
    return $this->executeRequest('get', $url, $parameters);
  }

  /**
   * Execute a http request.
   *
   * @param string $method
   *   The request method to execute.
   * @param string $url
   *   The url to request.
   * @param array $parameters
   *   The request parameters.
   *
   * @return Response
   *   Http guzzle response.
   */
  protected function executeRequest(
    string $method,
    string $url,
    array $parameters
  ): Response {
    $response = $this->httpClient->request(
      $method,
      $url,
      $parameters
    );

    if ($this->apiResponseParser->doesResponseHaveErrors($response)) {
      $response->getBody()->rewind();
      $body = $response->getBody()->getContents();
      $this->logErrors($body);

      throw new JsonApiClientResponseException(
        $this->apiResponseParser->getErrorSummaryString($response)
      );
    }

    return $response;
  }

  /**
   * Log all the errors.
   *
   * @param string $response
   *   The guzzle response.
   */
  protected function logErrors(string $response) {
    $data = json_decode($response);

    foreach ($data->errors as $error) {
      \Drupal::logger(
        'ccs_webengine_client'
      )->error(
        json_encode($error)
      );
    }
  }

  /**
   * Get a list of objects from the external service.
   *
   * @param string $url
   *   The request url.
   * @param array $parameters
   *   The request parameters.
   *
   * @return Response
   *   The guzzle response.
   */
  public function getList(string $url, array $parameters): Response {
    return $this->executeRequest('get', $url, $parameters);
  }

  /**
   * Post a new object to the external service.
   *
   * @param string $url
   *   The url to request.
   * @param array $parameters
   *   The request parameters.
   *
   * @return Response
   *   The guzzle response.
   */
  public function post(string $url, array $parameters): Response {
    return $this->executeRequest('post', $url, $parameters);
  }

  /**
   * Put a new object to the external service.
   *
   * @param string $url
   *   The url to request.
   * @param array $parameters
   *   The request parameters.
   *
   * @return Response
   *   The guzzle response.
   */
  public function put(string $url, array $parameters): Response {
    return $this->executeRequest('put', $url, $parameters);
  }

  /**
   * Patch an object to the external service.
   *
   * @param string $url
   *   The url to request.
   * @param array $parameters
   *   The request parameters.
   *
   * @return Response
   *   The guzzle response.
   */
  public function patch(string $url, array $parameters): Response {
    return $this->executeRequest('patch', $url, $parameters);
  }

  /**
   * Delete an object from the remote service.
   *
   * @param string $url
   *   The url to request.
   * @param array $parameters
   *   The request parameters.
   *
   * @return Response
   *   The guzzle response.
   */
  public function delete(string $url, array $parameters): Response {
    return $this->executeRequest('delete', $url, $parameters);
  }

}
