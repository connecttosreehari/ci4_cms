<?php

namespace App\Models;

use CodeIgniter\Model;

class FormFieldSettingsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'form_field_settings';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDelete        = false;
	protected $protectFields        = false;
	protected $allowedFields        = [];

	// Dates
	protected $useTimestamps        = true;
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
	 * fetching data
	 * @param null|array
	 * @return object|null 
	 */
	public function fetch_data($filter = [])
	{
		$builder = $this->db->table('form_field_settings as fs');
		$builder->select('fs.*,ff.title as form_field_title,ff.field_name as form_field_name,ff.identity as identity,ff.database_field as form_database_field,fg.title as form_group_title');
		$builder->join('form_fields as ff', 'ff.id = fs.form_field');
		$builder->join('form_groups as fg', 'fg.id = fs.form_group');
		if (isset($filter['id'])) {
			$builder->where('fs.id', $filter['id']);
		}
		if (isset($filter['group_id'])) {
			$builder->where('fs.form_group', $filter['group_id']);
		}
		if (isset($filter['group_slug'])) {
			$builder->where('fg.slug', $filter['group_slug']);
		}
		if (isset($filter['field_id'])) {
			$builder->where('fs.form_field', $filter['field_id']);
		}
		if (isset($filter['form_slug'])) {
			$builder->where('ff.slug', $filter['form_slug']);
		}
		if (isset($filter['active'])) {
			$builder->where('ff.active', $filter['active']);
		}
		$builder->orderBy('fs.active', 'ASC');
		$query = $builder->get();
		return $query->getResult();
	}
}
