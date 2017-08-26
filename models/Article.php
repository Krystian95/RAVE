<?php

namespace app\models;

use app\models\WikipediaAPI;
use app\models\GoogleMapsAPI;
use app\models\CrossrefAPI;
use app\models\TwitterAPI;
use yii\base\Model;
use app\models\MainCategory;

/**
 * ContactForm is the model behind the contact form.
 */
class Article extends Model {

    private $title;

    public function __construct($title) {
        $this->title = $title;
    }

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
        } else {
            $article['crossref'] = null;
            $article['google_maps'] = null;
            $article['twitter'] = null;
        }

        return $article;
    }

}
