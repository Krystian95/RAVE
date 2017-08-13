<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Profile';
?>
<div class="profile">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <span class="bolded">Username: </span> <?= $username; ?>
    </p>
</div>
