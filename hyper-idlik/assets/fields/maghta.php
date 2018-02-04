<select id="maghta_reg_user_" class="form-control select-control-reg">
	<option value="0">مقطع تحصیلی</option>
	<?php
	global $wpdb;
	$sql_select_paye = "select * from tb_paye";
	$get_paye = $wpdb->get_results($sql_select_paye);
	if($wpdb->num_rows > 0){
		foreach($get_paye as $row_paye){ ?>
			<option value="<?php echo $row_paye->paye_code; ?>">
				<?php echo $row_paye->paye_name; ?>
			</option>
		<?php
		}
	}
	?>
</select>