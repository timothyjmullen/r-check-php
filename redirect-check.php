<?php
$url = $_GET['url'];

function checkurl($theurl) {
  $cookie = tempnam ("/tmp", "CURLCOOKIE");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36");
  curl_setopt($ch, CURLOPT_URL, $theurl);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLINFO_HEADER_OUT, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: */*'));
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);
  curl_setopt($ch, CURLOPT_REFERER, $theurl);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
  curl_setopt($ch, CURLOPT_NOBODY, false);
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
