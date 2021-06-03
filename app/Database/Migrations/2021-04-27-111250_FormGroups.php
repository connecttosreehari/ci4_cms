<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormGroups extends Migration
{
	public function up()
	{
		// creating table
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'form_page' => [
				'type'           => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'title' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'slug' => [
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null' => true,
			],
			'created_at' => [
				'type'       => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type'       => 'DATETIME',
				'null' => true,
			],
			'created_by' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'updated_by' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'active' => [
				'type'       => 'TINYINT',
				'unsigned'       => true,
				'constraint' => '1',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('form_groups');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('form_groups');
	}
}
