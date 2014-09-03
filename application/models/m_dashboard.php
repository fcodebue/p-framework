<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model{

	/* 
	********************
	Author: Pietro 
    last edit 12/2/2014
    ********************
    */


    //controlla se l'utente corrente può accedere al modulo passato
    //in caso contrario esegue logout + session destroy e redirect alla dashboard
	function user_check($id_modulo){

		//$id_gruppo = $this->ion_auth->user()->row()->id;
		$id_utente = $this->ion_auth->user()->row()->id;
			
		$id_gruppo = $this->ion_auth->get_users_groups()->row()->id;
		
		if($this->ion_auth->logged_in() AND !empty($id_modulo)){

			$this->db->where('id_groups', $id_gruppo);
      		$this->db->where('id_modulo',$id_modulo);
			$query = $this->db->get('groups_moduli');
			$query->num_rows();

			if(!$query > 0){
				$this->ion_auth->logout();
				$this->session->sess_destroy();
				redirect(base_url());
			}
			
		}else{
			$this->ion_auth->logout();
			$this->session->sess_destroy();
			redirect(base_url());
		}

	}


	//metodo che viene richamato da MY_Controller
    //ritorna un array dei moduli attivati per utente correntr
	public function getModule(){

		if($this->ion_auth->logged_in()){

			$id_utente = $this->ion_auth->user()->row()->id;
			
			$id_gruppo = $this->ion_auth->get_users_groups()->row()->id;

			$myQuery = 'SELECT gm.id, gm.id_modulo ,m.modulo,m.indirizzoModulo,m.moduloHtml
			FROM groups_moduli AS gm
			INNER JOIN moduli AS m ON gm.id_modulo = m.id
			WHERE gm.id_groups = '.$id_gruppo.' ORDER BY m.order';

			$query = $this->db->query($myQuery);
			return $query->result_array();

		}else{
			return null;
		}
	}

	/*
	metodo che viene richamato da MY_Controller
    ritorna un'array delle operazioni consentite all'utente per il modulo passato
    */
	function getSubModule($arrayModuli){

		if($this->ion_auth->logged_in()){

			
			$id_utente = $this->ion_auth->user()->row()->id;
			
			$id_gruppo = $this->ion_auth->get_users_groups()->row()->id;
			// print_r($id_gruppo);
			
			for ($i = 0; $i < count($arrayModuli) ; $i++) {

				$currentIdModulo = $arrayModuli[$i]['id_modulo'];
				$currentHtmlModulo = $arrayModuli[$i]['moduloHtml'];


				$myQuery = 'SELECT id, submodulo, indirizzo, icon
				FROM operazionimoduli 
				WHERE id_groups >='.$id_gruppo.'
				AND id_modulo = '.$currentIdModulo;
				$query = $this->db->query($myQuery);
				$limit = $query->num_rows();
				
				for ($c=0; $c < $limit ; $c++ ) { 
	 				$response[$currentHtmlModulo][$c] = $query->row_array($c);
				}
			}

			return $response;

		}else{
			return null;
		}

	}



}