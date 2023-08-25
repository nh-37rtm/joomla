<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * SitemapsFasterList Model
 */
class SitemapFasterModelDownloads extends JModelList
{
	 protected function populateState($ordering = null, $direction = null) {

		$app = JFactory::getApplication();
		parent::populateState($ordering, $direction);
		$this->setState('list.limit', 0);
	}
 
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		$jroot = JURI::root();
		// Create a new query object.           
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query = "SELECT CONCAT('$jroot', path, '.html') AS url							
					FROM `#__menu` A,`#__content` B 							
					WHERE 							
					menutype <> 'menu' 							
					and published = '1'							
					and link like 'index.php?option=com_content&view=article&id=%'							
					and B.id = TRIM(LEADING 'index.php?option=com_content&view=article&id=' FROM link)							
					UNION						  
				  SELECT CONCAT('$jroot', path, '.html') AS url							
					FROM `#__menu` A							
					WHERE (							
					menutype <> 'menu' 							
					and published = '1'							
					and link like 'index.php?option=com_content&view=category&layout=blog&id=%'							
					)
				  OR							
					(							
					menutype <> 'menu' 							
					and published = '1'							
					and link like 'index.php?option=com_aicontactsafe&view=message&layout=message&pf=%'					
					)
				  OR
   				    (					
					menutype <> 'menu' 							
					and published = '1'							
					and link like 'index.php?option=com_contact&view=contact&id=%'
					)
					UNION						  
				  SELECT CONCAT('$jroot', path, '/', B.alias, '.html') AS url							
					FROM `#__menu` A,`#__content` B							
					WHERE							
					catid = TRIM(LEADING 'index.php?option=com_content&view=category&layout=blog&id=' FROM link) 							
					and menutype <> 'menu' 							
					and published = '1'							
					and link like 'index.php?option=com_content&view=category&layout=blog&id=%'							
					and B.id NOT IN (select TRIM(LEADING 'index.php?option=com_content&view=article&id=' FROM link) AS article_id 
					FROM #__menu where link like 'index.php?option=com_content&view=article&id=%')
                    and path not like '%/%'";   
				return $query;        
	}
}