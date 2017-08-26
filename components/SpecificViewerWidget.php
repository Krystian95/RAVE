<?php

namespace app\components;

use yii\base\Widget;
use app\assets\SpecificViewerAsset;
use app\assets\AnnotatorAsset;
use app\assets\AnnotatorGuestAsset;
use app\components\GoogleMapsWidget;
use app\components\TwitterWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class SpecificViewerWidget extends Widget {

    public $article_title;
    public $article_pageId;
    public $article_revisionId;
    public $article_text;
    public $username_logged_in;
    public $article_new_link;
    public $crossref;
    public $google_maps;
    public $twitter;

    public function init() {
        parent::init();

        SpecificViewerAsset::register($this->getView());
        AnnotatorAsset::register($this->getView());

        if (Yii::$app->user->isGuest) {
            AnnotatorGuestAsset::register($this->getView());
        }
    }

    public function run() {

        $homeUrl = Yii::$app->getHomeUrl();

        $html = <<<HTML
    <input type="hidden" id="homeUrl" value="{$homeUrl}" />
    <input type="hidden" id="article_id" value="{$this->article_pageId}" />
    <input type="hidden" id="article_revision_id" value="{$this->article_revisionId}" />
    <input type="hidden" id="username_logged_in" value="{$this->username_logged_in}" />
    <h1 class="main-title">{$this->article_title}</h1>
HTML;
        //if (Yii::$app->user->isGuest) {
            $html .= include Yii::getAlias('@GuestAdvice');
        //}

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
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#Article">Article</a></li>
    <li><a data-toggle="tab" href="#Crossref">Crossref</a></li>
    <li><a data-toggle="tab" href="#GoogleMaps">Google Maps</a></li>
    <li><a data-toggle="tab" href="#Twitter">Twitter</a></li>
    <li>
HTML;
        $html .= Html::a('YouTube', Url::toRoute([
                            'you-tube',
                            'query' => $this->article_title
                        ]), [
                    'id' => 'YouTubeLink',
                    'class' => 'tab_opener',
                    'data-destination' => '#YouTube'
        ]);

        $html .= <<<HTML
    </li>
</ul>
                
<div class="tab-content">
    <div id="Article" class="tab-pane fade in active">
        <div id="article">
            <div class="text">
                {$this->article_text}
            </div>
        </div>
    </div>
    <div id="Crossref" class="tab-pane fade">
HTML;
        $html .= CrossrefWidget::widget([
                    'crossref' => $this->crossref
        ]);

        $html .= <<<HTML
        </div>
        <div id = "Twitter" class = "tab-pane fade">
HTML;
        $html .= TwitterWidget::widget([
                    'twitter' => $this->twitter
        ]);

        $html .= <<<HTML
        </div>
        <div id = "YouTube" class = "tab-pane fade"></div>
        <div id = "GoogleMaps" class = "tab-pane fade" >
HTML;
        $html .= GoogleMapsWidget::widget([
                    'google_maps' => $this->google_maps
        ]);

        $html .= <<<HTML
   </div>
</div>
HTML;

        return $html;
    }

}
