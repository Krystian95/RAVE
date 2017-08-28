<?php

namespace app\components;

use yii\base\Widget;
use app\assets\D3Asset;

class D3Widget extends Widget {

    public $d3;

    public function init() {
        parent::init();

        D3Asset::register($this->getView());
    }

    public function run() {

        $html = '<h3 class="title">Number of Results for Wikipedia, Crossref and YouTube</h3>';

        foreach ($this->d3 as $key => $value) {
            $html .= '<input type="hidden" id="d3-' . $key . '" value="' . $value . '" />';
        }

        $html .= '<div id="d3-grafic"></div>';

        return $html;
    }

}
