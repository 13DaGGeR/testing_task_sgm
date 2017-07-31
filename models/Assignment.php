<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assignment".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $old_user_id
 * @property integer $new_user_id
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
            [['task_id', 'old_user_id', 'new_user_id', 'owner_id'], 'integer'],
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
            'old_user_id' => 'Old User ID',
            'new_user_id' => 'New User ID',
            'owner_id' => 'Owner ID',
            'reason' => 'Reason',
            'time' => 'Time',
        ];
    }
}
