<?php

namespace app\components;

use yii\base\Widget;
use app\assets\D3Asset;

/*
 * Widget that draws the charts via d3.js.
 * It has one public property $d3 (that will contains the number of results
 * for each API: Wikipedia, Crossref and YouTube).
 * It prints one input hidden for each API and set its value.
 * Then they will be taken by the JS scrippt that will draws the charts.
 */
class D3Widget extends Widget {

    /*
     * The d3 results.
     */
    public $d3;

    public function init() {
        parent::init();

        D3Asset::register($this->getView());
    }

    public function run() {

        $html = '<h3 class="title">Wikipedia, Crossref and YouTube Results Number</h3>';

        foreach ($this->d3 as $key => $value) {
            $html .= '<input type="hidden" id="d3-' . $key . '" value="' . $value . '" />';
        }

        $html .= '<div id="d3-grafic"></div>';

        return $html;
    }

}
