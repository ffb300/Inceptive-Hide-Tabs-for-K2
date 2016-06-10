<?php
/**
* @package		Inceptive Hide Tabs for K2
* @author		Inceptive Design Labs - http://www.inceptive.gr
* @copyright	Copyright (c) 2006 - 2016 Inceptive GP. All rights reserved.
* @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/

define( '_JEXEC', 1 );
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'DS', DIRECTORY_SEPARATOR );

$jpath_base = realpath(dirname(__FILE__).'/../../../..' );

if(file_exists($jpath_base .'/'.'includes')):
  define( 'JPATH_BASE', $jpath_base);
  require_once ( $jpath_base .'/'.'includes'.'/'.'defines.php' );
  require_once ( $jpath_base .'/'.'includes'.'/'.'framework.php' );
endif;

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();

if(version_compare(JVERSION, '3.0', 'ge')) { define( 'K2_JVERSION', '30' ); }

JLoader::register('K2Table', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'tables'.DS.'table.php');
JLoader::register('K2Parameter', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2parameter.php');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'tables');
$catid = JRequest::getInt('cid');
$category = JTable::getInstance('K2Category', 'Table');

$category->load($catid);
$incptvK2CategorySpecificParams = @new K2Parameter($category->plugins, '', 'incptvk2hidetabs');
$parameters = $incptvK2CategorySpecificParams->get('Params');
if($parameters == null || ($parameters != null && $parameters->incptvk2hidetabsUseCategorySpecific == '0'))
{
  $incptvk2htPluginData = @new K2Parameter($item->plugins, '', 'incptvk2hidetabs');
  $plugin = JPluginHelper::getPlugin('k2', 'incptvk2hidetabs');
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
  $k2htContent = $parameters->incptvk2hidetabsContent;
  $k2htImage = $parameters->incptvk2hidetabsImage;
  $k2htImageGallery = $parameters->incptvk2hidetabsImageGallery;
  $k2htMedia = $parameters->incptvk2hidetabsMedia;
  $k2htExtraFields = $parameters->incptvk2hidetabsExtraFields;
  $k2htAttachments = $parameters->incptvk2hidetabsAttachments;
  $k2htPlugins = $parameters->incptvk2hidetabsPlugins;
}

echo json_encode(
array(
  'k2htContent' => $k2htContent,
  'k2htImage' => $k2htImage,
  'k2htImageGallery' => $k2htImageGallery,
  'k2htMedia' => $k2htMedia,
  'k2htExtraFields' => $k2htExtraFields,
  'k2htAttachments' => $k2htAttachments,
  'k2htPlugins' => $k2htPlugins)
);
