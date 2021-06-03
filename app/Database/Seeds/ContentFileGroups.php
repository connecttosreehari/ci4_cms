<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContentFileGroups extends Seeder
{
	public function run()
	{
		// inserting data
		$types = [
			[
				'id'          => 1,
				'title'        => 'Images',
			],
			[
				'id'          => 2,
				'title'        => 'Documents',
			],
		];
		$this->db->table('content_file_groups')->insertBatch($types);
	}
}
