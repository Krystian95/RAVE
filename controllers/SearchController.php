<?php

namespace app\controllers;

use app\models\Search;
use Yii;

class SearchController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionSearch() {

        $query = Yii::$app->request->get('query');

        if (isset($query)) {
            if ($query !== null && $query !== '' && $query !== 'undefined') {

                $model = new Search($query);
                $result = $model->getResult();

                return $this->render('index', [
                            'query' => $query,
                            'result' => $result
                ]);
            } else {
                return $this->render('index');
            }
        } else {
            return $this->render('index');
        }
    }

}
