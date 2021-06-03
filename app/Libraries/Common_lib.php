<?php

namespace App\Libraries;

use CodeIgniter\HTTP\RequestInterface;
use Config\Services;

//loading model
use App\Models\ContentGroupsModel;

class Common_lib
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
     * function converts a string into slug format
     * @param $text
     * @return string
     */
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

}