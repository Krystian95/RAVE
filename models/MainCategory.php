<?php

namespace app\models;

use yii\base\Model;

/**
 * Class that defines the title of the main category.
 */
class MainCategory extends Model {

    /*
     * Title of the main category.
     */
    private $mainCategory = 'Member states of the United Nations';

    public function __construct() {
        
    }

    /*
     * Return the title of the main category.
     */
    public function getMainCategory() {

        return $this->mainCategory;
    }

}
