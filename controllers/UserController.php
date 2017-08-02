<?php

namespace app\controllers;

use Yii;

class UserController extends ApiControllerAbstract {

	public $modelClass = 'app\models\User';

	public function actionLogout(){
		Yii::$app->user->logout();
		throw new \yii\web\UnauthorizedHttpException();
	}
}
