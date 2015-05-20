<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /*	get photos/videos by tag */
    public function index()
    {
        $data['tag'] = $tag = ur(2);

        $data['meta_title'] = "Instagram photos for tag #$tag | Sharetagram";
        $data['meta_description'] = "Browse all Instagram photos tagged with #$tag. View likes and comments.";
        $data['meta_keywords'] = "Instagram, IG, web, viewer, stats, photo, video, Facebook, hashtag $tag";
        $data['meta_image'] = base_url() . 'images/logo_500.png';

        $data['title'] = "#$tag";

        $data['endpoint'] = "tag";
        $data['param'] = $tag;

        $data['content'] = 'view_media';
        $this->load->view('layout/dashboard_view', $data);
    }
}