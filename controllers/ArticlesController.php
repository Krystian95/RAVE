<?php

namespace app\controllers;

use app\models\Article;
use app\models\YouTubeAPI;
use Yii;

class ArticlesController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionYouTube($query) {

        $youtube_api = new YouTubeAPI($query);
        $youtube_result = $youtube_api->getResults();

        return $this->renderAjax('youtube', [
                    'youtube' => $youtube_result
        ]);
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
                        'google_maps' => $article['google_maps'],
                        'twitter' => $article['twitter'],
                        'd3' => $article['d3']
            ]);
        } else if (isset($article['error'])) {

            return $this->render('index', [
                        'article_error' => $article['error']
            ]);
        }
    }

}
