<?php

namespace app\components;

use yii\base\Widget;
use app\assets\TwitterAsset;

class TwitterWidget extends Widget {

    public $twitter;

    public function init() {
        parent::init();

        TwitterAsset::register($this->getView());
    }

    public function run() {

        $html = '';

        $twitter = $this->twitter;

        $html .= '<div class="twitter-results">';

        foreach ($twitter as $result) {

            $html .= '<div class="result">';

            if (isset($result['text'])) {
                $html .= '<span class="text">' . $result['text'] . '</span>';
            }

            if (isset($result['user_name'])) {
                $html .= '<br><span class="user-label"></span><span class="user">' . $result['user_name'] . '</span>';
            }

            if (isset($result['user_screen_name'])) {
                $html .= ' @ <span class="user_screen_name-label"></span><span class="user_screen_name">' . $result['user_screen_name'] . '</span>';
            }

            if (isset($result['user_country'])) {
                $html .= ' (<span class="user_country-label"></span><span class="user_country">' . $result['user_country'] . '</span>)';
            }

            if (isset($result['date_time'])) {
                $html .= '<br><span class="date_time-label"></span><span class="date_time">' . $result['date_time'] . '</span>';
            }

            if (isset($result['link'])) {
                $html .= '<a href="' . $result['link'] . '" target="_blank"><img class="right_arrow"/></a>';
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

}
