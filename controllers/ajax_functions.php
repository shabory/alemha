<?php
function get_watermark_image(){
	global $watermark_prefix;
	$watermark_select = get_post_meta( $_POST['id'], 'Mnbaa_watermark_select',true );
	$upload_dir = wp_upload_dir();	
	if(isset($watermark_select) && !(empty ($watermark_select))){
		$watermark_img_id = get_post_meta( $_POST['id'], 'Mnbaa_watermark_attachment_id',true );
		$watermark_img_guid = get_post_meta( $_POST['id'], 'Mnbaa_watermark_attachment_guid',true );
		/*$img_name= explode("/",$watermark_img_guid);
		$img=explode(".",end($img_name));
		$watermark_img_url=$upload_dir['url'] . '/'.$img[0].'-'.$_POST['width'].'x'.$_POST['height'].".".$img[1];*/
		$size=array($_POST['width'],$_POST['height']);
		$image_attributes = wp_get_attachment_image_src( $_POST['id'],$size );
		$img_name= explode("/",$image_attributes[0]);
		$watermark_img_name = $watermark_prefix.end($img_name);
		$watermark_img_url=$upload_dir['url'] . '/' . $watermark_img_name;
		echo $watermark_img_id."+".$watermark_img_url;
	}
	die(); 
	
}

function save_watermark(){
	
	update_post_meta($_POST['post_id'], 'Mnbaa_watermark_select', $_POST['watermark_id']);	
	die();
}


