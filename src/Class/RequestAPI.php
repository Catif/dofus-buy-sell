<?php

namespace Catif\Dofus\Class;

use Exception;

class RequestAPI
{
  public function get(string $url, array $params = [])
  {
    return $this->curlRequest('GET', $url, $params);
  }

  public function post($url, array $params = [], $body = [])
  {
    return $this->curlRequest('POST', $url, $params, $body);
  }

  public function put($url, array $params = [], $body = [])
  {
    return $this->curlRequest('PUT', $url, $params, $body);
  }

  public function patch($url, array $params = [], $body = [])
  {
    return $this->curlRequest('PATCH', $url, $params, $body);
  }

  public function delete($url, array $params = [], $body = [])
  {
    return $this->curlRequest('DELETE', $url, $params, $body);
  }

  private function generateUrl(string $url, array $params = [])
  {
    return $url . '?' . http_build_query($params);
  }

  private function curlRequest(string $method, string $url, array $params = [], array $body = [])
  {
    if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
      throw new Exception('Invalid method');
    }

    $url = $this->generateUrl($url, $params);

    $body = json_encode($body);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      'Content-Length: ' . strlen($body)
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    return $data;
  }
}
