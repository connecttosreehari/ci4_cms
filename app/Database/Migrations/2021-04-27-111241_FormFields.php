<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormFields extends Migration
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
			'title' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'identity' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'field_name' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'database_field' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'field_type' => [
				'type'       => 'INT',
				'unsigned'   => true,
				'null' => true,
			],
			'form_page' => [
				'type'       => 'INT',
				'unsigned'   => true,
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
		$this->forge->createTable('form_fields');
	}

	public function down()
	{
		//dropping table
		$this->forge->dropTable('form_fields');
	}
}
