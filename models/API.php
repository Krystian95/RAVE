<?php

namespace app\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class API extends Model {

    private $baseUrl;

    public function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function getAPIResult($api_call) {

        $opts = array('http' =>
            array(
                'user_agent' => 'MyBot/1.0 (http://www.mysite.com/)'
            )
        );

        $context = stream_context_create($opts);

        $url = $this->baseUrl . $api_call;

        $json = file_get_contents($url, false, $context);

        $data = json_decode($json, true);

        return $data;
    }

}
