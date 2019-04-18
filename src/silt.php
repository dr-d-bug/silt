<?php
// error_reporting(E_ALL);
/**
* generates an image with True Type Font text instead of pixels (centered and word wrapped)
* @param string $_GET['fm'] - fileformat of the resulted graphics file
* @param string $_GET['txtsize'] - fontsize
* @param string $_GET['txt'] - input text content
* @param string $_GET['w'] - width of the picture file
* @param string $_GET['h'] - height of the picture file
* @param string $_GET['txtclr'] - text color
* @param string $_GET['bg'] - background color
* @return imagefile (png/jpg)
* @author Dr.D.Bug
* @version 0.3
**/
//--> Checking the Input-Parameters
// Format: jpg or png32
$fm_pattern = '/^(jpg|png32)$/';
if ( isset($_GET['fm']) && preg_match($fm_pattern, $_GET['fm']) ) {
  $pic_format = $_GET['fm'];
}else{
  $pic_format = 'png32';
}
// size of text: 50
if ( isset($_GET['txtsize']) && !empty($_GET['txtsize']) ) {
  $font_size = $_GET['txtsize'];
}else{
  $font_size = 50;
}
// text:
if ( isset($_GET['txt']) && !empty($_GET['txt']) ) {
  $txt_content = $_GET['txt'];
}else{
  $txt_content = 'txt is missing!';
}
// width:
if ( isset($_GET['w']) && !empty($_GET['w']) ) {
  $pic_width = $_GET['w'];
}else{
  $pic_width = 500;
}
// height:
if ( isset($_GET['h']) && !empty($_GET['h']) ) {
  $pic_height = $_GET['h'];
}else{
  $pic_height = 250;
}
// text color: 000000
if ( isset($_GET['txtclr']) && !empty($_GET['txtclr']) ) {
  if ( strlen($_GET['txtclr']) == 6) {
    $arr_tx = str_split(strtoupper($_GET['txtclr']), 2);
  }else{
  $txt_color = '000000';
  $arr_tx =str_split($txt_color, 2);
  }
}
// background color: FFFFFF
if ( isset($_GET['bg']) && !empty($_GET['bg']) ) {
  if ( strlen($_GET['bg']) == 6) {
    $arr_bg = str_split(strtoupper($_GET['bg']), 2);
//  $pic_color = $_GET['bg'];
  }else{
  $pic_color = 'FFFFFF';
  $arr_bg = str_split($pic_color, 2);
  }
}
//--> (main) Creating the Output-File
// setting Content-Type
header('Content-Type: image/png');
// Creating Image with width $w and height $h
$im = imagecreatetruecolor($pic_width, $pic_height);
// if necessary add path to fontfile
$font_file= 'ARIALUNI.TTF';
// create background and text colors
$bg_col = imagecolorallocate($im, hexdec($arr_bg[0]), hexdec($arr_bg[1]), hexdec($arr_bg[2]));
$tx_col = imagecolorallocate($im, hexdec($arr_tx[0]), hexdec($arr_tx[1]), hexdec($arr_tx[2]));
// fill image with background color
imagefilledrectangle($im, 0, 0, $pic_width, $pic_height, $bg_col);
// Wrapping the Text by ((( finally width with size of content text ))) -->> 20 Test!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$wrapped_text = wordwrap($txt_content, 20, "\n");
// center the wrapped text
$text_box = imagettfbbox($font_size, 0, $font_file, $wrapped_text);
// Get your Text Width and Height
$text_width = $text_box[4]-$text_box[6];
$text_height = $text_box[3]-$text_box[1];
// Calculate coordinates of the text
$x = ceil(($pic_width - $text_box[2]) / 2);
$y = ceil(($pic_height - $text_box[3]) / 2);
// put text into image
imagettftext($im, $font_size, 0, $x, $y, $tx_col, $font_file, $wrapped_text);
// imagepng() has better quality than imagejpeg()
imagepng($im);
imagedestroy($im);
?>
