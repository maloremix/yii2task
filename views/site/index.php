<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\UrlForm $model */


use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <?php $form = ActiveForm::begin([
    ]); ?>
        <?= $form->field($model, 'url')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'frequency')->dropDownList([
                '1' => '1 минута',
                '5' => '5 минут',
                '10' => '10 минут',
            ]
        ) ?>

    <?= $form->field($model, 'replays')->dropDownList([
            '0' => '0',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
        ]
    ) ?>
        <div class="form-group">
                <?= Html::submitButton('Add url', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
