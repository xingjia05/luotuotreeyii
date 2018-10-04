<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Video;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'channel_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'course_type')->dropDownList(
        Video::courseTypeList(), []);?>

    <?= $form->field($model, 'charge_type')->dropDownList(
        Video::chargeTypeList(), []);?>

    <?= $form->field($model, 'teacher_name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'play_time')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'is_remind')->dropDownList(
        Video::isRemindList(), []);?>

    <?= $form->field($model, 'subscribe_num')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'is_out_of_stock')->dropDownList(
        Video::isRemindList(), []);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
