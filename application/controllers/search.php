<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('instagram_model','instagram');		
		$this->load->model('mod_user','user');
		
		if (empty(session('ig_token'))) {
	        $this->instagram->setToken($this->user->getTokenUsed());
		} else {
			$this->instagram->setToken(session('ig_token'));
		}
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
        $keyword = trim(ur(3));
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

        $tags_search = $this->instagram->tagSearch($keyword);
        $users_search = $this->instagram->userSearch($keyword);

        if (!$tags_search && !$users_search) {
            redirect('api?url=search/'.urldecode($keyword));
        }

		if (property_exists($tags_search, 'code') || property_exists($users_search,'code')) {
			if($tags_search->code === 429 || $users_search === 429)
			redirect('limit');
		}

        $data['tags'] = $tags_search;
        $data['users'] = $users_search;

        $clean_keyword = urldecode($keyword);

        $data['meta_title'] = "Search Instagram for {$clean_keyword} | Sharetagram";
        $data['meta_description'] = "Find all Instagram hashtags and users matching the search $keyword";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook";
        $data['meta_image'] = 'static/images/logo_500.png';

        $data['keyword'] = $clean_keyword;

        $data['content'] = 'search/result';
        $this->load->view('layout/dashboard_view',$data);
    }

}
