<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\db\Query;
use app\models\API;

/**
 * ContactForm is the model behind the contact form.
 */
class WikipediaAPI extends Model {

    private $baseUrl = 'https://en.wikipedia.org/w/api.php';
    private $query;
    private $category;
    private $title;

    public function __construct() {
        
    }

    private function starts_with_upper($str) {
        $chr = mb_substr($str, 0, 1, "UTF-8");
        return mb_strtolower($chr, "UTF-8") != $chr;
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

        $api = new API($this->baseUrl);
        $api_result = $api->getAPIResult($api_call);

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
                    'url' => Yii::$app->getHomeUrl() . 'articles/article?title=' . $page['title']
                ];

                if (isset($page['snippet'])) {

                    $points = '';

                    if (!$this->starts_with_upper(trim($page['snippet']))) {
                        $points = '...';
                    }

                    $snippet = $points . trim($page['snippet']) . '...';

                    $response_snippet = [
                        'snippet' => $snippet
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

        $categoryName = $this->category;
        $result_limit = 'max'; /* max=500 */

        $categoryNameForUrl = urlencode($categoryName);
        /*
         * Ordine di aggiunta alla categoria (dalla più recente alla meno recente)
         * https://en.wikipedia.org/wiki/Special:ApiSandbox#action=query&format=json&list=categorymembers&cmtitle=Category%3AMember_states_of_the_United_Nations&cmlimit=500&cmsort=timestamp&cmdir=desc&cmnamespace=0
         */
        $api_call = '?action=query&format=json&list=categorymembers&cmtitle=Category:' . $categoryNameForUrl . '&cmlimit=' . $result_limit . '&cmsort=timestamp&cmdir=newer&cmnamespace=0';

        $api = new API($this->baseUrl);
        $api_result = $api->getAPIResult($api_call);

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
                    $newer = 'Last<br>Updated';
                } else {
                    $newer = false;
                }

                $response_element = [
                    'id' => $post['pageid'],
                    'title' => $post['title'],
                    'url' => Yii::$app->getHomeUrl() . 'articles/article?title=' . $post['title'],
                    'newer' => $newer
                ];

                array_push($response, $response_element);

                $count++;
            }
        }

        for ($i = 0; $i < count($response); $i++) {
            if ($response[$i]['title'] === $this->category) {
                unset($response[$i]);
            }
        }

        return $response;
    }

    public function setArticleParams($title, $category) {
        $this->title = $title;
        $this->category = $category;
    }

    private function getPostTitlesByCategory($category) {

        $categoryName = $category;
        $result_limit = 'max'; /* max=500 */

        $categoryNameForUrl = urlencode($categoryName);
        /*
         * Ordine di aggiunta alla categoria (dalla più recente alla meno recente)
         * https://en.wikipedia.org/wiki/Special:ApiSandbox#action=query&format=json&list=categorymembers&cmtitle=Category%3AMember_states_of_the_United_Nations&cmlimit=500&cmsort=timestamp&cmdir=desc&cmnamespace=0
         */
        $api_call = '?action=query&format=json&list=categorymembers&cmtitle=Category:' . $categoryNameForUrl . '&cmlimit=' . $result_limit . '&cmsort=timestamp&cmdir=newer&cmnamespace=0';

        $api = new API($this->baseUrl);
        $api_result = $api->getAPIResult($api_call);

        $items = $api_result['query']['categorymembers'];

        $articles_titles = array_column($items, 'title');

        for ($i = 0; $i < count($articles_titles); $i++) {
            if ($articles_titles[$i] === $categoryName) {
                unset($articles_titles[$i]);
            }
        }

        return $articles_titles;
    }

    public function getArticle($newer = null) {

        $pageTitle = $this->title;

        $pageTitleForUrl = urlencode($pageTitle);
        /*
         * https://en.wikipedia.org/wiki/Special:ApiSandbox#action=parse&format=json&page=Silvio+Berlusconi&prop=text%7Crevid&mobileformat=1&noimages=1
         */
        $api_call = '?action=parse&format=json&page=' . $pageTitleForUrl . '&prop=text%7Crevid&mobileformat=1&noimages=1';

        $api = new API($this->baseUrl);
        $api_result = $api->getAPIResult($api_call);

        $response = $this->buildArticleResponse($api_result);

        if ($newer !== true) {
            if (isset($response['revisionId'])) {
                if (($this->getRevisionIdIfAnnotated($response['pageId']) != $response['revisionId'] && $this->getRevisionIdIfAnnotated($response['pageId']) != null)) {
                    $old_atricle = $this->getOldArticle($response['revisionId']);
                    $old_atricle['newLink'] = Yii::$app->getHomeUrl() . 'articles/article?title=' . $pageTitle . '&revision=newer';
                    return $old_atricle;
                } else {
                    $response['newLink'] = null;
                }
            }
        } else {
            $response['newLink'] = null;
        }

        return $response;
    }

    public function getOldArticle($revision_id) {

        /*
         * https://en.wikipedia.org/wiki/Special:ApiSandbox#action=parse&format=json&oldid=636165877&prop=text%7Crevid&mobileformat=1&noimages=1
         */
        $api_call = '?action=parse&format=json&oldid=' . $revision_id . '&prop=text%7Crevid&mobileformat=1&noimages=1';

        $api = new API($this->baseUrl);
        $api_result = $api->getAPIResult($api_call);

        $response = $this->buildArticleResponse($api_result);

        return $response;
    }

    private function getRevisionIdIfAnnotated($pageId) {

        $query = new Query;
        $annotations = $query
                ->select('article_revision_id')
                ->from([
                    'annotation'
                ])
                ->where([
                    'page_id' => $pageId,
                ])
                ->all();

        $article_revision_ids = array_column($annotations, 'article_revision_id');

        if (sizeof($article_revision_ids) > 0) {
            return $article_revision_ids[0];
        } else {
            return null;
        }
    }

    private function buildArticleResponse($api_result) {

        if (isset($api_result['parse'])) {

            $main_category = new MainCategory();
            $main_category_name = $main_category->getMainCategory();
            $main_category_articles = $this->getPostTitlesByCategory($main_category_name);

            if (in_array($api_result['parse']['title'], $main_category_articles)) {
                $article_in_main_category = true;
            } else {
                $article_in_main_category = false;
            }

            $response = [
                'title' => $api_result['parse']['title'],
                'pageId' => $api_result['parse']['pageid'],
                'revisionId' => $api_result['parse']['revid'],
                'text' => $api_result['parse']['text']['*'],
                'of_main_category' => $article_in_main_category
            ];

            return $response;
        } else {

            $response = [
                'error' => $api_result['error']['info']
            ];

            return $response;
        }
    }

}
