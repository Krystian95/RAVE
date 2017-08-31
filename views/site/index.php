<?php
/* @var $this yii\web\View */

$this->title = 'RAVE';
use app\components\HomeWidget;
?>

<div class="site-index">
    
    <div class="intro">
        <br>
        <br>
        <img class="logo" src="css/images/logo_big_description.png" alt="RAVE Resources Annotator, Visualizer and Enhancer">
        <br>
        <br>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">What is RAVE</h3>
                        <p class="card-text">RAVE is a web application that allow users to search for information about any topic on 
                            <a href="https://en.wikipedia.org/" target="_blank">Wikipedia</a>. If the topic you are looking 
                            for belongs to the category "Member states of the United Nations" then the results from 
                            <a href="https://www.crossref.org" target="_blank">Crossref</a>, 
                            <a href="https://twitter.com/" target="_blank">Twitter</a>, 
                            <a href="https://www.youtube.com/" target="_blank">YouTube</a>, 
                            <a href="https://www.google.com/maps" target="_blank">Google Maps</a> and 
                            <a href="https://d3js.org" target="_blank">D3.js</a> will also be displayed. 
                            Additionally, RAVE registered users also have the ability to create annotations on pages.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Visualizer</h3>
                        <p class="card-text">You can search what you want with RAVE by using the search bar on top of the page. 
                            The application will retrieve the related Wikipedia page about the topic you're searching. If the 
                            topic is in "Member states of the United Nations" category, the corresponding  Crossref results will 
                            be displayed. You can also find all the pages of the "Member states of the United Nations" category 
                            in the home page.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Annotator</h3>
                        <p class="card-text">If you are register to RAVE you can annotate all the text you want, in any searched 
                            page! After search a topic, select a portion of text, and automatically a little button will appear, 
                            just click it and annotate the text. You can also choose to make your annotation public or private. If 
                            a Wikipedia annotated page is update, the application will automatically show the older version of that 
                            page.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Enhancer</h3>
                        <p class="card-text">All the pages of the "Member states of the United Nations" category are mashed up with 
                            related contents comes from Twitter, YouTube and Google Maps. In this way you can view tweets, videos and 
                            places related. You can also view the chart that show the number of results come from Wikipedia, Crossref 
                            and YouTube. Instead in the "Charts" section there are graphics about United Nations.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        <hr>

    </div>

    <?php
    if (isset($posts) && isset($category)) {
        echo HomeWidget::widget([
            'category' => $category,
            'posts' => $posts
        ]);
    }
    ?>

</div>
