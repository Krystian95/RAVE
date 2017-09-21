<?php

namespace app\components;

use yii\base\Widget;
use app\assets\ChartsAsset;

/*
 * Widget that draw the 2 charts on the "Charts" page:
 * - Number of member states of the United Nations over time
 * - Population growth of United Nations member states in the 1960s and 2016s
 */
class ChartsWidget extends Widget {

    public function init() {
        parent::init();

        ChartsAsset::register($this->getView());
    }

    public function run() {

        $html = '<div id="D3">';

        $html .= '<h3 class="titlepage">Number of member states of the United Nations over time</h3>';

        $html .= '<div id="d3-grafic-members"></div>';

        $html .= '<h3 class="titlepage">Population growth of United Nations member states in 1960 and 2016</h3>';

        $html .= '<div id="d3-grafic-population"></div>';

        $html .= '</div>';

        return $html;
    }

}
