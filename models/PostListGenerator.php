<?php

namespace app\models;

use app\models\WikipediaAPI;
use yii\base\Model;

/**
 * Class that generates the list of the title belonging to
 * the title of the main category.
 */
class PostListGenerator extends Model {

    /*
     * The title of main category.
     */
    private $category;

    public function __construct($category) {
        $this->category = $category;
    }

    /*
     * Returns the list which contains the post's title list
     */
    public function getPostsList() {

        $wikipedia_api = new WikipediaAPI();
        $wikipedia_api->setPostByCategoryParams($this->category);
        $wikipedia_results = $wikipedia_api->getPostByCategory();

        return $wikipedia_results;
    }

}
