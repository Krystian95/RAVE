<?php

namespace app\models;

use Yii;
use app\models\WikipediaAPI;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PostListGenerator extends Model {

    private $category;

    public function __construct($category) {
        $this->category = $category;
    }

    public function getPostsList() {

        $wikipedia_api = new WikipediaAPI();
        $wikipedia_api->setPostByCategoryParams($this->category);
        $wikipedia_results = $wikipedia_api->getPostByCategory();

        return $wikipedia_results;
    }

}
