<?php

/* @var $this yii\web\View */
use app\components\GenericViewerWidget;
use app\components\SpecificViewerWidget;
use yii\widgets\Pjax;

$this->title = 'RAVE';

if (isset($article_text) || isset($article_error)) {

    if (isset($article_text)) {

        if ($article_of_main_category) {

            Pjax::begin([
                'linkSelector' => '#YouTubeLink',
                'timeout' => 50000,
                'scrollTo' => false,
                'clientOptions' => ['container' => '#YouTube']
            ]);

            echo SpecificViewerWidget::widget([
                'article_title' => $article_title,
                'article_pageId' => $article_pageId,
                'article_revisionId' => $article_revisionId,
                'article_text' => $article_text,
                'username_logged_in' => $username_logged_in,
                'crossref' => $crossref,
                'google_maps' => $google_maps,
                'twitter' => $twitter
            ]);

            Pjax::end();
        } else {

            echo GenericViewerWidget::widget([
                'article_title' => $article_title,
                'article_pageId' => $article_pageId,
                'article_revisionId' => $article_revisionId,
                'article_text' => $article_text,
                'username_logged_in' => $username_logged_in,
                'article_new_link' => $article_new_link
            ]);
        }
    } else if (isset($article_error)) {

        echo $article_error;
    }
}