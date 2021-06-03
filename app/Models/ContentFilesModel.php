<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentFilesModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'content_files';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDelete        = false;
	protected $protectFields        = false;
	protected $allowedFields        = [];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	/**
	 * Fetching file details
	 * @param array filter
	 */
	public function fetch_data($filter = [])
	{
		$builder = $this->db->table('content_files as cf');
		$builder->select('fd.*,fg.title as file_group_title,fg.id as file_group_id,cf.content as content_id');
		$builder->join('content_file_details as fd', 'fd.content_file=cf.id');
		$builder->join('content_file_groups as fg', 'fg.id = cf.content_file_group');
		if (isset($filter['id'])) {
			$builder->where('cf.id', $filter['id']);
		}
		if (isset($filter['details_id'])) {
			$builder->where('fd.id', $filter['details_id']);
		}
		if (isset($filter['content_id'])) {
			$builder->where('cf.content', $filter['content_id']);
		}
		if (isset($filter['file_group'])) {
			$builder->where('cf.content_file_group', $filter['file_group']);
		}
		if (isset($filter['language'])) {
			$builder->where('fd.language', $filter['language']);
		}
		if (isset($filter['active'])) {
			$builder->where('fd.active', $filter['active']);
		}
		$builder->orderBy('fd.file_order', 'ASC');
		$builder->orderBy('fd.active', 'ASC');
		$query = $builder->get();
		return $query->getResult();
	}
	
}
