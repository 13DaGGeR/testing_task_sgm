<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $birth_date
 * @property string $avatar
 * @property string $token
 *
 * @property Project[] $projects
 * @property Task[] $tasks
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'user';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			['avatar','default','value'=>'/face.jpg'],
			['birth_date', 'date', 'format'=>'yyyy-MM-dd'],
			[['name', 'birth_date', 'avatar'], 'required'],
			[['name', 'avatar', 'token'], 'string', 'max' => 255],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'name' => 'Name',
			'birth_date' => 'Birth Date',
			'avatar' => 'Avatar',
			'token' => 'Token',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProjects() {
		return $this->hasMany(Project::className(), ['owner_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTasks() {
		return $this->hasMany(Task::className(), ['owner_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return false;
	}

	public static function findIdentity($id){
		return static::findOne($id);
	}

	public static function findIdentityByAccessToken($token, $type = null){
		return static::findOne(['token'=>$token]);
	}
}
