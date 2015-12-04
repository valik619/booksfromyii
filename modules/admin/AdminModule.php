<?php

namespace app\modules\admin;

use Yii;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = 'admin';

    public function init()
    {
        parent::init();

        if (Yii::$app->user->isGuest) {
            $this->layout = '//main';
        }

    }

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if (Yii::$app->user->isGuest || Yii::$app->user->status == 'user') {
            Yii::$app->getResponse()->redirect(Yii::$app->user->loginUrl);
        }
    }

}
