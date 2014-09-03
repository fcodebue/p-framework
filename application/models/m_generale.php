
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_generale extends CI_Model{

	//profilo
	function getUserInfo(){
		$id = $this->ion_auth->user()->row()->id;
		$this->db->select('
			users.id AS id,
			users.username AS username,
			users.first_name AS first_name,
			users.last_name AS last_name,
			users.email AS email,
			users.phone AS phone,
			clienti.ragione_sociale AS ragione_sociale
			');
		$this->db->join('clienti','users.id_cliente = clienti.id','left');
		$query = $this->db->get_where('users',array('users.id'=>$id));
		$data = $query->result_array();
		// print_r($id);
		return $data;

	}
	//utente

	function get_role($id_utente){
		if(isset($id_utente)){
			$data = array('user_id'=> $id_utente);
			$this->db->select('group_formazione_id');
			$query = $this->db->get_where('users_groups_formazione',$data);
			return $query->result_array();
		}else{
			return null;
		}
	}

	function dipendenze_user($id = null){
		$num_rows = 0;
		$table_field = array();
		$table_field[] = array('table' => 'users_groups_formazione', 'field' => 'user_id');
		// $table_field[] = array('table' => 'users_groups', 'field' => 'user_id');

		foreach ($table_field as $key) {
			$query = $this->db->get_where($key['table'],array($key['field'] => $id));
			if($query->num_rows > 0) return FALSE;
		}
		return TRUE;
	}

	function get_regioni(){
		$query = $this->db->get('regioni');
		$data = $query->result_array();
		return $data;
	}

	function get_company(){
		$this->db->select('id,ragione_sociale');
		$query = $this->db->get('clienti');
		$data = $query->result_array();
		return $data;
	}

	function get_nation(){
		$this->db->select('id,codice_nazione,nazione');
		$query = $this->db->get('nazioni');
		$data = $query->result_array();
		return $data;
	}

	function get_province(){
		$this->db->order_by("nomeprovincia", "asc");	
		$query = $this->db->get('province');
		$data = $query->result_array();
		return $data;	
	}

	function get_comuni($id_prov = null){
		if($id_prov){
			$this->db->where('id_provincia',intval($id_prov));
		}
		$this->db->order_by("nomecomune", "asc");
		$query = $this->db->get('comuni');
		$data = $query->result_array();
		return $data;
	}

	function get_email(){
		$this->db->select('email');
		$query = $this->db->get('users');
		return $data = $query->result_array();
	}

	function rec($username,$password,$additiona_data = array(), $groups = array(),$id_cdl){

		print_r($additiona_data);
	}

	function add_formapp_group($id_group = array(), $id_utente = null){
		// $data = array('user_id' => $id_utente,'group_formazione_id'=> $id_group );
		// $this->db->insert('users_groups_formazione',$data);
	}
	
	function listMyUser($id_cdl = null){
		$dt = array();
		$this->db->select('users.id, 
			users.first_name,
			users.last_name,
			users.email,
			users.phone,
			users.created_on,
			users.id_cliente,
			clienti.ragione_sociale as ragione_sociale
			',FALSE);
		$this->db->join('users_groups','users_groups.user_id = users.id','inner');
		$this->db->join('clienti','clienti.id = users.id_cliente','left');
		$this->db->where('users_groups.group_id',4);
		if($id_cdl){
			$this->db->where('id_consulente',$id_cdl);
		}
		$query = $this->db->get('users');
		$dt = array('sEcho'=> 1,'iTotalRecord' => $query->num_rows(),'iTotalDisplayRecord' => $query->num_rows(),
		'aaData' => $query->result_array() );
		// return $query->result_array();
		return $dt;
	}

	function test_dt(){
		$this->datatables
		->select('
			users.id as id, 
			users.first_name' )
		->from('users')
		->add_column('FORMAPP', '$1', 'formapp(users.id)');
		
		// return $this->datatables->generate('json','UTF-8','assoc');
		return $this->datatables->generate();
	}

	function formapp_cb(){
		$this->db->select('id,name,description');
		$query = $this->db->get('groups_formazione');
		$result_data = $query->result_array();
		$new_result = array();
		$checked = FALSE;
		foreach ($result_data as $item ) {
			$new_result[] = array('id_gruppo'=>$item['id'],
				'name' => $item['name'],
				'description' => $item['description'],
				'checked' => $checked 
				); 
			
		}
		return $new_result;
	}

	function load_formapp($id){
		$generale = $this->formapp_cb();

		$this->db->select('groups_formazione.id as id_gruppo,
			groups_formazione.name AS nome_gruppo,
			group_formazione_id AS valore_presente');
		$this->db->where('users_groups_formazione.user_id',$id);
		$this->db->join('groups_formazione','groups_formazione.id = users_groups_formazione.group_formazione_id','inner');
		$query = $this->db->get('users_groups_formazione');
		$dettaglio =  $query->result_array();
		// var_dump($dettaglio);
		$result = array();
		$checked = FALSE;

		foreach ($generale as $item_g) {
			if(!empty($dettaglio)){
				$checked = FALSE;
				foreach ($dettaglio as $item_d) {
					if(!empty($item_d) || !$item_d){
						if(intval($item_g['id_gruppo']) === intval($item_d['id_gruppo'])){

							if(isset($item_d['valore_presente']) || !empty($item_d['valore_presente'])){
								$checked = TRUE;
							
							}else{
								$checked = FALSE;
							}
						}
					}else{
						$checked = FALSE;
					}
				}
			}else{
				$checked = FALSE;
			}
			$result[] = array('user_id' => $id, 'id_gruppo' => $item_g['id_gruppo'],'name'=>$item_g['name'],'checked'=>$checked);
		}
		return $result;
	}

	function save_formapp($input = array()){
		foreach ($input as $key => $value) {
			$this->db->select('users_groups_formazione.id');
			$query = $this->db->get_where('users_groups_formazione',array('users_groups_formazione.user_id' => intval($value['user_id']),'users_groups_formazione.group_formazione_id' => intval($value['id_gruppo'])));
			if($value['checked']){
				if($query->num_rows() == 0){
					$data = array('user_id' => intval($value['user_id']),'group_formazione_id' => intval($value['id_gruppo']));
					$this->db->insert('users_groups_formazione',$data);
				}
			}else{
				if($query->num_rows() > 0){
					$row = $query->row();
					$this->db->delete('users_groups_formazione',array('users_groups_formazione.id' => intval($row->id)));
				}	
			}			
		}
	}

	//CUSTOMER

	function listMyCustomer($id_cdl = null){
		$this->db->select('users.id, 
			users.first_name,
			users.last_name,
			users.email,
			users.phone,
			users.company,
			users.created_on,
			users.id_cliente,
			users.id_cliente,
			clienti.partita_iva,
			clienti.ragione_sociale,
			clienti.codice_fiscale,
			clienti.telefono,
			clienti.fax,
			clienti.pec,
			clienti.website,
			clienti.mobile,
			clienti.ruolo,
			clienti.indirizzo,
			clienti.id_nazione,
			clienti.id_provincia,
			clienti.id_localita,
			users.created_on
			',FALSE);
		$this->db->join('users_groups','users_groups.user_id = users.id','inner');
		$this->db->join('clienti','clienti.id = users.id_cliente','inner');
		$this->db->where('users_groups.group_id',3);
		//ci sono ancora da fare le join su nomi delle id_nazione, id_provincie, id_localitò
		if($id_cdl){
			$this->db->where('users.id_consulente',$id_cdl);
		}
		$query = $this->db->get('users');
		return $query->result_array();
	}

	function register_customer($params = array()){
		foreach ($params as $key) {
			$data = array('codice_fiscale' => $params['codice_fiscale'],
				'email' => $params['email'], 'fax' => $params['fax'],
				'partita_iva' => $params['partita_iva'], 'ragione_sociale' => $params['ragione_sociale'],
				'indirizzo' => $params['indirizzo'], 'mobile' => $params['mobile'], 'pec' => $params['pec'],
				'ruolo' => $params['ruolo'],'website' => $params['website'], 'id_localita' => $params['id_localita'],
				'id_provincia' => $params['id_provincia'], 'id_nazione' => $params['id_nazione']);
		}

		$this->db->insert('clienti',$data);	
		$id_cliente = $this->db->insert_id();
		if($id_cliente){
			return $id_cliente;	
		}else{
			return FALSE;
		}
	}

	function update_clienti_customer($id_cliente,$user_id){
		$data = array('id_cliente'=>$id_cliente);
		$this->db->where('users.id', $user_id);
		$this->db->update('users', $data);
		if($this->db->affected_rows() != 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function update_customer($params = array()){
		$id = intval($params['id_cliente']);
		$data = array('codice_fiscale' => $params['codice_fiscale'],
				'email' => $params['email'], 'fax' => $params['fax'],
				'partita_iva' => $params['partita_iva'], 'ragione_sociale' => $params['ragione_sociale'],
				'indirizzo' => $params['indirizzo'], 'mobile' => $params['mobile'], 'pec' => $params['pec'],
				'ruolo' => $params['ruolo'],'website' => $params['website'], 'id_nazione' => $params['id_nazione'],
				'id_provincia' => $params['id_provincia']);
		$this->db->where('id',$id);
		$this->db->update('clienti',$data); 
		if($this->db->affected_rows() != 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function delete_cliente($id){
		$b = $this->db->count_all('clienti');
		$this->db->where('id', $id);
		$this->db->delete('clienti');
		$a = $this->db->count_all('clienti');
		if($b == $a){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	


}