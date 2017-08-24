<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class GoogleMapsAPI extends Model {

    private $baseUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
    private $key = 'AIzaSyAy9WVj2-ghraoUb-lmkp7HcP6QLBwhEiY';
    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function getResults() {

        $queryForUrl = urlencode($this->query);

        $api_call = '?address=' . $queryForUrl . '&key=' . $this->key;

        $api = new API($this->baseUrl);
        $api_result = $api->getAPIResult($api_call);

        $response = $this->buildResultsResponse($api_result);

        return $response;
    }

    private function buildResultsResponse($api_result) {

        if (isset($api_result['results'])) {

            $response = [
                'lat' => $api_result['results'][0]['geometry']['location']['lat'],
                'lng' => $api_result['results'][0]['geometry']['location']['lng']
            ];

            return $response;
        } else {
            return null;
        }
    }

    private function sanitize($string) {
        return preg_replace("/[^ \w]+/", " ", $string);
    }

}
