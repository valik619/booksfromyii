<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
	#public $layout = "admin";
	//$this->layout = (Yii::app()->user->name == 'admin') ? '//layouts/column2' : '//layouts/column1';
	public function actionIndex()
    {
		//$this->layout = (\Yii::$app->user->identity == 'admin') ? 'admin' : '/main';
        return $this->render('index');
    }
}
