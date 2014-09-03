<?php
/**
 * @param    stringData   date string mySQL format YYYY-mm-dd
 * @return   stringData   data string italian format dd/mm/YYYY
 */

function mysqlDate2ItalianDate($mySQLData) {
  return substr($mySQLData, 8, 2).'/'.substr($mySQLData, 5, 2).'/'.substr($mySQLData, 0, 4);
}

/**
 * @param    number       number string 
 * @return   number       valuta
 */

function formatValuta($number2format) {
  return number_format($number2format, 2);
}



/**
 * @param    string   identical to the 1st param of anchor()
 * @param    mixed    identical to the 3rd param of anchor()
 * @param    string   the path to the image; it can be either an external one 
 *                    starting by "http://", or internal to your application
 * @param    mixed    image attributes that have similar structure as the 3rd param of anchor()
 * @return   string
 * 
 * Example 1: anchor_img('controller/method', 'title="My title"', 'path/to/the/image.jpg', 'alt="My image"')
 * Example 2: anchor_img('http://example.com', array('title' => 'My title'), 'http://example.com/image.jpg', array('alt' => 'My image'))
 */

function anchor_img($uri = '', $anchor_attributes = '', $img_src = '', $img_attributes = '', $img_title = '', $img_alt = '', $img_subtitle= ''){
  if ( ! is_array($uri)) {
    $site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
  } else {
    $site_url = site_url($uri);
  }

  if ($anchor_attributes != '') {
    $anchor_attributes = _parse_attributes($anchor_attributes);
  }
  
  if (strpos($img_src, '://') === FALSE) {
    $CI =& get_instance();
    $img_src = $CI->config->slash_item('base_url').$img_src;
  }
  
  if ($img_attributes != '') {
    $img_attributes = _parse_attributes($img_attributes);
  }

  if ($uri == '') {
    if ($img_subtitle == '') {
      return '<img src="'.$img_src.'" '.$img_attributes.' alt="'.$img_alt.'" title="'.$img_title.'"/>';
    } else {
      return '<img src="'.$img_src.'" '.$img_attributes.' alt="'.$img_alt.'" title="'.$img_title.'" /><h6>'.$img_subtitle.'</h6>';
    }
  } else {
    if ($img_subtitle == '') {
      return '<a href="'.$site_url.'">'.'<img src="'.$img_src.'" '.$img_attributes.' alt="'.$img_alt.'" title="'.$img_title.'" /></a>';
    } else {
      return '<a href="'.$site_url.'">'.'<img src="'.$img_src.'" '.$img_attributes.' alt="'.$img_alt.'" title="'.$img_title.'" /></a><h6>'.$img_subtitle.'</h6>';
    }
  }
}  
  
function form_input_date($data = '', $value = '', $extra = '') {
  $defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);
  // $inputdate= '<div class="input-append date" data-date="'.$value.'" data-date-format="dd/mm/yyyy" data-link-field="'.$data.'" data-link-format="yyyy-mm-dd">';
  $inputdate= '<div class="input-append date" data-date="'.$value.'" >';
  $inputdate.= '<input '._parse_form_attributes($data, $defaults).$extra.' />';
  $inputdate.= '<span class="add-on"><i class="fa fa-calendar"></i></span>';
  $inputdate.= '</div>';
  return $inputdate;
}


/* End of file p_date_helper.php */
/* Location: ./system/application/helpers/p_date_helper.php */

