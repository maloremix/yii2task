<?php
namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


class UrlForm extends ActiveRecord{

    public function rules()
    {
        return [
            // username and password are both required
            [['frequency', 'replays', 'date'], 'safe'],
            ['url', 'url'],
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    public static function tableName()
    {
        return '{{url}}';
    }
}

