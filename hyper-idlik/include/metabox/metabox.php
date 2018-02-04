<?php
add_action('add_meta_boxes', 'gt_infocustom_meta_box');
add_action('transition_post_status', 'gt_infocutom_meta_save', 10, 3);
function gt_infocustom_meta_box() {
    $screens = array('products');
    foreach ($screens as $screen){
        add_meta_box('gt_infocustom_meta_box', 'اطلاعات محصول', 'gt_infocustom_form', $screen, 'normal', 'high');
    }
}

function gt_infocustom_form($post){
	
	
	$price = get_post_meta($post->ID, 'price', true);
	$offer = get_post_meta($post->ID, 'offer', true);
	?>
	<div class="panel-wrap">
       <table>
           <tr>
               <td>
                   قیمت
               </td>
               <td>
                   <input type="text" placeholder="قیمت" name="price" value="<?php echo $price; ?>">
               </td>
               
           </tr>
		   <tr>
               <td>
                   تخفیف
               </td>
               <td>
                   <input type="text" placeholder="در صورت تخفیف، قیمت تخفیف را وارد کنید." name="offer" value="<?php echo $offer; ?>">
               </td>
               
           </tr>
       </table>
    </div>
<?php
}
function gt_infocutom_meta_save($new_status, $old_status, $post){
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}
	if(isset($_POST['price'])){ $price=trim($_POST['price']," ") ;update_post_meta($post->ID,'price', sanitize_text_field($price)); }
	if(isset($_POST['offer'])){ $offer=trim($_POST['offer']," ") ;update_post_meta($post->ID,'offer', sanitize_text_field($offer)); }
    
   
}