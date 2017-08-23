<?php

namespace app\controllers;

use app\models\Article;
use Yii;

class ArticlesController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionArticle($title, $newer = null) {

        $model = new Article($title);

        if ($newer) {
            $article = $model->getArticle($newer = true);
        } else {
            $article = $model->getArticle();
        }

        if (isset($article['title'])) {

            $article_title = $article['title'];
            $article_pageId = $article['pageId'];
            $article_revisionId = $article['revisionId'];
            $article_text = $article['text'];
            $article_of_main_category = $article['of_main_category'];
            $article_new_link = $article['newLink'];
            $username_logged_in = Yii::$app->user->identity['username'];

            return $this->render('index', [
                        'article_title' => $article_title,
                        'article_pageId' => $article_pageId,
                        'article_revisionId' => $article_revisionId,
                        'article_text' => $article_text,
                        'article_of_main_category' => $article_of_main_category,
                        'username_logged_in' => $username_logged_in,
                        'article_new_link' => $article_new_link
            ]);
        } else if (isset($article['error'])) {

            return $this->render('index', [
                        'article_error' => $article['error']
            ]);
        }
    }

}
