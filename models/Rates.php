<?php

namespace app\models;
use app\models\Banks;
use app\models\Office;
use Yii;

/**
 * This is the model class for table "rates".
 *
 * @property int $bank_id
 * @property int $cur_code
 * @property string $cur_name
 * @property double $buy
 * @property double $sell
 * @property double $buy_l
 * @property double $sell_l
 */
class Rates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rates';
    }


   public function getBank()
   {
    return $this->hasOne(Banks::className(), ['id' => 'bank_id']);
   }
  
  public function getOffices()
   {
    return $this->hasMany(Office::className(), ['bank_id' => 'bank_id']);
   }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bank_id', 'cur_code', 'cur_name'], 'required'],
            [['bank_id', 'cur_code'], 'integer'],
            [['buy', 'sell', 'buy_l', 'sell_l','res','ratex','lrate'], 'number'],
			[['buy', 'sell', 'buy_l', 'sell_l','res'],'default', 'value' => 1],
            [['cur_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bank_id' => 'Bank ID',
            'cur_code' => 'Cur Code',
            'cur_name' => 'Cur Name',
            'buy' => 'Buy',
            'sell' => 'Sell',
            'buy_l' => 'Buy L',
            'sell_l' => 'Sell L',
			'res' => 'Res',
			'ratex' => 'Ratex',
        ];
    }
	
	
}
