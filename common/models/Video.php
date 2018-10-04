<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property int $id
 * @property string $channel_id 频道号
 * @property string $name 课程名称
 * @property int $course_type 课程类型, 1 社群招生，2 教学教研，3 课程销售
 * @property int $charge_type 观看条件：1 公开课，2 会员课程，3 收费课程
 * @property string $teacher_name
 * @property string $play_time 课程时间
 * @property int $is_remind 是否开课前提醒:1 是，0 否
 * @property int $subscribe_num 预约人数
 * @property int $is_out_of_stock 是否已下架:1 是，0 否
 * @property string $add_time
 * @property string $last_modify
 */
class Video extends \yii\db\ActiveRecord
{
    private static $course_type_map = [
        '1' => '社群招生',
        '2' => '教学教研',
        '3' => '课程销售'
    ];

    private static $charge_type_map = [
        '1' => '公开课',
        '2' => '会员课程',
        '3' => '收费课程'
    ];

    private static $is_remind_map = [
        '1' => '是',
        '0' => '否',
    ];

    private static $is_out_of_stock_map = [
        '1' => '是',
        '0' => '否',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_type', 'charge_type', 'is_remind', 'subscribe_num', 'is_out_of_stock'], 'integer'],
            [['add_time', 'last_modify'], 'safe'],
            [['channel_id'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 127],
            [['teacher_name'], 'string', 'max' => 63],
            [['play_time'], 'string', 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'channel_id' => '频道号',
            'name' => '课程名称',
            'course_type' => '课程类型',
            'charge_type' => '观看条件',
            'teacher_name' => '讲师姓名',
            'play_time' => '课程时间',
            'is_remind' => '是否开课前提醒',
            'subscribe_num' => '预约人数',
            'is_out_of_stock' => '是否已下架',
            'add_time' => 'Add Time',
            'last_modify' => 'Last Modify',
        ];
    }

    public static function courseType($course_type) {
        return isset(self::$course_type_map[$course_type]) ? self::$course_type_map[$course_type] : '未知';
    }

    public static function chargeType($charge_type) {
        return isset(self::$charge_type_map[$charge_type]) ? self::$charge_type_map[$charge_type] : '未知';
    }

    public static function isRemind($is_remind) {
        return isset(self::$is_remind_map[$is_remind]) ? self::$is_remind_map[$is_remind] : '未知';
    }

    public static function isOutOfStock($is_out_of_stock) {
        return isset(self::$is_out_of_stock_map[$is_out_of_stock]) ? self::$is_out_of_stock_map[$is_out_of_stock] : '未知';
    }

    public static function courseTypeList() {
        return self::$course_type_map;
    }

    public static function chargeTypeList() {
        return self::$charge_type_map;
    }

    public static function isRemindList() {
        return self::$is_remind_map;
    }

    public static function isOutOfStockList() {
        return self::$is_out_of_stock_map;
    }
}
