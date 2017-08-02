<?php

namespace app\controllers;
use app\models\Project;
use yii\web\NotFoundHttpException;

class ProjectController extends ApiControllerAbstract {

	public $modelClass = 'app\models\Project';

	/**
	 * User's projects and their tasks (created by and assigned to him)
	 * @param int $id
	 * @return array
	 */
	public function actionGetByUser($id){
		return Project::getByUser($id);
	}

}
