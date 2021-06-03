<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormPages extends Migration
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
				'constraint' => '50',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('form_pages');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('form_pages');
	}
}
