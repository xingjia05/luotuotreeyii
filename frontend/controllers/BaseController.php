<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller {

    private $errCode = 0;
    private $errMsg = 'success';
    private $httpCode = 200;

    protected $session = [];
    protected $userId = 0;
    public $enableCsrfValidation = false;

    public function setError($errCode, $errMsg, $httpCode = 200)
    {
        $this->errCode = $errCode;
        $this->errMsg = $errMsg;
        $this->httpCode = $httpCode;
    }

    public function getError()
    {
        $result = array();
        $result['errCode']  = $this->errCode;
        $result['errMsg']   = $this->errMsg;
        $result['httpCode'] = $this->httpCode;

        return $result;
    }

    public function setErrorMsg($errMsg)
    {
        $this->errMsg = $errMsg;
    }

    /**
     * 认证
     */
    public function authentication() {

        if (empty($this->userId)) {
            return false;
        }
        return true;
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $callBack = Yii::$app->request->get('callback', NULL);
        $format = $callBack ? \yii\web\Response::FORMAT_JSONP : \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->format = $format;

        return true;
    }

    public function afterAction($action, $result)
    {
        parent::afterAction($action, $result);

        if ($this->httpCode != 200) {
            throw new \yii\web\HttpException($this->httpCode, 'Bad request');
        }
        Yii::$app->response->data = [
            'name' => 'OK',
            'message' => $this->errMsg,
            'code' => $this->errCode,
            'status' => 200,
            'data' => $result,
        ];
    }

}
