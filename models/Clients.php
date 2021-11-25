<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property string $name
 * @property double $tel
 * @property string $office
 * @property double $cash
 * @property int $bank_id
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tel',], 'required'],
            [['tel', ], 'number'],
            [['status','cash','cashout'],'string', 'max' => 1200],
            [['name', 'office'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'tel' => 'Tel',
            'office' => 'Office',
            'cash' => 'Cash',
            'cashout' => 'Cashout',
			'status' => 'Status',
        ];
    }
}
