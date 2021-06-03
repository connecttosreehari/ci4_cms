<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormFieldSettings extends Migration
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
			'form_field' => [
				'type'           => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'form_group' => [
				'type'           => 'INT',
				'unsigned'       => true,
				'null' => true,
			],
			'check_required' => [
				'type'       => 'TINYINT',
				'unsigned'       => true,
				'constraint' => '1',
				'null' => true,
			],
			'check_valid_email' => [
				'type'       => 'TINYINT',
				'unsigned'       => true,
				'constraint' => '1',
				'null' => true,
			],
			'match_regex' => [
				'type'       => 'CHAR',
				'constraint' => '100',
				'null' => true,
			],
			'max_length' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],
			'enable_editor' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'enable_multiple' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'allowed_extensions' => [
				'type'       => 'CHAR',
				'constraint' => '50',
				'null' => true,
			],
			'enable_file_edit' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'enable_file_delete' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'enable_file_order' => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'null' => true,
			],
			'file_form_group' => [
				'type'       => 'INT',
				'null' => true,
			],
			'min_width' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],
			'min_height' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],
			'max_width' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],
			'max_height' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],
			'thumb_width' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],
			'thumb_height' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],
			'max_size' => [
				'type'       => 'MEDIUMINT',
				'null' => true,
			],			
			'enable_resize' => [
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
		$this->forge->createTable('form_field_settings');
	}

	public function down()
	{
		// dropping table
		$this->forge->dropTable('form_field_settings');
	}
}
