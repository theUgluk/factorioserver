<?php

  class CurlEmu
  {
      // Storing the result in here
      private $result;

      // The headers of the result will be stored here
      private $responseHeader;

      // url for request
      private $url;

      // options
      private $options = [];

      public function CurlEmu($url)
      {
          $this->url = $url;
      }

      public function setOpt($option, $value)
      {
          $this->options[$option] = $value;
      }

      public function getInfo($opt = 0)
      {
          if (!$this->result) {
              $this->fetchResult();
          }

          $responseHeaderSize = 0;
          foreach ($this->responseHeader as $header)
              $responseHeaderSize += (strlen($header) + 2); // The one is for each newline

          $httpCode = 200;
          if (preg_match('#HTTP/\d+\.\d+ (\d+)#', $this->responseHeader[0], $matches))
              $httpCode = intval($matches[1]);

          // opt
          if ($opt == CURLINFO_HEADER_SIZE)
              return $responseHeaderSize;

          if ($opt == CURLINFO_HTTP_CODE)
              return $httpCode;

          return [
              "url" => $this->url,
              "content_type" => "",
              "http_code" => $httpCode,
              "header_size" => $responseHeaderSize,
              "request_size" => 0,
              "filetime" => 0,
              "ssl_verify_result" => null,
              "redirect_count" => 0,
              "total_time" => 0,
              "namelookup_time" => 0,
              "connect_time" => 0,
              "pretransfer_time" => 0,
              "size_upload" => 0,
              "size_download" => 0,
              "speed_download" => 0,
              "speed_upload" => 0,
              "download_content_length" => 0,
              "upload_content_length" => 0,
              "starttransfer_time" => 0,
              "redirect_time" => 0,
              "certinfo" => 0,
              "request_header" => 0
          ];
      }

      public function exec()
      {
          $this->fetchResult();

          $fullResult = $this->result;

          if ($this->getValue(CURLOPT_HEADER, false)) {
              $headers = implode("\r\n", $this->responseHeader);
              $fullResult = $headers . "\r\n" . $this->result;
          }

          if ($this->getValue(CURLOPT_RETURNTRANSFER, false) == false) {
              print $fullResult;
          } else {
              return $fullResult;
          }
      }

      private function fetchResult()
      {
          // Create the context for this request based on the curl parameters

          // Determine the method
          if (!$this->getValue(CURLOPT_CUSTOMREQUEST, false) && $this->getValue(CURLOPT_POST, false)) {
              $method = 'POST';
          } else {
              $method = $this->getValue(CURLOPT_CUSTOMREQUEST, 'GET');
          }

          // Add the post header if type is post and it has not been added
          if ($method == 'POST') {
              if (is_array($this->getValue(CURLOPT_HTTPHEADER))) {
                  $found = false;
                  foreach ($this->getValue(CURLOPT_HTTPHEADER, array()) as $header) {
                      if (strtolower($header) == strtolower('Content-type: application/x-www-form-urlencoded')) {
                          $found = true;
                      }
                  }

                  // add post header if not found
                  if (!$found) {
                      $headers = $this->getValue(CURLOPT_HTTPHEADER, array());
                      $headers[] = 'Content-type: application/x-www-form-urlencoded';
                      $this->setOpt(CURLOPT_HTTPHEADER, $headers);
                  }
              }
          }

          // Determine the content which can be an array or a string
          if (is_array($this->getValue(CURLOPT_POSTFIELDS))) {
              $content = http_build_query($this->getValue(CURLOPT_POSTFIELDS, array()));
          } else {
              $content = $this->getValue(CURLOPT_POSTFIELDS, "");
          }

          // get timeout
          $timeout = $this->getValue(CURLOPT_TIMEOUT, 60);
          $connectTimeout = $this->getValue(CURLOPT_CONNECTTIMEOUT, 30);

          // take bigger timeout
          if ($connectTimeout > $timeout)
              $timeout = $connectTimeout;

          $headers = $this->getValue(CURLOPT_HTTPHEADER, "");
          if (is_array($headers)) {
              $headers = join("\r\n", $headers);
          }

          // 'http' instead of $parsedUrl['scheme']; https doest work atm
          $options = array(
              'http' => array(
                  "timeout" => $timeout,
                  "ignore_errors" => true,
                  'method' => $method,
                  'header' => $headers,
                  'content' => $content
              )
          );

          $options["http"]["follow_location"] = $this->getValue(CURLOPT_FOLLOWLOCATION, 1);

          // get url from options
          if ($this->getValue(CURLOPT_URL, false))
              $this->url = $this->getValue(CURLOPT_URL);


          // SSL settings when set
//          $parsedUrl = parse_url($this->url);
//			if($parsedUrl['scheme'] == 'https')
//			{
//				$context['https']['ssl'] = array(
//					'verify_peer' => $this->getValue(CURLOPT_SSL_VERIFYPEER, false)
//				);
//			}

          $context = stream_context_create($options);
          $this->result = file_get_contents($this->url, false, $context);

          $this->responseHeader = $http_response_header;
      }

      private function getValue($value, $default = null)
      {
          if (isset($this->options[$value]) && $this->options[$value]) {
              return $this->options[$value];
          }
          return $default;
      }

      public function errNo()
      {
          return 0;
      }

      public function error()
      {
          return "";
      }

      public function close()
      {

      }
  }

  function curlemu_init($url = null)
  {
      return new CurlEmu($url);
  }

  function curlemu_setopt($ch, $option, $value)
  {
      $ch->setOpt($option, $value);
  }

  function curlemu_exec($ch)
  {
      return $ch->exec();
  }

  function curlemu_getinfo($ch, $option = 0)
  {
      return $ch->getInfo($option);
  }

  function curlemu_errno($ch) {
      return $ch->errNo();
  }

  function curlemu_error($ch) {
      return $ch->error();
  }

  function curlemuclose($ch) {
      return $ch->close();
  }

  function curlemu_setopt_array($ch, $options) {
      foreach ($options as $option => $value) {
          curl_setopt($ch, $option, $value);
      }
  }
