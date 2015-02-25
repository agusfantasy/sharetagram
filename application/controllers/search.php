<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('InstagramModel','model');
        $this->model->setToken(instagram_token());
    }

    public function index()
    {
        $data['meta_title'] = "Search Instagram Photos, Hashtags and Users | Sharetagram";
        $data['meta_description'] = "Search Instagram online. The best Instagram search engine for photos, videos, hashtags and users.";
        $data['meta_keywords'] = "Instagram search, Instagram search engine, Instagram search users, Instagram search hashtags, Instagram search photos, search Instagram, Instagram search videos";
        $data['meta_image'] = base_url().'images/logo_500.png';

        $data['content'] = 'search/index';
        $this->load->view('layout/dashboard_view',$data);
    }

    public function search_post()
    {
        $keyword = ur(3);
        if (empty($keyword)) {
            redirect(site_url());
        }
        redirect("search/q/$keyword","refresh");
    }

    public function q()
    {
        $keyword = ur(2);
        if (empty($keyword)) {
            redirect('index404');
        }

        $tags_search = $this->model->tagSearch($keyword);
        $users_search = $this->model->userSearch($keyword);
        if  (!$tags_search && !$users_search) {
            redirect('api?url=search/'.urldecode($keyword));
        }

        $data['tags'] = $tags_search;
        $data['users'] = $users_search;

        $data['meta_title'] = "Search Instagram for $keyword | Sharetagram";
        $data['meta_description'] = "Find all Instagram hashtags and users matching the search $keyword";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";
        $data['meta_image'] = base_url() . 'images/logo_500.png';

        $data['keyword'] = urldecode($keyword);

        $data['content'] = 'search/result';
        $this->load->view('layout/dashboard_view',$data);
    }

}
