<?php
//ini_set('display_errors', 1);

require_once('api/TwitterAPIExchange.php');


$settings = array(
    'oauth_access_token' => "10183232-FlPEnrPyCWuG29OXpZXr6EtHGIbyWyiw6OS4raaaI",
    'oauth_access_token_secret' => "03o4A78tdJXF07XtkO0R8Lp0wPUHGkW8s3XFCixhU",
    'consumer_key' => "Cx5n4rj173JbUMktHTegyA",
    'consumer_secret' => "GTihR4cYVVA4TkiFUoVvJKJ8rm1THJNjSz3camykZQ"
);



if (file_exists('/home/elmercur/www/wp-content/twitter_result.data')) {
    $data = unserialize(file_get_contents('/home/elmercur/www/wp-content/twitter_result.data'));
    if ($data['timestamp'] > time() - 10 * 60) {
        $twitter_result = $data['twitter_result'];
    }
}


if (!$twitter_result) { // cache doesn't exist or is older than 10 mins

    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    $getfield = '?screen_name=mercurioec&exclude_replies=true&include_rts=false';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $valor = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();


    foreach($valor as $v)
    {
        $html_links = preg_replace('"\b(http://\S+)"', '<a href="$1" target="_blank">$1</a>', $v['text']);
        $json[] = array('created_at'=>$v['created_at'],'text'=>$html_links);

    }

    $twitter_result = json_encode($json);

    $data = array ('twitter_result' => $twitter_result, 'timestamp' => time());
    file_put_contents('/home/elmercur/www/wp-content/twitter_result.data', serialize($data));
}


echo $twitter_result;

exit();


