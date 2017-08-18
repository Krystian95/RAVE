<?php

namespace app\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class MainCategory extends Model {

    private $mainCategory = 'Member states of the United Nations';

    public function __construct() {
        
    }

    public function getMainCategory() {

        return $this->mainCategory;
    }

}
