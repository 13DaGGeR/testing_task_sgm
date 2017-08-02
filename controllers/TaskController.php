<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use app\models\Assignment;

class TaskController extends ApiControllerAbstract {

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

	public function actionMyTasks(){
		$uid=Yii::$app->user->identity->id;
		return Task::find()->where(['owner_id'=>$uid])->asArray()->all();
	}
	
	public function actionAssign(){
		$tid=Yii::$app->request->get('id',0);
		$task=Task::findOne($tid);
		if(!$task)
			throw new \yii\web\NotFoundHttpException;

		$model=new Assignment();
		$model->load(Yii::$app->request->post(),'');
		$model->task_id=$tid;
		$model->old_owner_id=$task->owner_id;
		
		if($model->validate() && $model->save()){
			$task->owner_id=$model->new_owner_id;
			$task->save();
		}else{
			return $model->errors;
		}
	}
}
