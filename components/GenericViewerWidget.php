<?php

namespace app\components;

use yii\base\Widget;
use app\assets\GenericViewerAsset;
use app\assets\AnnotatorAsset;
use app\assets\AnnotatorGuestAsset;
use Yii;

class GenericViewerWidget extends Widget {

    public $article_title;
    public $article_pageId;
    public $article_revisionId;
    public $article_text;
    public $username_logged_in;
    public $article_new_link;

    public function init() {
        parent::init();

        GenericViewerAsset::register($this->getView());
        AnnotatorAsset::register($this->getView());


        if (Yii::$app->user->isGuest) {
            AnnotatorGuestAsset::register($this->getView());
        }
    }

    public function run() {

        $homeUrl = Yii::$app->getHomeUrl();

        $html = <<<HTML
<div id="article">
    <input type="hidden" id="homeUrl" value="{$homeUrl}" />
    <input type="hidden" id="article_id" value="{$this->article_pageId}" />
    <input type="hidden" id="article_revision_id" value="{$this->article_revisionId}" />
    <input type="hidden" id="username_logged_in" value="{$this->username_logged_in}" />
    <h1 class="title">{$this->article_title}</h1>
HTML;

        if ($this->article_new_link !== null) {
            $html .= <<<HTML
    <p class="alert alert-warning" role="alert">
        <strong>Warning!</strong>
            The version we are showing of this page is not the latest one.
                This is because there are content that has been annotated.
                   To see the most recent available click <a id="new_version_page_link" class="new_version_page_link" href="{$this->article_new_link}" target="_blank">HERE</a>.
    </p><br>
HTML;
        }

        $html .= <<<HTML
    <div class="text">
        {$this->article_text}
    </div>
</div>
HTML;

        return $html;
    }

}
