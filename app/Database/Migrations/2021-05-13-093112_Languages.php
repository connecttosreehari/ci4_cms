<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Languages extends Migration
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
			'code' => [
				'type'       => 'VARCHAR',
				'constraint' => '10',
				'null' => true,
			],
			'direction' => [
				'type'       => 'CHAR',
				'constraint' => '3',
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
		$this->forge->createTable('languages');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('languages');
	}
}
