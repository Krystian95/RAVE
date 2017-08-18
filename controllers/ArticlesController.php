<?php

namespace app\controllers;

use app\models\Article;

class ArticlesController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionArticle($title) {

        $model = new Article($title);
        $article = $model->getArticle();

        if (isset($article['title'])) {

            $article_title = $article['title'];
            $article_pageId = $article['pageId'];
            $article_revisionId = $article['revisionId'];
            $article_text = $article['text'];
            $article_of_main_category = $article['of_main_category'];

            return $this->render('index', [
                        'article_title' => $article_title,
                        'article_pageId' => $article_pageId,
                        'article_revisionId' => $article_revisionId,
                        'article_text' => $article_text,
                        'article_of_main_category' => $article_of_main_category
            ]);
        } else if (isset($article['error'])) {

            return $this->render('index', [
                        'article_error' => $article['error']
            ]);
        }
    }

}
