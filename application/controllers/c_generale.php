<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_generale extends MY_Controller
{
	function __construct(){
		parent::__construct();
		$_ID_MODULO = 4;
		$this->load->model('m_dashboard');
        $this->m_dashboard->user_check($_ID_MODULO);

	}

	//PROFILO

	function init_profilo(){
		$this->javascript[] = 'angular.min.js';
		$this->javascript[] = 'ui-bootstrap-tpls-0.11.0.js';
		$this->javascript[] = 'angular-strap.min.js';
		$this->javascript[] = 'angular-strap.tpl.js';
		$this->javascript[] = 'classes/generale_app.js';
		$this->javascript[] = 'validator.min.js';
 		$this->javascript[] = 'classes/spin.js';
	}

	function profilo(){
		$this->init_profilo();
		$this->load->model('m_generale');
		
		$nome = $this->ion_auth->user()->row()->first_name;
		$cognome = $this->ion_auth->user()->row()->last_name;
		
		$this->data['nome'] = $nome;
		$this->data['cognome'] = $cognome;

		$this->title =  $nome . ' ' . $cognome;
		$this->_render('generale/w_profilo.php');
	}

	function getUserInfo(){
		$this->load->model('m_generale');
		$data = $this->m_generale->getUserInfo();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}

	function saveProfile(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$edit = $serializer->unserialize($json);

		if(isset($edit)){
			$id = intval($edit['id']);
			$data = array('first_name' => $edit['first_name'],
				'last_name'=>$edit['last_name'], 'email'=>$edit['email']);
			if(array_key_exists('password',$edit)){
				$data['password'] = $edit['password']; 
			}
			if(array_key_exists('phone', $edit)){
				$data['phone'] = $edit['phone'];
			}
			if($this->ion_auth_model->update($id,$data)){
				$return = array('title'=>'Aggiornamento profilo utente','content'=>'Aggiornamento profilo utente completato','type'=>'success');
			}else{
				$return = array('title'=>'Errore Aggiornamento profilo utente','content'=>'','type'=>'danger');
			}
		}else{
			$return = array('title'=>'Errore Aggiornamento profilo utente','content'=>'','type'=>'danger');
			
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));

	}

	//GENERALE

	function test(){
		$this->title="test";
		$this->init();
		$this->javascript[] = 'classes/generale_test.js';	
		$this->_render('generale/w_test.php');
	}

	function init(){
		$this->javascript[] = 'angular.min.js';
		$this->javascript[] = 'ui-bootstrap-tpls-0.11.0.js';
		$this->javascript[] = 'angular-strap.min.js';
		$this->javascript[] = 'angular-strap.tpl.js';
		$this->javascript[] = 'classes/spin.js';
		$this->javascript[] = 'jquery.dataTables.min.js';
		$this->javascript[] = 'classes/generale_list.js';
		$this->javascript[] = 'classes/generale_clienti_list.js';
		$this->javascript[] = 'classes/generale_app.js';	
		$this->javascript[] = 'validator.min.js';
		$this->css[] = 'dataTables.bootstrap.css';
	}

	function index(){
		$this->init();
		$this->title = "Generale";
		
		$this->_render('generale/w_generale.php');
	}

	function get_nation(){
		$this->load->model('m_generale');
		$data = $this->m_generale->get_nation();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_province(){
		$this->load->model('m_generale');
		$data = $this->m_generale->get_province();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_regioni(){
		$this->load->model('m_generale');
		$data = $this->m_generale->get_regioni();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_comuni(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);

		$this->load->model('m_generale');
		$data = $this->m_generale->get_comuni($input);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	//USERS

	function register_user(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$user = $serializer->unserialize($json);	

		$additional_data = array(
			'first_name' => $user['first_name'],
			'last_name' => $user['last_name'],
			'phone' => $user['phone'],
			'company' =>"",);

		$username = $user['first_name'] . ' ' . $user['last_name'];
		$email = $user['email'];
		$password = $user['password'];
		$id_cdl = $this->ion_auth->user()->row()->id;
		if(isset($user['company']['id'])){
			$id_cliente = $user['company']['id'];
		}else{
			$id_cliente = null;
		}

		$this->load->model('ion_auth_model');
		$groups = array(4);
		$new_id = $this->ion_auth_model->register($username,$password,$email,$additional_data,$groups,$id_cdl,$id_cliente);
		if($new_id){
			$return = array('status'=>'success','msg'=>'contatto aggiunto correttamente.');	
		}else{
			$return = array('status'=>'danger','msg'=>'Errore, contatto non creato.');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	function update_user(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$user = $serializer->unserialize($json);	

		if(isset($user['company']['id'])){
			$id_cliente = $user['company']['id'];
		}else{
			$id_cliente = null;
		}

		$id = intval($user['id']);
		$additional_data = array(
			'first_name' => $user['first_name'],
			'last_name' => $user['last_name'],
			'phone' => $user['phone'],
			'id_cliente' =>$id_cliente,);
		$this->load->model('ion_auth_model');
		$update = $this->ion_auth_model->update($id,$additional_data);
		if($update){
			$return = array('status'=>'success','msg'=>'contatto modificato correttamente.');	
		}else{
			$return = array('status'=>'danger','msg'=>'Errore, contatto non modificato.');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	function delete_user(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$users = $serializer->unserialize($json);	
		
		$this->load->model('ion_auth_model');
		$this->load->model('m_generale');
		
		foreach ($users as $key ) {
			$id = intval($key['id']);
			$passOver = $this->m_generale->dipendenze_user($id);
			if($passOver){
				if($this->ion_auth_model->delete_user($id)){
					$return = array('status'=>'success','msg'=>'contatto/i eliminato correttamente.');					
				}else{
					$return = array('status'=>'danger','msg'=>'impossiblie eliminare contatto.');
				}		
			}else{

				$return = array('status'=>'danger','msg'=>'impossiblie eliminare contatto, controllare le dipendenze.');
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	function test_dt(){
		$this->load->model('m_generale');
		$data = $this->m_generale->test_dt();
		print_r($data);
	}

	function get_company(){
		$this->load->model('m_generale');
		$data = $this->m_generale->get_company();

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function email_check(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);

		$email = $input['email'];
 
		$data = $this->ion_auth_model->email_check($email);
		if($data == NULL){
			echo TRUE;
		}else{
			echo FALSE;
		}
	}

	function get_email(){
		$this->load->model('m_generale');
		$data = $this->m_generale->get_email();
		echo json_encode($data);
	}

	//carica modello generale
	function formapp_cb(){
		$this->load->model('m_generale');
		$data = $this->m_generale->formapp_cb();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	// carica la formazione per que
	function load_formapp(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);
		// $input = 13;
		$this->load->model('m_generale');
		$data = $this->m_generale->load_formapp($input);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function save_formapp(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$input = $serializer->unserialize($json);

		$this->load->model('m_generale');
		$this->m_generale->save_formapp($input);	
	}

	function listMyUser(){
		$id_utente = $this->ion_auth->user()->row()->id;
		$id_gruppo = $this->ion_auth->get_users_groups()->row()->id;
		$this->load->model('m_generale');
		if($id_gruppo == 1){	
			$utenti = $this->m_generale->listMyUser();
		}else{
			$utenti = $this->m_generale->listMyUser($id_utente);
		}
		// $aaData['data'] = $utenti;

		$this->output->set_content_type('application/json')->set_output(json_encode($utenti));
	}

	//CUSTOMER

	function listMyCustomer(){
		$id_utente = $this->ion_auth->user()->row()->id;
		$id_gruppo = $this->ion_auth->get_users_groups()->row()->id;
		$this->load->model('m_generale');
		if($id_gruppo == 1){
			$customers = $this->m_generale->listMyCustomer();
		}else{
			$customers = $this->m_generale->listMyCustomer($id_utente);
		}
		$aaData['data'] = $customers;
		$this->output->set_content_type('application/json')->set_output(json_encode($aaData));
	}

	function registerCustomer(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$customer = $serializer->unserialize($json);	

		$additional_data = array(
			'first_name' => $customer['first_name'],
			'last_name' => $customer['last_name'],
			'company' => $customer['ragione_sociale'],
 		);
 		$email = $customer['email'];
 		$password = $customer['password'];
 		$username = $customer['first_name'] . ' ' .$customer['last_name'];
 		$groups = array(3);
 		
 		$id_cdl = $this->ion_auth->user()->row()->id;
 		$new_id = $this->ion_auth_model->register($username,$password,$email,$additional_data,$groups,$id_cdl);

 		if($new_id){
 			$this->load->model('m_generale');
 			$id_cliente = $this->m_generale->register_customer($customer);
 			if($id_cliente){
 				if($this->m_generale->update_clienti_customer($id_cliente,$new_id)){
 					$return = array('status'=>'success','msg'=>'cliente aggiunto correttamente.');
 				}else{
 					$return = array('status'=>'danger','msg'=>'impossibile aggiungere cliente.');
 				}
 			}else{
				$return = array('status'=>'danger','msg'=>'impossibile aggiungere cliente.');
 			}
 		}
 		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	function updateCustomer(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$customer = $serializer->unserialize($json);	
		$this->load->model('m_generale');

		$id = intval($customer['id']);
		$additional_data = array(
			'first_name' => $customer['first_name'],
			'last_name' => $customer['last_name'],
			'phone' => $customer['phone'],
			'company' =>$customer['company']);
		$this->load->model('ion_auth_model');
		$update = $this->ion_auth_model->update($id,$additional_data);	
		if($update){
			if($this->m_generale->update_customer($customer)){
				$return = array('status'=>'success','msg'=>'cliente modificato correttamente.');
			}else{
				$return = array('status'=>'danger','msg'=>'impossibile modificare cliente.');
			}
		}else{
			$return = array('status'=>'danger','msg'=>'impossibile modificare cliente.');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	function deleteCustomer(){
		$json = file_get_contents('php://input');
		$serializer = new Zumba\Util\JsonSerializer();
		$customer = $serializer->unserialize($json);	
		
		$this->load->model('ion_auth_model');
		$this->load->model('m_generale');

		foreach ($customer as $key) {
			$id = intval($key['id']);
			$id_cliente = intval($key['id_cliente']);
			$response = $this->ion_auth_model->delete_user($id);
			$res = FALSE;
			if($response){
				$res = $this->m_generale->delete_cliente($id_cliente);	
			}
			if($res){
				$return = array('status'=>'success','msg'=>'cliente eleminato con successo.');
			}else{
				$return = array('status'=>'danger','msg'=>'impossiblie eliminare cliente.');
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

}