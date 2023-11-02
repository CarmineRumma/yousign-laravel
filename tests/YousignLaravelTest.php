<?php

class YousignLaravelTest extends \PHPUnit\Framework\TestCase
{
  private $http;

  public function setUp(): void
  {
    $this->http = new GuzzleHttp\Client(['base_uri' => 'https://httpbin.org/']);
  }

  public function tearDown(): void {
    $this->http = null;
  }
}
