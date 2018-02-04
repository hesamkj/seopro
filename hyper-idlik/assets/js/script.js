jQuery(document).ready(function(){
	
	
	jQuery('#top-search-items #city').change(function(){
		var v = jQuery(this).find('option:selected').html();
		updateUrlParameter("city", v);
	});
	
	jQuery('#dcity').change(function(){
		jQuery('#dtown').html("<option>لطفا صبر کنید...</option>");
		var v = jQuery(this).find('option:selected').val();
		$.post("", {get_dtown:1 , city:v}, function(data){
			jQuery('#dtown').html(data);
		});
	});
	
	jQuery('#ecity').change(function(){
		jQuery('#etown').html("<option>لطفا صبر کنید...</option>");
		var v = jQuery(this).find('option:selected').val();
		$.post("", {get_dtown:1 , city:v}, function(data){
			jQuery('#etown').html(data);
		});
	});
	
	jQuery('#ccity').change(function(){
		jQuery('#ctown').html("<option>لطفا صبر کنید...</option>");
		var v = jQuery(this).find('option:selected').val();
		$.post("", {get_dtown:1 , city:v}, function(data){
			jQuery('#ctown').html(data);
		});
	});
	
	jQuery('#edu-city').change(function(){
		jQuery('#edu-town').html("<option>لطفا صبر کنید...</option>");
		var v = jQuery(this).find('option:selected').val();
		$.post("", {get_dtown:1 , city:v}, function(data){
			jQuery('#edu-town').html(data);
		});
	});
	
	jQuery('.rad_btn').click(function(){
		var name = jQuery(this).find('input').attr('name');
		jQuery('input[name='+name+']').parent().removeClass('active_btn');
		jQuery('input[name='+name+']').attr('checked', false);
		jQuery(this).addClass('active_btn');
		//jQuery(this).find('input').attr('checked', true);
		this.checked = true;
	});

	jQuery("form.no-submit").submit(function(e){
        e.preventDefault();
    });
	
	jQuery('.renew-captcha').click(function(){
		var id = jQuery(this).attr('id');
		jQuery(this).addClass('fa-spin');
		var res = id.split("_");
		jQuery('#code-'+res[1]).html("صبر کنید");
		jQuery.post("", {renewcaptcha:1},function(data){
			jQuery('#code-'+res[1]).html(data);
		});
		jQuery(this).removeClass('fa-spin');
	});
	
});