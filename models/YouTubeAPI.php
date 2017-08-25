<?php

namespace app\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class YouTubeAPI extends Model {

    private $baseUrl = 'https://www.googleapis.com/youtube/v3/search';
    private $key = 'AIzaSyAy9WVj2-ghraoUb-lmkp7HcP6QLBwhEiY';
    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function getResults() {

        $queryForUrl = urlencode($this->query);
        $limit = 12;

        $api_call = '?part=snippet&q=' . $queryForUrl . '&order=relevance&maxResults=' . $limit . '&key=' . $this->key;

        $api = new API($this->baseUrl);
        $api_result = $api->getAPIResult($api_call);

        $response = $this->buildResultsResponse($api_result);

        return $response;
    }

    private function buildResultsResponse($api_result) {

        if (isset($api_result['items'])) {

            $videos = $api_result['items'];

            $response = [];

            foreach ($videos as $video) {
                if (isset($video['id']['videoId'])) {
                    array_push($response, $video['id']['videoId']);
                }
            }

            return $response;
        } else {
            return null;
        }
    }

}
