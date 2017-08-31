<?php

namespace app\models;

use app\models\WikipediaAPI;
use app\models\GoogleMapsAPI;
use app\models\CrossrefAPI;
use app\models\TwitterAPI;
use app\models\D3API;
use yii\base\Model;
use app\models\MainCategory;

/**
 * Class that create the Wikipedia article and the apis' results.
 */
class Article extends Model {

    /*
     * The title of the article.
     */
    private $title;

    public function __construct($title) {
        $this->title = $title;
    }

    /*
     * Return the article and the apis' results
     * (if the article is of the main category).
     */
    public function getArticle($newer = null) {

        $main_category = new MainCategory();
        $main_category_name = $main_category->getMainCategory();

        $wikipedia_api = new WikipediaAPI();
        $wikipedia_api->setArticleParams($this->title, $main_category_name);

        if ($newer) {
            $article = $wikipedia_api->getArticle();
        } else {
            $article = $wikipedia_api->getArticle($newer = true);
        }

        if ($article['of_main_category']) {

            $crossref_api = new CrossrefAPI($this->title);
            $cossref_results = $crossref_api->getResults();
            $article['crossref'] = $cossref_results;

            $google_maps_api = new GoogleMapsAPI($this->title);
            $google_maps_result = $google_maps_api->getResults();
            $article['google_maps'] = $google_maps_result;

            $twitter_api = new TwitterAPI($this->title);
            $twitter_result = $twitter_api->getResults();
            $article['twitter'] = $twitter_result;

            $d3_api = new D3API($this->title);
            $d3_result = $d3_api->getResults();
            $article['d3'] = $d3_result;
        } else {
            $article['crossref'] = null;
            $article['google_maps'] = null;
            $article['twitter'] = null;
            $article['d3'] = null;
        }

        return $article;
    }

}
