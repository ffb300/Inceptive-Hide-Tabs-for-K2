<?php
/**
 * @version		1.0
 * @package		Inceptive Hide Tabs for K2
 * @author		Inceptive Design Labs - http://www.inceptive.gr
 * @copyright	Copyright (c) 2006 - 2012 Inceptive GP. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

// Load the base K2 plugin class. All K2 plugins extend this class.
JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.'/'.'components'.'/'.'com_k2'.'/'.'lib'.'/'.'k2plugin.php');

class plgK2Incptvk2hidetabs extends K2Plugin
{
    // K2 plugin name. Used to namespace parameters.
    var $pluginName = 'incptvk2hidetabs';
    
    // K2 human readable plugin name. This the title of the plugin users see in K2 form.
    var $pluginNameHumanReadable = 'Inceptive Hide Tabs for K2';
    
    var $plg_copyrights_start		= "\n\n<!-- Inceptive Hide Tabs for K2 Plugin (v1.0) starts here -->\n";
    var $plg_copyrights_end		= "\n<!-- Inceptive Hide Tabs for K2 Plugin (v1.0) ends here -->\n\n";

    // Constructor
    public function __construct(&$subject, $config)
    {   
        // Construct
        parent::__construct($subject, $config);
    }
    
    function onRenderAdminForm (&$item, $type, $tab='') {
	if ($tab == 'other' && $type == 'item') {
	    $document 		= &JFactory::getDocument();
	    $path 		= str_replace("/administrator", "",JURI::base(true));
	    $document->addScript($path.DS.'plugins'.DS.'k2'.DS.'incptvk2hidetabs'.DS.'js'.DS.'incptvk2hidetabsactiveprofile.js.php?cid='.$item->id);
	}
	
	if($tab == '' && $type == 'category')
	{
	    $incptvK2CategorySpecificParams = new K2Parameter($item->plugins, '', $this->pluginName);
	    $parameteres = $incptvK2CategorySpecificParams->get('Params');
	    if($parameteres != null)
	    {
		$useCategorySpecific = $parameteres->incptvk2hidetabsUseCategorySpecific;
		$content = $parameteres->incptvk2hidetabsContent;
		$image = $parameteres->incptvk2hidetabsImage;
		$imageGallery = $parameteres->incptvk2hidetabsImageGallery;
		$media = $parameteres->incptvk2hidetabsMedia;
		$extraFields = $parameteres->incptvk2hidetabsExtraFields;
		$attachments = $parameteres->incptvk2hidetabsAttachments;
		$plugins = $parameteres->incptvk2hidetabsPlugins;
	    }
	    else 
	    {
		$useCategorySpecific = 'false';
		$content = 'show';
		$image = 'show';
		$imageGallery = 'show';
		$media = 'show';
		$extraFields = 'show';
		$attachments = 'show';
		$plugins = 'show';
	    }
	    $mainframe 		= &JFactory::getApplication();
	    $document 		= &JFactory::getDocument();
	    $path 		= str_replace("administrator/", "",JURI::base());
	    $plugin_folder 	= basename(dirname(__FILE__));
	    $document->addScript($path.'plugins/k2/'.$plugin_folder.'/js/incptvk2hidetabs.js');
	    $document->addStyleSheet($path.'plugins/k2/'.$plugin_folder.'/css/style.css');

	    //Loading the appropriate language files
	    $lang = JFactory::getLanguage();
	    $languagePath = JPATH_PLUGINS.DS.'k2'.DS.'incptvk2hidetabs';
	    $lang->load("plg_k2_incptvk2hidetabs", $languagePath, null, false);
	    

	    $valueHide = new stdClass();
	    $valueHide->value = 'hide';
	    $valueHide->text = JText::_('PLG_K2_INCPTV_HT_HIDE');
	    $valueShow = new stdClass();
	    $valueShow->value = 'show';
	    $valueShow->text = JText::_('PLG_K2_INCPTV_HT_SHOW');
	    $values = array($valueHide, $valueShow);
	    
	    $valueUseFalse = new stdClass();
	    $valueUseFalse->value = 'false';
	    $valueUseFalse->text = JText::_('PLG_K2_INCPTV_HT_FALSE');
	    $valueUseTrue = new stdClass();
	    $valueUseTrue->value = 'true';
	    $valueUseTrue->text = JText::_('PLG_K2_INCPTV_HT_TRUE');
	    $valuesUse = array($valueUseFalse, $valueUseTrue);
	    $tabIncptvHT_innerHtml  = '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_('PLG_K2_INCPTV_HT_CATEGORY_SPECIFIC_PARAMS').'</div><div class="k2clr"></div></div>';
	    //Use parameters?
	    $tabIncptvHT_innerHtml .= '<table class="admintable"><tbody>';
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_USE_CATEGORY_SPECIFIC').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $valuesUse, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsUseCategorySpecific]', '', 'value', 'text', $useCategorySpecific);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    $tabIncptvHT_innerHtml .='</tbody></table>';
	    
	    $tabIncptvHT_innerHtml .= '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_('PLG_K2_INCPTV_HT_PARAMS').'</div><div class="k2clr"></div></div>';
	    
	    $tabIncptvHT_innerHtml .= '<table class="admintable"><tbody>';
	    //Content tab
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_CONTENT').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsContent]', '', 'value', 'text', $content);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    //Image tab
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_IMAGE').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsImage]', '', 'value', 'text', $image);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    //Image Gallery tab
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_IMAGE_GALLERY').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsImageGallery]', '', 'value', 'text', $imageGallery);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    //Media tab
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_MEDIA').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsMedia]', '', 'value', 'text', $media);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    //Extra Fields tab
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_EXTRA_FIELDS').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsExtraFields]', '', 'value', 'text', $extraFields);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    //Attachements tab
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_ATTACHMENTS').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsAttachments]', '', 'value', 'text', $attachments);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    //Plugins tab
	    $tabIncptvHT_innerHtml .='<tr><td class="key">'.JText::_('PLG_K2_INCPTV_HT_PLUGINS').'</td>';
	    $tabIncptvHT_innerHtml .='<td class="adminK2RightCol">';
	    $tabIncptvHT_innerHtml .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsPlugins]', '', 'value', 'text', $plugins);
	    $tabIncptvHT_innerHtml .= '</td></tr>';
	    
	    $tabIncptvHT_innerHtml .='</tbody></table>';
	    
	    $tabIncptvHT	=   '<li id="tabIncptvHT">
					<a href="#k2tabIncptvHT">'.JText::_('PLG_K2_INCPTV_HT').'</a>
				    </li>';
	    $tabIncptvHT_content  = '<div id="k2tabIncptvHT" class="simpleTabsContent" >'.$tabIncptvHT_innerHtml.'</div>';
	    
	    echo $tabIncptvHT.$tabIncptvHT_content;
	}
    }
}
