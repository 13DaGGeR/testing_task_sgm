<?php

use yii\db\Migration;

class m170731_183239_init extends Migration
{
    public function safeUp()
    {
		$this->createTable('user',[
			'id'=>$this->primaryKey(),
			'name'=>$this->string(255)->notNull(),
			'birth_date'=>$this->date()->notNull(),
			'avatar'=>$this->string(255)->notNull(),
			'token'=>$this->string(255)->defaultValue(''),
		]);
		$this->createIndex('token', 'user', 'token');

		$this->createTable('project',[
			'id'=>$this->primaryKey(),
			'name'=>$this->string(255)->notNull(),
			'creation_date'=>$this->date()->notNull(),
			'description'=>$this->text()->notNull(),
			'owner_id'=>$this->integer()->notNull(),
			'status'=>$this->integer(2)->notNull(),
			'deadline'=>$this->dateTime()->notNull(),
			'is_deleted'=>$this->integer(1)->notNull()->defaultValue(0),
		]);
		$this->createIndex('status', 'project', 'status');
		$this->createIndex('deadline', 'project', 'deadline');
		$this->createIndex('is_deleted', 'project', 'is_deleted');
		$this->addForeignKey('project_owner','project','owner_id','user','id');

		$this->createTable('task',[
			'id'=>$this->primaryKey(),
			'name'=>$this->string(255)->notNull(),
			'creation_date'=>$this->date()->notNull(),
			'description'=>$this->text()->notNull(),
			'project_id'=>$this->integer()->notNull(),
			'owner_id'=>$this->integer()->notNull(),
			'status'=>$this->integer(2)->notNull(),
			'deadline'=>$this->dateTime()->notNull(),
			'is_deleted'=>$this->integer(1)->notNull()->defaultValue(0),
		]);
		$this->createIndex('status', 'task', 'status');
		$this->createIndex('deadline', 'task', 'deadline');
		$this->createIndex('is_deleted', 'task', 'is_deleted');
		$this->addForeignKey('project','task','project_id','project','id');
		$this->addForeignKey('task_owner','task','owner_id','user','id');

		$this->createTable('assignment',[
			'id'=>$this->primaryKey(),
			'task_id'=>$this->integer()->notNull(),
			'old_owner_id'=>$this->integer()->notNull()->defaultValue(0),
			'new_owner_id'=>$this->integer()->notNull()->defaultValue(0),
			'owner_id'=>$this->integer()->notNull()->defaultValue(0),
			'reason'=>$this->text()->notNull(),
			'time'=>$this->dateTime()->notNull(),
		]);
		#don't add foreign keys, because assignment table is kind of history log
    }

    public function safeDown()
    {
		foreach(['assignment','task','project','user'] as $table)
			$this->dropTable($table);
    }
}
