<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Video;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '视频管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定删除这个视频吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'channel_id',
            'name',
            [
                'attribute'=>'course_type',
                'label'=>'课程类型',
                'value'=>function($model) {
                    return Video::courseType($model->course_type);
                }
            ],
            [
                'attribute'=>'charge_type',
                'label'=>'观看条件',
                'value'=>function($model) {
                    return Video::chargeType($model->charge_type);
                }
            ],
            'teacher_name',
            'play_time',
            [
                'attribute'=>'is_remind',
                'value'=>function($model) {
                    return Video::isRemind($model->is_remind);
                }
            ],
            'subscribe_num',
            [
                'attribute'=>'is_out_of_stock',
                'value'=>function($model) {
                    return Video::isOutOfStock($model->is_out_of_stock);
                }
            ],
        ],
        'template'=>'<tr><th style="width:120px;">{label}</th><td>{value}</td></tr>',
    	'options'=>['class'=>'table table-striped table-bordered detail-view'],
    ]) ?>

</div>
