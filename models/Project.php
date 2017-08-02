<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $creation_date
 * @property string $description
 * @property integer $owner_id
 * @property integer $status
 * @property string $deadline
 * @property integer $is_deleted
 *
 * @property User $owner
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
	use SoftDelete;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['status','default','value'=>0],
			['creation_date','default','value'=>function(){return date('Y-m-d');}],
			['owner_id','default','value'=>function(){return Yii::$app->user->identity->id;}],
            ['creation_date', 'date', 'format'=>'yyyy-MM-dd'],
			['deadline', 'datetime', 'format'=>'yyyy-MM-dd HH:mm:ss'],
            [['name', 'creation_date', 'description', 'owner_id', 'status', 'deadline'], 'required'],
            [['description'], 'string'],
            [['owner_id', 'status', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'creation_date' => 'Creation Date',
            'description' => 'Description',
            'owner_id' => 'Owner ID',
            'status' => 'Status',
            'deadline' => 'Deadline',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }
	
	public static function getByUser($uid){
		$created=static::find()->with('tasks')->where(['owner_id'=>$uid])->asArray()->all();
		
		$assigned=[];
		$tasks=Task::findAll(['owner_id'=>$uid]);
		$pids=$p2t=[];
		foreach($tasks as $t){
			$pids[$t->project_id]=1;
			$p2t[$t->project_id][]=$t;
		}
		foreach(static::find()->where(['id'=>array_keys($pids)])->asArray()->all() as $proj){
			$proj=(object)$proj;
			$proj->tasks=$p2t[$proj->id];
			$assigned[]=$proj;
		}
		return [
			'created'=>$created,
			'assigned'=>$assigned,
		];
	}
}
