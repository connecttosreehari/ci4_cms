<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContentGroups extends Migration
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
			'form_group' => [
				'type'       => 'INT',
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
				'constraint' => '100',
				'null' => true,
			],
			'related_groups' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'enable_add' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'enable_edit' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'enable_delete' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'enable_order' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'hide_group' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'menu_icon' => [
				'type'       => 'VARCHAR',
				'constraint' => '20',
				'null' => true,
			],
			'group_order' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'null' => true,
			],			
			'enable_custom_form_group' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
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
		$this->forge->createTable('content_groups');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('content_groups');
	}
}