function preview_img(){
    global $dir_name;
    $count=$_POST['count'];
    parse_str($_POST['formElements'], $params);
    $new_image="index_".$params['post_ID'].$count.".jpg";
    $filepath = $dir_name."/images/".$new_image ;
    $old_img=$dir_name."/images/"."index_".$params['post_ID'].($count-1).".jpg";
    if (file_exists($old_img))
	unlink($old_img);
	
    $filepath2 = $dir_name."/images/index.jpg" ;
    copy($filepath2, $filepath);
    $mime_type = wp_check_filetype($filepath);
    $extension = $mime_type['type'];
    $string	= $params['watermark_title'];
    //$font_color = explode(',' ,$params['rgb']);
    list($r, $g, $b) =sscanf($params['color'], "#%02x%02x%02x");
    list($r_bg, $g_bg, $b_bg) =sscanf($params['color_bg'], "#%02x%02x%02x");
    
    $txt_size = $params['txt_size'];
    $wm_rotate = $params['rotation'];
    if($wm_rotate=="") $wm_rotate=0;
    $position = $params['position'];
    $wm_bg = $params['background'];
    $wm_opacity	= $params['opicity'];
    $txt_type = $params['txt_type'];
    $padding = $params['padding'];
    $dest_x = $params['destance_x'];
    $mes_x = $params['mesaure_x'];
    $mes_y = $params['mesaure_y'];
    $image = $params['image'];
    $wm_opacity_img = $params['img_opicity'];
    $padding_img = $params['img_padding'];
    $dest_x_img = $params['img_destance_x'];
    $mes_x_img = $params['img_mesaure_x'];
    $mes_y_img = $params['img_mesaure_y'];
    $position_img = $params['img_position'];
    if($image!=""){
        $img_uploaded = get_post((int) $image);
        $img_uploaded_path=explode('/',$img_uploaded->guid);
        $img_uploaded_name=end($img_uploaded_path);
        $upload_dir = wp_upload_dir();	
        $img_filepath = $upload_dir['path'] . DIRECTORY_SEPARATOR . $img_uploaded_name ;
        $img = $img_uploaded_name;
        $img_size = $params['img_size'];
        $wm_rotate_img = $params['img_rotation'];
        if($wm_rotate_img=="") $wm_rotate_img=0;
    }    
    $bg_destance_x = $params['bg_destance_x'];
    $bg_padding = $params['bg_padding'];
    
    $im = imagecreatefromjpeg($dir_name."/images/index.jpg");
    $color = imagecolorallocate($im, $r, $g, $b);
    $font = plugin_dir_path( __FILE__ ).'../libraries/fonts/'.$txt_type;
    
    $keywords=explode(" ",$string);
    //var_dump($keywords);
    $text="";
    foreach($keywords as $k=>$v){
            if (preg_match('/[ط£-ظٹ]/ui', $v)){
                    $Arabic = new I18N_Arabic('Glyphs'); 
                    $text .= $Arabic->utf8Glyphs($v);
            }else{
                    $text .= $v;
            }
            $text .=" ";
    }

    $size = getimagesize($filepath);	
    if($padding=="" || $padding==0){$padding=5;}
    $wm_bBox = imagettfbbox($txt_size, 0, $font, $text);
    $lowerLeftX = $wm_bBox[0];
    $lowerLeftY = $wm_bBox[1];
    $lowerRightX = $wm_bBox[2];
    $lowerRightY = $wm_bBox[3];
    $upperRightX = $wm_bBox[4];
    $upperRightY = $wm_bBox[5];
    $upperLeftX = $wm_bBox[6];
    $upperLeftY = $wm_bBox[7];
    if($dest_x=="" || $dest_x==0){$dest_x=5;}
    if($bg_destance_x==""){
            $bg_watermark_rWidth = ($upperRightX - $upperLeftX)+ 5;
            $watermark_rWidth = ($upperRightX - $upperLeftX) + $padding ;

    }else{
            $bg_watermark_rWidth = $bg_destance_x+5;
            $watermark_rWidth = $bg_destance_x + $padding;
    }
    if($bg_padding==""){
            $bg_watermark_rHeight = ($lowerLeftY - $upperLeftY) +5;
            $watermark_rHeight = ($lowerLeftY - $upperLeftY) + $padding;
    }else{
            $bg_watermark_rHeight = $bg_padding +5;
            $watermark_rHeight = $bg_padding + $padding;	
    }
    $watermark_r = imagecreatetruecolor($bg_watermark_rWidth, $bg_watermark_rHeight);
    //if($extension=='image/png'){
    //	/*$background = imagecolorallocate($watermark_r, 255, 255, 255);
    //	imagecolortransparent($watermark_r, $background);*/
    //	imagealphablending($watermark_r, false);
    //	imagesavealpha($watermark_r, true);
    //}
    if ($wm_bg=='yes') {
            $color_bg = imagecolorallocate($watermark_r, $r_bg, $g_bg, $b_bg);
            imagefilledrectangle($watermark_r, 0, 0, $watermark_rWidth, $watermark_rHeight, $color_bg);
    }
    $watermark_rWidth = imagesx($watermark_r);
    $watermark_rHeight = imagesy($watermark_r);
    $offset_y = ($watermark_rHeight-($wm_bBox[1] +  $wm_bBox[5]))/2  ;
    $offset_x = ($watermark_rWidth-($wm_bBox[0] +  $wm_bBox[4]))/2 ;			
    imagettftext($watermark_r, $txt_size, 0, $offset_x, $offset_y, $color, $font, $text);
    //imagesavealpha($watermark_r, true);						
    if ($wm_bg=='yes') {					
            $white = imagecolorallocate($watermark_r, 255, 255, 255);
            $watermark_r = imagerotate($watermark_r, $wm_rotate,$white,0);
            $bg = imagecolortransparent($watermark_r,$white);
    }elseif($wm_bg=='no'){
            $watermark_r = imagerotate($watermark_r, $wm_rotate,0,0);
            $bg = imagecolortransparent($watermark_r,0);
    }
                    $watermark_rWidth = imagesx($watermark_r);
                    $watermark_rHeight = imagesy($watermark_r);
            //}

            if($mes_x=='%'){
                    $x=$watermark_rWidth/2;
                    $dest_x=(($size[0]*$dest_x)/100)-$x;
            }else{
                    $dest_x=$dest_x;
            }

            if($mes_y=='%'){
                    $y=$watermark_rHeight/2;
                    $padding=(($size[1]*$padding)/100)-$y;
            }else{

                    $padding=$padding;
            }

            if ($position == 'bottom') {
                    $dest_y = $size[1] - ($watermark_rHeight + $padding);
            } else {
                    $dest_y = $padding;
            } 
            //if($string !=''){
            //imagesavealpha($watermark_r, true);
            /*if($extension=='image/png'){
                    imagecopy($im, $watermark_r, $dest_x, $dest_y, 0, 0, $watermark_rWidth, $watermark_rHeight);
            }else{*/
                    imagecopymerge($im, $watermark_r, $dest_x, $dest_y, 0, 0, $watermark_rWidth, $watermark_rHeight, $wm_opacity);
            //}
            //}

            if($image !=''){
                    if($wm_rotate_img==""){
                            $wm_rotate_img=0;
                    }
                    $wm_image=$img_filepath;
                    $factor =1/($img_size);
                    $img_ext_arr=explode('.',$img);
                    $img_ext=end($img_ext_arr);
                    if($img_ext=='jpg' || $img_ext=='jpeg'){
                            $watermark2 = imagecreatefromjpeg($wm_image);
                    }elseif($img_ext=='png'){
                            $watermark2 = imagecreatefrompng($wm_image);
                            imagealphablending($watermark2, true);
                            imagesavealpha($watermark2, true);
                    }elseif($img_ext=='gif'){
                            $watermark2 = imagecreatefromgif($wm_image);
                    }
                    $wm_width2 = imagesx($watermark2);		
                    $wm_height2 = imagesy($watermark2);		
                    $watermark_rWidth2 = $wm_width2 * $factor;	
                    $watermark_rHeight2 = $wm_height2 * $factor;
                    $watermark_r2 = @imagecreatetruecolor($watermark_rWidth2, $watermark_rHeight2);

                    if($img_ext=='png'){

                            $bgc = imagecolorallocate($watermark_r2, 255, 255, 255);
                            imagecolortransparent($watermark_r2,$bgc);
                            imagefilledrectangle($watermark_r2, 0, 0, $watermark_rWidth2, $watermark_rHeight2, $bgc);

                            imagealphablending($watermark_r2, true);
                            imagesavealpha($watermark_r2, true);
                    }
                    imagecopyresampled($watermark_r2, $watermark2, 0,0, 0, 0, $watermark_rWidth2, $watermark_rHeight2, $wm_width2, $wm_height2);

                    //if ($wm_rotate_img != 0) {
                            //if (phpversion() >= 5.1) { 
    //					$bg2 = imagecolortransparent($watermark_r2);
    //					$watermark_r2 = imagerotate($watermark_r2, $wm_rotate_img, $bg2, 1);
    //			} else {
                                            $white = imagecolorallocate($watermark_r2, 255, 255, 255);
                                            $watermark_r2 = imagerotate($watermark_r2, $wm_rotate_img, $white,0);
                                            $bg = imagecolortransparent($watermark_r2,$white);
                            //} 

                            $watermark_rWidth2 = imagesx($watermark_r2);
                            $watermark_rHeight2 = imagesy($watermark_r2);
                    //}
                    if($padding_img==""){$padding_img=20;}
                    if($dest_x_img==""){$dest_x_img=20;}
                    if($mes_x_img=='%'){
                            $x=$watermark_rWidth2/2;
                            $dest_x_img=(($size[0]*$dest_x_img)/100)-$x;
                    }else{
                            $dest_x_img=$dest_x_img;
                    }

                    if($mes_y_img=='%'){
                            $y=$watermark_rHeight2/2;
                            $padding_img=(($size[1]*$padding_img)/100)-$y;
                    }else{
                            $padding_img=$padding_img;
                    }

                    if ($position_img == 'bottom') {
                            $dest_y_img= $size[1] - ($watermark_rHeight2 + $padding_img);

                    } else {
                            $dest_y_img = $padding_img;
                    } 

                    imagecopymerge($im, $watermark_r2, $dest_x_img, $dest_y_img, 0, 0, $watermark_rWidth2, $watermark_rHeight2, $wm_opacity_img);
            }

            //imagealphablending($im, true);

            if($extension=='image/jpg' || $extension=='image/jpeg'){		
                    imagejpeg($im, $filepath, apply_filters( 'jpeg_quality', 90 ));
            }elseif($extension=='image/png'){
                    imagepng($im,$filepath);

            }elseif($extension=='image/gif'){
                    imagegif($im,$filepath);
            }
            $new_img=plugins_url( "images/".$new_image , dirname(__FILE__) );
            echo $new_img;
    
    die(); 
	
}


?>