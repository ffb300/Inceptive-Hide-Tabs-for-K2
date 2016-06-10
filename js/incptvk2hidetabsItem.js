/**
* @package		Inceptive Hide Tabs for K2
* @author		Inceptive Design Labs - http://www.inceptive.gr
* @copyright	Copyright (c) 2006 - 2016 Inceptive GP. All rights reserved.
* @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/
var $incptvK2 = jQuery.noConflict();

$incptvK2(document).ready(function(){

  $incptvK2('#catid').change(function () {
    var selectedValue = $incptvK2(this).val();
    var tabs = $incptvK2('#k2Tabs').tabs();
    var url = K2BasePath + '../plugins/k2/incptvk2hidetabs/helpers/incptvk2hidetabshelper.php?cid=' + selectedValue;
    $incptvK2('#mefgTabs').remove();
    $incptvK2.ajax({
      url : url,
      type : 'get',
      success : function(response) {
        var hideTabsParameters = JSON.parse(response);
        $incptvK2.each( hideTabsParameters, function( key, value ) {
          if(key == 'k2htContent')
          {
            (value == '1') ? $incptvK2('#k2Tabs #tabContent').show() : $incptvK2('#k2Tabs #tabContent').hide();
          }

          if(key == 'k2htImage')
          {
            (value == '1') ? $incptvK2('#tabImage').show() : $incptvK2('#tabImage').hide();
          }

          if(key == 'k2htImageGallery')
          {
            (value == '1') ? $incptvK2('#tabImageGallery').show() : $incptvK2('#tabImageGallery').hide();
          }

          if(key == 'k2htMedia')
          {
            (value == '1') ? $incptvK2('#tabVideo').show() : $incptvK2('#tabVideo').hide();
          }

          if(key == 'k2htExtraFields')
          {
            (value == '1') ? $incptvK2('#tabExtraFields').show() : $incptvK2('#tabExtraFields').hide();
          }

          if(key == 'k2htAttachments')
          {
            (value == '1') ? incptvK2('#tabAttachments').show() : incptvK2('#tabAttachments').hide();
          }

          if(key == 'k2htPlugins')
          {
            (value == '1') ? incptvK2('#tabPlugins').show() : incptvK2('#tabPlugins').hide();
          }

        });

        setTimeout(function(){
          $incptvK2('#k2Tabs').find('li:visible:first a').click();
        }, 300);

      }
    });
  });
});
