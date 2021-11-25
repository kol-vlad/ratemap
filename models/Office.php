<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "office".
 *
 * @property int $id
 * @property string $addres
 * @property string $tel
 * @property int $bank_id
 */
class Office extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'office';
    }
    public function getBank()
   {
    return $this->hasOne(Banks::className(), ['id' => 'bank_id']);
   }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['addres', 'bank_id'], 'required'],
            [['bank_id'], 'integer'],
			  [['lat', 'lon'], 'number'],
            [['addres', 'tel','addfield1','wclocks'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'addres' => 'Addres',
            'tel' => 'Tel',
			'addfield1' => 'Addfield1',
            'bank_id' => 'Bank ID',
        ];
    }
}
