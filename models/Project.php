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
            [['name', 'creation_date', 'description', 'owner_id', 'status', 'deadline'], 'required'],
            [['creation_date', 'deadline'], 'safe'],
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
}
