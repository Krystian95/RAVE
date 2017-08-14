<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Search extends Model {

    private $query;

    public function __construct($query) {
        $this->query = $query;
    }

    public function getQuery() {
        return $this->query;
    }
    
    public function getResult(){
        $result = [
            'aaaa',
            'bbbb',
            'cccc',
            'dddd'
        ];
        
        return $result;
    }

}
