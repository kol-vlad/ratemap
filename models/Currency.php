<?php
	
	namespace app\models;
	
	use Yii;
	
	/**
		* This is the model class for table "currency".
		*
		* @property int $id
		* @property int $code
		* @property string $name
		* @property string $namecode
		* @property string $icon
	*/
	class Currency extends \yii\db\ActiveRecord
	{
		/**
			* {@inheritdoc}
		*/
		public static function tableName()
		{
			return 'currency';
		}
		public $image; 
		/**
			* {@inheritdoc}
		*/
		public function rules()
		{
			return [
            [['state','code', 'name', 'namecode', 'icon'], 'required'],
            [['code','state'], 'integer'],
            [['name', 'namecode', 'icon','description','keys',], 'string', 'max' => 255],
			[['description','text',], 'string', 'max' => 10000],
			
			[['image'], 'file', 'extensions' => 'png, jpg'],
			];
		}
		
		public function upload(){
			if ($this->validate()) {
				$this->image->saveAs('uploads/' . $this->image->baseName . '.' . $this->image->extension);
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
            'id' => 'ID',
			'state' => 'State',
			
            'code' => 'Code',
            'name' => 'Name',
            'namecode' => 'Namecode',
            'icon' => 'Icon',
			];
		}
	}
