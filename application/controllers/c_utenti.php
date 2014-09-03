<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_utenti extends My_Controller
{

	function __construct(){
		parent::__construct();
		$this->load->model('m_dashboard');
		$_ID_MODULO = 4;
		$this->load->helper('language');
		$this->load->helper('general_helper');
		$this->load->model('m_utenti');	
		$this->lang->load('utenti');

	}

	function index(){
				
	}

	function init(){
		$this->css[] = '../js/angular_colorPicker/css/colorpicker.css';
		$this->css[] = 'xeditable.css';
		$this->javascript[] = 'angular.min.js';
		$this->javascript[] = 'ckeditor/ckeditor.js';
		$this->javascript[] = 'xeditable.min.js';
		$this->javascript[] = 'ui-bootstrap-tpls-0.11.0.js';
		$this->javascript[] = 'angular_colorPicker/js/bootstrap-colorpicker-module.js';
		$this->javascript[] = 'classes/utenti_setting.js';
		$this->javascript[] = 'classes/utenti_setting_app.js';
		$this->javascript[] = 'classes/utenti_generalCtrl.js';
		$this->javascript[] = 'classes/utenti_calendarioCtrl.js';
		$this->javascript[] = 'classes/utenti_contactCtrl.js';
		$this->javascript[] = 'classes/utenti_mailCtrl.js';
		$this->javascript[] = 'classes/utenti_apprendistaCtrl.js';
		$this->javascript[] = 'classes/utenti_tirocinanteCtrl.js';
	}

	function setting(){
		$this->init();
		$this->lang->load('utenti');
		$this->title= lang('user_title');
		if(is_logged_in()){
			$this->_render('utenti/w_user_setting');
		}else{
			redirect(base_url());
		}
	}
	
	//GENERALE

	function get_dateformat(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$type = $serializer->unserialize($json);	
		
		$data = $this->m_utenti->get_dateformat($type);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}	

	function get_timezone(){
		$data = $this->m_utenti->get_timezone();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_defaultModule(){
		$data = $this->m_utenti->get_defaultModule();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_language(){
		$data = $this->m_utenti->get_language();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}

	function get_generalSetting(){
		$data = $this->m_utenti->get_generalSetting();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}

	function save_general(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);
		if(isset($input)){
			$this->m_utenti->save_general($input);
		}
	}

	//CALENDARIO

	function get_days(){
		$data = $this->m_utenti->get_days();
		$arrayName = array();
		foreach ($data as $key) {
			$giorno = $key['giorno'];
			$arr = array('id' => $key['id'], 'giorno' => $this->lang->line($giorno),'visible' => TRUE);
			$arrayName[] = $arr;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($arrayName));
	}

	function get_defaultCalendarOption(){
		$data = $this->m_utenti->get_defaultCalendarOption();
		$arrayName = array();
		foreach ($data as $row) {
			$desc = $row['description'];
			$arr = array('id' => $row['id'], 'name'=> $this->lang->line($desc), 'type'=> $row['type']);
			$arrayName[] = $arr;
		} 
		$this->output->set_content_type('application/json')->set_output(json_encode($arrayName));
	}

	function get_calendarCategories(){
		$data = $this->m_utenti->get_calendarCategories();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_calendarSetting(){
		$data = $this->m_utenti->get_calendarSetting();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	// function test_time(){
	// 	$json = file_get_contents('php://input');
	// 	$serializer = new Zumba\Util\JsonSerializer();
	// 	$time= $serializer->unserialize($json);	

	// 	print_r($time);
	// 	print_r('<br><br>');
	// 	$data = date("H:i:s",strtotime($time));

	// 	$this->m_utenti->test_time($data);
	// }

	function save_calendar(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);
		print_r($input);
		if(isset($input)){
			if(isset($input['calendar_setting']) && count($input['calendar_setting']) > 0){
				$this->m_utenti->save_calendar_setting($input['calendar_setting']);
				print_r($input['calendar_setting']);
			}

			if(isset($input['calendar_categories']) && count($input['calendar_categories']) > 0){
				print_r($input['calendar_categories']);
				foreach ($input['calendar_categories'] as $key) {
						$this->m_utenti->save_calendar_categories($key);
				}
			}

			if(isset($input['delete_categories']) && count($input['delete_categories']) > 0){
				// print_r($input['delete_categories']);
				foreach ($input['delete_categories'] as $key) {
					$this->m_utenti->delete_calendarCategories($key);
				}
			}

		}
	}

	//CONTACT

	function get_contactCategories(){
		$data = $this->m_utenti->get_contactCategories();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function save_contactCategories(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);
		if(isset($input)){
			if(isset($input['delete_category']) && count($input['delete_category']) > 0){
				print_r('delete');
				foreach ($input['delete_category'] as $key) {
					$this->m_utenti->detele_contactCategories($key);
				}
			}

			if(isset($input['contact_category']) && count($input['contact_category']) > 0 ){
				print_r('add or update');
				foreach ($input['contact_category'] as $key) {
					$this->m_utenti->save_contactCategories($key);
				}
			}
		}
	}

	//MAIL

	function get_defaultMailSetting(){
		$data = $this->m_utenti->get_defaultMailSetting();
		$arrayName = array();
		foreach ($data as $row) {
			$name = $row['name'];
			if($row['description'] != null){
				$description = $this->lang->line($row['description']);
			}else{
				$description = $row['description'];
			}
			$arr = array('id' => $row['id'], 'name' => $this->lang->line($name), 'desc' => $description, 'type' => $row['type']);
			$arrayName[] = $arr;	
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($arrayName));
	}

	function get_emailSettingById(){
		$data = $this->m_utenti->get_emailSettingById();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function saveMyAccount(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);

		if(isset($input)){
			$data = $this->m_utenti->saveMyAccount($input);
		}

		if($data != null){
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}		
	}

	function deleteAccount(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);

		if(isset($input)){
			$this->m_utenti->deleteAccount($input);
		}		
	}

	//IMAP controllare se si utilizzano ancora

	function get_defaultImapSetting(){
		$data = $this->m_utenti->get_defaultImapSetting();
		$arrayName = array();
		foreach ($data as $row ) {
			$name = $this->lang->line($row['name']);
			if($row['description'] != null){
				$description = $this->lang->line($row['description']);
			}else{
				$description = $row['description'];	
			}
			$arr = array('id' => $row['id'], 'name' => $name,'description'=>$description,'type'=>$row['type']  );
			$arrayName[] = $arr;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($arrayName));
	}


}