<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContentFileDetails extends Migration
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
			'content_file' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'translation_id' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'title' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
			],
			'subtitle' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
			],
			'short_description' => [
				'type'       => 'VARCHAR',
				'constraint' => '2000',
				'null' => true,
			],
			'description' => [
				'type'       => 'VARCHAR',
				'constraint' => '2000',
				'null' => true,
			],
			'link' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
			],
			'button_name' => [
				'type'       => 'VARCHAR',
				'constraint' => '20',
				'null' => true,
			],
			'icon' => [
				'type'       => 'VARCHAR',
				'constraint' => '20',
				'null' => true,
			],
			'file' => [
				'type'       => 'VARCHAR',
				'constraint' => '300',
				'null' => true,
			],
			'file_order' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'language' => [
				'type'       => 'CHAR',
				'constraint' => '10',
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
		$this->forge->createTable('content_file_details');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('content_file_details');
	}
}
