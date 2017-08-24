<?php

namespace app\components;

use yii\base\Widget;
use app\assets\GoogleMapsAsset;

class GoogleMapsWidget extends Widget {

    public $google_maps;
    public $keyword;

    public function init() {
        parent::init();

        GoogleMapsAsset::register($this->getView());
    }

    public function run() {

        $html = '<input type="hidden" id="google_maps_map_lat" value="' . $this->google_maps['lat'] . '" />';
        $html .= '<input type="hidden" id="google_maps_map_lng" value="' . $this->google_maps['lng'] . '" />';

        $html .= <<<HTML
<div class="google-maps-container">
    <div class="">
        <div class="">
            <form id="routes">
                <div id="target" class="place-inputs">
                    <div class="place-input">
                        <input class="form-control" id="from" type="text" placeholder="Type a place to start your journey">
                    </div>
                    <div id="from-to-switcher"></div>
                    <div class="place-input">
                        <input class="form-control" id="to" type="text" placeholder="Type your destination" value="{$this->keyword}">
                    </div>
                    <div class="row place-input selector-wrapper">
                            <select class="form-control" id="travel-mode">
                                <option>Bicycling</option>
                                <option>Walking</option>
                                <option selected>Driving</option>
                            </select>
                            <select class="form-control" id="measurement-mode">
                                <option value="miles">Miles</option>
                                <option value="km" selected>Kilometres</option>
                            </select>
                    </div>
                    <div class="row place-input">
                        <button class="btn btn-primary" type="submit" id="go">Calculate Travel</button>
        <div id="path-result">
            <div class="row travel-info">
                <b>Distance</b>:
                <span id="distance"></span>
            </div>
            <div class="row travel-info">
                <div id="travel-label">
                    <b>Travel Time</b>:
                    <span id="travel-time"></span>
                </div>
            </div>
        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div>
            <div class="" id="map-canvas"></div>
        </div>
        <div class="">
            <div class="chart hide" id="elevation_chart"></div>
            <div class="chart hide" id="slope_chart"></div>
        </div>
    </div>
    <div id="directionsPanel"></div>
</div>
HTML;

        return $html;
    }

}
