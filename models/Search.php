<?php

namespace app\models;

use Yii;
use app\models\WikipediaAPI;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Search extends Model {

    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function getSearchResults() {

        $wikipedia_api = new WikipediaAPI();
        $wikipedia_api->setSearchParams($this->query);
        $wikipedia_results = $wikipedia_api->getSearchResults();

        return $wikipedia_results;
    }

}
