<?php

// telegram: @jingsong87

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function get_username($username, $proxy, $cookie) {

  $url = "https://www.instagram.com/api/v1/feed/user/$username/username/?count=12";
  $user_agent = "Mozilla/5.0 (Windows NT 10.0; rv:109.0) Gecko/20100101 Firefox/115.0";

  $headers = array(
    'User-Agent: ' . $user_agent,
    'Accept: */*',
    'Accept-Language: en-US,en;q=0.5',
    'Accept-Encoding: gzip, deflate, br',
    'Referer: https://www.instagram.com/' . $username . '/',
    'X-CSRFToken: ICQYkb93CStU7D0snOnDxmnb1sbGEOas',
    'X-IG-App-ID: 936619743392459',
    'X-ASBD-ID: 129477',
    'X-IG-WWW-Claim: hmac.AR0VVymmYIrBAnkkhFzUYC7zI4J73OwREVBlPsDo7Qs4dUu0',
    'X-Requested-With: XMLHttpRequest',
    'Connection: keep-alive',
    'Cookie: ' . $cookie,
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-origin',
    'TE: trailers'
  );

  $curl = curl_init();

  if (!$curl) {
    echo 'Unable to initialize curl.';
  }

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

  curl_setopt($curl, CURLOPT_PROXY, $proxy['proxy']);
  curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy['auth']);

  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_ENCODING, '');
  curl_setopt($curl, CURLOPT_MAXREDIRS, 0);
  curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


  $response = curl_exec($curl);

  $header  = curl_getinfo($curl);
  // print_r($response);

  $json = json_decode($response, true);

  $data = [];

  // print_r($json);

  echo "\n";
  echo "pk: {$json['user']['pk']}\n";
  echo "username: {$json['user']['username']}\n";
  echo "full_name: {$json['user']['full_name']}\n";

  $private = $json['user']['is_private'] ? 1 : 0;

  echo "is_private: {$private}\n";
  echo "profile_pic_url: {$json['user']['profile_pic_url']}\n";
  echo "status: {$json['status']}\n";

  echo "\nlocation\n";

  $location_arr = [];
  $location_val = '';
  foreach ($json['items'] as $key => $item) {

    if (isset($item['location'])) {
      $location_arr[] = $item['location']['name'];
      $location_val = $location_val . $item['location']['name'] . "\n";
      // echo "\n[$key] " . $item['location']['name'];
      // echo 'short_name: ' . $item['location']['short_name'];
      // echo "\n";
    }
  }

  $data['user'] = $json['user'];
  $data['location_val'] = $location_val;
  $data['location_arr'] = $location_arr;
  echo $location_val;
  print_r($location_arr);
  echo "\n";

  curl_close($curl);

  return $data;

}

function get_userinfo($user_id, $proxy, $cookie) {

  $username = 'durov';

  $url = "https://www.instagram.com/api/v1/users/$user_id/info/";
  $user_agent = "Mozilla/5.0 (Windows NT 10.0; rv:109.0) Gecko/20100101 Firefox/115.0";

  $headers = array(
    'User-Agent: ' . $user_agent,
    'Accept: */*',
    'Accept-Language: en-US,en;q=0.5',
    'Accept-Encoding: gzip, deflate, br',
    'Referer: https://www.instagram.com/' . $username . '/followers/',
    'X-CSRFToken: ICQYkb93CStU7D0snOnDxmnb1sbGEOas',
    'X-IG-App-ID: 936619743392459',
    'X-ASBD-ID: 129477',
    'X-IG-WWW-Claim: hmac.AR0VVymmYIrBAnkkhFzUYC7zI4J73OwREVBlPsDo7Qs4dUu0',
    'X-Requested-With: XMLHttpRequest',
    'Connection: keep-alive',
    'Cookie: ' . $cookie,
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-origin',
    'TE: trailers'
  );

  $curl = curl_init();

  if (!$curl) {
    echo 'Unable to initialize curl.';
  }

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

  curl_setopt($curl, CURLOPT_PROXY, $proxy['proxy']);
  curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy['auth']);

  // curl_setopt($curl, CURLOPT_FAILONERROR, false);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_ENCODING, '');
  curl_setopt($curl, CURLOPT_MAXREDIRS, 0);
  // curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


  $response = curl_exec($curl);

  $header  = curl_getinfo($curl);
  // print_r($response);

  $json = json_decode($response, true);

  // print_r($json);

  $data = [
    'user' => $json['user']
  ];

  echo "\n";
  echo "biography: {$json['user']['biography']}\n\n";
  if (isset($json['user']['external_url'])) {
    echo "external_url: {$json['user']['external_url']}\n";
  }
  echo "follower_count: {$json['user']['follower_count']}\n";
  echo "following_count: {$json['user']['following_count']}\n";
  echo "media_count: {$json['user']['media_count']}\n\n";

  if (isset($json['user']['bio_links'][0])) {
    print_r($json['user']['bio_links']);
  }

  curl_close($curl);

  return $data;

}

$account_cookie = '';

$account = get_username('instagram', [
  'proxy' => 'ip:port',
  'auth' => 'logg:pass',
], $account_cookie);

$get_account = get_userinfo($account['user']['pk'], [
  'proxy' => 'ip:port',
  'auth' => 'logg:pass',
], $account_cookie);

print_r($account);
print_r($get_account);


?>
