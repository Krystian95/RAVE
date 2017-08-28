<?php

namespace app\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CrossrefAPI extends Model {

    private $baseUrl = 'https://api.crossref.org/works';
    private $query;

    public function __construct($query = null) {
        $this->query = $query;
    }
    
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function getResults() {

        $api = new API($this->baseUrl);
        $normalizeChars = $api->getNormalizeChar();
        $mainQuery = strtr($this->query, $normalizeChars);

        $queryForUrl = urlencode($mainQuery);

        $limit = 10;

        $api_call = '?query=' . $queryForUrl . '&sort=published&order=asc&rows=' . $limit;

        $api_result = $api->getAPIResult($api_call);

        $response = $this->buildResultsResponse($api_result);

        return $response;
    }

    private function buildResultsResponse($api_result) {

        if (isset($api_result['message']['items'])) {

            $response = [];

            $items = $api_result['message']['items'];

            for ($i = 0; $i < count($items); $i++) {

                $response_element = [];

                if (isset($items[$i]['title'][0])) {
                    $response_element['title'] = $this->sanitize($items[$i]['title'][0]);
                }

                if (isset($items[$i]['ISBN'][0])) {
                    $response_element['ISBN'] = $items[$i]['ISBN'][0];
                }

                if (isset($items[$i]['link'][0]['URL'])) {
                    $response_element['link'] = $items[$i]['link'][0]['URL'];

                    if ($this->linkReturn404Error($response_element['link'])) {
                        $response_element['link_corrupted'] = true;
                    }
                }

                if (isset($items[$i]['indexed']['date-time'])) {
                    $time = str_replace('T', ' ', $items[$i]['indexed']['date-time']);
                    $time = str_replace('Z', '', $time);
                    $response_element['date_time'] = $time;
                }

                $response_element['authors'] = [];

                if (isset($items[$i]['author'])) {

                    for ($k = 0; $k < count($items[$i]['author']); $k++) {

                        $author = [];

                        if (isset($items[$i]['author'][$k]['given'])) {
                            $author['name'] = $items[$i]['author'][$k]['given'];
                        }

                        if (isset($items[$i]['author'][$k]['family'])) {
                            $author['family'] = $items[$i]['author'][$k]['family'];
                        }

                        $author['affiliation'] = [];

                        for ($q = 0; $q < count($items[$i]['author'][$k]['affiliation']); $q++) {

                            $affiliation = [
                                'name' => $items[$i]['author'][$k]['affiliation'][$q]['name']
                            ];

                            array_push($author['affiliation'], $affiliation);
                        }

                        array_push($response_element['authors'], $author);
                    }
                }

                array_push($response, $response_element);
            }

            return $response;
        } else {
            return null;
        }
    }

    private function sanitize($string) {
        return preg_replace("/[^ \w]+/", " ", $string);
    }

    private function linkReturn404Error($url) {
        $file_headers = @get_headers($url);
        if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return true;
        } else {
            return false;
        }
    }

}
