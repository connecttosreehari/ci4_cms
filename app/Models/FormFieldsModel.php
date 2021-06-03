<?php

namespace App\Models;

use CodeIgniter\Model;

class FormFieldsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'form_fields';
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
		$builder=$this->db->table('form_fields as ff');
		$builder->select('ff.*,ft.id as type_id,ft.title as type,fp.title as form_page_title');
		$builder->join('form_field_types as ft', 'ft.id = ff.field_type');
		$builder->join('form_pages as fp', 'ff.form_page = fp.id');
		if (isset($filter['id'])) {
			$builder->where('ff.id', $filter['id']);
		}
		if (isset($filter['active'])) {
			$builder->where('ff.active', $filter['active']);
		}
		$builder->orderBy('ff.title', 'ASC');
		$query= $builder->get();
		return $query->getResult();
	}
}
