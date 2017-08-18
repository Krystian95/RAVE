<?php

/* @var $this yii\web\View */
use app\components\GenericViewerWidget;

if (isset($article_text) || isset($article_error)) {

    if (isset($article_text)) {

        if ($article_of_main_category) {
            
            echo GenericViewerWidget::widget([
                'article_title' => $article_title,
                'article_pageId' => $article_pageId,
                'article_revisionId' => $article_revisionId,
                'article_text' => $article_text
            ]);
            
        } else {
            
            /*
             * replace with SpecificViewer
             */
            
            echo GenericViewerWidget::widget([
                'article_title' => $article_title,
                'article_pageId' => $article_pageId,
                'article_revisionId' => $article_revisionId,
                'article_text' => $article_text
            ]);
            
        }
    } else if (isset($article_error)) {

        echo $article_error;
    }
}