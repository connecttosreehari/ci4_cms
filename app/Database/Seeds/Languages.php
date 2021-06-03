<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Languages extends Seeder
{
	public function run()
	{
		// inserting data
		$types = [
			[
				'id'          => 1,
				'title'        => 'English',
				'code'        => 'en',
				'direction'        => 'ltr',
				'active' => 1,
			],
			[
				'id'          => 2,
				'title'        => 'Arabic',
				'code'        => 'ae',
				'direction'        => 'rtl',
				'active' => 1,
			],
		];
		$this->db->table('languages')->insertBatch($types);
	}
}
