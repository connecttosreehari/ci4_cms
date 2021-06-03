<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contents extends Migration
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
			'content_group' => [
				'type'       => 'INT',
				'unsigned'  => true,
				'null' => true,
			],
			'custom_form_group' => [
				'type'       => 'INT',
				'unsigned'  => true,
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
		$this->forge->createTable('contents');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('contents');
	}
}
