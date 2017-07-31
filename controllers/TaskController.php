<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\TaskSearch;

class TaskController extends ActiveController {

	public $modelClass = 'app\models\Task';

	public function actions() {
		$actions = parent::actions();
		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
		return $actions;
	}

	public function prepareDataProvider() {
		$searchModel = new TaskSearch();
		return $searchModel->search(Yii::$app->request->queryParams);
	}

}
