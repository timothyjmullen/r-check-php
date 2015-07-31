<?php
$url = $_GET['url'];

function checkurl($theurl) {
  $cookie = tempnam ("/tmp", "CURLCOOKIE");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
  curl_setopt($ch, CURLOPT_URL, $theurl);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_ENCODING, "");
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLINFO_HEADER_OUT, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  $content = curl_exec($ch);
  $response = curl_getinfo($ch);
  curl_close($ch);
  return $response;
}

$i = 1;
$dataout = array('result' => 'success');
while ($i <= 4) {
  $response = checkurl($url);
  $dataout['data'][] = $response;
  if (strlen($response['redirect_url']) > 0) {
    $url = $response['redirect_url'];
    $i++;
  } else {
    $i = 5;
  }
}

echo json_encode($dataout);
 ?>
