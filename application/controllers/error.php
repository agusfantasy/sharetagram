<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class error extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index404()
    {
        $data['meta_title'] = "404 not found";

        $data['error'] = "This page doesn't exist!";
        $data['link'] = site_url();
        $data['back_text'] = 'Go back to Sharetagram';
        $data['content'] = 'layout/error_api_v';
        $this->load->view('layout/dashboard_view',$data);
    }

    public function instagramApi()
    {
        $data['meta_title'] = "Instagram time out";
        $data['link']  = base_url().$this->input->get('url') ;
        $data['error'] = "Sorry, an error occurred loading this content.<br>(Instagram could not be reached)";
        $data['back_text'] = 'Try again';
        $data['content'] = 'layout/error_api_v';
        $this->load->view('layout/dashboard_view',$data);
    }
}