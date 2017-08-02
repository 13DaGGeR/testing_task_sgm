<?php

namespace app\models;

trait SoftDelete {

	/**
	 * Soft delete an object
	 */
	public function delete($purge=0) {
		if($purge)
			return parent::delete();
		$this->is_deleted=1;
		return $this->save();
	}

	public static function find(){
		return parent::find()->andWhere(['is_deleted'=>0]);
	}
}
