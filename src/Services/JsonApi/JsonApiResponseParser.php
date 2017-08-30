<?php


namespace Drupal\json_api_client\Services\JsonApi;


use Drupal\json_api_client\Exception\JsonApiClientResponseException;
use GuzzleHttp\Psr7\Response;

class JsonApiResponseParser {

  /**
   * Get the error summary as a string.
   *
   * @param Response $response
   *   The guzzle response.
   *
   * @return string
   *   The error summary
   */
  public function getErrorSummaryString(Response $response): string {
    if (!$this->doesResponseHaveErrors($response)) {
      throw new JsonApiClientResponseException('There are no errors to parse');
    }

    $response->getBody()->rewind();
    $body = $response->getBody()->getContents();
    $decoded = json_decode($body);

    $format = '%10s:%50s:%100s';

    $errorList = [];

    foreach ($decoded->errors as $error) {
      $errorList[] = sprintf(
        $format,
        $error->code,
        $error->title,
        $error->details
      );
    }

    return implode(PHP_EOL, $errorList);
  }

  /**
   * Does the response have errors.
   *
   * @param Response $response
   *   The guzzle response.
   *
   * @return bool
   *   Does the response have errors.
   */
  public function doesResponseHaveErrors(Response $response): bool {
    $response->getBody()->rewind();
    $body = $response->getBody()->getContents();
    $decoded = json_decode($body);

    return isset($decoded->errors);
  }
}
