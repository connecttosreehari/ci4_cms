<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormFieldTypes extends Seeder
{
	public function run()
	{
		// inserting data
		$types = [
			[
				'id'          => 1,
				'title'        => 'Text',
			],
			[
				'id'          => 2,
				'title'        => 'Textarea',
			],
			[
				'id'          => 3,
				'title'        => 'Radio',
			],
			[
				'id'          => 4,
				'title'        => 'Checkbox',
			],
			[
				'id'          => 5,
				'title'        => 'Select',
			],
			[
				'id'          => 6,
				'title'        => 'File',
			],
		];
		$this->db->table('form_field_types')->insertBatch($types);
	}
}
