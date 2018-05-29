<?php
/**
 * @author      Sociedad Española de Cardiología
 * @copyright   Copyright (C) 2018 Sociedad Española de Cardiología. All rights reserved.
 * @url         https://secardiologia.github.io
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.plugin.plugin');

class plgContentSeccontent extends JPlugin
{	
	var $position;
	
	function plgContentSeccontent(&$subject, $config)
	{
		parent::__construct($subject, $config);
		
		parent::__construct($subject, $config);
		$this->plugin = JPluginHelper::getPlugin('content', 'seccontent');
		$this->position 	= $this->params->get('position');	
	}

	function onContentAfterDisplay($context, &$article, &$params, $page = 0)
	{
		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			return '';
		}
		if ($this->position == 2 && $context != 'com_content.category')
			return $this->getSecContent($context, $article);
	}	
	
	public function onContentAfterTitle($context, &$article, &$params, $page = 0){
		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			return '';
		}	
		if ($this->position == 3 && $context != 'com_content.category') 
			return $this->getSecContent($context, $article);
	}
		
	function onContentBeforeDisplay($context, &$article, &$params, $page=0)
	{
		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			return '';
		}		
		if ($this->position == 1 && $context != 'com_content.category')
			return $this->getSecContent($context, $article);
	}
	
	function getSecContent($context, &$article)
	{
		if (!isset($article->catid)) {
			$article->catid = 0;
		}
		
		$categories 		= array();
		$cats 				= $this->getParam('catids');
		
		if (is_array($cats)) {
			$categories 	= $cats;
		} else {
			$categories[] 	= $cats;
		}
		
		// Custom content
		$custom_content		= $this->getParam('custom');
		
		if (in_array($article->catid, $categories)) {
			$output = '';

			$output .= '<div class="seccontent">';
			$output .= $custom_content;
			$output .= '</div>';			
			
			return $output;		
		}

	}
	
	function getParam($param) {
		return $this->params->get($param);
	}
}