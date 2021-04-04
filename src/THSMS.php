<?php

namespace Necessarylion;

use Exception;

class THSMS {

  /**
   * @var string
   */
  const API = 'http://www.thsms.com/api/rest';

  /**
   * @var Array
   */
  private $params = [];

  /**
   * Class Constructor
   * @param Array $params = [
   *  'username' => <string>
   *  'password' => <string>
   *  'sender'   => <string>
   * ]
   */
  public function __construct($params) {
    $this->params['username'] = $params['username'];
    $this->params['password'] = $params['password'];
    $this->params['method']   = 'send';
    $this->params['from']     = $params['sender'];   
  }

  /**
   * function to sent sms to thailand phone number
   * @param string $to
   * @param string $message
   * @return string <UUID>
   */
  public function sent($to, $message) {
    try {
      $this->params['to']      = str_replace('+66', '0', $to);
      $this->params['message'] = $message;

      if (is_null($to)) {
        throw new Exception('required phone number to sent');
      }

      if (is_null($message)) {
        throw new Exception('required message to sent');
      }

      $result = $this->curl();
      $xml    = @simplexml_load_string($result);

      if (!is_object($xml)) {
        throw new Exception('Respond error');
      } 

      if ($xml->send->status != 'success') {
        throw new Exception($xml->send->message);
      } 
      
      return $xml->send->uuid;
    }
    catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  /**
   * CURL 
   * @param $params;
   */
  private function curl() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::API);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response  = curl_exec($ch);
    $lastError = curl_error($ch);
    $lastReq   = curl_getinfo($ch);
    curl_close($ch);
    return $response;
  }
}