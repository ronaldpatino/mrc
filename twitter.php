<?php
//ini_set('display_errors', 1);

require_once('api/TwitterAPIExchange.php');
require_once(__DIR__.'../../../../wp-load.php');


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
    $getfield = '?screen_name=mercurioec&exclude_replies=true&include_rts=false&count=10';
    $template_url = get_bloginfo('template_url').'/twimg.php';

    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $valor = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

    foreach($valor as $v)
    {
        $fecha = date( 'H:i', strtotime($v['created_at']));
        $href = isset($v['entities']['urls'][0]['url'])?$v['entities']['urls'][0]['url']:'#';
        $title = isset($v['entities']['urls'][0]['expanded_url'])?$v['entities']['urls'][0]['expanded_url']:'El Mercurio  Cuenca - Noticias Ecuador Azuay';
        $target = isset($v['entities']['urls'][0]['expanded_url'])?'target="_blank"':'';
        $media = isset($v['entities']['media'][0]['media_url_https'])?'data-trigger="hover" data-placement="top" rel="popover"':'';
        $html_links = '<a id="t_'. $v['id_str'] .'" '. $media .  'href="'.$href . '" ' . $target .'><strong>' . $fecha . '</strong> - ' . $v['text'] .  '</a>';
        $json[] = array('created_at'=>$v['created_at'],'text'=>$html_links);
    }


    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    $getfield = '?screen_name=cronicamercurio&exclude_replies=true&include_rts=false&count=20';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $valor = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

    foreach($valor as $v)
    {
        $fecha = date( 'H:i', strtotime($v['created_at']));
        $href = isset($v['entities']['urls'][0]['url'])?$v['entities']['urls'][0]['url']:'#';
        $title = isset($v['entities']['urls'][0]['expanded_url'])?$v['entities']['urls'][0]['expanded_url']:'El Mercurio  Cuenca - Noticias Ecuador Azuay';
        $target = isset($v['entities']['urls'][0]['expanded_url'])?'target="_blank"':'';
        $media = isset($v['entities']['media'][0]['media_url_https'])?'data-trigger="hover" data-placement="top" rel="popover"':'';

        $html_links = '<a data-poload="' . $template_url . '" id="t_'. $v['id_str'] .'" '. $media .  'href="'.$href . '" ' . $target .'><strong>' . $fecha . '</strong> - ' . $v['text'] .  '</a>';
        $json[] = array('created_at'=>$v['created_at'],'text'=>$html_links);
    }

    $twitter_result = json_encode($json);

    $data = array ('twitter_result' => $twitter_result, 'timestamp' => time());
    file_put_contents('/home/elmercur/www/wp-content/twitter_result.data', serialize($data));
}

echo $twitter_result;

exit();


