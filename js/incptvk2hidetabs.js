/**
 * @version		1.0
 * @package		Inceptive Hide Tabs for K2
 * @author		Inceptive Design Labs - http://www.inceptive.gr
 * @copyright	Copyright (c) 2006 - 2012 Inceptive GP. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

window.addEvent('domready', function () {	
    k2tabs_holder 	= $$('.simpleTabsNavigation');
    tabIncptvHT 	= $('tabIncptvHT');
    k2all_tabs	  	= $('k2Tabs');
    k2tabIncptvHT  	= $('k2tabIncptvHT');

    k2tabs_holder[0].grab(tabIncptvHT,'bottom');	
    k2all_tabs.grab(k2tabIncptvHT, 'bottom');
    tabIncptvHT.setStyle('visibility','visible');
    k2tabIncptvHT.setStyle('visibility','visible');
});