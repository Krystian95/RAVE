<?php

namespace app\models;

use yii\base\Model;

/**
 * Class to create the Google Maps API request.
 */
class GoogleMapsAPI extends Model {

    private $baseUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
    private $key = 'AIzaSyAy9WVj2-ghraoUb-lmkp7HcP6QLBwhEiY';
    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    /*
     * Returns the results.
     */
    public function getResults() {
        
        $api = new API($this->baseUrl);
        $normalizeChars = $api->getNormalizeChar();
        $mainQuery = strtr($this->query, $normalizeChars);

        $queryForUrl = urlencode($mainQuery);

        $api_call = '?address=' . $queryForUrl . '&key=' . $this->key;

        $api_result = $api->getAPIResult($api_call);

        $response = $this->buildResultsResponse($api_result);
        $response['keyword'] = $this->query;

        return $response;
    }

    /*
     * Rebuilds results by making them usable.
     */
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

}
