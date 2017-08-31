<?php

namespace app\models;

use app\models\WikipediaAPI;
use yii\base\Model;

/**
 * Class that return the serch results.
 */
class Search extends Model {

    /*
     * The query searched.
     */
    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    /*
     * Retuns the search results.
     */
    public function getSearchResults() {

        $wikipedia_api = new WikipediaAPI();
        $wikipedia_api->setSearchParams($this->query);
        $wikipedia_results = $wikipedia_api->getSearchResults();

        return $wikipedia_results;
    }

}
