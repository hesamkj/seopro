<?php
add_action('show_user_profile', 'gt_user_meta_fields');
add_action('edit_user_profile', 'gt_user_meta_fields');
function gt_user_meta_fields($user){ ?>
	<h3>اطلاعات تماس</h3>
	<table class="form-table">
		<tr>
			<td>
				<label>موبایل</label><br>
				<input type="text" name="mobile" value="<?php echo esc_attr( get_the_author_meta( 'mobile', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			
			<td>
				<label>ادرس</label><br>
				<textarea name="address" class="regular-text" ><?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?> </textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label>کد اشتراک</label><br>
			
				<input type="text" class="" name="code-e" value="<?php echo esc_attr( get_the_author_meta( 'codee', $user->ID ) ); ?>" disabled/>
			</td>
		</tr>
		
		<tr>
			
			
	</table>
	<?php
}

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
function my_save_extra_profile_fields($user_id){
	if(!current_user_can('edit_user', $user_id))
		return false;
	update_user_meta($user_id, 'mobile', $_POST['mobile']);
	update_user_meta($user_id, 'address', $_POST['address']);
}


add_action('register_form','show_first_name_field');
add_action('register_post','check_fields',10,3);
add_action('user_register', 'register_extra_fields');
add_action( 'user_new_form', 'show_first_name_field' );
function show_first_name_field()
{
?>
    <table class="form-table">
		<tr>
			<td>
				<label>موبایل</label><br>
				<input type="text" name="mobile" value="<?php echo esc_attr( get_the_author_meta( 'mobile', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			
			<td>
				<label>ادرس</label><br>
				<textarea name="address" class="regular-text" ><?php echo esc_attr( get_the_author_meta( 'town', $user->ID ) ); ?> </textarea>
			</td>
		</tr>
		
			
	</table>
<?php
}

function check_fields ( $login, $email, $errors )
{
    if ( $_POST['address'] == '' ||  $_POST['mobile'] == '')
    {
        $errors->add( 'empty_realname', "<strong>ERROR</strong>: ادرس و موبایل را چک کنید" );
    }
}

function register_extra_fields ( $user_id, $password = "", $meta = array() )
{
    
	global $wpdb;
	$sql="select meta_value from wp_usermeta where meta_key ='codee' order by meta_value desc LIMIT 1";
	$res = $wpdb->get_results($sql);
	foreach($res as $row)
	{
		$lastcodee= $row->meta_value+1;
	}
	update_user_meta( $user_id, 'codee',$lastcodee);
	update_user_meta($user_id, 'mobile', $_POST['mobile']);
	update_user_meta($user_id, 'address',  $_POST['address']);
	wp_set_password( $mobile, $user_id );
}
?>