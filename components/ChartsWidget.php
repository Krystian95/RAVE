<?php

namespace app\components;

use yii\base\Widget;
use app\assets\D3Asset;

class ChartsWidget extends Widget {

    public function init() {
        parent::init();

        D3Asset::register($this->getView());
    }

    public function run() {

        $html = '<div id="D3">';

        $html .= '<h3 class="title">Number of member states of the United Nations over time</h3>';

        $html .= '<div id="d3-grafic-members"></div>';

        $html .= '<h3 class="title">Population growth of United Nations member states in the 1960s and 2016s</h3>';

        $html .= '<div id="d3-grafic-population"></div>';

        $html .= '</div>';

        return $html;
    }

}
