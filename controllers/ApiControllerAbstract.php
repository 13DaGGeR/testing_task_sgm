<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

abstract class ApiControllerAbstract extends ActiveController {
	public function behaviors() {
		$behaviors=parent::behaviors();
		$behaviors['authentificator']=[
			'class'=> HttpBasicAuth::className(),
		];
		return $behaviors;
	}
}
