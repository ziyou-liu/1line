/* JCE Editor - 2.4.5 | 09 December 2014 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2014 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
(function(){tinymce.create('tinymce.plugins.ColorPicker',{init:function(ed,url){this.editor=ed;ed.addCommand('mceColorPicker',function(ui,v){ed.windowManager.open({url:ed.getParam('site_url')+'index.php?option=com_jce&view=editor&layout=plugin&plugin=colorpicker',width:375+parseInt(ed.getLang('advanced.colorpicker_delta_width',0)),height:310+parseInt(ed.getLang('advanced.colorpicker_delta_height',0)),close_previous:false,inline:true,popup_css:false},{input_color:v.color,func:v.func});});}});tinymce.PluginManager.add('colorpicker',tinymce.plugins.ColorPicker);})();