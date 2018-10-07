<?php

namespace backend\controllers;

use Yii;
use common\models\Video;
use common\models\VideoSearch;
use common\models\LtsCommonMember;
use common\models\LtsCommonMemberWechat;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\phplib\wechat\Wechat;
include './../config/const.php';

/**
 * WxPushController implements the CRUD actions for Video model.
 */
class WxPushController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        /* 获取用户 */
        $memberObj = new LtsCommonMember();
        $memberArr = $memberObj->getMember();
        /* 获取模版 */
        $videoObj = new Video();
        $video = $videoObj->getDetail($id);
        if (empty($video)) {
            echo '改课程不能推送';
            die();
        }
        foreach ($memberArr as $member) {
            if (empty($member['openid'])) {
                continue;
            }
            $param = [
                'template_id' => '0Qb8clm-uN9BI8J3BmKQUBxZN3chCfXh-i0Qv95sGaI',
                'open_id' => $member['openid'],
//                'open_id' => 'oAhO-01_mxeWnBmT5PB_Dq4pSfOw',
                'url' => '',
                'name' => $video[0]['name'],
                'teacher_name' => $video[0]['teacher_name'],
                'play_time' => $video[0]['play_time'],
            ];
            /* 推送消息 */
            $this->sendGetCouponTemplate($param);
        }

        return $this->render('/video/view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function sendGetCouponTemplate($param)
    {
        $data = [
            'touser' => $param['open_id'],
            'template_id' => $param['template_id'],
            'url' => '',
            'data' => [
                'first' => [
                    'value' => "你好，明晚有新课程",
                    'color' => '#173177',
                ],
                'keyword1' => [
                    'value' => $param['name'],
                    'color' => '#173177',
                ],
                'keyword2' => [
                    'value' => '在线直播',
                    'color' => '#173177',
                ],
                'keyword3' => [
                    'value' => $param['teacher_name'],
                    'color' => '#173177',
                ],
                'keyword3' => [
                    'value' => $param['play_time'],
                    'color' => '#173177',
                ],
                'remark' => [
                    'value' => '请按照时间提前签到',
                    'color' => '#173177',
                ],
            ],
        ];
        $wechatObj = new Wechat(['appsecret' => APP_SECRET, 'appid' => APP_ID,]);
        return $wechatObj->sendTemplateMessage($data);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
