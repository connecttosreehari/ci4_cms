<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Settings extends Seeder
{
	public function run()
	{
		// inserting data
		$types = [
			[
				'id'          => 1,
			],
		];
		$this->db->table('settings')->insertBatch($types);
	}
}
