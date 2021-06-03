<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContentFileTypes extends Seeder
{
	public function run()
	{
		// inserting data
		$types = [
			[
				'id'          => 1,
				'title'        => 'Image',
			],
			[
				'id'          => 2,
				'title'        => 'Other',
			],
		];
		$this->db->table('content_file_types')->insertBatch($types);
	
	}
}
