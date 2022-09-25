<?php
  $tokens=array('set-me-up');
  $storage="/var/lib/monitoring/passive";

  $is_ok=false;
  if(isset($_REQUEST['token'])) {
    $token=$_REQUEST['token'];
    if(in_array($token,$tokens)) {
      if(isset($_REQUEST['agent'])) {
        $agent=$_REQUEST['agent'];
        if(isset($_REQUEST['hostname'])) {
          $hostname=$_REQUEST['hostname'];
          $is_ok=true;
        }
      }
    }
  }
  if(!$is_ok) {
    http_response_code(403);
    die();
  }
  if(!filter_var($hostname,FILTER_VALIDATE_DOMAIN,FILTER_FLAG_HOSTNAME)) {
    die('FAIL:HOSTNAME');
  }
  $data=gzdecode(base64_decode($agent));
  if($data === false) {
      die('FAIL:DECODE');
  }
  if( ($temp=tempnam($storage,".check:${hostname}:")) === false ) {
      die('FAIL:TMP');
  }
  chmod($temp,0644);
  if(file_put_contents($temp,$data,LOCK_EX) === false) {
    @unlink($temp);
    die('FAIL:WRITE');
  }
  if(!rename($temp,$storage . "/" . $hostname)) {
    @unlink($temp);
    die('FAIL:QUEUE');
  }
