<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;

use App\Library\Helpers;

class ApiController extends Controller {
  private $helpers = null;

  public function __construct() {
    $this->helpers = new Helpers();
  }

  private function getHeaders() {
    return [
      'accept' => 'application/json',
      'content-type' => 'application/json',
      'x-api-key' => env('ESPACETV_API_KEY', null),
    ];
  }

  private function getURL($endpoint) {
    return env('ESPACETV_API_URL', '') . '/' . $endpoint;
  }

  public function get($url, $params = [], $attachToken = false) {
    if (empty($url)) {
      return null;
    }
    if ($attachToken) {
      $token = $_COOKIE['token'];
      if (empty($token)) {
        return null;
      }
      $responseFromApi = Http::withHeaders($this->getHeaders())
        ->withToken($token)
        ->get($this->getURL($url), $params);
    } else {
      $responseFromApi = Http::withHeaders($this->getHeaders())->get(
        $this->getURL($url),
        $params,
      );
    }

    $response = [
      'statusCode' => $responseFromApi->status(),
      'data' => $this->helpers->arrayToObject($responseFromApi->json()),
    ];
    return (object) $response;
  }

  public function post($url, $body, $attachToken = false) {
    if (empty($url)) {
      return null;
    }
    if ($attachToken) {
      $token = $_COOKIE['token'];
      if (empty($token)) {
        return null;
      }
      $responseFromApi = Http::withHeaders($this->getHeaders())
        ->withToken($token)
        ->post($this->getURL($url), $body);
    } else {
      $responseFromApi = Http::withHeaders($this->getHeaders())->post(
        $this->getURL($url),
        $body,
      );
    }
    $response = [
      'statusCode' => $responseFromApi->status(),
      'data' => $this->helpers->arrayToObject($responseFromApi->json()),
    ];
    return (object) $response;
  }

  public function delete($url, $attachToken = false) {
    if (empty($url)) {
      return null;
    }
    if ($attachToken) {
      $token = $_COOKIE['token'];
      if (empty($token)) {
        return null;
      }
      $responseFromApi = Http::withHeaders($this->getHeaders())
        ->withToken($token)
        ->delete($this->getURL($url));
    } else {
      $responseFromApi = Http::withHeaders($this->getHeaders())->delete(
        $this->getURL($url),
      );
    }

    $response = [
      'statusCode' => $responseFromApi->status(),
      'data' => $this->helpers->arrayToObject($responseFromApi->json()),
    ];
    return (object) $response;
  }

  public function patch($url, $body, $attachToken = false) {
    if (empty($url)) {
      return null;
    }
    if ($attachToken) {
      $token = $_COOKIE['token'];
      if (empty($token)) {
        return null;
      }
      $responseFromApi = Http::withHeaders($this->getHeaders())
        ->withToken($token)
        ->patch($this->getURL($url), $body);
    } else {
      $responseFromApi = Http::withHeaders($this->getHeaders())->patch(
        $this->getURL($url),
        $body,
      );
    }

    $response = [
      'statusCode' => $responseFromApi->status(),
      'data' => $this->helpers->arrayToObject($responseFromApi->json()),
    ];
    return (object) $response;
  }
}
