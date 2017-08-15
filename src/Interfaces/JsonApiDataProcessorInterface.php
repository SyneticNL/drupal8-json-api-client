<?php


namespace Drupal\json_api_client\Interfaces;


use Drupal\json_api_client\Iterator\JsonApiModelIterator;
use GuzzleHttp\Psr7\Response;

interface JsonApiDataProcessorInterface {
  /**
   * @param Response $response
   *
   * @return JsonApiModelInterface
   */
  public function createModel(Response $response): JsonApiModelInterface;

  /**
   * @param Response $response
   *
   * @return JsonApiModelIterator
   */
  public function createIterator(Response $response): JsonApiModelIterator;

  /**
   * @param JsonApiModelInterface $model
   *
   * @return array
   */
  public function createRequestBody(JsonApiModelInterface $model): array;
}
