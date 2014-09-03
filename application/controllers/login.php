<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

	public function index($renderData="") {
   
		if ($this->ion_auth->logged_in()) {
			redirect('home/index');
		} else {
      $this->_render('login',$renderData);
    }
	}

	public function log_in() { 
		$username = $this->input->post('utente_codice', TRUE);
		$password = $this->input->post('utente_password', TRUE);
		$remember = TRUE;
		if ($this->ion_auth->login($username, $password, $remember)) {
			redirect('op/index');
		} else {
			redirect(base_url());
		}
	}

	public function log_out() {
		$this->ion_auth->logout();

		// $this->session->sess_destroy();
		//$this->_render('pages/home');
		redirect(base_url());
	}

	public function iscrizione() {
		$this->load->model('tabelle_model');
		$this->load->view('pages/iscrizione', $data);
	}

	public function profilo() {
		$this->load->model('user_model');
		$data['rs'] = $this->ion_auth_model->user()->result();
		$this->load->view('pages/profilo', $data);
	}

	public function save() {
		$id = $this->input->post('id', TRUE);
		if(!empty($id)) {
			$nascita = $this->input->post('data_nascita', TRUE);
			$carta_identita_emissione = $this->input->post('carta_identita_emissione', TRUE);
			$data = array(
				'first_name'				=> $this->input->post('first_name', TRUE),
				'last_name'					=> $this->input->post('last_name', TRUE),
				'sesso'						=> $this->input->post('sesso', TRUE),
				'data_nascita'				=> (!empty($nascita)) ? implode('-', array_reverse(explode('/', $nascita))) : NULL,
				'comune_nascita'			=> $this->input->post('comune_nascita', TRUE),
				'provincia_nascita'			=> $this->input->post('provincia_nascita', TRUE),
				'email_address'				=> $this->input->post('email_address', TRUE),
				'username'					=> $this->input->post('username', TRUE),
				'company'					=> $this->input->post('company', TRUE),
				'carta_identita'			=> $this->input->post('carta_identita', TRUE),
				'carta_identita_emissione'	=> (!empty($carta_identita_emissione)) ? implode('-', array_reverse(explode('/', $carta_identita_emissione))) : NULL,
				'codice_fiscale'			=> $this->input->post('codice_fiscale', TRUE),
				'mobile_phone'				=> $this->input->post('mobile_phone', TRUE),
				'phone'						=> $this->input->post('phone', TRUE),
				'attivita'					=> $this->input->post('attivita', TRUE),
				'descrizione_attivita'		=> $this->input->post('descrizione_attivita', TRUE),
				'liquidita_iva'				=> $this->input->post('liquidita_iva', TRUE),
				'iban'						=> $this->input->post('iban', TRUE),
				'gestione_per_cassa'		=> $this->input->post('gestione_per_cassa',TRUE),
			);

			if(strlen($this->input->post('password', TRUE)) > 0) $data['password'] = $this->input->post('password', TRUE);

			$this->ion_auth->update($this->input->post('id', TRUE), $data);
		} else {
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$email = $this->input->post('email_address', TRUE);

			if (!$this->ion_auth->username_check($username)) {
				$additional_data = array(
					'first_name' => $this->input->post('first_name', TRUE),
					'last_name' => $this->input->post('last_name', TRUE),
					'carta_identita' => $this->input->post('carta_identita', TRUE),
					'carta_identita_emissione' => $this->input->post('carta_identita_emissione', TRUE),
					'codice_fiscale' => $this->input->post('codice_fiscale', TRUE),
					'mobile_phone' => $this->input->post('mobile_phone', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'codice_attivita' => $this->input->post('codice_attivita', TRUE),
					'descrizione_attivita' => $this->input->post('descrizione_attivita', TRUE),
					'accettazione_contratto' => $this->input->post('accettazione_contratto', TRUE),
					'carta_credito_tipo' => $this->input->post('carta_credito_tipo', TRUE),
					'carta_credito_numero' => $this->input->post('carta_credito_numero', TRUE)
				);

				if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
					$this->load->dbforge();

					if ($this->dbforge->create_database("`".$username."`")) {
						$config['hostname'] = $this->db->hostname;
						$config['username'] = $this->db->username;
						$config['password'] = $this->db->password;
						$config['database'] = $username;
						$config['dbdriver'] = $this->db->dbdriver;
						$config['dbprefix'] = $this->db->dbprefix;
						$config['pconnect'] = $this->db->pconnect;
						$config['db_debug'] = $this->db->db_debug;
						$config['cache_on'] = $this->db->cache_on;
						$config['cachedir'] = $this->db->cachedir;
						$config['char_set'] = $this->db->char_set;
						$config['dbcollat'] = $this->db->dbcollat;
						$config['swap_pre'] = $this->db->swap_pre;
						$config['autoinit'] = $this->db->autoinit;
						$config['stricton'] = $this->db->stricton;

						$this->load->database($config, TRUE, TRUE);

						$command = "mysql -u".$this->db->username." -p".$this->db->password." -h ".$this->db->hostname." -D ".$username." < ";

						shell_exec($command . Q_DB_FILES . "user_db.sql");

						redirect('');
					}
				} else {
					redirect('c_login/iscrizione');
				}
			} // ALTRIMENTI SEGNALA CHE ESISTE GIA' UTENTE
		}
	}

}

/* End of file login.php */
/*   Location: ./application/controllers/login.php */