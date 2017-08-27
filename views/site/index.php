<?php
/* @var $this yii\web\View */

$this->title = 'RAVE';
use app\components\PostListWidget;
?>

<div class="site-index">
    
    <div class="intro">
        
        <h1>Welcome to RAVE</h1>
        <h2>Resources Annotator, Visualizer and Enhancer</h2>
        <br>
        <img class="aaa">
        <br><br><br><br><br>
        <p>OBE is an integrated environment that allows the user to search topic and information about anything on Wikipedia. 
            Furthermore all the topics the users can find in the platform are mashed up together with related contents from 
            Youtube platform, Twitter, Google Maps, Spotify and if the content is about "English Rock Singer" category, we also 
            retrive you some articles from the Crossref database. We also give our community the feature of making annotations 
            over all the content searched, so you can remember in every moment your thoughts and your opinions and eventually 
            share them with other users, so remember to sign-up to have full access to every feature.
        </p>
        
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
