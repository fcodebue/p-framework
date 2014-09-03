<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($user=0, $html, $filename, $orientation="portrait", $stream=TRUE) {    
    require_once('dompdf/dompdf_config.inc.php');
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper("a4", $orientation);
    $dompdf->render();

    // always wite file per users
    $CI =& get_instance();
    $CI->load->helper('file');
    $now= date('YmdHis');
    $localFilename= base_url().'pdf/'.$user.'_'.$now.'_'.$filename.'.pdf';
    // $httpFilename= base_url().Q_PDF_DIR.$user.'_'.$now.'_'.$filename.'.pdf';
    // if (file_exists($localFilename)) {
    //   @unlink($localFilename);
    // }
    // write_file($localFilename, $dompdf->output());

    if ($stream) {
      $dompdf->stream($localFilename);
    }
    
    return $httpFilename;
    
}
?>