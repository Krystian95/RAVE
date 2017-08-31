<?php

namespace app\models;

use yii\base\Model;
use app\models\API;
use app\models\YouTubeAPI;
use app\models\WikipediaAPI;
use app\models\CrossrefAPI;

/**
 * Class to create the D3 API request.
 */
class D3API extends Model {

    private $query;

    public function __construct($query = null) {
        $this->query = $query;
    }

     /*
     * Return the results.
     */
    public function getResults() {

        $size_result_youtube = $this->getResultsSizeForYouTube();
        $size_result_wikipedia = $this->getResultsSizeForWikipedia();
        $size_result_crossref = $this->getResultsSizeForCrossref();

        $response = [];

        if ($size_result_youtube !== null) {
            $response['youtube'] = $size_result_youtube;
        }

        if ($size_result_wikipedia !== null) {
            $response['wikipedia'] = $size_result_wikipedia;
        }

        if ($size_result_crossref !== null) {
            $response['crossref'] = $size_result_crossref;
        }

        return $response;
    }

    /*
     * Returns the total number of results of Crossref.
     */
    private function getResultsSizeForCrossref() {

        $crossref = new CrossrefAPI();
        $baseUrl = $crossref->getBaseUrl();

        $pageTitle = $this->query;
        $pageTitleForUrl = urlencode($pageTitle);

        $api_call = '?query=' . $pageTitleForUrl . '&sort=published&order=asc&rows=10';

        $api = new API($baseUrl);
        $api_result = $api->getAPIResult($api_call);

        if (isset($api_result['message']['total-results'])) {
            return (int) $api_result['message']['total-results'];
        } else {
            return null;
        }
    }

    /*
     * Returns the total number of results of Wikipedia.
     */
    private function getResultsSizeForWikipedia() {

        $wikipedia = new WikipediaAPI();
        $baseUrl = $wikipedia->getBaseUrl();

        $pageTitle = $this->query;
        $pageTitleForUrl = urlencode($pageTitle);

        $api_call = '?action=query&format=json&list=search&srlimit=1&srsearch=' . $pageTitleForUrl;

        $api = new API($baseUrl);
        $api_result = $api->getAPIResult($api_call);

        if (isset($api_result['query']['searchinfo']['totalhits'])) {
            return (int) $api_result['query']['searchinfo']['totalhits'];
        } else {
            return null;
        }
    }

    /*
     * Returns the total number of results of YouTube.
     */
    private function getResultsSizeForYouTube() {

        $youtube = new YouTubeAPI();
        $baseUrl = $youtube->getBaseUrl();
        $key = $youtube->getKey();

        $queryForUrl = urlencode($this->query);

        $api_call = '?part=snippet&q=' . $queryForUrl . '&order=relevance&maxResults=10&key=' . $key;

        $api = new API($baseUrl);
        $api_result = $api->getAPIResult($api_call);

        if (isset($api_result['pageInfo']['totalResults'])) {
            return (int) $api_result['pageInfo']['totalResults'];
        } else {
            return null;
        }
    }

}
