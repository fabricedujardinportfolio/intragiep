jQuery(document).ready(function() {
				  var afmui = ['toolbar', 'tree', 'path', 'stat'];
				  if(fmaatts.ui != '') {
				    var fmui_params = fmaatts.ui;
				  if(fmui_params == 'files') {
					var afmui = [];
				  } else 
				    var afmui = fmui_params.split(",");
				   }
				 jQuery('#file_manager_advanced').elfinder(
					// 1st Arg - options
					{
						cssAutoLoad : false,               // Disable CSS auto loading
					    url : fmaatts.ajaxurl,  // connector URL (REQUIRED),						
						lang: fmaatts.lang,					
					
					    defaultView : fmaatts.view,
					
					    dateFormat : fmaatts.dateformat,
					
						customData : {action: 'fma_load_shortcode_fma_ui',
					   _fmakey: fmaatts.fmakey,
						path:fmaatts.path,
						url:fmaatts.url,
					    w: fmaatts.w,
						r: fmaatts.r,
						hide: fmaatts.hide,
						operations: fmaatts.operations,
						path_type: fmaatts.path_type,
						hide_path: fmaatts.hide_path,
						enable_trash: fmaatts.enable_trash,
					},
						height: fmaatts.height,
						width: fmaatts.width,
						ui: afmui
					});


});