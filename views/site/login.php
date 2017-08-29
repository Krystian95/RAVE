<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'RAVE - Login';
?>
<div class="site-login">
    <h3 class="titlepage">Login</h3>

    <p><br>Do you want to Annotate the pages? Login!</p>
    <p>Please fill out the following fields to login:</p>

    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form'
    ]);
    ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?=
    $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox()
    ?>

    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

    <?php ActiveForm::end(); ?>
</div>
