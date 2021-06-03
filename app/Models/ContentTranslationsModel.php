<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentTranslationsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'content_translations';
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
	 * disable all  translations of content
	 * @param int $content_id
	 */

	public function disable_by_content(int $content_id)
	{
		$builder = $this->db->table('content_translations');
		$builder->where('content', $content_id);
		$builder->set('active', '2');
		$builder->update();
	}


	/**
	 * update content order
	 * @param int $content_id
	 * @param int $content_order
	 */
	public function update_content_order(int $content_id, int $content_order)
	{
		$builder = $this->db->table('content_translations');
		$builder->where('content', $content_id);
		$builder->set('content_order', $content_order);
		$builder->update();
	}


	/**
	 * getting content order
	 * @param int $content_id
	 * @param string $lang
	 * @return result
	 */
	public function get_content_order(int $content_id, string $lang)
	{
		$builder = $this->db->table('content_translations');
		$builder->select('content_order');
		$builder->where('content', $content_id);
		$builder->where('language', $lang);
		$query = $builder->get();
		$row = $query->getRow();
		if (isset($row)) {
			return $row->content_order;
		}
		return 0;
	}
}
