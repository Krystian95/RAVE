<?php

namespace app\components;

use yii\base\Widget;
use app\assets\GenericViewerAsset;

class GenericViewerWidget extends Widget {

    public $article_title;
    public $article_pageId;
    public $article_revisionId;
    public $article_text;

    public function init() {
        parent::init();

        GenericViewerAsset::register($this->getView());
    }

    public function run() {

        $html = <<<HTML
<div id="article">
    <h1 class="title">{$this->article_title}</h1>
    <div class="text">
        {$this->article_text}
    </div>
</div>
HTML;

        return $html;
    }

}
