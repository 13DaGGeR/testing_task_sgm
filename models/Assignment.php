<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assignment".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $old_owner_id
 * @property integer $new_owner_id
 * @property integer $owner_id
 * @property string $reason
 * @property string $time
 */
class Assignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'reason', 'time'], 'required'],
            [['task_id', 'old_owner_id', 'new_owner_id', 'owner_id'], 'integer'],
            [['reason'], 'string'],
            [['time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'old_owner_id' => 'Old User ID',
            'new_owner_id' => 'New User ID',
            'owner_id' => 'Owner ID',
            'reason' => 'Reason',
            'time' => 'Time',
        ];
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

	public function beforeValidate() {
		$ok=parent::beforeValidate();
		if($ok){
			$this->owner_id=Yii::$app->user->identity->id;
			$this->time=date('Y-m-d H:i:s');

			//Permit assignment if user is not owner of the project
			if($this->isAttributeChanged('owner_id') && 
				$this->task->project->owner_id != Yii::$app->user->identity->id
			){
				throw new \yii\web\UnauthorizedHttpException;
			}
		}
		return $ok;
	}
}
