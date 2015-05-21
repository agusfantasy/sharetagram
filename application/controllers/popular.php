<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Popular extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['meta_title'] = "Instagram Popular Photo - Sharetagram";
        $data['meta_description'] = "The best Instagram Popular Photo ";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, photo, video, Facebook";

        $data['title'] = 'Popular on Instagram';

        $data['endpoint'] = 'popular';
        $data['param'] = '';
        
        $data['content'] = 'view_media';
        $this->load->view('layout/dashboard_view', $data);
    }
}
