<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContentFiles extends Migration
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
			'content' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'constraint' => '1',
				'null' => true,
			],
			'content_file_group' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'constraint' => '1',
				'null' => true,
			],
			'content_file_type' => [
				'type'       => 'INT',
				'unsigned'       => true,
				'constraint' => '1',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('content_files');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('content_files');
	}
}
