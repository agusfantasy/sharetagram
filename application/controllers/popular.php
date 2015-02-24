<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Popular extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mod_instagram', 'M');
    }

    public function index()
    {
        $popular = $this->M->getPopular();

        if (!$popular) {
            redirect('api');
        }

        $data['meta_title'] = "Instagram Popular Photo - Sharetagram";
        $data['meta_description'] = "The best Instagram Popular Photo ";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, photo, video, Facebook";

        $data['title'] = 'Popular on Instagram';
        $data['next'] = '';

        $data['query'] = $popular;
        $data['content'] = 'popular/index';
        $this->load->view('layout/dashboard_view', $data);
    }
}