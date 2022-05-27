<?php

  function check_reCAPTCHA(){

      $captcha = $_POST['g-recaptcha'];
      $secretKey = '6LelKNIfAAAAAJ-K2lZ6E9jlj3u5fkAtystTKrQ-'; 
      $ip = $_SERVER['REMOTE_ADDR'];                           
      
      $data = array(
          'secret' => $secretKey,
          'response' => $captcha,
          'remoteip' => $ip  
      );
      
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $response = curl_exec($ch);
      curl_close($ch);
      
      $responseKeys = json_decode($response, true);

      if ($responseKeys["success"]) {
          return true;
      } else {
          return false;
      }

  }

?>
