<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('convert_date'))
{
	function convert_date($date) {
		return implode('/', array_reverse(explode('-', $date)));
	}
}

if ( ! function_exists('currency_format'))
{
	function currency_format($currency) {
		return number_format($currency, 2, ',', '.');
	}
}

if ( ! function_exists('convert_iva_code'))
{
	function convert_iva_code($code) {
		switch($code) {
			case 6001: return 'Gennaio'; break;
			case 6002: return 'Febbraio'; break;
			case 6003: return 'Marzo'; break;
			case 6004: return 'Aprile'; break;
			case 6005: return 'Maggio'; break;
			case 6006: return 'Giugno'; break;
			case 6007: return 'Luglio'; break;
			case 6008: return 'Agosto'; break;
			case 6009: return 'Settembre'; break;
			case 6010: return 'Ottobre'; break;
			case 6011: return 'Novembre'; break;
			case 6012: return 'Dicembre'; break;
			case 6013: return 'Acconto IVA'; break;
			case 6031: return 'I Trimestre'; break;
			case 6032: return 'II Trimestre'; break;
			case 6033: return 'III Trimestre'; break;
			case 6034: return 'IV Trimestre'; break;
			case 6035: return 'Acconto IVA'; break;
			case 6099: return 'Dichiarazione annuale'; break;
		}
	}
}


if ( ! function_exists('exclude_code'))
{
	function exclude_code($code) {
		return $code . '&nbsp;<a href="'.base_url().'c_riconciliazione/exclude/'.$code.'" class="exclude" title="Escludi codice"><span class="delete"></span></a>';
	}
}


