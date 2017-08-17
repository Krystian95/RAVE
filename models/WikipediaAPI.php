<?php

namespace app\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class WikipediaAPI extends Model {

    private $baseUrl = 'https://en.wikipedia.org/w/api.php';
    private $query;
    private $category;

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

        $pageTitleForUrl = urlencode($pageTitle);
        /*
         * https://en.wikipedia.org/wiki/Special:ApiSandbox#action=query&format=json&list=search&titles=Italy&exchars=200&exintro=1&explaintext=1&srsearch=Italy&srlimit=500&srwhat=text&srprop=snippet
         */
        $api_call = '?action=query&format=json&list=search&titles=' . $pageTitleForUrl . '&srsearch=' . $pageTitleForUrl . '&srnamespace=0&srlimit=' . $result_limit . '&sroffset=0&srwhat=text&srprop=snippet';

        $api_result = $this->getAPIResult($api_call);

        $response = $this->buildSearchResultsResponse($api_result);

        return $response;
    }

    private function buildSearchResultsResponse($api_result) {

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

    public function setPostByCategoryParams($category) {
        $this->category = $category;
    }

    public function getPostByCategory() {

        $pageTitle = $this->category;
        $result_limit = 'max'; /* max=500 */

        $pageTitleForUrl = urlencode($pageTitle);
        /*
         * Ordine di aggiunta alla categoria (dalla più recente alla meno recente)
         * https://en.wikipedia.org/wiki/Special:ApiSandbox#action=query&format=json&list=categorymembers&cmtitle=Category%3AMember_states_of_the_United_Nations&cmlimit=500&cmsort=timestamp&cmdir=desc&cmnamespace=0
         */
        $api_call = '?action=query&format=json&list=categorymembers&cmtitle=Category:' . $pageTitleForUrl . '&cmlimit=' . $result_limit . '&cmsort=timestamp&cmdir=newer&cmnamespace=0';

        $api_result = $this->getAPIResult($api_call);

        $response = $this->buildPostByCategoryResponse($api_result);

        return $response;
    }

    private function buildPostByCategoryResponse($api_result) {

        $response = [];

        if (isset($api_result['query']['categorymembers'])) {

            $posts = $api_result['query']['categorymembers'];

            $count = 0;

            foreach ($posts as $post) {

                if ($count < 12) {
                    $newer = true;
                } else {
                    $newer = false;
                }

                $response_element = [
                    'id' => $post['pageid'],
                    'title' => $post['title'],
                    'url' => 'SOMETHING_TO_ADD_TO_' . $post['title'],
                    'newer' => $newer
                ];

                array_push($response, $response_element);

                $count++;
            }
        }

        return $response;
    }

}
