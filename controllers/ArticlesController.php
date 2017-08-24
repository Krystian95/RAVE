<?php

namespace app\controllers;

use app\models\Article;
use Yii;

class ArticlesController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionArticle($title, $newer = null) {

        $article = new Article($title);

        if ($newer) {
            $article = $article->getArticle($newer = true);
        } else {
            $article = $article->getArticle();
        }

        if (isset($article['title'])) {

            return $this->render('index', [
                        'article_title' => $article['title'],
                        'article_pageId' => $article['pageId'],
                        'article_revisionId' => $article['revisionId'],
                        'article_text' => $article['text'],
                        'article_of_main_category' => $article['of_main_category'],
                        'username_logged_in' => Yii::$app->user->identity['username'],
                        'article_new_link' => $article['newLink'],
                        'crossref' => $article['crossref'],
                        'google_maps' => $article['google_maps']
            ]);
        } else if (isset($article['error'])) {

            return $this->render('index', [
                        'article_error' => $article['error']
            ]);
        }
    }

}
