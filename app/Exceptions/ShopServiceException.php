<?php

namespace App\Exceptions;

use RuntimeException;

class ShopServiceException extends RuntimeException
{
  public function __construct(
    string $message,
    private int $statusCode = 400
  ) {
    parent::__construct($message);
  }

  public function getStatusCode(): int
  {
    return $this->statusCode;
  }
}