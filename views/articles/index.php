<?php
/* @var $this yii\web\View */
use app\components\GenericViewerWidget;

$this->title = 'RAVE';

if (isset($article_text) || isset($article_error)) {

    if (isset($article_text)) {

        if ($article_of_main_category) {

            /*
             * replace with SpecificViewer
             */

            echo GenericViewerWidget::widget([
                'article_title' => $article_title,
                'article_pageId' => $article_pageId,
                'article_revisionId' => $article_revisionId,
                'article_text' => $article_text,
                'username_logged_in' => $username_logged_in
            ]);
        } else {

            echo GenericViewerWidget::widget([
                'article_title' => $article_title,
                'article_pageId' => $article_pageId,
                'article_revisionId' => $article_revisionId,
                'article_text' => $article_text,
                'username_logged_in' => $username_logged_in,
                'article_new_link' => $article_new_link
            ]);
            ?>
            <!--<span class="annotator-hl annotator-hl-errata" id="1503311089340" style="border-color: rgb(0, 0, 0); border-width: 0px; border-style: solid;">crushed </span>-->
            <?php
        }
    } else if (isset($article_error)) {

        echo $article_error;
    }
}