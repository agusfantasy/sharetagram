<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller
{
	public function __construct()
    {
		parent::__construct();
	}

    public function index()
    {
		$data['meta_title'] = "Sharetagram - Instagram web viewer online"; 
		$data['meta_description'] = "The best Instagram web viewer online, browse popular photos, tags, users.";
		$data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";
		$data['meta_image'] = '/images/logo_500.png';

        $data['content'] = 'home/home_index';
		$this->load->view('layout/dashboard_view',$data);
	}
}
