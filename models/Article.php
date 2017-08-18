<?php

namespace app\models;

use app\models\WikipediaAPI;
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

    public function getArticle() {
        
        $main_category = new MainCategory();
        $main_category_name = $main_category->getMainCategory();

        $wikipedia_api = new WikipediaAPI();
        $wikipedia_api->setArticleParams($this->title, $main_category_name);
        $wikipedia_article = $wikipedia_api->getArticle();

        return $wikipedia_article;
    }

}
