jQuery(document).ready(function(){
	
	jQuery(".chk_btn").on("click", function () {
		var checkBoxes = jQuery(this).find("input[type='checkbox']");
		//(checkBoxes.prop("checked")==true)?checkBoxes.prop("checked", false):checkBoxes.prop("checked", true);
		if(checkBoxes.prop("checked")==true){
			checkBoxes.prop("checked", false);
			jQuery(this).removeClass('chk_btn_active');
		}else{
			checkBoxes.prop("checked", true);
			jQuery(this).addClass('chk_btn_active');
		}
	});
	
	jQuery('.rad_btn').click(function() {
		jQuery(this).find('input').prop("checked", true);
	});
	
	
	jQuery('.sel_btn').change(function(){
		var name = jQuery(this).attr('name');
		if(name=="military"){
			var val = jQuery(this).find('option:selected').html();
			if(val=="معاف"){
				jQuery('#freedom-wrap').show();
			}else{
				jQuery('#freedom-wrap').hide();
			}
		}
		if(name=="health"){
			var val = jQuery(this).find('option:selected').html();
			if(val=="معلول"){
				jQuery('#disablity-wrap').show();
			}else{
				jQuery('#disablity-wrap').hide();
			}
		}
		if(name=="workstatus"){
			var val = jQuery(this).find('option:selected').html();
			if(val=="قطع همکاری"){
				jQuery('#endreason').show();
			}else{
				jQuery('#endreason').hide();
			}
		}
		if(name=="nationality"){
			var val = jQuery(this).find('option:selected').html();
			if(val=="ایرانی"){
				jQuery('#melli-wrap').show();
				jQuery('#passport-wrap').hide();
			}else{
				jQuery('#passport-wrap').show();
				jQuery('#melli-wrap').hide();
			}
		}
	});
	
});