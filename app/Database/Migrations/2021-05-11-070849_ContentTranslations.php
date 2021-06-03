<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContentTranslations extends Migration
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
				'null' => true,
			],
			'title' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
			],
			'slug' => [
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
				'type'       => 'TEXT',
				'null' => true,
			],
			'description' => [
				'type'       => 'TEXT',
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
			'full_name' => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'address' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => true,
			],
			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => true,
			],
			'phone' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => true,
			],
			'fax' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => true,
			],
			'meta_title' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => true,
			],
			'meta_keyword' => [
				'type'       => 'VARCHAR',
				'constraint' => '250',
				'null' => true,
			],
			'meta_description' => [
				'type'       => 'VARCHAR',
				'constraint' => '1000',
				'null' => true,
			],
			'meta_canonical_url' => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
				'null' => true,
			],
			'language' => [
				'type'       => 'CHAR',
				'constraint' => '10',
				'null' => true,
			],
			'content_order' => [
				'type'       => 'INT',
				'unsigned'       => true,
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
		$this->forge->createTable('content_translations');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('content_translations');
	}
}
