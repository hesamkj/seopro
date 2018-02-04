<select class="form-control" id="Shahrestan" runat="server" name="town">
	<?php if(is_user_logged_in()){
		$town = get_user_meta($current_user->ID, 'town', true);
		echo "<option>$town</option>";
		} ?>
	شهرستان
</select>