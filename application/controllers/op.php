<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_op extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('login');
		}
	}

  public function index($renderData="") {
    $this->title = "Care Orasilavora";
    
		$data['utente'] = $this->ion_auth_model->user();
		$utente = $data['utente']->result();
		$data['utente'] = $utente[0];

		$this->session->set_userdata($data);
/*
		$this->load->model('riepilogo_model');
    // carica dati situazione economica
		$data['situazione'] = $this->riepilogo_model->situazione_economica($this->session->userdata('user_id'));
    // carica dati controllo per profesionista
		$data['professionista'] = $this->riepilogo_model->controllo_professionista();
    // carica ultimi ricavi inseriti
    $data['ultime_scadenze_fiscali'] = $this->riepilogo_model->ultime_scadenze_fiscali();
    // carica esercizi fiscali
		$data['years'] = $this->riepilogo_model->get_financial_years();
    // carica ultimi ricavi inseriti
    $data['ultimi_ricavi'] = $this->riepilogo_model->ultimi_ricavi();
    // carica ultimi costi inseriti
    $data['ultimi_costi'] = $this->riepilogo_model->ultimi_costi();
    // carica ultimi scadenze inseriti
    $data['ultime_scadenze'] = $this->riepilogo_model->ultime_scadenze();
*/
		$this->_render('pages/home', $renderData);
	}


	public function profile_edit(){
		$this->load->model('user_model');
		$this->load->library('Ion_auth');
		$user = $this->ion_auth->get_user();
		echo $user->username;

		$renderData['extra_datas'] = $this->user_model->profilo_edit($user->username);
    $this->_render('pages/profilo', $renderData);
	}  

 
  
 
}

/* End of file op.php */
/*   Location: ./application/controllers/op.php */