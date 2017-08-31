<?php

namespace app\components;

use yii\base\Widget;
use app\assets\YouTubeAsset;

/*
 * Widget that draws the YouTube result.
 * It has one public property $twitter (the youtube results).
 */
class YouTubeWidget extends Widget {

    /*
     * The YouTube results (links list).
     */
    public $youtube;

    public function init() {
        parent::init();

        YouTubeAsset::register($this->getView());
    }

    public function run() {

        $html = '';

        if (sizeof($this->youtube) > 0) {

            foreach ($this->youtube as $video_id) {

                $html .= <<<HTML
<div class="embed-responsive embed-responsive-16by9" >
    <iframe class="embed-responsive-item"  src="https://www.youtube.com/embed/{$video_id}" allowfullscreen></iframe>
</div>    
HTML;
            }
        } else {
            $html .= '<h4 class="no-posts">Oops... No <span class="youtube-color">Video</span> was found.</h4>';
        }

        return $html;
    }

}
