<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Search';
?>
<div class="search">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Pjax::begin([
        'linkSelector' => 'a.button-search',
        'timeout' => 20000,
        'scrollTo' => false
    ]);
    ?>

    <div class="input-group col-lg-4">
        <input type="text" id="query-value-page" class="query-value form-control" placeholder="Search for..." value="" />
        <span class="input-group-btn">
            <a href="<?= Url::home() ?>" id="button-search-page" class="button-search btn btn-default">Search <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
        </span>
    </div>

    <?php
    if (isset($result) && isset($query)) {
        echo '<h3>Results for "' . $query . '"</h3>';
        foreach ($result as $value) {
            echo '<br>' . $value;
        }
    }

    Pjax::end();
    ?>

</div>
