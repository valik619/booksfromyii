<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "catalog".
 *
 * @property integer $id
 * @property string $title
 * @property string $author
 * @property string $year
 * @property string $description
 * @property string $img
 * @property string $category
 * @property integer $price
 * @property integer $sale
 * @property integer $sold
 */
class Catalog extends \yii\db\ActiveRecord
{
	public $image;
	public $string;
	public $filename;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author', 'year', 'description', 'category', 'price', 'sale'], 'required'],
            [['year'], 'safe'],
            [['description'], 'string'],
            [['price', 'sale', 'sold'], 'integer'],
            [['title', 'category'], 'string', 'max' => 100],
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
            'title' => 'Title',
            'author' => 'Author',
            'year' => 'Year',
            'description' => 'Description',
            'img' => 'Img',
            'category' => 'Category',
            'price' => 'Price',
            'sale' => 'Sale',
            'sold' => 'Sold',
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
