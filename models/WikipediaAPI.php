<?php

namespace app\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class WikipediaAPI extends Model {

    private $type;
    private $query;
    private $api_result;
    private $baseUrl = 'https://en.wikipedia.org/w/api.php';

    public function __construct() {
        
    }

    private function getAPIResult($api_call) {

        $opts = array('http' =>
            array(
                'user_agent' => 'MyBot/1.0 (http://www.mysite.com/)'
            )
        );

        $context = stream_context_create($opts);

        $url = $this->baseUrl . $api_call;

        $json = file_get_contents($url, false, $context);

        $data = json_decode($json, true);

        return $data;
    }

    public function setSearchParams($query) {
        $this->query = $query;
    }

    public function getSearchResults() {

        $pageTitle = $this->query;
        $result_limit = 'max'; /* max=500 */
        $extract_chars_limit = 400; /* 1200 */

        $pageTitleForUrl = urlencode($pageTitle);
        /*
         * https://en.wikipedia.org/wiki/Special:ApiSandbox#action=query&format=json&list=search&titles=Italy&exchars=200&exintro=1&explaintext=1&srsearch=Italy&srlimit=500&srwhat=text&srprop=snippet
         */
        $api_call = '?action=query&format=json&list=search&titles='.$pageTitleForUrl.'&srsearch='.$pageTitleForUrl.'&srnamespace=0&srlimit='.$result_limit.'&sroffset=0&srwhat=text&srprop=snippet';

        $this->api_result = $this->getAPIResult($api_call);

        $response = $this->buildResponse($this->api_result);

        return $response;
    }

    private function buildResponse($api_result) {

        $response = [];


        if (isset($api_result['query']['search'])) {

            $pages = $api_result['query']['search'];

            foreach ($pages as $page) {

                $response_element = [
                    'title' => $page['title'],
                    'url' => 'SOMETHING_TO_ADD_TO_' . $page['title']
                ];

                if (isset($page['snippet'])) {
                    $response_snippet = [
                        'snippet' => $page['snippet']
                    ];
                    $response_element = array_merge($response_element, $response_snippet);
                }

                array_push($response, $response_element);
            }
        }

        return $response;
    }

}
