/**
* @package		Inceptive Hide Tabs for K2
* @author		Inceptive Design Labs - http://www.inceptive.gr
* @copyright	Copyright (c) 2006 - 2016 Inceptive GP. All rights reserved.
* @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/

window.addEvent('domready', function () {
  k2tabs_holder 	= $$('.simpleTabsNavigation');
  tabIncptvHT 	= $('tabIncptvHT');
  k2all_tabs	  	= $('k2Tabs');
  k2tabIncptvHT  	= $('k2tabIncptvHT');

  if (typeof (k2tabs_holder[0]) === 'undefined') {
    k2tabs_holder = $$('.k2TabsNavigation');
    k2tabs_holder[0].grab(tabIncptvHT,'bottom');
    // k2tabIncptvHT.removeChild(k2tabIncptvHT.getElementById('k2tabIncptvHTContainerOld'));
    // var node = document.getElementById('k2tabIncptvHTold');
    // node.parentNode.removeChild(node);
  }
  else {
    k2tabs_holder[0].grab(tabIncptvHT,'bottom');
    //var containerNode = k2tabIncptvHT.getElementById('k2tabIncptvHTContainerNew');
    // if(containerNode)
    // {
    //   k2tabIncptvHT.removeChild(containerNode);
    // }
    // var tabNode = document.getElementById('k2tabIncptvHTge27');
    // tabNode.parentNode.removeChild(tabNode);
  }

  k2all_tabs.grab(k2tabIncptvHT, 'bottom');
  tabIncptvHT.setStyle('visibility','visible');
  k2tabIncptvHT.setStyle('visibility','visible');
});
