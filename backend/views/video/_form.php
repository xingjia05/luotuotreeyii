<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Video;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <div style="display: none">
    <?= $form->field($model, 'channel_id')->textInput(['maxlength' => true, 'type' => 'hidden']) ?>
    </div>
    <?= $form->field($model, 'name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'course_type')->dropDownList(
        Video::courseTypeList(), []);?>

    <?= $form->field($model, 'charge_type')->dropDownList(
        Video::chargeTypeList(), []);?>

    <?= $form->field($model, 'teacher_name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'play_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'file')->widget('manks\FileInput', []) ?>
    <?= $form->field($model, 'image_big')->widget('manks\FileInput', []) ?>

    <?= $form->field($model, 'is_remind')->dropDownList(
        Video::isRemindList(), []);?>

    <?= $form->field($model, 'is_out_of_stock')->dropDownList(
        Video::isRemindList(), []);?>

    <?= $form->field($model, 'describe')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
