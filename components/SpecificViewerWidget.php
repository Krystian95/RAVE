<?php

namespace app\components;

use yii\base\Widget;
use app\assets\SpecificViewerAsset;
use app\assets\AnnotatorAsset;
use app\assets\AnnotatorGuestAsset;
use app\components\GoogleMapsWidget;
use app\components\TwitterWidget;
use app\assets\YouTubeSpecificViewerAsset;
use app\components\D3Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

/*
 * Widget that draws the Wikipedia article
 * (of main category).
 */
class SpecificViewerWidget extends Widget {

    /*
     * Article title.
     */
    public $article_title;
    /*
     * Article page id.
     */
    public $article_pageId;
    /*
     * Article revision id.
     */
    public $article_revisionId;
    /*
     * Article text.
     */
    public $article_text;
    /*
     * The username of the user logged in (null if not exist).
     */
    public $username_logged_in;
    /*
     * The link to the article's latest version (null if not exist).
     */
    public $article_new_link;
    /*
     * Crossref results.
     */
    public $crossref;
    /*
     * Google Maps results.
     */
    public $google_maps;
    /*
     * Twitter results.
     */
    public $twitter;
    /*
     * D3 results.
     */
    public $d3;

    public function init() {
        parent::init();

        SpecificViewerAsset::register($this->getView());
        AnnotatorAsset::register($this->getView());

        /*
         * Apply the restrictions to the annotation capabilities if user is a guest.
         */
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
        $html .= include Yii::getAlias('@GuestAdvice');

        /*
         * Display the alert if the article printed is not the latest.
         */
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
    <li class="active Wikipedia"><a data-toggle="tab" href="#Wikipedia"><div class="img"></div> Wikipedia</a></li>
    <li class="Crossref"><a data-toggle="tab" href="#Crossref"><div class="img"></div> Crossref</a></li>
    <li class="YouTube">
HTML;
        $html .= Html::a(' YouTube', Url::toRoute([
                            'you-tube',
                            'query' => $this->article_title
                        ]), [
                    'id' => 'YouTubeLink',
                    'class' => 'tab_opener',
                    'data-destination' => '#YouTube'
        ]);

        $html .= <<<HTML
    </li>
    <li class="Twitter"><a data-toggle="tab" href="#Twitter"><div class="img"></div> Twitter</a></li>
    <li class="GoogleMaps"><a data-toggle="tab" href="#GoogleMaps"><div class="img"></div> Google Maps</a></li>
    <li class="D3"><a data-toggle="tab" href="#D3"><div class="img"></div> Chart</a></li>
</ul>
HTML;
        YouTubeSpecificViewerAsset::register($this->getView());

        $html .= <<<HTML
<div class="tab-content">
<div id="Wikipedia" class="tab-pane fade in active">
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
        <div id="Twitter" class="tab-pane fade">
HTML;
        $html .= TwitterWidget::widget([
                    'twitter' => $this->twitter
        ]);

        $html .= <<<HTML
        </div>
        <div id="YouTube" class="tab-pane fade"></div>
        <div id="GoogleMaps" class="tab-pane fade" >
HTML;
        $html .= GoogleMapsWidget::widget([
                    'google_maps' => $this->google_maps
        ]);

        $html .= <<<HTML
   </div>
    <div id="D3" class="tab-pane fade" >
HTML;
        $html .= D3Widget::widget([
                    'd3' => $this->d3
        ]);

        $html .= <<<HTML
    </div>
</div>
HTML;

        return $html;
    }

}
