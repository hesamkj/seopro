jQuery(document).ready(function(){
	
	jQuery('#quick-sharj').click(function(){
		jQuery('#quick-sharj-result').html("<i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i>");
		var price = jQuery('#quick-sharj-price').val();
		jQuery.post("", {quick_sharj:1, price:price }, function(data){
			jQuery('#quick-sharj-result').html(data);
			jQuery('#go-bank').click();
		});		
	});
	
	jQuery('#quick-sharj-price').keypress(function(e){
		var key = e.which;
		if(key==13)
			jQuery('#quick-sharj').click();
	});
	
	
	jQuery('#pay-from-credit').click(function(){
		jQuery('#pay-from-credit-result').html("<ul><li><i class='fa fa fa-spinner fa-spin' style='font-size:20px; padding: 5px 0;'></i></li></ul>");
		var uid = jQuery('#uid').val();
		var ads_id = jQuery('#ads_id').val();
		jQuery.post("", {pay_from_credit:1, uid:uid, ads_id:ads_id}, function(data){
			jQuery('#pay-from-credit-result').html(data);
		});
	});
	
});