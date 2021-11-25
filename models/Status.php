<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property string $new
 * @property string $reserv
 * @property string $can1
 * @property string $can2
 * @property string $done
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['new', 'reserv', 'can1', 'can2', 'done'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'new' => 'New',
            'reserv' => 'Reserv',
            'can1' => 'Can1',
            'can2' => 'Can2',
            'done' => 'Done',
        ];
    }
}
