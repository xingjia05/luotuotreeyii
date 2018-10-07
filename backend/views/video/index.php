<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\VideoSearch;
use common\models\Video;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '视频管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增直播', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute'=>'id',
                'contentOptions'=>['width'=>'30px'],
            ],
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
