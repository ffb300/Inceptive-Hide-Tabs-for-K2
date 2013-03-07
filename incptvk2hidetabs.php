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
	    
	    $category = JTable::getInstance('K2Category', 'Table');
	    $category->load($item->catid);
	    $incptvK2CategorySpecificParams = new K2Parameter($category->plugins, '', $this->pluginName);
	    $parameteres = $incptvK2CategorySpecificParams->get('Params');
	    if($parameteres == null || ($parameteres != null && $parameteres->incptvk2hidetabsUseCategorySpecific == 'false'))
	    {
		$incptvk2htPluginData = new K2Parameter($item->plugins, '', $this->pluginName);
		$plugin = JPluginHelper::getPlugin('k2', $this->pluginName);			
		$incptvk2htPluginData = new JRegistry();
		$incptvk2htPluginData->loadString($plugin->params, 'JSON');			
		$k2htContent = $incptvk2htPluginData->get('k2htContent');
		$k2htImage = $incptvk2htPluginData->get('k2htImage');
		$k2htImageGallery = $incptvk2htPluginData->get('k2htImageGallery');
		$k2htMedia = $incptvk2htPluginData->get('k2htMedia');
		$k2htExtraFields = $incptvk2htPluginData->get('k2htExtraFields');	    
		$k2htAttachments = $incptvk2htPluginData->get('k2htAttachments');
		$k2htPlugins = $incptvk2htPluginData->get('k2htPlugins');
	    }
	    else
	    {	
		$k2htContent = $parameteres->incptvk2hidetabsContent;
		$k2htImage = $parameteres->incptvk2hidetabsImage;
		$k2htImageGallery = $parameteres->incptvk2hidetabsImageGallery;
		$k2htMedia = $parameteres->incptvk2hidetabsMedia;
		$k2htExtraFields = $parameteres->incptvk2hidetabsExtraFields;
		$k2htAttachments = $parameteres->incptvk2hidetabsAttachments;
		$k2htPlugins = $parameteres->incptvk2hidetabsPlugins;
	    }
	    
	    $script = "var incptvK2 = jQuery.noConflict();"; 
	    $script .= "incptvK2(document).ready(function () {"; 
	    
	    if($k2htContent == "hide")
	    {
		if($k2htImage != "hide")
		{
		    $script .= "imageTab = $('tabImage');";
		    $script .= "imageTab.addClass('ui-tabs-selected ui-state-active');";
		    $script .= "imageContainer = $('k2Tab2');";
		    $script .= "imageContainer.removeClass('ui-tabs-hide');";
		}
		elseif ($k2htImageGallery != "hide") 
		{
		    $script .= "imageGalleryTab = $('tabImageGallery');";
		    $script .= "imageGalleryTab.addClass('ui-tabs-selected ui-state-active');";
		    $script .= "imageGalleryContainer = $('k2Tab3');";
		    $script .= "imageGalleryContainer.removeClass('ui-tabs-hide');";
		}
		elseif ($k2htMedia != "hide")
		{
		    $script .= "mediaTab = $('tabVideo');";
		    $script .= "mediaTab.addClass('ui-tabs-selected ui-state-active');";
		    $script .= "mediaContainer = $('k2Tab4');";
		    $script .= "mediaContainer.removeClass('ui-tabs-hide');";
		}
		elseif ($k2htExtraFields != "hide")
		{
		    $script .= "extraFieldsTab = $('tabExtraFields');";
		    $script .= "extraFieldsTab.addClass('ui-tabs-selected ui-state-active');";
		    $script .= "extraFieldsContainer = $('k2Tab5');";
		    $script .= "extraFieldsContainer.removeClass('ui-tabs-hide');";
		}
		elseif ($k2htAttachments != "hide")
		{
		    $script .= "attachmentsTab = $('tabExtraFields');";
		    $script .= "attachmentsTab.addClass('ui-tabs-selected ui-state-active');";
		    $script .= "attachmentsContainer = $('k2Tab6');";
		    $script .= "attachmentsContainer.removeClass('ui-tabs-hide');";
		}
		
		$script .= "contentTab = $('tabContent');";
		$script .= "contentTab.setStyle('display','none');";
		$script .= "contentTab.removeClass('ui-tabs-selected ui-state-active');";
		$script .= "contentContainer = $('k2Tab1');";
//		$script .= "contentContainer.setStyle('display','none');";
		$script .= "contentContainer.addClass('ui-tabs-hide');";
	    }
	    
	    if($k2htImage == "hide")
	    {
		$script .= "imageTab = $('tabImage');";
		$script .= "imageTab.setStyle('display','none');";
		$script .= "imageContainer = $('k2Tab2');";
		$script .= "imageContainer.setStyle('display','none');";
	    }
	    
	    if($k2htImageGallery == "hide")
	    {
		$script .= "imageGalleryTab = $('tabImageGallery');";
		$script .= "imageGalleryTab.setStyle('display','none');";
//		$script .= "imageGalleryContainer = $('k2Tab3');";
//		$script .= "imageGalleryContainer.setStyle('display','none');";
	    }
	    
	    if($k2htMedia == "hide")
	    {
		$script .= "mediaTab = $('tabVideo');";
		$script .= "mediaTab.setStyle('display','none');";
//		$script .= "mediaContainer = $('k2Tab4');";
//		$script .= "mediaContainer.setStyle('display','none');";
	    }
	    
	    if($k2htExtraFields == "hide")
	    {
		$script .= "extraFieldsTab = $('tabExtraFields');";
		$script .= "extraFieldsTab.setStyle('display','none');";
//		$script .= "extraFieldsContainer = $('k2Tab5');";
//		$script .= "extraFieldsContainer.setStyle('display','none');";
	    }
	    
	    if($k2htAttachments == "hide")
	    {
		$script .= "attachmentsTab = $('tabAttachments');";
		$script .= "attachmentsTab.setStyle('display','none');";
//		$script .= "attachmentsContainer = $('k2Tab6');";
//		$script .= "attachmentsContainer.setStyle('display','none');";
	    }
	    
	    if($k2htPlugins == "hide")
	    {
		$script .= "pluginsTab = $('tabPlugins');";
		$script .= "if(pluginsTab !== null) {";
		$script .= "pluginsTab.setStyle('display','none');";
		$script .= "}";
//		$script .= "pluginsContainer = $('k2Tab7');";
//		$script .= "pluginsContainer.setStyle('display','none');";
	    }
	    
	    $script .= "});";
	    $document->addScriptDeclaration( $script );
	    //$document->addScript($path.'plugins/k2/'.$plugin_folder.'/js/incptvk2hidetabs.php');
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
