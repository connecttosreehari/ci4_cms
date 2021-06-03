<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Settings extends Migration
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
			'contact_email' => [
				'type'       => 'VARCHAR',
				'constraint' => '200',
				'null' => true,
			],
			'contact_phone' => [
				'type'       => 'VARCHAR',
				'constraint' => '20',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('settings');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('settings');
	}
}
