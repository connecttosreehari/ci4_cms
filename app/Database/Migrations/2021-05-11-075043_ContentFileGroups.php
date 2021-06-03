<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContentFileGroups extends Migration
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
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('content_file_groups');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('content_file_groups');
	}
}
