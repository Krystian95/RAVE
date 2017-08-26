<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class TwitterAPI extends Model {

    private $baseUrl = 'https://api.twitter.com/1.1/search/tweets.json';
    private $keys = array(
        'oauth_access_token' => "255642319-mycVb3G8IyLop7W8RukFbPGI4XBwYRZC4FcA5kRv",
        'oauth_access_token_secret' => "TIjSry1h1amGt2ARbQFcPxcCLjVWQfxOpXM4OcNwxS2X6",
        'consumer_key' => "n7JTMJj7QFqqXdjIpnfrlTRxP",
        'consumer_secret' => "SMr6fy225NblbmttKDFWzLKFbqFwL0eKlNyC3GpYdW5Afv1cu6"
    );
    private $requestMethod = 'GET';
    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function getResults() {

        require_once Yii::getAlias('@TwitterAPIExchange');

        $queryForUrl = urlencode($this->query);
        $limit = 10;

        /* Richiede i 10 tweet più recenti cercando la parola "news" */
        $api_call = '?q=%23' . $queryForUrl . '&result_type=recent&count=' . $limit . '&lang=en&tweet_mode=extended&exclude=retweets';

        $twitter = new TwitterAPIExchange($this->keys);

        $json = $twitter->setGetfield($api_call)
                ->buildOauth($this->baseUrl, $this->requestMethod)
                ->performRequest();

        $api_result = json_decode($json, true);

        $response = $this->buildResultsResponse($api_result);

        return $response;
    }

    private function buildResultsResponse($api_result) {

        if (isset($api_result['statuses'])) {

            $tweets = $api_result['statuses'];

            $response = [];

            foreach ($tweets as $tweet) {

                $tweet_obj = [];

                if (isset($tweet['id_str']) && isset($tweet['user']['screen_name'])) {
                    $tweet_obj['user'] = $tweet['user']['screen_name'];
                    $link = 'https://twitter.com/' . $tweet['user']['screen_name'] . '/status/' . $tweet['id_str'];
                    $tweet_obj['link'] = $link;
                }

                if (isset($tweet['created_at'])) {
                    $tweet_obj['date_time'] = $tweet['created_at'];
                }

                if (isset($tweet['user']['name'])) {
                    $tweet_obj['user_name'] = $tweet['user']['name'];
                }

                if (isset($tweet['user']['screen_name'])) {
                    $tweet_obj['user_screen_name'] = $tweet['user']['screen_name'];
                }

                if (isset($tweet['user']['location'])) {
                    if ($tweet['user']['location'] !== '') {
                        $tweet_obj['user_country'] = $tweet['user']['location'];
                    }
                }

                if (isset($tweet['full_text'])) {
                    $tweet_obj['text'] = $tweet['full_text'];
                }

                array_push($response, $tweet_obj);
            }

            return $response;
        } else {
            return null;
        }
    }

}
