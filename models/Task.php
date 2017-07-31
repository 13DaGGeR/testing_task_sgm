<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property string $creation_date
 * @property string $description
 * @property integer $project_id
 * @property integer $owner_id
 * @property integer $status
 * @property string $deadline
 * @property integer $is_deleted
 *
 * @property Project $project
 * @property User $owner
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'creation_date', 'description', 'project_id', 'owner_id', 'status', 'deadline'], 'required'],
            [['creation_date', 'deadline'], 'safe'],
            [['description'], 'string'],
            [['project_id', 'owner_id', 'status', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'project_id' => 'Project ID',
            'owner_id' => 'Owner ID',
            'status' => 'Status',
            'deadline' => 'Deadline',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }
}
