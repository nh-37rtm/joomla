<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// echo 'suis dans view download';
// import Joomla view library
jimport('joomla.application.component.view');
// echo ' vais rentrer dans class dans view download';
 // ini_set('display_errors',1);
 // error_reporting(E_ALL);
/** * HTML View class for the SitemapFaster Component */
class SitemapFasterViewDownloads extends JViewLegacy
{		
/**         
* SitemapFaster view download method         
* @return void        		
*/	
		function display($tpl = null)         		
		{   			
		// echo ' suis dans function view download de SitemapFasterViewDownloads';			
		//Get data from the model			
		$items = $this->get('Items');             
		//$pagination = $this->get('Pagination');			
		//Assign data to the view			
		$this->items = $items;			
		//$this->pagination = $pagination;			
		// Check for errors.                			
		if (count($errors = $this->get('Errors')))                 
			{                        
				JError::raiseError(500, implode('<br />', $errors));                        
				return false;                
			}      
			// open the file
			$filename = 'sitemap'. date("m.d.y") . '.xml';		
			$file = fopen($filename, 'c');					
			// write the file	
			$xml     = '<?xml version="1.0" encoding="UTF-8"?>';
			$urlset  = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
			fwrite($file, $xml);
			fwrite($file, "\n");			
			fwrite($file, $urlset);			
			// echo 'avant foreach';			
			foreach($this->items as $i => $item){	
					// write xml file					
					echo $item->url;
					fwrite($file, "\n");
					fwrite($file, '<url>');
					fwrite($file, "\n");
					fwrite($file, '<loc>');
					// Append a new url to the file
					fwrite($file, $item->url);
					// echo $item->url;
					// echo '<br>';
					fwrite($file, '</loc>');
					fwrite($file, "\n");
					fwrite($file, '</url>');
				}	      		
			fwrite($file, "\n");
			fwrite($file, '</urlset>');
			fclose($file);

			if (file_exists($filename)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($filename));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($filename);
				exit;
			}
			else echo 'file doesn t exist';	
		}
}