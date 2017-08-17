<?php
/* @var $this yii\web\View */

$this->title = 'RAVE';
use app\components\PostListWidget;
?>
<div class="site-index">

    <?php
    if (isset($posts) && isset($category)) {
        echo PostListWidget::widget([
            'category' => $category,
            'posts' => $posts
        ]);
    }
    ?>

</div>
