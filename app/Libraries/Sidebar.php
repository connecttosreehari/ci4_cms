<?php

namespace App\Libraries;

use CodeIgniter\HTTP\RequestInterface;
use Config\Services;

//loading model
use App\Models\ContentGroupsModel;

class Sidebar
{
    /**
     * Request instance. So we can get access to the files.
     *
     * @var \CodeIgniter\HTTP\RequestInterface
     */
    protected $request;

    //--------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request = null)
    {
        if (is_null($request)) {
            $request = Services::request();
        }

        $this->request = $request;
    }


    /**
     * generate content sidebar menu
     */
    public function content_groups()
    {
        // assigning model
        $content_groups_model = new ContentGroupsModel();
        $content_group_menu = '';
        $data = [];
        $content_groups = $content_groups_model->where(['active' => 1, 'related_groups!=' => ''])->orderBy('group_order', 'ASC')->orderBy('id', 'ASC')->findAll();
        $content_related_groups = '';
        if (!$content_groups) {
            $content_groups = $content_groups_model->where(['active' => 1])->orderBy('group_order', 'ASC')->orderBy('id', 'ASC')->findAll();
        }
        if ($content_groups) {
            foreach ($content_groups as $content_group) {
                $data['content_group'] = $content_group;
                $data['content_related_groups'] = null;
                $related_group_ids = [];
                if ($content_group->related_groups) {
                    $related_group_ids = explode(',', $content_group->related_groups);
                    $content_related_groups = $content_groups_model->where(['active' => 1])->whereIn('id', $related_group_ids)->orderBy('group_order', 'ASC')->orderBy('id', 'ASC')->findAll();
                    $data['content_related_groups'] = $content_related_groups;
                }
                $data['related_group_ids'] = $related_group_ids;
                $data['content_group'] = $content_group;
                $content_group_menu .= view("admin/layouts/sidebar_content_group", $data);
            }
        }
        return $content_group_menu;
    }
}
