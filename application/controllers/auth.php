<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{		
		parent::__construct();
        $this->load->model('instagram_model', 'instagram');
	}
	
	public function login()
    {
		//save url before login to session for callback after instagram login
 		$this->session->unset_userdata('url_before_login');
        $this->session->set_userdata('url_before_login', get('url'));

		header("Location:".$this->instagram->login());
	}
	
	/*
	 * Function for the Instagram callback url
	 */
	public function get_code()
	{	
		// Make sure that there is a GET variable of code
		if (isset($_GET['code']) && $_GET['code'] != '')
		{			
			$auth_response = $this->instagram->auth($_GET['code']);
			
			// Set up session variables containing some useful Instagram data
			$this->session->set_userdata('ig_token', $auth_response->access_token);	
			$this->session->set_userdata('ig_username', $auth_response->user->username);
			$this->session->set_userdata('ig_avatar', $auth_response->user->profile_picture);
			$this->session->set_userdata('ig_id', $auth_response->user->id);
			
			$this->load->model('mod_user','U');
			$check_user = $this->U->getDetail('ig_id', $auth_response->user->id);			
			
			$data = [
				'ig_token' => $auth_response->access_token,
				'ig_username' => $auth_response->user->username
			];
			
			if ( count($check_user) == 0 ) {
				$data = [
					'ig_id' => $auth_response->user->id,			
					'time_add' => date('Y-m-d H:i:s')
				];
				$q = $this->U->add($data);
			} else {
				$q = $this->U->update('ig_id', $auth_response->user->id, $data);
			}

            if (strpos($this->session->userdata('url_before_login'), site_url())===0) {
                redirect('feed');
            }
            redirect($this->session->userdata('url_before_login'));
		}

		redirect('auth/login');
	}	
	
	public function logout()
    {
		$array_items = [
			'ig_token' => '',
			'ig_username' =>'',
			'ig_avatar' => '',
			'ig_id' => '',
			'user_id' => '',
            'url_before_login' => ''
		];

		$this->session->unset_userdata($array_items);
		$url = $this->input->get('url');
		if ($url != '') {
			redirect($url);
		}
		redirect(site_url());
	}
}