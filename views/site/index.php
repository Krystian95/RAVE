<?php
/* @var $this yii\web\View */

$this->title = 'RAVE';
use app\components\PostListWidget;
?>

<div class="site-index">
    
    <div class="intro">
        
        <br>
        <img class="logo" src="css/images/logo_big_description.png" alt="RAVE Resources Annotator, Visualizer and Enhancer">
        <br>
        <hr>
        <p>
           What is RAVE? RAVE is a web application that allow users to search for information about any topic on 
           <a href="https://en.wikipedia.org/" target="_blank">Wikipedia</a>. If the topic you are looking 
           for belongs to the category "Member states of the United Nations" then the results from 
           <a href="https://www.crossref.org" target="_blank">Crossref</a>, 
           <a href="https://twitter.com/" target="_blank">Twitter</a>, 
           <a href="https://www.youtube.com/" target="_blank">YouTube</a>, 
           <a href="https://www.google.com/maps" target="_blank">Google Maps</a> and 
           <a href="https://d3js.org" target="_blank">D3.js</a> will also be displayed. 
           Additionally, RAVE registered users also have the ability to create annotations on pages.
        </p>
        
        <hr>
          
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
