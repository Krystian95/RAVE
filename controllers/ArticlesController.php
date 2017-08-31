<?php

namespace app\controllers;

use app\models\Article;
use app\models\YouTubeAPI;
use Yii;

/*
 * Controller class for the Wikipedia Articles (Generic and 
 * Specific Visualizer).
 */
class ArticlesController extends \yii\web\Controller {

    /*
     * Renders the index (main) page.
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /*
     * Renders as Ajax the results of the YouTube query.
     */
    public function actionYouTube($query) {

        $youtube_api = new YouTubeAPI($query);
        $youtube_result = $youtube_api->getResults();

        return $this->renderAjax('youtube', [
                    'youtube' => $youtube_result
        ]);
    }

    /*
     * Renders the index with params to print the article.
     */
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
