<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "authors".
 *
 * @property integer $id
 * @property string $author
 * @property string $bday
 * @property string $bio
 * @property string $img
 */
class Authors extends \yii\db\ActiveRecord
{
	public $image;
	public $string;
	public $filename;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'bday', 'bio'], 'required'],
            [['bday'], 'safe'],
            [['bio'], 'string'],
            [['author'], 'string', 'max' => 50],
			//[['img'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'bday' => 'Bday',
            'bio' => 'Bio',
            'img' => 'Img',
        ];
    }

	public function beforeSave($insert){
		if ($this->isNewRecord) { //для первой загрузки файла
			//generate & upload
			$this->string = substr(uniqid('img'), 0, 12); //imgRandomString
			$this->image = UploadedFile::getInstance($this, 'img');
			$this->filename = 'static/images/' . $this->string . '.' . $this->image->extension;
			$this->image->saveAs($this->filename);

			//save
			$this->img = '/' . $this->filename;
		}else{ //для редактирования
			$this->image = UploadedFile::getInstance($this, 'img');
			if($this->image) {
				$this->string = substr(uniqid('img'), 0, 12);
				$this->filename = 'static/images/' . $this->string . '.' . $this->image->extension;
				$this->img = '/' . $this->filename;
				$this->image->saveAs(substr($this->img, 1));
			}
		}
		return parent::beforeSave($insert);
	}
}
