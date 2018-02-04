<?php 
	if(isset($_REQUEST['ins_sabad'])){
			global $wpdb;
			$wpdb->insert( 'sabad',
				array( 'eshetrak'=>$_REQUEST['eshterak'], 'idpro'=>$_REQUEST['idpro'], 'tedad'=>$_REQUEST['tedad'] ),
				array( '%d', '%d', '%d')
			);
			$response = array();
			$response['success'] = true;
			echo json_encode($response);
			exit();
	}


	if(isset($_REQUEST['get_ghaza'])){
			global $wpdb;
			$sql = "select * from ghaza";
			$res = $wpdb->get_results($sql);
			echo json_encode($res);
			exit();
	}
	if(isset($_REQUEST['register'])){
			global $wpdb;
			$sql = "select * from ghaza";
			$res = $wpdb->get_results($sql);
			echo json_encode($res);
			exit();
	}
	if(isset($_REQUEST['login'])){
			global $wpdb;
			$sql = "select * from ghaza";
			$res = $wpdb->get_results($sql);
			echo json_encode($res);
			exit();
	}
	if(isset($_REQUEST['search'])){
			global $wpdb;
			$sql = "select * from ghaza";
			$res = $wpdb->get_results($sql);
			echo json_encode($res);
			exit();
	}
	if(isset($_REQUEST['menu'])){
			global $wpdb;
			$sql = "select * from ghaza";
			$res = $wpdb->get_results($sql);
			echo json_encode($res);
			exit();
	}
	if(isset($_REQUEST['login'])){
			global $wpdb;
			$sql = "select * from ghaza";
			$res = $wpdb->get_results($sql);
			echo json_encode($res);
			exit();
	}
	
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			$terms = get_terms( array(
				'taxonomy' = 'product_type_f',
				'hide_empty' = false,
				'parent' =0
			) 
			);
			$c=count($terms);
			for ($i=0; $i  $c ; $i++){
				$term_link = get_term_link($terms[$i]);
				$image_id = get_term_meta( $terms[$i]-term_id, 'image', true );
				$image_data = wp_get_attachment_image_src( $image_id, 'full' );
				$image = $image_data[0];
					php
					if(!empty($image)){
						echo 'img src=' . esc_url( $image ) . ' ';
					}
					?>