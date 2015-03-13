<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{		
		parent::__construct();
	}

    public function index()
	{		
		echo '<h1>Authorize</h1>';	
		echo "<pre>";print_r($this->session->all_userdata());echo "</pre>";
	}
	
	public function login()
    {
		//save url before login to session for callback after instagram login
 		if( $this->input->get('url') ){
			//redirect( $this->input->get('url') );
			$this->session->set_userdata('url_before_login',$this->input->get('url'));
		}		
		header("Location:".$this->instagram_api->instagramLogin());	
	}
	
	/*
	 * Function for the Instagram callback url
	 */
	public function get_code()
	{	
		// Make sure that there is a GET variable of code
		if(isset($_GET['code']) && $_GET['code'] != '') 
		{			
			$auth_response = $this->instagram_api->authorize($_GET['code']);
			
			// Set up session variables containing some useful Instagram data
			$this->session->set_userdata('ig-token', $auth_response->access_token);
			$this->session->set_userdata('ig-username', $auth_response->user->username);
			$this->session->set_userdata('ig-avatar', $auth_response->user->profile_picture);
			$this->session->set_userdata('ig-id', $auth_response->user->id);
			$this->session->set_userdata('ig-fullname', $auth_response->user->full_name);
			
			$this->load->model('mod_user','U');
			$check_user = $this->U->getDetail('ig_id',$auth_response->user->id);
			if( count($check_user)==0 ){
				$data = array(
					'ig_username' => $auth_response->user->username,
					'ig_id' => $auth_response->user->id,
					'user_fullname' => $auth_response->user->full_name,
					'time_add' => date('Y-m-d H:i:s')
				);			
				$q = $this->U->add($data);
				if(!$q){return FALSE;}
			}
			//cek id 
			$check_user2 = $this->U->getDetail('ig_id',$auth_response->user->id);
			$this->session->set_userdata('user-id', $check_user2->user_id);			
			
			if( $this->session->userdata('url_before_login')!='' ){
				$url = $this->session->userdata('url_before_login');
				redirect($url);
			}	
			else{
				redirect(site_url());
			}	
		}
	}	
	
	public function logout()
    {
		$array_items = array(
			'ig-token' => '',
			'ig-username' =>'',
			'ig-avatar' => '',
			'ig-id' => '',
			'ig-fullname' => '',
			'user-id' => ''
		);
		$this->session->unset_userdata($array_items);
		$url = $this->input->get('url');
		if($url!=''){
			redirect($url);
		}else{
			redirect(site_url());
		}
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */