<?php 

function message_erreur($erreurs, $input){
	if (count($_POST) > 0) {
		$message ='';
		if (count($erreurs[$input]) > 0) {
			foreach ($erreurs[$input] as $e) {
				$message = $message . '<li>'.$e.'</li>';
			}
		}
		return '<ul class="error_messages">'.$message.'</ul>';
	}
}

function is_valid_email($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}


function redimPicture($picture, $heigth, $width, $compress){
        ini_set('memory_limit', '128M');
        if(is_file($picture)){
        	
        	
            $img_src = "";
            if(strstr($picture, '.jpg') || strstr($picture, '.jpeg') || strstr($picture, '.JPG') || strstr($picture, '.JPEG')) {
           		$img_src = imagecreatefromjpeg($picture); // on charge une image en mémoire
            }
            else if(strstr($picture, '.png') || strstr($picture, '.PNG')) {
            	$img_src = imagecreatefrompng($picture);
            }
            
            
            
            $largeur_source = imagesx($img_src);//on récupère sa largeur
            $hauteur_source = imagesy($img_src);//on récupère sa hauteur

            $largeur_dest = $largeur_source;//on défini les valeur par défaut en cas d'erreur
            $hauteur_dest = $hauteur_source;//on défini les valeur par défaut en cas d'erreur

            

            //si $hauteur = 0 on garde le meme ratio basé sur la largeur
            if($heigth == 0){
            	if($width < $largeur_source){
	                $ratio = $hauteur_source/$largeur_source;
	                $largeur_dest = $width;
	                $hauteur_dest = ceil($largeur_dest*$ratio);//on arrondie 
            	}
            }
            //si $largeur = 0 on garde le meme ratio basé sur la hauteur
            else if($width == 0){
            	if($heigth < $hauteur_source) {
	                $ratio = $largeur_source/$hauteur_source;
	                $hauteur_dest = $heigth;
	                $largeur_dest = ceil($hauteur_dest*$ratio);//on arrondie 
            	}
            }
            //si la hauteur et la largeur ont été spécifié ont déforme l'image.
            else{
            	if($width < $largeur_source && $heigth < $hauteur_source){
                	$largeur_dest = $width;
                	$hauteur_dest = $heigth;
           		}
            }


            $img_out = imagecreatetruecolor($largeur_dest, $hauteur_dest);//création d'une image vierge via PHP
            imagecopyresampled($img_out, $img_src, 0, 0, 0, 0, imagesx($img_out), imagesy($img_out), $largeur_source, $hauteur_source);// création de l'image de sortie basé sur l'image chargée et aux bonnes dimensions
            
            //on enregistre la photo
            if(strstr($picture, '.jpg') || strstr($picture, '.jpeg') || strstr($picture, '.JPG') || strstr($picture, '.JPEG')) {
            	imagejpeg($img_out, $picture, $compress);
            }
            else if(strstr($picture, '.png') || strstr($picture, '.PNG')) {
            	imagepng($img_out, $picture);
            }
            
               
        }
        else {
            $res['success'] = false;
            return $res;
        }
    }


 ?>