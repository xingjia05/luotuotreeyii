<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lts_common_member_wechat".
 *
 * @property int $uid
 * @property string $openid
 * @property int $status
 * @property int $isregister
 * @property string $mobile
 */
class LtsCommonMemberWechat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lts_common_member_wechat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'mobile'], 'required'],
            [['uid', 'status', 'isregister'], 'integer'],
            [['openid'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 20],
            [['openid'], 'unique'],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'openid' => 'Openid',
            'status' => 'Status',
            'isregister' => 'Isregister',
            'mobile' => 'Mobile',
        ];
    }
}
