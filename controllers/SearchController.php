<?php

namespace app\controllers;

use app\models\Search;
use Yii;

/*
 * Controller class for the Wikipedia post search.
 */
class SearchController extends \yii\web\Controller {

    /*
     * Renders the main page for the search.
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /*
     * Renders the page with the results of the search.
     */
    public function actionSearch() {

        $query = Yii::$app->request->get('query');

        if (isset($query)) {
            if ($query !== null && $query !== '' && $query !== 'undefined') {

                $searcher = new Search($query);
                $results = $searcher->getSearchResults();

                return $this->render('index', [
                            'query' => $query,
                            'results' => $results
                ]);
            } else {
                return $this->render('index');
            }
        } else {
            return $this->render('index');
        }
    }

}
