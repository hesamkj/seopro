function updateUrlParameter(param, value){
    var url = window.location.href;
	var regex = new RegExp('('+param+'=)[^\&]+');
    window.location.href = url.replace( regex , '$1' + value);
}

jQuery(document).ready(function(){
	
	jQuery("form.no-submit").submit(function(e){
        e.preventDefault();
    });
		
	jQuery('#section').change(function(){
		var val = jQuery(this).find('option:selected').val();
		jQuery('#field-parent').val(val);
		var str = jQuery(this).find('option:selected').html();
		if(str=="انتخاب مقطع"){
			jQuery('#field').attr("disabled", true);
			jQuery('#trend').attr("disabled", true);	
		}else{
			jQuery('#field').attr("disabled", false);
			jQuery('#trend').attr("disabled", false);
		}
	});

	jQuery('#field').attr("disabled", true);
	jQuery('#trend').attr("disabled", true);
	jQuery('#job').attr("disabled", true);
	
	jQuery('#field').keyup(function(){
		var v = jQuery(this).val();
		if(v!=""){
			jQuery('#field-reset').show();
		}else{
			jQuery('#field-reset').hide();
		}
	});
	
	jQuery('#job').keyup(function(){
		var v = jQuery(this).val();
		if(v!=""){
			jQuery('#field-reset').show();
		}else{
			jQuery('#field-reset').hide();
		}
	});
	
	jQuery('#uni-id').keyup(function(){
		var v = jQuery(this).val();
		if(v!=""){
			jQuery('#uni-id-reset').show();
		}else{
			jQuery('#uni-id-reset').hide();
		}
	});

	jQuery('#field-reset').click(function(){ jQuery(this).hide(); });
	jQuery('#uni-id-reset').click(function(){ jQuery(this).hide(); });

	jQuery('#field').keyup(function(){
		jQuery('#field-result').html("<ul class='combo-result'><li><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
		var val = jQuery(this).val();
		var parent = jQuery('#field-parent').val();
		if(val!=""){
			jQuery.post("", {get_field:1, val:val, parent:parent, class:"field"},function(data){
				jQuery('#field-result').html(data);
			});
		}else{
			jQuery('#field-result').html("");
		}
	});
	
	jQuery('#job').keyup(function(){
		jQuery('#job-result').html("<ul class='combo-result'><li class='job-item'><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
		var val = jQuery(this).val();
		var parent = jQuery('#job-parent').val();
		if(val!=""){
			jQuery.post("", {get_job:1, val:val, parent:parent, class:"field"},function(data){
				jQuery('#job-result').html(data);
			});
		}else{
			jQuery('#job-result').html("");
		}
	});
	
	jQuery('#uni-id').keyup(function(){
		jQuery('#uni-id-result').html("<ul class='combo-result'><li class='job-item'><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
		var val = jQuery(this).val();
		//var parent = jQuery('#field-parent').val();
		if(val!=""){
			jQuery.post("", {get_uni:1, val:val},function(data){
				jQuery('#uni-id-result').html(data);
			});
		}else{
			jQuery('#uni-id-result').html("");
		}
	});
	
	
	jQuery('#trend').keyup(function(){
		var v = jQuery(this).val();
		if(v!=""){
			jQuery('#trend-reset').show();
		}else{
			jQuery('#trend-reset').hide();
		}
	});

	jQuery('#trend-reset').click(function(){ jQuery(this).hide(); });

	jQuery('#trend').keyup(function(){
		jQuery('#trend-result').html("<ul><li><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
		var val = jQuery(this).val();
		var parent = jQuery('#trend-parent').val();
		if(val!=""){
			jQuery.post("", {get_field:1, val:val, parent:parent, class:"trend"},function(data){
				jQuery('#trend-result').html(data);
			});
		}else{
			jQuery('#trend-result').html("");
		}
	});
	
	jQuery('#job-result').hide();
	jQuery('#skill-result').hide();
	jQuery('#uni-result').hide();
	
	
	jQuery('body').click(function(e){
		//var target = e.target;
		//var cid = e.target.parentNode.id;
		var cid = jQuery(e.target).attr('class');
		jQuery('#job-result').hide();	
		jQuery('#skill-result').hide();
		var readonlyj = $('#job').attr("readonly");
		if(readonlyj && readonlyj.toLowerCase()!=='false') { }else{
			jQuery('#job-result').hide();
			jQuery('#job-reset').hide();
			jQuery('#job').val("");
		}
		var readonly = $('#skill').attr("readonly");
		if(readonly && readonly.toLowerCase()!=='false') { }else{
			jQuery('#skill-result').hide();
			jQuery('#skill-reset').hide();
			jQuery('#skill').val("");
		}
		var readonlyu = $('#uni').attr("readonly");
		if(readonlyu && readonlyu.toLowerCase()!=='false') { }else{
			jQuery('#uni-result').hide();
			jQuery('#uni-reset').hide();
			jQuery('#uni').val("");
		}
	});
	
	
	jQuery('#job-group').click(function(event){
		event.stopPropagation();
	});
	
	function reset_btn(id){
		jQuery('#'+id+'-reset').click(function(){
			jQuery(this).hide();
			jQuery('#'+id).removeAttr('readonly');
		});
	}
	reset_btn("job");
	reset_btn("skill");
	reset_btn("uni-id");
	
	jQuery('#job-group').change(function(){	
		jQuery('#job').attr("disabled", false);
		jQuery('#job-reset').click();
		jQuery('#job-result').show();
		var gparent = jQuery(this).find('option:selected').val();
		jQuery('#job-parent').val(gparent);
		jQuery('#job-result').show();
		jQuery('#job-result').html("<ul><li><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
		jQuery.post("", {get_job:1, all:1,parent:gparent},function(data){
			jQuery('#job-result').html(data);
		});	
	});

	
	function on_search(id){
		jQuery('#'+id).keyup(function(){
			if(jQuery('#'+id).attr('readonly') == undefined){
				jQuery('#'+id+'-result').show();
				jQuery('#'+id+'-result').html("<ul><li><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
				var val = jQuery(this).val();
				var parent = jQuery('#'+id+'-parent').val();
				if(val!=""){
					jQuery('#'+id+'-reset').show();
					jQuery.post("", {get_job:1, val:val, parent:parent},function(data){
						jQuery('#job-result').html(data);
					});
				}else{
					jQuery('#'+id+'-reset').hide();
					jQuery.post("", {get_field:"all", val:val, parent:parent},function(data){
						jQuery('#'+id+'-result').html(data);
					});
				}
			}
		});
	}
	on_search("job");
	
	
	function on_search_other(id){
		jQuery('#'+id).keyup(function(){
			if(jQuery('#'+id).attr('readonly') == undefined){
				jQuery('#'+id+'-result').show();
				jQuery('#'+id+'-result').html("<ul><li><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
				var tax = id+"_tax";
				var name = jQuery(this).val();
				if(name!=""){
					jQuery('#'+id+'-reset').show();
					jQuery.post("", {get_field_other:1, name:name, tax:tax},function(data){
						jQuery('#'+id+'-result').html(data);
					});
				}else{
					jQuery('#'+id+'-reset').hide();
					jQuery.post("", {get_field_other:"all", name:name, tax:tax},function(data){
						jQuery('#'+id+'-result').html(data);
					});
				}
			}
		});
	}
	on_search_other("skill");
	on_search_other("uni");

	jQuery('#skill-cat').change(function(){
		var str = jQuery(this).find('option:selected').html();
		if(str=="مهارت زبان های خارجه"){
			jQuery('.skills1').hide();
			jQuery('.skills2').show();
		}else{
			jQuery('.skills2').hide();
			jQuery('.skills1').show();
		}
	});
    
});

jQuery(document).on('click', '.field-item', function(){
	var item = jQuery(this).find('span').html();
	jQuery('#field').val(item);
	var parent = jQuery(this).find('input').val();
	jQuery('#trend-parent').val(parent);
	jQuery('#field-result').find('ul').hide();
});

jQuery(document).on('click', '.job-item', function(){
	var item = jQuery(this).find('span').html();
	jQuery('#job').val(item);
	var vid = jQuery(this).find('input').val();
	jQuery("#job-value").val(vid);
	jQuery('#job-result').find('ul').hide();
});

jQuery(document).on('click', '.trend-item', function(){
	var item = jQuery(this).find('span').html();
	jQuery('#trend').val(item);
	var parent = jQuery(this).find('input').val();
	jQuery('#trend-result').find('ul').hide();
});

jQuery(document).on('click', '.uni-id-item', function(){
	var item = jQuery(this).find('span').html();
	jQuery('#trend').val(item);
	var parent = jQuery(this).find('input').val();
	jQuery('#trend-result').find('ul').hide();
});

function click_item(id){
	jQuery(document).on('click', '.'+id+'-item', function(){
		jQuery('#'+id+'-reset').show();
		var item = jQuery(this).find('span').html();
		jQuery('#'+id).val(item);
		var v = jQuery(this).find('input').val();
		jQuery('#'+id+'_val').val(v);
		jQuery('#'+id).attr("readonly", true);
		jQuery('#'+id+'-result').hide();
	});
}
click_item("job");
click_item("skill");
click_item("uni-id");