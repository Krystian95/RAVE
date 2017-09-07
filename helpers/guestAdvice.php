<?php

/*
 * The advice shown to the guest users.
 */

$advice = '<div id="alert-intro" class="alert alert-success alert-dismissible into" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="alert-heading">Hi Guest!</h4>
    <p>Do you know that you can annotate everything in this page?
    You have just to <b>select</b> a portion of text and <b>click</b> the button that will appear.</p>
    <p class="mb-0">If you like it please <a class="alert-intro-link" href="' . Yii::$app->getHomeUrl() . 'site/signup">Register</a> or <a class="alert-intro-link" href="' . Yii::$app->getHomeUrl() . 'site/login">Login</a>.</p>
</div>';

return $advice;
