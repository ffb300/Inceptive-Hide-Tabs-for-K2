<?php
/**
* @package		Inceptive Hide Tabs for K2
* @author		Inceptive Design Labs - http://www.inceptive.gr
* @copyright	Copyright (c) 2006 - 2016 Inceptive GP. All rights reserved.
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

  var $plg_copyrights_start		= "\n\n<!-- Inceptive Hide Tabs for K2 Plugin (v1.2) starts here -->\n";
  var $plg_copyrights_end		= "\n<!-- Inceptive Hide Tabs for K2 Plugin (v1.2) ends here -->\n\n";

  // Constructor
  public function __construct(&$subject, $config)
  {
    // Construct
    parent::__construct($subject, $config);
  }

  function onRenderAdminForm (&$item, $type, $tab='') {
    JLoader::register('K2HelperStats', JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'stats.php');
    $K2_VERSION = class_exists('K2HelperStats') ? "ge27" : "lt27";

    if ($tab == 'other' && $type == 'item') {
      $document 		= JFactory::getDocument();
      $path 		= str_replace("/administrator", "",JURI::base(true));
      $document->addScript($path.DS.'plugins'.DS.'k2'.DS.'incptvk2hidetabs'.DS.'js'.DS.'incptvk2hidetabsactiveprofile.js.php?cid='.$item->id);
      $document->addScript($path.DS.'plugins'.DS.'k2'.DS.'incptvk2hidetabs'.DS.'js'.DS.'incptvk2hidetabsItem.js');
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
        $useCategorySpecific = '0';
        $content = '1';
        $image = '1';
        $imageGallery = '1';
        $media = '1';
        $extraFields = '1';
        $attachments = '1';
        $plugins = '1';
      }
      $mainframe 		= JFactory::getApplication();
      $document 		= JFactory::getDocument();
      $path 		= str_replace("administrator/", "",JURI::base());
      $plugin_folder 	= basename(dirname(__FILE__));
      $document->addScript($path.'plugins/k2/'.$plugin_folder.'/js/incptvk2hidetabs.js');
      $document->addStyleSheet($path.'plugins/k2/'.$plugin_folder.'/css/style.css');

      //Loading the appropriate language files
      $lang = JFactory::getLanguage();
      $languagePath = JPATH_PLUGINS.DS.'k2'.DS.'incptvk2hidetabs';
      $lang->load("plg_k2_incptvk2hidetabs", $languagePath, null, false);


      $valueHide = new stdClass();
      $valueHide->value = '0';
      $valueHide->text = JText::_('PLG_K2_INCPTV_HT_HIDE');
      $valueShow = new stdClass();
      $valueShow->value = '1';
      $valueShow->text = JText::_('PLG_K2_INCPTV_HT_SHOW');
      $values = array($valueHide, $valueShow);

      $valueUseFalse = new stdClass();
      $valueUseFalse->value = '0';
      $valueUseFalse->text = JText::_('PLG_K2_INCPTV_HT_FALSE');
      $valueUseTrue = new stdClass();
      $valueUseTrue->value = '1';
      $valueUseTrue->text = JText::_('PLG_K2_INCPTV_HT_TRUE');
      $valuesUse = array($valueUseFalse, $valueUseTrue);
      $tabIncptvHT_innerHtml  = '<div id="k2tabIncptvHTContainerOld">';
      $tabIncptvHT_innerHtml  .= '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_('PLG_K2_INCPTV_HT_CATEGORY_SPECIFIC_PARAMS').'</div><div class="k2clr"></div></div>';
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
      $tabIncptvHT_innerHtml .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 = '<div id="k2tabIncptvHTContainerNew">';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27  .= '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_('PLG_K2_INCPTV_HT_CATEGORY_SPECIFIC_PARAMS').'</div><div class="k2clr"></div></div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_USE_CATEGORY_SPECIFIC').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $valuesUse, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsUseCategorySpecific]', '', 'value', 'text', $useCategorySpecific);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_('PLG_K2_INCPTV_HT_PARAMS').'</div><div class="k2clr"></div></div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_CONTENT').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsContent]', '', 'value', 'text', $content);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_IMAGE').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsImage]', '', 'value', 'text', $image);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_IMAGE_GALLERY').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsImageGallery]', '', 'value', 'text', $imageGallery);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_MEDIA').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsMedia]', '', 'value', 'text', $media);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_EXTRA_FIELDS').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsExtraFields]', '', 'value', 'text', $extraFields);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_ATTACHMENTS').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsAttachments]', '', 'value', 'text', $attachments);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalField">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="k2FLeft k2Right itemAdditionalValue">';
      $tabIncptvHT_innerHtmlK2ge27 .= '<label>'.JText::_('PLG_K2_INCPTV_HT_PLUGINS').'</label>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '<div class="itemAdditionalData">';
      $tabIncptvHT_innerHtmlK2ge27 .= JHTML::_('select.radiolist', $values, 'plugins[incptvk2hidetabsParams][incptvk2hidetabsPlugins]', '', 'value', 'text', $plugins);
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';
      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT_innerHtmlK2ge27 .= '</div>';

      $tabIncptvHT	=   '<li id="tabIncptvHT">';
      if($K2_VERSION == 'lt27') {
        $tabIncptvHT .= '<a href="#k2tabIncptvHT" id="k2tabIncptvHTold">'.JText::_('PLG_K2_INCPTV_HT').'</a>';
      }
      else {
        $tabIncptvHT .= '<a href="#k2tabIncptvHT" id="k2tabIncptvHTge27"><i class="fa fa-eye-slash" aria-hidden="true"></i> '.JText::_('PLG_K2_INCPTV_HT').'</a>';
      }

      $tabIncptvHT .= '</li>';

      if($K2_VERSION == 'lt27')
        $tabIncptvHT_content  = '<div id="k2tabIncptvHT" class="simpleTabsContent k2TabsContent k2TabsContentLower" >'.$tabIncptvHT_innerHtml .'</div>';
      else {
        $tabIncptvHT_content  = '<div id="k2tabIncptvHT" class="simpleTabsContent k2TabsContent k2TabsContentLower" >'. $tabIncptvHT_innerHtmlK2ge27 .'</div>';
      }

      echo $tabIncptvHT.$tabIncptvHT_content;
    }
  }
}