if ( ! function_exists('bandi_list'))
{
	function bandi_list($id) {
		$CI =& get_instance();

		$CI->db->select('bandi.id');
		$result = $CI->db->get_where('bandi', array('bandi.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" class="bando btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" class="bando btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
			<button type="button" rel="'.$id.'" class="bando info btn btn-info btn-sm"><span class="glyphicon glyphicon-zoom-in"></span></button>';	
		} else {
			$action = '<button type="button" rel="'.$id.'" class="bando btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'"  class="bando btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>
			<button type="button" rel="'.$id.'" class="bando info btn btn-info btn-sm"><span class="glyphicon glyphicon-zoom-in"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('tipologiafondi_list')){

	function tipologiafondi_list($id,$tipologiafondo) {
		$CI =& get_instance();

		$CI->db->select('tipologiafondi.id');
		$result = $CI->db->get_where('tipologiafondi', array('tipologiafondi.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$tipologiafondo.'" class="tipologiafondi btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$tipologiafondo.'" class="tipologiafondi btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			// $action = '<a href="" rel="'.$id.'" class="edit" title="Modifica"><span class="glyphicon glyphicon-search"></span></a><a href="" rel="'.$id.'" class="delete" title="Cancella"><span class="delete last"></span></a>';
			$action = '<button type="button" rel="'.$id.'" title="'.$tipologiafondo.'" class="tipologiafondi btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$tipologiafondo.'" class="tipologiafondi btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('um_list')){

	function um_list($id,$descrizione,$sigla,$decimali,$minuti) {
		$CI =& get_instance();

		$CI->db->select('um.id');
		$result = $CI->db->get_where('um', array('um.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" sigla="'.$sigla.'"  minuti="'.$minuti.'" decimali="'.$decimali.'" title="'.$descrizione.'" class="um btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" sigla="'.$sigla.'"  minuti="'.$minuti.'" decimali="'.$decimali.'" title="'.$descrizione.'" class="um btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			// $action = '<a href="" rel="'.$id.'" class="edit" title="Modifica"><span class="glyphicon glyphicon-search"></span></a><a href="" rel="'.$id.'" class="delete" title="Cancella"><span class="delete last"></span></a>';
			$action = '<button type="button" rel="'.$id.'" sigla="'.$sigla.'"  minuti="'.$minuti.'" decimali="'.$decimali.'" title="'.$descrizione.'" class="um btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" sigla="'.$sigla.'"  minuti="'.$minuti.'" decimali="'.$decimali.'" title="'.$descrizione.'" class="um btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('moderogazione_list')){

	function moderogazione_list($id,$modalitaerogazione) {
		$CI =& get_instance();

		$CI->db->select('modalitaerogazioni.id');
		$result = $CI->db->get_where('modalitaerogazioni', array('modalitaerogazioni.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$modalitaerogazione.'" class="modalitaerogazioni btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$modalitaerogazione.'" class="modalitaerogazioni btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			// $action = '<a href="" rel="'.$id.'" class="edit" title="Modifica"><span class="glyphicon glyphicon-search"></span></a><a href="" rel="'.$id.'" class="delete" title="Cancella"><span class="delete last"></span></a>';
			$action = '<button type="button" rel="'.$id.'" title="'.$modalitaerogazione.'" class="modalitaerogazioni btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$modalitaerogazione.'" class="modalitaerogazioni btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('target_list')){

	function target_list($id,$target,$id_relazione,$relazione,$id_tipo_valore,$tipologiavalore,$valore1,$valore2) {
		$CI =& get_instance();

		$CI->db->select('target.id');

		$result = $CI->db->get_where('target', array('target.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$target.'" id_rel="'.$id_relazione.'" relazione="'.$relazione.'" id_valore="'.$id_tipo_valore.'" val1="'.$valore1.'" val2="'.$valore2.'" class="target btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$target.'" id_rel="'.$id_relazione.'" relazione="'.$relazione.'" id_valore="'.$id_tipo_valore.'" val1="'.$valore1.'" val2="'.$valore2.'" class="target btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
		} else {
			$action = '<button type="button" rel="'.$id.'" title="'.$target.'" id_rel="'.$id_relazione.'" relazione="'.$relazione.'" id_valore="'.$id_tipo_valore.'" val1="'.$valore1.'" val2="'.$valore2.'" class="target btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$target.'" id_rel="'.$id_relazione.'" relazione="'.$relazione.'" id_valore="'.$id_tipo_valore.'" val1="'.$valore1.'" val2="'.$valore2.'" class="target btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('relazioni_list')){

	function relazioni_list($id,$relazione) {
		$CI =& get_instance();

		$CI->db->select('relazioni.id');
		$result = $CI->db->get_where('relazioni', array('relazioni.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$relazione.'" class="relazioni btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$relazione.'" class="relazioni btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
		} else {
			$action = '<button type="button" rel="'.$id.'" title="'.$relazione.'" class="relazioni btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$relazione.'" class="relazioni btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('tipologiavalori_list')){

	function tipologiavalori_list($id,$tipologiavalore) {
		$CI =& get_instance();

		$CI->db->select('tipologiavalori.id');
		$result = $CI->db->get_where('tipologiavalori', array('tipologiavalori.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$tipologiavalore.'" class="tipologiavalori btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$tipologiavalore.'" class="tipologiavalori btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
		} else {
			$action = '<button type="button" rel="'.$id.'" title="'.$tipologiavalore.'" class="tipologiavalori btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$tipologiavalore.'" class="tipologiavalori btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('valori_list')){

	function valori_list($id,$valore) {
		$CI =& get_instance();

		$CI->db->select('valori.id');
		$result = $CI->db->get_where('valori', array('valori.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$valore.'" class="valori btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$valore.'" class="valori btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
		} else {
			$action = '<button type="button" rel="'.$id.'" title="'.$valore.'" class="valori btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$valore.'" class="valori btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('interventibandi_list')){

	function interventibandi_list($id,$interventibandi) {
		$CI =& get_instance();

		$CI->db->select('interventibandi.id');
		$result = $CI->db->get_where('interventibandi', array('interventibandi.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$interventibandi.'" class="interventibandi btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$interventibandi.'" class="interventibandi btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			$action = '<button type="button" rel="'.$id.'" title="'.$interventibandi.'" class="interventibandi btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$interventibandi.'" class="interventibandi btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('enti_list')){

	function enti_list($id,$ente) {
		$CI =& get_instance();

		$CI->db->select('enti.id');
		$result = $CI->db->get_where('enti', array('enti.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" title="'.$ente.'" class="enti btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$ente.'" class="enti btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			$action = '<button type="button" rel="'.$id.'" title="'.$ente.'" class="enti btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" title="'.$ente.'" class="enti btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('candidatura'))
{
	function candidatura($id) {
		$CI =& get_instance();

		$CI->db->select('bandi_target.id');
		$result = $CI->db->get_where('bandi_target', array('bandi_target.id' => $id));

		if($result->num_rows() == 0) {
			$action = '
			
			<button type="button" rel="'.$id.'" class="candidatura btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" class="candidatura btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
			';
			
		} else {
			$action = '
			
			<button type="button" rel="'.$id.'" class="candidatura btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" class="candidatura btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>
			';
		}

		return $action;

		return $action;
	}
}

if ( ! function_exists('erogazioniFromTarget'))

{
	function erogazioniFromTarget($id,$id_bando,$id_target,$id_um,$id_modalitaerogazione,$valore_erogato,$id_prog) {
		$CI =& get_instance();

		$CI->db->select('erogazioni.id');
		$result = $CI->db->get_where('erogazioni', array('erogazioni.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" id_prog="'.$id_prog.'" id_bando="'.$id_bando.'" id_target="'.$id_target.'" id_um="'.$id_um.'" id_modalitaerogazione="'.$id_modalitaerogazione.'" valore_erogato="'.$valore_erogato.'" class="erogazione btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" id_bando="'.$id_bando.'" id_prog="'.$id_prog.'" id_target="'.$id_target.'" class="erogazione btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			$action = '<button type="button" rel="'.$id.'" id_bando="'.$id_bando.'" id_prog="'.$id_prog.'" id_target="'.$id_target.'" id_um="'.$id_um.'" id_modalitaerogazione="'.$id_modalitaerogazione.'" valore_erogato="'.$valore_erogato.'" class="erogazione btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" id_bando="'.$id_bando.'" id_target="'.$id_target.'" id_prog="'.$id_prog.'" class="erogazione btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('list_interventibandiTarget'))
{
	function list_interventibandiTarget($id,$livello,$id_interventobando) {
		$CI =& get_instance();

		$CI->db->select('bandi_interventibandi.id');
		$result = $CI->db->get_where('bandi_interventibandi', array('bandi_interventibandi.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" livello="'.$livello.'" id_interventobando="'.$id_interventobando.'" rel="'.$id.'"   class="interventibandiTarget edit btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" livello="'.$livello.'" id_interventobando="'.$id_interventobando.'" class="interventibandiTarget btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			$action = '<button type="button" livello="'.$livello.'" rel="'.$id.'" id_interventobando="'.$id_interventobando.'"   class="interventibandiTarget btn edit btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" livello="'.$livello.'"   id_interventobando="'.$id_interventobando.'" class="interventibandiTarget btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}

		return $action;
	}
}

if ( ! function_exists('list_valoricandidature'))
{
	function list_valoricandidature($id,$id_relazione,$id_tipo_valore,$v1,$v2) {
		$CI =& get_instance();

		$CI->db->select('bandi_target.id');
		$result = $CI->db->get_where('bandi_target', array('bandi_target.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" id_relazione="'.$id_relazione.'" id_tipo_valore="'.$id_tipo_valore.'" valore1="'.$v1.'" valore2="'.$v2.'" class="valoriCandidatura btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" id_relazione="'.$id_relazione.'" id_tipo_valore="'.$id_tipo_valore.'" valore1="'.$v1.'" valore2="'.$v2.'"  class="valoriCandidatura delete btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>';
			
		} else {
			$action = '<button type="button" rel="'.$id.'" id_relazione="'.$id_relazione.'" id_tipo_valore="'.$id_tipo_valore.'" valore1="'.$v1.'" valore2="'.$v2.'"  class="valoriCandidatura btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" id_relazione="'.$id_relazione.'" id_tipo_valore="'.$id_tipo_valore.'" valore1="'.$v1.'" valore2="'.$v2.'"  class="delete valoriCandidatura btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button>';
		}
		return $action;
	}
}

if ( ! function_exists('elenco_fornitori'))
{
	function elenco_fornitori($id) {
		$CI =& get_instance();

		$CI->db->select('fornitori.codice');
		$result = $CI->db->get_where('fornitori', array('fornitori.id' => $id));

		if($result->num_rows() == 0 && $id > 1) {
			$action = '<a href="" rel="'.$id.'" class="edit" title="Modifica"><span class="edit"></span></a><a href="" rel="'.$id.'" class="delete" title="Cancella"><span class="delete last"></span></a>';
		} else {
			$action = '<a href="" rel="'.$id.'" class="edit" title="Modifica"><span class="edit last"></span></a>';
		}

		return $action;
	}
}

if(! function_exists('_list_user')){
	function _list_user($id){
		$CI =& get_instance();

		$CI->db->select('users.id');
		$result = $CI->db->get_where('users', array('users.id' => $id));

		if($result->num_rows() == 0) {
			$action = '<button type="button" rel="'.$id.'" class="btn btn-sm btn-info" ng-click="userDetail('.$id.')"><span class="glyphicon glyphicon-search"></span></button>
			<button type="button" rel="'.$id.'" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
			';
			
		} else {
			$action = '<button type="button" rel="'.$id.'" class="btn btn-sm btn-info"ng-model="pulsante" ng-click="userDetail('.$id.')"><span class="glyphicon glyphicon-search"></span></button>
			<button type="button" rel="'.$id.'" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></button>
			<button type="button" rel="'.$id.'" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>';
		}
		return $action;
	}
}

if(! function_exists('formapp')){
	function formapp($id){
		$CI =& get_instance();

		$CI->db->select('users_groups_formazione.group_formazione_id');
		$result = $CI->db->get_where('users_groups_formazione', array('users_groups_formazione.user_id' => $id));
		
		return json_encode($result->num_rows());
		
		
	}
}
if(! function_exists('test')){
	function test(){
		return 'ciao pietro';
	}
}

/* End of file datatables_helper.php */
/* Location: ./helpers/datatables_helper.php */