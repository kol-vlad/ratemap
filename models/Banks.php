<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property string $name
 * @property string $icon
 * @property string $tel
 * @property int $state
 * @property int $pars
 * @property string $parsurl
 * @property string $parsfile
 * @property int $lrate
 * @property int $lratex
 * @property string $time
 * @property int $id
 */
class Banks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banks';
    }
    public $image; 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name',  'state', 'pars', 'parsurl',  'lrate',   ], 'required'],
            [['state', 'pars', 'lrate',  'id'], 'integer'],

            [['name', 'icon', 'tel', 'parsurl','lratex', 'parsfile','wclocks'], 'string', 'max' => 255],
			[['image'], 'file', 'extensions' => 'png, jpg,PNG , JPG'],
        ];
    }

    
    /** getContents()
    {
        return $this->hasMany(Content::className(), ['office' => 'id']);
    }*/
	function findCurrency(){
    if (($cur = Currency::find()->where('State = :id', [':id' => '1'])->All()) !== null) {
        return $cur;
        }

    }
	
	
    public function upload(){
        if ($this->validate()) {
        $this->image->saveAs('uploads/'.$this->image->baseName . '.' . $this->image->extension);
        return true;
    } else {
        return false;
    }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'icon' => 'Icon',
            'tel' => 'Tel',
            'state' => 'State',
            'pars' => 'Pars',
            'parsurl' => 'Parsurl',
            'parsfile' => 'Parsfile',
            'lrate' => 'Lrate',
            'lratex' => 'Lratex',
            'time' => 'Time',
            'id' => 'ID',
        ];
    }
}
