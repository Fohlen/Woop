<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squadmanagement!
# ------------------------------------------------------------------------
# author    Lennard Berger
# copyright Copyright (C) 2014 Lennard Berger. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basesquadtemplate.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';

class woopsquadtemplate extends basesquadtemplate 
{

	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squad/Woop/style.css';
		$doc->addStyleSheet($cssHTML);
		
		$html = array(); // The html we'd like to render
		$groups = array(); // Groups of people based on their role
		
		// Categorize users within groups
		foreach($this->squad->members as $member) {
			$role = substr($this->getSquadMemberRole($member), 6, strlen($this->getSquadMemberRole($member))); // Strip the first 6 chars because they're always: "Role: "
			$groups[$role][] = $member;
		}
		
		$html[] = '<div style="clear:both;">&nbsp;</div>';
		$html[] = '<dl id="plist">';

		foreach ($groups as $group) {
			$html[] = '<dt style="color: #fff;">' .key($groups). '</dt>'; // Group title
			
			foreach ($group as $member) {
				$html[] = '<dd><a href="#'.$member->membername.'"><span class="i"><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" alt="'.$member->membername.'"></span><span>'.$member->membername.'</span></a></dd>';
			}
		}
		
		$html[] = '</dl>';
		$html[] = '<div style="clear:both;">&nbsp;</div>';
		$html[] = '<hr style="background-color: #747474;">';
		$html[] = '<div style="clear:both;">&nbsp;</div>';

		
		foreach($this->squad->members as $member) {
			
			$html[] = '<h2><a name="'.$member->membername.'" href="#'.$member->membername.'">'.$member->membername.' style="color: #fff;"</a></h2>';
			$html[] = '<dl class="p_stats">';
			$html[] = '<dd class="dim"><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" alt="'.$member->membername.'" style="border-radius: 10px;"></dd>';
			/*foreach ($this->fieldlist as $field) 
			{
				$html[] = '<dd>';
				$html[] = $this->renderField($field,$member);
				$html[] = '</dd>';		
			}*/
			
			$html[] = '<dd>'.$this->getLastSquadMemberOnline($member).'</dd>';
			$html[] = '</dl>';
			if ($member->description != '') $html[] = $member->description;
			
			$html[] = '<hr style="background-color: #747474;">'; // Separate the profiles though
		}
		
		echo implode("\n", $html);
	}
}
