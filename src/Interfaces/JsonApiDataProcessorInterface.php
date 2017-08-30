<?php


namespace Drupal\json_api_client\Interfaces;


use Drupal\json_api_client\Iterator\JsonApiModelIterator;
use GuzzleHttp\Psr7\Response;

/**
 * Interface JsonApiDataProcessorInterface.
 *
 * @package Drupal\json_api_client\Interfaces
 */
interface JsonApiDataProcessorInterface {

  /**
   * Create a single model.
   *
   * @param Response $response
   *   The guzzle response.
   *
   * @return JsonApiModelInterface
   *   The Json api model interface to create.
   */
  public function createModel(Response $response): JsonApiModelInterface;

  /**
   * Create an iterator of models.
   *
   * @param Response $response
   *   The guzzle Response object.
   *
   * @return JsonApiModelIterator
   *   The json Api model iterator.
   */
  public function createIterator(Response $response): JsonApiModelIterator;

  /**
   * Create a json request body.
   *
   * @param JsonApiModelInterface $model
   *   The json api model interface to use for the request.
   *
   * @return array
   *   The return array dataset.
   */
  public function createRequestBody(JsonApiModelInterface $model): array;
}
