<?php
/* @var $this yii\web\View */

$this->title = 'RAVE';
use app\components\PostListWidget;
?>

<div class="site-index">
    
    <div class="intro">
        
        <h1>Welcome to RAVE</h1>
        
        <p>.........</p>
        
    </div>

    <?php
    if (isset($posts) && isset($category)) {
        echo PostListWidget::widget([
            'category' => $category,
            'posts' => $posts
        ]);
    }
    ?>

</div>
