<select name="reshte_reguser" id="reshte_reguser_" class="form-control select-control-reg" >
	<option value="0">رشته تحصیلی</option>
	<?php
  	$sql_select_reshte = " Select * From tb_reshte";
  	$get_reshte = $wpdb->get_results($sql_select_reshte);
  	if($wpdb->num_rows > 0){
		foreach($get_reshte as $row_reshte){ ?>
			<option class="<?php echo $row_reshte->base; ?>" value="<?php echo $row_reshte->reshte_code; ?>">
				<?php echo $row_reshte->reshte_name; ?>
			</option>
			<?php
		}
	}
	?>
</select>