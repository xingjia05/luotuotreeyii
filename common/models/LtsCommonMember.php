<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lts_common_member".
 *
 * @property int $uid
 * @property string $email
 * @property string $username
 * @property string $password
 * @property int $status
 * @property int $emailstatus
 * @property int $avatarstatus
 * @property int $videophotostatus
 * @property int $adminid
 * @property int $groupid
 * @property int $groupexpiry
 * @property string $extgroupids
 * @property int $regdate
 * @property int $credits
 * @property int $notifysound
 * @property string $timeoffset
 * @property int $newpm
 * @property int $newprompt
 * @property int $accessmasks
 * @property int $allowadmincp
 * @property int $onlyacceptfriendpm
 * @property int $conisbind
 * @property int $freeze
 */
class LtsCommonMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lts_common_member';
    }

    /**
     * 连接的数据库
     * @return mixed
     */
    public static function getDb()
    {
        return Yii::$app->db_z;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'emailstatus', 'avatarstatus', 'videophotostatus', 'adminid', 'groupid', 'groupexpiry', 'regdate', 'credits', 'notifysound', 'newpm', 'newprompt', 'accessmasks', 'allowadmincp', 'onlyacceptfriendpm', 'conisbind', 'freeze'], 'integer'],
            [['email'], 'string', 'max' => 40],
            [['username'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 32],
            [['extgroupids'], 'string', 'max' => 20],
            [['timeoffset'], 'string', 'max' => 4],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'status' => 'Status',
            'emailstatus' => 'Emailstatus',
            'avatarstatus' => 'Avatarstatus',
            'videophotostatus' => 'Videophotostatus',
            'adminid' => 'Adminid',
            'groupid' => 'Groupid',
            'groupexpiry' => 'Groupexpiry',
            'extgroupids' => 'Extgroupids',
            'regdate' => 'Regdate',
            'credits' => 'Credits',
            'notifysound' => 'Notifysound',
            'timeoffset' => 'Timeoffset',
            'newpm' => 'Newpm',
            'newprompt' => 'Newprompt',
            'accessmasks' => 'Accessmasks',
            'allowadmincp' => 'Allowadmincp',
            'onlyacceptfriendpm' => 'Onlyacceptfriendpm',
            'conisbind' => 'Conisbind',
            'freeze' => 'Freeze',
        ];
    }

    public function getMember()
    {
        $ret = self::find()
            ->select('*')
            ->from('lts_common_member as member')
            ->leftJoin('lts_common_member_wechat as wechat', 'wechat.uid = member.uid')
            ->asArray()
            ->all();
        return $ret;
    }
}
