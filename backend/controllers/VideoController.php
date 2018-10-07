<?php

namespace backend\controllers;

use Yii;
use common\models\Video;
use common\models\VideoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends Controller
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
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Video model.
     * @param integer $id
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Video();

        $post = Yii::$app->request->post();
        if (!empty($post['Video'])) {
            $live = $this->createLive(['name' => $post['Video']['name']]);
            if (!empty($live['data'])) {
                $post['Video']['channel_id'] = (string)$live['data']['channelId'];
            }
        }
//        print_r($post);die;

        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

    private function createLive($param) {
        //设置post数据
        $post_data = array(
            "appId" => "f0izdmj7b7",
            "timestamp" => time()*1000,
            'userId' => '4630174efe',
            'name' => $param['name'],
            'channelPasswd' => '1',
        );
        $post_data['sign'] =  $this->getSign($post_data);
        //显示获得的数据
        //初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.polyv.net/live/v2/channels/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 360);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $response = curl_exec ( $ch );
        curl_close ( $ch );
        if (!empty($response)) {
            return json_decode($response,true);
        }
    }

    function getSign($params){
        $appSecret = '8ddafa04da8d4d509f341130690278de';
        // 1. 对加密数组进行字典排序
        foreach ($params as $key=>$value){
            $arr[$key] = $key;
        }
        sort($arr);
        $str = $appSecret;
        foreach ($arr as $k => $v) {
            $str = $str.$arr[$k].$params[$v];
        }
        $restr = $str.$appSecret;
        $sign = strtoupper(md5($restr));
        return $sign;
    }
}
