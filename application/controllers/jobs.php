<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('instagram_model','instagram');
		$this->load->model('mod_user','user');
    }

    public function setTokenActive()
    {
		$tokens = $this->user->getTokens();
		foreach($tokens as $token) {
			$this->user->setTokenUsed($token->ig_id, $this->checkTokenLimit($token->ig_token));
		}				
    }
	
	/*
	* Check Token Limit
	*/
	private function checkTokenLimit($token)
	{		
		$this->instagram->setToken($token);
		
		$users = $this->instagram->getUser('1315524220');
		
		if (property_exists($users, 'code')) {
			if ($users->code === 429) {
				return false;
			}
		}		
		return true;
	}

}