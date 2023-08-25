<?php
/**
 * @package mod_tribucontentslideshow for Joomla! 3
 * @author Tribu And Co
 * @copyright (C) 2014 - Tribu And Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access to this file
defined('_JEXEC') or die;

abstract class TribuHelper {
	public function getThumb ($image,$imgWidth=0,$imgHeight=0,$crop=false ){
		//si aucune dimension retourne false
		if ( ($imgWidth==0) && ($imgHeight==0) ) return false;
		//Si une des dimensions = 0 => carr�
		if ($imgHeight==0) $imgHeight=$imgWidth;
		if ($imgWidth==0) $imgWidth=$imgHeight;

		$path_parts = pathinfo(JPATH_ROOT.'/'.$image);
		$origImage = new JImage ($image);
		//si image plus petite que la taille d�sir�e retourne false
		if (($origImage->getWidth() < $imgWidth) && ($origImage->getHeight() < $imgHeight)) return false;
		//calcul des dimensions final du thumbnail (uniquement si m�thode redimensionnement ... si m�thode crop ce sont exactement les tailles demand�)
		if ($crop===FALSE) {
			$rapport=$origImage->getWidth()/$origImage->getHeight();
			if ( $rapport > ($imgWidth/$imgHeight) ){
				$thumbWidth=$imgWidth;
				$thumbHeight=round($imgWidth/$rapport);
			}
			else{
				$thumbHeight=$imgHeight;
				$thumbWidth=round($imgHeight*$rapport);
			}
		}
		else {
			$thumbWidth=$imgWidth;
			$thumbHeight=$imgHeight;
		}
		//chemin du thumbnail
		$paththumb = $path_parts['dirname'].'/thumbs/'.$path_parts['filename'].'_'.$thumbWidth.'x'.$thumbHeight.'.'.$path_parts['extension'];
		//si il existe
		if (is_file($paththumb)){
			// et qu'il a �t� modifi�e plus r�cemment que le fichier original
			if (filemtime(JPATH_ROOT.'/'.$image)<filemtime($paththumb)){
				//on retourne le chemin relatif
				$thumb=str_replace(JPATH_ROOT.'/', '',$paththumb);
				return $thumb;
			}
		}	
		//sinon on cr�e le thumbnail aux dimensions souhait�es (5 => CROP_RESIZE , 2 => SCALE_INSIDE)
		$method = ($crop) ? 5 : 2;
		$thumb=$origImage->createThumbs($imgWidth.'x'.$imgHeight,$method);
		return $thumb[0]->getPath();
	}
}	