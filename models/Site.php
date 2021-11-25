<?php 
namespace app\models;
use yii\base\Model;
use app\models\Currency;


class Site extends Model
{

 public function rules()
    {
        return [
		     [['cashin' ], 'required'],
            [['cashin', 'incur','outcur' ], 'number'],
            [['name', 'icon', 'tel','incur ', 'parsurl', 'parsfile', 'time'], 'safe'],
        ];
    }
	
	

	
public $cashin;
public $cashout;
public $incur;
public $outcur;

 function findCurrency(){
    if (($cur = Currency::find()->where('State = :id', [':id' => '1'])->All()) !== null) {
        return $cur;
        }

 }


}