<?php
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\components\SearchResultWidget;

/* @var $this yii\web\View */
$this->title = 'RAVE - Search';
?>
<div class="search">
    <h1>Search</h1>

    <?php
    Pjax::begin([
        'linkSelector' => 'a.button-search',
        'timeout' => 20000,
        'scrollTo' => false
    ]);
    ?>

    <div class="input-group col-lg-4">
        <input type="text" id="query-value-page" class="query-value form-control" placeholder="Search for..." value="<?php echo (isset($query) ? $query : ''); ?>" />
        <span class="input-group-btn">
            <a href="<?= Url::home() ?>" id="button-search-page" class="button-search btn btn-default">Search <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
        </span>
    </div>

    <?php
    if (isset($results)) {
        echo SearchResultWidget::widget([
            'query' => $query,
            'results' => $results
        ]);
    }

    Pjax::end();
    ?>

</div>
