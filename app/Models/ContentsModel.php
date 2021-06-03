<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'contents';
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
	 * fetching records
	 * @param array $filter
	 * return $results
	 */
	public function fetch_data($filter = [])
	{

		$builder = $this->db->table('contents as c');
		$builder->select('ct.*,c.id as content_id,c.content_group as content_group,c.custom_form_group as custom_form_group');
		$builder->join('content_translations as ct', 'ct.content = c.id');
		if (isset($filter['id'])) {
			$builder->where('c.id', $filter['id']);
		}
		if (isset($filter['content_group'])) {
			$builder->where('c.content_group', $filter['content_group']);
		}
		if (isset($filter['language'])) {
			$builder->where('ct.language', $filter['language']);
		}
		if (isset($filter['content_group'])) {
			$builder->where('c.content_group', $filter['content_group']);
		}
		if (isset($filter['active'])) {
			$builder->where('c.active', $filter['active']);
		}
		$builder->orderBy('c.active', 'ASC');
		$builder->orderBy('ct.content_order', 'ASC');
		$builder->orderBy('ct.created_at', 'ASC');
		$query = $builder->get();
		return $query->getResult();
	}

	/**
	 * update content group order
	 * @param int $id
	 * @param int $group_order
	 */
	public function update_group_order(int $id, int $group_order)
	{
		$builder = $this->db->table('content_translations');
		$builder->where('id', $id);
		$builder->set('group_order', $group_order);
		$builder->update();
	}
}
