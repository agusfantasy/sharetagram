<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ig extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null){
		$this->load->view('admin/ig_v.php',$output);
	}

	public function offices(){
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}

	public function index(){
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	public function all(){
		try{
			$crud = new grocery_CRUD();
			$table = ur(4);
			if($table!=''){
				$crud->set_table($table);
				$output = $crud->render();
			}else{
				echo "Please provide table name";
			}

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	public function info(){
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('info');
			$crud->set_subject('Info');
			$crud->unset_columns('time_add');
			$crud->unset_fields('time_add','time_update');
			
			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	public function contest(){
		try{
			$crud = new grocery_CRUD();

			//$crud->set_theme('datatables');
			$crud->set_table('contest');
			$crud->set_subject('Contest');
			//$crud->unset_columns('time_add');
			$crud->unset_fields('time_add','time_update');
			
			$crud->required_fields('contest_name','contest_fullname','contest_image','contest_banner');
			$crud->set_field_upload('contest_image','files/contest/');
			$crud->set_field_upload('contest_banner','files/contest/');
			
			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	public function contest_user(){
		try{
			$crud = new grocery_CRUD();

			//$crud->set_theme('datatables');
			$crud->set_table('contest_user');
			$crud->set_subject('Contest User');
			$crud->unset_edit();$crud->unset_delete();
			
			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	public function user(){
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('user');
			$crud->set_subject('User');
			
			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

}
