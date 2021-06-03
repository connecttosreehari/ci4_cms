<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormPages extends Seeder
{
	public function run()
	{
		// inserting data
		$types = [
			[
				'id'          => 1,
				'title'        => 'Content',
			],
			[
				'id'          => 2,
				'title'        => 'File',
			],
		];
		$this->db->table('form_pages')->insertBatch($types);
	}
}
