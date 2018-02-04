<?php
add_action('admin_enqueue_scripts', 'gtglobal_add_theme_scripts');
function app_output_buffer() {
    ob_start();
} // soi_output_buffer
add_action('init', 'app_output_buffer');
add_action('admin_menu', 'mt_add_pages');
function mt_add_pages() {
    add_menu_page('مدیریت', 'فاکتورها', 'manage_options', 'manage-page', 'manage_page' );
    add_submenu_page('manage-page', 'ویرایش فاکتور', 'ویرایش', 'manage_options', 'checkout-page', 'checkout_page');
	add_submenu_page('manage-page', 'سفارشات', 'اضافه کردن', 'manage_options', 'order-page', 'order_page');
	add_submenu_page('manage-page', 'گزارشات مالی', 'نمایش', 'manage_options', 'report-page', 'report_page');
}

function manage_page(){
    
}

function checkout_page() { 
						////// شروع ویرایش در فاکتورها                             
							 
?>
	<h2>ویرایش</h2>
	<div class="wrap">
	<?php 				/////  حذف کد سفارش
	if($_GET['edit']==0 && $_GET['add']==0 && $_GET['del']==1 && $_GET['cancel']==0 && !isset($_POST['submite']) && !isset($_POST['submita']) && !isset($_POST['submitd'])){
             $cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
	?>
	<form action="#" method="post">
	
	<h3>
		<span>ایا از حذف این سفارش مطمئن هستید؟</span>
		<input type="submit" name="subodel" value="بله" class="button button-primary">
		<a href="<?php echo $cu; ?>&orderid=0&del=0&edit=0&add=0&cancel=1" class="button button-secondary">خیر</a>
	</h3>
	</form>
	
	<?php
		 ///////    ویرایش فاکتورها و حذف کالا
		global $wpdb;
		if(isset($_POST['subodel']))
		{
			$cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']."&del=0&cancel=1";
			$orderid=$_GET['orderid'];
			$wpdb->delete( 'factors', array( 'orderid' => $orderid ), array( '%s' ) );
			$wpdb->delete( 'orders', array( 'orderid' => $orderid ), array( '%s' ) );
			ob_clean();
			wp_redirect($cu);
		} 
	}
	if($_GET['edit']==1 && $_GET['add']==0 && $_GET['del']==0 && $_GET['cancel']==0 && !isset($_POST['submite']) && !isset($_POST['submita']) && !isset($_POST['submitd'])){
                                    $cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
                                ///////     صفحه تغییر اطلاعات برحسب شماره سفارش
			?>
		
 
			<div style="width:20%;background: #9b59b6;position: absolute; top: 4em; color: #fff; border: #8e44ad 3px solid; text-align: center; padding: 10px; left: 2em;">
                <form action="#" method="post">
					<span>
						 <input type="text" style="width:100%;" name="product_search" placeholder="دنبال چه محصولی هستید؟" />
					</span>
					<input type="submit" name="submit_search" value="جستجو" class="button button-primary"/>
					<?php 
					if(isset($_POST['submit_search']))
					{
						global $wpdb;
						$product_title= $_POST['product_search'];
						$sql_search="select * from wp_posts where post_type = 'products' and post_title LIKE '%".$product_title."%'";
						$res_search = $wpdb->get_results($sql_search);
						foreach($res_search as $row_search)
						{
							?>
					<span style="float:right; width: 100%; font-size: 1em; padding-top: 10px; border-top: 3px solid #e1b8f3; margin-top: 1em;">
						<img Style="width: 40%; float: right;" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $row_search->ID)); ?>" alt="">
						<strong style="width: 60%; float: right; font-size: 0.9em;font-weight: normal;  text-align: right; height: 30px; padding: 5px 0;">
							<?php
								echo $row_search->post_title;
							?>
						</strong>
						<p style="width: 60%; float: right; height: auto; padding: 5px 0;">
							<?php
							global $wpdb;
							$sql_search_price="select meta_value from wp_postmeta where meta_key = 'price' and post_id = '".$row_search->ID."'";
							$res_search_price = $wpdb->get_results($sql_search_price);
							foreach($res_search_price as $row_search_price)
							{ ?>
							<strong style="width: 100%; float: right; text-align: right;">قیمت : <?php if($row_search_price->meta_value != 0){ echo number_format($row_search_price->meta_value)." تومان";} else{echo "قیمت وارد نشده است.";} ?></strong>
							<?php 
							}
							?>
							
						</p>
						<?php
							echo "<p style='width:100%;float:right;text-align:right;background:#8e44ad'>".$row_search->post_content."</p>";
						?>
						<strong style="width:100%;float:right;text-align:center;margin-top:10px;">
						کد محصول : <?php
								echo $row_search->ID;
								?> 
						</strong>
					</span>
					<?php 
						}
					}
					?>
				</form>
			</div>
    <table style="width:60%;display:inline-block;margin:0;">
              <form action="#" method="post">
               
               <tr>
					<th>کد</th>
                    <th>کد سفارش</th>
                    <th>نام کالا</th>
					<th>کد کالا</th>
                    <th class="price-tb">تعداد</th>
                    <th>قیمت</th>
                    <th style="text-align:center;padding-right:4em;">حذف</th>
                    
               </tr>
			   <?php 
				$orderid=$_GET['orderid'];
				global $wpdb;
				$sql="select * from orders where orderid ='".$orderid."'";
				$res=$wpdb->get_results($sql);
				$i = 1;
				foreach($res as $row)
				{
			   ?>
               <tr>
					<td>
						<?php echo $row->id; ?>
						<input type="hidden" value="<?php echo $row->id; ?>" name="id<?php echo $i; ?>">
					</td>
					<td>
                       <input type="text" disabled name="orderid" id="cproducte" value="<?php echo $row->orderid; ?>" style="width:120px;height:30px;">
					</td>
                   <td>
				   <?php 
					$producti= $row->postid;
					$sqlp="select post_title from wp_posts where ID='".$producti."'";
					$resp=$wpdb->get_results($sqlp);
					
					foreach($resp as $rowp){
					?>
                       <input type="text" placeholder="" disabled id="productnamec" name="product_codeinp-<?php echo $i; ?>" value="<?php echo $rowp->post_title;?>" style="width:120px;height:30px;">
					<?php 
					
					}
					?>
                   </td>
				   <td>
					<input type="text" style="width:50px;height:30px" name="productcn-<?php echo $i; ?>" value="<?php echo $producti ?>"/>
				   </td>
                   <td>
                       <input type="number" name="countp<?php echo $i; ?>" value="<?php echo $row->count; ?>" min="1" style="width:70px;height:30px;">
                   </td>
                   <td style="width:150px">
						
                       <input type="text" name="pricep<?php echo $i; ?>" placeholder="" value="<?php echo $row->price; ?>" style="width:80px;height:30px;">
                       <label style="width:35px;float:left;font-size:12px;margin-top:5px;">تومان</label>
                   </td>
                  <td style="padding-right:4em;text-align:center">
                       <button name="deleteproduct" value="<?php echo $row->postid; ?>" class="" style="width:30px;border-radius:10px;background:red;color:#fff;border:0">X</button>
                  </td>
               </tr>
			   <input type="hidden" value="<?php echo $i;?>" name="rowcount">
				<?php 
				$i++;
				}
				
				?>
    </table>
           
            <div style="width:100%;display:block;margin-top:5em;">
                <span style="display:inline-block">
                    <input type="submit" name="submitee" value="ذخیره تغییرات" class="button button-primary">
                </span>
                <span style="display:inline-block;margin-right:4em;">
                    <a href="<?php echo $cu; ?>&orderid=0&del=0&edit=0&add=0&cancel=1" class="button button-secondary">
                        انصراف
                    </a>
                </span>
            </div>
	</form>
           <?php }
		   ////							شرط ذخیره سازی تغییرات
		   global $wpdb;
				if(isset($_POST['submitee'])){
					$rowcount= $_POST['rowcount'];
					for($j=1; $j <= $rowcount ; $j++)
					{
						$idcount= 'id'.$j;
						$IDp=$_POST[$idcount];
						$postcount='productcn-'.$j;
						$countid="countp".$j;
						$countorder=$_POST[$countid];
						$priceid="pricep".$j;
						$price=$_POST[$priceid];
						$wpdb->update( 
							'orders', 
							array( 
								'postid' => $_POST[$postcount],
								'count' => $countorder,	
								'price' =>trim($price," ") 
							), 
							array( 'ID' => $IDp ), 
							array( 
								'%d',
								'%d',
								'%d'
							), 
							array( '%d' ) 
						);
					}
					$cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					ob_clean();
					wp_redirect($cu);
				}
				if(isset($_POST['deleteproduct']))
				{
					$orderidel= $_GET['orderid'];
					$wpdb->delete( 'orders', array( 'postid' => $_POST['deleteproduct'] , 'orderid' =>$orderidel ), array( '%d','%d' ) );
					$cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					ob_clean();
					wp_redirect($cu);
				}
								////// اضافه کردن به فاکتور
				if($_GET['edit']==0 && $_GET['add']==1 && $_GET['del']==0 && $_GET['cancel']==0 && !isset($_POST['submite']) && !isset($_POST['submita']) && !isset($_POST['submitd'])){
                                    $cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
				?>
				
				<form action="" method="post">
				<?php
					global $wpdb;
					if(isset($_POST['found_product']))
					{
						$producti= $_POST['product_code'];
						$image = wp_get_attachment_url( get_post_thumbnail_id($producti));
						$sqlp="select post_title , post_content from wp_posts where ID='".$producti."'";
						$resp=$wpdb->get_results($sqlp);						
						foreach($resp as $rowp){						
						?>
						   <div style="width:20%;background: #9b59b6;position: absolute; top: 4em; color: #fff; border: #8e44ad 3px solid; text-align: center; padding: 10px; left: 2em;">
								<span style="display:block;font-size:20px;">
								
									<img Style="width:100%;" src="<?php echo $image; ?>" alt="">
								</span>
								<span style="display:block;font-size:15px;margin-top:2em;">
									<?php echo $rowp->post_title;?>
								</span>
								<span style="display:block;font-size:12px;margin-top:2em;">
									<?php echo $rowp->post_content; ?>
								</span>
							</div>
				<?php 
						}
					}
				

				?>
				<div style="width:20%;background: #9b59b6;position: absolute; top: 8em; color: #fff; border: #8e44ad 3px solid; text-align: center; padding: 10px; left: 25em;">
                
					<span>
						 <input type="text" style="width:100%;" name="product_search" placeholder="دنبال چه محصولی هستید؟" />
					</span>
					<input type="submit" class="button button-primary" name="submit_search" value="جستجو" />
					<?php 
					if(isset($_POST['submit_search']))
					{
						global $wpdb;
						$product_title= $_POST['product_search'];
						$sql_search="select * from wp_posts where post_type = 'products' and post_title LIKE '%".$product_title."%'";
						$res_search = $wpdb->get_results($sql_search);
						foreach($res_search as $row_search)
						{
							?>
					<span style="float:right; width: 100%; font-size: 1em; padding-top: 10px; border-top: 3px solid #e1b8f3; margin-top: 1em;">
						<img Style="width: 40%; float: right;" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $row_search->ID)); ?>" alt="">
						<strong style="width: 60%; float: right; font-size: 0.9em;font-weight: normal;  text-align: right; height: 30px; padding: 5px 0;">
							<?php
								echo $row_search->post_title;
							?>
						</strong>
						<p style="width: 60%; float: right; height: auto; padding: 5px 0;">
							<?php
							global $wpdb;
							$sql_search_price="select meta_value from wp_postmeta where meta_key = 'price' and post_id = '".$row_search->ID."'";
							$res_search_price = $wpdb->get_results($sql_search_price);
							foreach($res_search_price as $row_search_price)
							{ ?>
							<strong style="width: 100%; float: right; text-align: right;">قیمت : <?php if($row_search_price->meta_value != 0){ echo number_format($row_search_price->meta_value)." تومان";} else{echo "قیمت وارد نشده است.";} ?></strong>
							<?php 
							}
							?>
							
						</p>
						<?php
							echo "<p style='width:100%;float:right;text-align:right;background:#8e44ad'>".$row_search->post_content."</p>";
						?>
						<strong style="width:100%;float:right;text-align:center;margin-top:10px;">
						کد محصول : <?php
								echo $row_search->ID;
								?> 
						</strong>
					</span>
					<?php 
						}
					}
					?>
				
			</div>
				<!-- END OF SEARCH -->
					<table style="width:60%;display:inline-block;margin:0;">
						<tr>
							<th>کد کالا</th>
							<th>تعداد</th>
							<th>قیمت</th>
					    </tr>
						<tr>
						<?php
						if(isset($_POST['found_product']))										
						{
							$sqlpo= "select meta_value from wp_postmeta where meta_key='price' and post_id = '".$producti."'";
							$respo= $wpdb->get_results($sqlpo);
							if(count($respo)!=0)
							{
								foreach ($respo as $rowpo){
						?>								
								<td>
									<input type="text" name="product_code" value="<?php echo $_POST['product_code']; ?>" style="width:150px;height:30px;">
								</td>
								<td>
									<input type="number" name="product_count" min="1" style="width:150px;height:30px;">
								</td>
								<td>
									<input type="text" name="product_price" value="<?php echo $rowpo->meta_value; ?>" style="width:150px;height:30px;">
									<label>تومان</label>
								</td>
							<?php 
							}
							}
							else
							{?>
							<div style="width:100%;display:block;color:red;font-size:1em;">
							قیمت این محصول وارد نشده است!!!
							</div>	
							<?php 
							}
						}
						else
						{?>
							<td>
								<input type="text" name="product_code" placeholder="کد کالا را وارد کنید" style="width:150px;height:30px;">
							</td>
							<td>
								<input type="number" name="product_count" min="1" style="width:150px;height:30px;">
							</td>
							<td>
								<input type="text" name="product_price" placeholder="قیمت کالا اینجا نمایش داده میشود" style="width:150px;height:30px;">
								<label>تومان</label>
							</td>
						<?php 
						}
						?>
							
					    </tr>
					</table>
					<div style="width:100%;display:block;margin-top:3em;">
						<button type="submit" name="found_product" class="button button-primary">
							نمایش
						</button>
						<input type="submit" name="suboad" value="اضافه کردن" class="button button-secondary">
						<a href="<?php echo $cu; ?>&orderid=0&del=0&edit=0&add=0&cancel=1" style="margin-right:5em;" class="button button-secondary">انصراف</a>
					</div>
				</form>	
				<?php 
					if(isset($_POST['suboad']))
					{	
						global $wpdb;
						$orderid= $_GET['orderid'];
						$producount=$_POST['product_count'];
						$priceduct=$_POST['product_price'];
						$productcode=$_POST['product_code'];
						if($productcode=="" || $priceduct=="" || $producount=="")
						{
							echo '<div style="width:100%;background:red;color:#fff;display:block;text-align:center;font-size:2em;height:50px;padding:10px;">لطفا هر 3 کادر را پرکنید.</div>';
						}
						else{
							
							$wpdb->insert( 
								'orders', 
								array( 
									'orderid' => $orderid, 
									'postid' => $productcode,
									'count' => $producount,
									'price' => $priceduct
								), 
								array( 
									'%s', 
									'%d',
									'%d', 
									'%d'
								) 
							);
						}
					}
				
				}
				if($_GET['edit']==0 && $_GET['add']==0 && $_GET['del']==0 && $_GET['cancel']==1 || isset($_POST['submite']) || isset($_POST['submita']) || isset($_POST['submitd']) || !isset($_GET['edit']) && !isset($_GET['add']) && !isset($_GET['del']) && !isset($_GET['cancel'])){
         
                            ////// صفحه ویرایش و دیدن تمام کد اشتراک ها و شماره های سفارش change page
			?>
	<form action="" method="post">
	  <table class="wp-list-table widefat striped">
               
               <tr>
                    <th>کاربر</th>
                    <th>سفارش</th>
                    <th>نام کاربر</th>
                    <th>اضافه کردن</th>
                    <th>ویرایش</th>
                    <th>حذف</th> 
                    <th>وضعیت سفارش</th>
					<th>قیمت</th>
               </tr>
               <?php 
                    $cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
                    global $wpdb;
						if(isset($_GET['paging'])){$paging= $_GET['paging']*10 ;}else{$paging=0;}
                        $sqls="select * from factors order by datee desc limit 10 OFFSET ".$paging;
                        $ress= $wpdb->get_results($sqls);
						$si=1;
                        foreach($ress as $rows){ ?>   
               <tr>
                   
                    <td><?php echo $rows->codee; ?></td>
                    <td><?php echo $rows->orderid; ?> </td>
                    <td>
						<?php  
							$sql_family_userid="select user_id from wp_usermeta where meta_key = 'codee' and meta_value = '". $rows->codee."'";
							$res_family_userid = $wpdb->get_results($sql_family_userid);
							foreach($res_family_userid as $row_family_userid)
							{
								$family_userid= $row_family_userid->user_id;
							}
							$sql_family = "select meta_value from wp_usermeta where meta_key = 'last_name' and user_id = '".$family_userid."'";
							$res_family = $wpdb->get_results($sql_family);
							foreach($res_family as $row_family)
							{
								echo "<strong>".$row_family->meta_value."</strong> ";
							}
							$sql_name="select meta_value from wp_usermeta where meta_key = 'first_name' and user_id = '".$family_userid."'";;
							$res_name= $wpdb->get_results($sql_name);
							foreach($res_name as $row_name)
							{
								echo $row_name->meta_value;
							}
						?> 
					</td>
                    <Td>
                        <a href="<?php echo $cu; ?>&add=1&cancel=0&edit=0&del=0&orderid=<?php echo $rows->orderid; ?>">
                            <img src="<?php echo GTGLOBAL_IMG_URL; ?>/add.png" width="32" alt="">
                        </a>
                    </Td>
                    <td>
                      
                       <a href="<?php echo $cu; ?>&add=0&cancel=0&edit=1&del=0&orderid=<?php echo $rows->orderid; ?>">
							<span><img src="<?php echo GTGLOBAL_IMG_URL; ?>/edit.png" width="32"></span>
					   </a>
                    </td>
                    <td>
						<a href="<?php echo $cu; ?>&add=0&cancel=0&edit=0&del=1&orderid=<?php echo $rows->orderid; ?>">
							<img src="<?php echo GTGLOBAL_IMG_URL; ?>/del.png" width="32"alt=""> 
						</a>
                    </td>
                    <td>
					<?php 
									///// شرط برای وضعیت های سفارش
						switch ($rows->status) {
							case 0:
								?>
								<select name="status-<?php echo $si;?>">
								  <option value="wait" selected>انتظار</option>
								  <option value="printed">چاپ شده</option>
								  <option value="canceled">انصرف</option>
								  <option value="delivered">تحویل داده شده</option>
								</select>
								
							<?php	break;
							case 1:
								?>
								<select name="status-<?php echo $si;?>">
								  <option value="wait" >انتظار</option>
								  <option value="printed" selected>چاپ شده</option>
								  <option value="canceled">انصرف</option>
								  <option value="delivered">تحویل داده شده</option>
								</select>
								
							<?php
								break;
							case 2:
								?>
								<select name="status-<?php echo $si;?>">
								  <option value="wait" >انتظار</option>
								  <option value="printed" >چاپ شده</option>
								  <option value="canceled" >انصرف</option>
								  <option value="delivered" selected>تحویل داده شده</option>
								</select>
								
							<?php
								break;
							case 3:
								?>
								<select name="status-<?php echo $si;?>">
								  <option value="wait" >انتظار</option>
								  <option value="printed" >چاپ شده</option>
								  <option value="canceled" selected>انصرف</option>
								  <option value="delivered">تحویل داده شده</option>
								</select>
								
							<?php
								break;	
						}
									//// پایان شرط برای وضعیت های سفارش
					?>
                    </td>
					<?php 
					$sql_pro_price="SELECT SUM(count*price) as price_product FROM orders where orderid='".$rows->orderid."'";
					$res_pro_price = $wpdb->get_results($sql_pro_price);
					foreach ($res_pro_price as $row_pro_price){
					?>
					<td><?php echo number_format($row_pro_price->price_product); ?> تومان</td>
						<?php } ?>
               </tr>
			   <input type="hidden" name="si_OID-<?php echo $si;?>" value="<?php echo $rows->orderid;?>">
               <input type="hidden" name="si_count" value="<?php echo $si;?>">
				<?php  
				 $si++;
				 
			   }?>
			   
               <button class="button button-primary" name="submit">ذخیره</button>             
                 <div style="width:100%;float:left;text-align:left;margin:2em auto;font-size:1.3em">
					<?php 
						$limit_count=count($wpdb->get_results("select * from factors"));
						for($i_limit=0;$i_limit<=$limit_count/10;$i_limit++)
						{
							$cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						?>
							<A href="<?php echo $cu."&paging=".$i_limit; ?>" style="background:#34495e;padding:10px;color:#fff;text-decoration:none;margin-left:10px;">
								<?php echo $i_limit+1; ?>
							</a>
						<?php }
						?>
					</div>   
         <?php }  ?>
            </table>
	<br>
	
	</form>
	</div>
<?php
if(isset($_POST['submit']))
		 {
			 for($j=1;$j<=10;$j++)
			 {
				 $OID_val= 'si_OID-'.$j;
				 echo $OID_val."<br>";
				 $orderid= $_POST[$OID_val];
				 echo $orderid."<br>";
				 $status_cid= 'status-'.$j;
				 $status_val= $_POST[$status_cid];
				 switch ($status_val) 
				 {
					case "wait":
						$status_num_save=0;
						break;
					case "canceled":
						$status_num_save=3;
						break;
					case "printed":
						$status_num_save=1;
						break;
					case "delivered":
						$status_num_save=2;
						break;  
				}
				global $wpdb;
				$wpdb->update( 
							'factors', 
							array( 
								'status' => $status_num_save
							), 
							array( 'orderid' => $orderid), 
							array( 
								'%d',
							), 
							array( '%s' ) 
						);
			 }
			 $cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']."&del=0&cancel=1";
			 ob_clean();
			 wp_redirect($cu);
			 
		 }
}										////  پایان ویرایش فاکتور ها 
function order_page() { 					///// شروع اضافه کردن سفارش
?>
        <h2>اضافه کردن یک سفارش</h2>
        <div class="wrap">
			<form action="#" method="post">
				 <table class="wp-list-table widefat striped">
				   
					   <tr>
							<th>کد اشتراک کاربر</th>
					   </tr>
					  
					 <tr>
						 <td><input type="text" placeholder="کد اشتراک کاربر را وارد کنید" name="codee"></td>
					 </tr>
					  
				 </table>
			
         
				<br>
				<input type="submit" class="button button-primary" value="ثبت سفارش" name="submita">
			</form>
			<!--  مشخصات فردی که این کد اشتراک رو داره   -->
			<div style="width: 40%;background: #9b59b6;display: block;margin: 4em auto;color:#fff;border: #8e44ad 3px solid;text-align: center;padding: 10px;">
				<form action="#" method="post">
					<input type="text" name="user_family" placeholder="کد اشتراک کاربر خاصی را میخواهید؟" style="width:70%;margin:10px auto;display:block;">
					<input type="submit" name="name-codee" class="button button-secondary" value="جستجو">
				</form>
				
			<?php
				
				if(isset($_POST['name-codee']))
				{
					global $wpdb;
					$name_codee = $_POST['user_family'];
					$codee = $_POST['name-codee'];
					if($name_codee != "" || $name_codee != " ")
					{
						$sql_codee= "select user_id from wp_usermeta where meta_key = 'last_name' and meta_value LIKE '%".$name_codee."%'";
						$res_codee= $wpdb->get_results($sql_codee);
						if(count($res_codee) != 0)
									{
										foreach($res_codee as $row_codee)
										{
											?>
											<div style="border-right: 4px solid #5d0880; background: #d08bec; width: 100%; padding: 10px 0; margin-top: 1em;">
											<?php
											$sql_family = "select meta_value from wp_usermeta where meta_key = 'first_name' and user_id = '".$row_codee->user_id."'";
											$res_family = $wpdb->get_results($sql_family);
											foreach($res_family as $row_family)
											{
												$sql_name = "select meta_value from wp_usermeta where meta_key = 'last_name' and user_id = '".$row_codee->user_id."'";
												$res_name = $wpdb->get_results($sql_name);
												foreach($res_name as $row_name)
												{
												?>	
												<span style="display:block;font-size:20px;">
													<?php echo $row_family->meta_value." ".$row_name->meta_value; ?>
												</span>
												<?php
												}
											}
											$sql_mobile = "select meta_value from wp_usermeta where meta_key = 'mobile' and user_id = '".$row_codee->user_id."'";
											$res_mobile = $wpdb->get_results($sql_mobile);
											foreach($res_mobile as $row_mobile)
											{
											?>
												<span style="display:block;font-size:15px;margin-top:2em;">
													<?php echo "شماره همراه :".$row_mobile->meta_value; ?>
												</span>
											<?php
											}
											$sql_codesh = "select meta_value from wp_usermeta where meta_key = 'codee' and user_id = '".$row_codee->user_id."'";
											$res_codesh = $wpdb->get_results($sql_codesh);
											foreach($res_codesh as $row_codesh)
											{
											?>
												<span style="display:block;font-size:15px;margin-top:2em;">
													<?php echo "کد اشتراک :".$row_codesh->meta_value; ?>
												</span>
											<?php
											}
											$sql_address = "select meta_value from wp_usermeta where meta_key = 'address' and user_id = '".$row_codee->user_id."'";
											$res_address = $wpdb->get_results($sql_address);
											foreach($res_address as $row_address)
											{
											?>
												<span style="display:block;font-size:12px;margin-top:2em;">
													ادرس : <?php echo $row_address->meta_value; ?>
												</span>
											<?php
											}?>
											</div>
										<?php }
									}
									else{
										echo "متاسفانه چنین کاربری با این فامیل، وجود ندارد";
									}	
					}
						
				}
				?>
				
			</div>
        </div>
<?php
							//// شرط بعد از کلیک روی ذخیره و دریافت اخرین شماره سفارش
				global $wpdb;
							if(isset($_POST['submita'])){
									
									$codee= $_POST['codee'];
									$sql_empty = "select user_id from wp_usermeta where meta_key = 'codee' and meta_value = '".$codee."'";
									$res_empty = $wpdb->get_results($sql_empty);
									if(count($res_empty)!= 0)
									{
										
									
										$sql="select orderid from factors order by orderid desc LIMIT 1";
										$res = $wpdb->get_results($sql);
										foreach($res as $row){
											 $LastOID = explode ("-",$row->orderid) ;
											 $saveOID = $LastOID[1]+1;
											 $datejalali= parsidate('Y-m-d-H:s',$datetime='now',$lang='eng');
										 }
										$wpdb->insert('factors',
											array ( 
												'codee' => $codee,
												'orderid'=> "op-".$saveOID,
												'status'=>0,
												'datee'=>$datejalali,
											),
											array(
												'%d','%s','%d','%s'
											)
										);
										$cu = site_url()."/wp-admin/admin.php?page=checkout-page&add=1&orderid=op-".$saveOID;
										ob_clean();
										wp_redirect($cu);
									}
									else
									{ ?>
										<div style="width:100%;background:red;padding:10px 0;position:absolute;top:2em;color:#fff">
											<strong>
												چنین کد اشتراکی نداریم!!!
											</strong>
										</div>
										
									<?php }
							}
										/////// اتمام 
}									///// پایان اضافه کردن سفارش
function report_page(){ 
								///// شروع نمایش فاکتور ها و سفارشات
?>
	<h2>نمایش فاکتور ها و سفارشات</h2>
	<?php
	if($_GET['show']==1 && $_GET['cancel']==0)
	{
		$cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];	
	?>
	<div class="wrap">
		<table class="wp-list-table widefat striped hide_print">
				<tr>
					<th>نام کالا</th>
					<th>تعداد</th>
					<th>مبلغ واحد</th>
					<th>مبلغ کل</th>
					
				</tr>
				<?php 
				global $wpdb;
				$sql="select * from orders where orderid = '".$_GET['orderid']."'";
				$res=$wpdb->get_results($sql);
				foreach($res as $row)
				{	?>
				<tr>
					<td>
						<?php 
							$sql_pcode = "select post_title from wp_posts where id = '".$row->postid."'";
							$res_pcode = $wpdb->get_results($sql_pcode);
							foreach ($res_pcode as $row_pcode)
							{
								echo $row->postid." / ".$row_pcode->post_title;
							}
						?> 
					</td>
					<Td>
						<?php echo $row->count; ?>
					</td>
					<Td>
						<?php echo number_format($row->price); ?>
					</td>
					<Td>
						<?php 
							$sql_pro_price="SELECT SUM(count*price) as price_product FROM orders where postid = '".$row->postid."'and orderid='".$row->orderid."'";
							$res_pro_price = $wpdb->get_results($sql_pro_price);
							foreach ($res_pro_price as $row_pro_price){
								echo number_format($row_pro_price->price_product);
							}
						?>
					</td>
				</tr>	
				<?php 
				}
				?>
		</table>
		<a href="<?php echo $cu; ?>&cancel=1&show=0" class="button button-secondary hide_print" style="margin-top:1em;">انصراف</a>
		<form action="#" method="post" style="display:inline-block" class="hide_print">
			<button name="single_factor_print" class="button button-primary" class="hide_print" onclick="window.print()" style="margin-top:1em;">چاپ</button>
		</form>
		<!--- کد چاپ فاکتور تکی --->
			<div class="wrap">
				  <div class="for_print">
						
						<div class="page-break">
							<span class="ads">
								<strong>شماره های تماس و پشتیبانی : 3434322333</strong>
								
								<p>نان داغ، پرداخت درب منزل، تمام طول روز</p>
							</span>
							  <table>
								<tr>
									<th>نام و نام خانوادگی</th>
									<th>شماره تماس</th>
								</tr>
								<?php
										global $wpdb;
										$sql_fac = "select * from factors where orderid = '".$_GET['orderid']."'";
										$res_fac = $wpdb->get_results($sql_fac);
										foreach($res_fac as $row_fac)
										{
											$sql_fac_name_uid = "select user_id from wp_usermeta where meta_value = '".$row_fac->codee."'";		
											$res_fac_name_uid = $wpdb->get_results($sql_fac_name_uid);
											foreach($res_fac_name_uid as $row_fac_name_uid)
											{
												$user = get_user_by('id', $row_fac_name_uid->user_id);
											?>
								<tr>
								
									<td><?php $name = $user->first_name;$family = $user->last_name;echo $name." ".$family; ?></td>
									<td><?php $mob = $user->mobile; echo $mob;?></td>
								</tr>
								<tr>
									<th colspan="2">آدرس</th>
								</tr>
								<tr>
									<td colspan="2"><?php $address = $user->address; echo $address;?></td>
								</tr>
								<?php 
											}
									    }
								?>
									<th>کد سفارش</th>
									<th>مبلغ فاکتور</th>
								</tr>
								<tr>
									<td><?Php echo $_GET['orderid']; ?></td>
									<td>
										<?php 
											global $wpdb;
											$sql_fac_sum ="select SUM(count*price) as Price_pro from orders where orderid = '".$_GET['orderid']."'";
											$res_fac_sum = $wpdb->get_results($sql_fac_sum);
											foreach($res_fac_sum as $row_fac_sum)
											{
												echo number_format($row_fac_sum->Price_pro);
											}
										?>
									</td>
								</tr>
							  </table>
							  
							  <table style="margin-top:9pt;width:100%;">
								<tr>
									<th>
										نام کالا
									</th>
									<th>
										تعداد
									</th>
									<th>
										قیمت واحد
									</th>
									<th>
										قیمت کل
									</th>
								</tr>
								
								<?php 
									global $wpdb;
									$sql_body_fac = "select * from orders where orderid = '".$_GET['orderid']."'" ;
									$res_body_fac = $wpdb->get_results($sql_body_fac);
									foreach($res_body_fac as $row_body_fac)
									{
									?>
									<tr>
									<td>
										<?php 
											echo get_the_title($row_body_fac->postid);
										?>
									</td>
									<td>
										<?php echo $row_body_fac->count; ?>
									</td>
									<td>
										<?php echo $row_body_fac->price; ?>
									</td>
									<td>
										<?php echo $row_body_fac->count*$row_body_fac->price; ?>
									</td>
									</tr>
								<?php
											
									}
								?>
								
							  </table>
						</div>
				  </div>
			 </div>
		<!--- پایان کد فاکتور --->
	</div>
<?php 
	}?>
	<?php 
		if( $_GET['cancel']==1 && $_GET['show']==0 || !isset($_GET['show'])){
	?>
	<div class="wrap hide_print">
		<form action="#" method="post">
			<button name="print_waitingfactors" class="button button-primary" style="margin-bottom:2em;" onclick="window.print()"> چاپ فاکتورهای چاپ نشده! </button>
		</form>      
		  <table class="wp-list-table widefat striped hide_print" class="hide_print">
               
                   <tr>
                        <th>کد کاربر</th>
                        <th>کد سفارش</th>
                        <th >وضعیت سفارش</th>
                        <th class="price">قیمت کل</th>
                        <th>شماره تماس</th>
                        <th>ادرس</th>
						
                   </tr>
				   <?php 
				   global $wpdb;
				   $cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					if(isset($_GET['paging'])){$paging= $_GET['paging']*10 ;}else{$paging=0;}
					$sql="SELECT * FROM factors order by datee desc limit 10 OFFSET ".$paging;
					$res = $wpdb->get_results($sql);
					foreach($res as $row){
						$codee= $row->codee;
						
					
				   ?>
                 <tr>
                     <td>
						<?php echo $codee." = "; 
							$sql_family_userid="select user_id from wp_usermeta where meta_key = 'codee' and meta_value = '".$codee."'";
							$res_family_userid = $wpdb->get_results($sql_family_userid);
							foreach($res_family_userid as $row_family_userid)
							{
								$family_userid= $row_family_userid->user_id;
							}
							$sql_family = "select meta_value from wp_usermeta where meta_key = 'last_name' and user_id = '".$family_userid."'";
							$res_family = $wpdb->get_results($sql_family);
							foreach($res_family as $row_family)
							{
								echo "<strong>".$row_family->meta_value."</strong> ";
							}
							$sql_name="select meta_value from wp_usermeta where meta_key = 'first_name' and user_id = '".$family_userid."'";;
							$res_name= $wpdb->get_results($sql_name);
							foreach($res_name as $row_name)
							{
								echo $row_name->meta_value;
							}
						?>
					 </td>
                     <td>
						<a href="<?php echo $cu; ?>&show=1&cancel=0&orderid=<?php echo $row->orderid; ?>">
							<?php 
								echo $row->orderid;
							?>
						</a>
					 </td>
                     <td>
						<?php 
							switch ($row->status) {
								case 0:
									echo "انتظار";
									break;
								case 1:
									echo "چاپ شده";
									break;
								case 2:
									echo "تحویل داده شده";
									break;
								case 3:
									echo "انصراف";
									break;	
							}
						?>
					 </td>
                     <td>
						<?php 
							$sql_pro_price="SELECT SUM(count*price) as price_product FROM orders where orderid='".$row->orderid."'";
							$res_pro_price = $wpdb->get_results($sql_pro_price);
							foreach($res_pro_price as $row_price)
							{
								echo number_format($row_price->price_product);
							}
						?>
					 </td>
                     <td>
						<?php 
							$sql_mobile ="select meta_value from wp_usermeta where meta_key = 'mobile' and user_id = '".$family_userid."'";
							$res_mobile = $wpdb->get_results($sql_mobile);
							foreach($res_mobile as $row_mobile)
							{
								echo $row_mobile->meta_value;
							}
						?>
					 </td>
                     <td>
						<?php 
							$sql_address ="select meta_value from wp_usermeta where meta_key = 'address' and user_id = '".$family_userid."'";
							$res_address = $wpdb->get_results($sql_address);
							foreach($res_address as $row_address)
							{
								echo $row_address->meta_value;
							}
						?>
					 </td>
                 </tr>
				 <?php 
					}?>
          </table>
		  <div class="hide_print" style="width:100%;float:left;text-align:left;margin:2em auto;font-size:1.3em">
					<?php 
						global $wpdb;
						$limit_count=count($wpdb->get_results("select * from factors"));
						for($i_limit=0;$i_limit<=$limit_count/10;$i_limit++)
						{
							$cu = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						?>
							<a href="<?php echo $cu."&paging=".$i_limit; ?>" style="background:#34495e;padding:10px;color:#fff;text-decoration:none;margin-left:10px;">
								<?php echo $i_limit+1; ?>
							</a>
						<?php }
						?>
					</div>
				<?php 	}
				 ?>
		  </div>
		  <?php  
			if(!isset($_POST['print_waitingfactors']) && $_GET['show']==0)
			{
			  global $wpdb;
			  $sql = "select codee , orderid from factors where status = 0" ;
			  $res= $wpdb->get_results($sql);
			  foreach($res as $row)
			  {
				  ?>
			  <div class="wrap">
				  <div class="for_print">
						
						<div class="page-break">
							<span class="ads">
								<strong>شماره های تماس و پشتیبانی : 3434322333</strong>
								
								<p>نان داغ، پرداخت درب منزل، تمام طول روز</p>
							</span>
							  <table>
								<tr>
									<th>نام و نام خانوادگی</th>
									<th>شماره تماس</th>
								</tr>
								<tr>
								<?php
									global $wpdb;
									$sql_usermeta= "select user_id from wp_usermeta where meta_value = '".$row->codee."'";
									$res_usermeta = $wpdb->get_results($sql_usermeta);
									foreach($res_usermeta as $row_usermeta)
									{
										$user = get_user_by('id', $row_usermeta->user_id);	
										?>
											<td><?php $name = $user->first_name;$family = $user->last_name;echo $name." ".$family; ?></td>
									
									
									<td><?php $mobile = $user->mobile;echo $mobile;?></td>
								
								</tr>
								<tr>
									<th colspan="2">آدرس</th>
								</tr>
								<tr>
									<td colspan="2"><?php $address = $user->address;echo $address;?></td>
								</tr>
								<?php
									}
								?>
									<th>کد سفارش</th>
									<th>مبلغ فاکتور</th>
								</tr>
								<tr>
									<td><?php echo $row->orderid ; ?></td>
									<td>
										<?php 
											global $wpdb;
											$sql_sum="SELECT SUM(count*price) as price_product FROM orders where orderid = '".$row->orderid."'";
											$res_sum = $wpdb->get_results($sql_sum);
											foreach ($res_sum as $row_sum){
												 echo number_format($row_sum->price_product);
											}
										?> 
									</td>
								</tr>
							  </table>
							  
							  <table style="margin-top:9pt;width:100%;">
								<tr>
									<th>نام کالا</th>
									<th>تعداد</th>
									<th>قیمت واحد</th>
									<th>قیمت کل</th>
								</tr>
								<?php
									global $wpdb;
									$sql_procode = "select * from orders where orderid = '".$row->orderid."'";
									$res_procode = $wpdb->get_results($sql_procode);
									foreach($res_procode as $row_procode)
									{
										$sql_proname="select * from wp_posts where id = '".$row_procode->postid."'";
										$res_proname=$wpdb->get_results($sql_proname);
										foreach($res_proname as $row_proname)
										{
								?>
								<tr>
									<td><?php echo $row_proname->post_title; ?></td>
									<td>
										<?php echo $row_procode->count; ?>
									</td>
									<td>
										<?php echo $row_procode->price; ?>
									</td>
									<td>
										<?php echo $row_procode->count * $row_procode->price; ?>
									</td>
								</tr>
								<?php 
								}
									}
								?>
							  </table>
						</div>
				  </div>
			  </div>
				<?php
				}
			  } // برای فور ایچ اولی که کد سفارش و اشتراک دریافت میکنه
			  ////// if جدید
			if(isset($_POST['print_waitingfactors']) && $_GET['show']==0)
		  {
			 $sql = "select codee , orderid from factors where status = 0" ;
			  $res= $wpdb->get_results($sql);
			  foreach($res as $row)
			  {
				  ?>
			  <div class="wrap">
				  <div class="for_print">
						
						<div class="page-break">
							<span class="ads">
								<strong>شماره های تماس و پشتیبانی : 3434322333</strong>
								
								<p>نان داغ، پرداخت درب منزل، تمام طول روز</p>
							</span>
							  <table>
								<tr>
									<th>نام و نام خانوادگی</th>
									<th>شماره تماس</th>
								</tr>
								<tr>
								<?php
									global $wpdb;
									$sql_usermeta= "select user_id from wp_usermeta where meta_value = '".$row->codee."'";
									$res_usermeta = $wpdb->get_results($sql_usermeta);
									foreach($res_usermeta as $row_usermeta)
									{
										$user = get_user_by('id', $row_usermeta->user_id);	
										?>
											<td><?php $name = $user->first_name;$family = $user->last_name;echo $name." ".$family; ?></td>
									
									
									<td><?php $mobile = $user->mobile;echo $mobile;?></td>
								
								</tr>
								<tr>
									<th colspan="2">آدرس</th>
								</tr>
								<tr>
									<td colspan="2"><?php $address = $user->address;echo $address;?></td>
								</tr>
								<?php
									}
								?>
									<th>کد سفارش</th>
									<th>مبلغ فاکتور</th>
								</tr>
								<tr>
									<td><?php echo $row->orderid ; ?></td>
									<td>
										<?php 
											global $wpdb;
											$sql_sum="SELECT SUM(count*price) as price_product FROM orders where orderid = '".$row->orderid."'";
											$res_sum = $wpdb->get_results($sql_sum);
											foreach ($res_sum as $row_sum){
												 echo number_format($row_sum->price_product);
											}
										?> 
									</td>
								</tr>
							  </table>
							  
							  <table style="margin-top:9pt;width:100%;">
								<tr>
									<th>نام کالا</th>
									<th>تعداد</th>
									<th>قیمت واحد</th>
									<th>قیمت کل</th>
								</tr>
								<?php
									global $wpdb;
									$sql_procode = "select * from orders where orderid = '".$row->orderid."'";
									$res_procode = $wpdb->get_results($sql_procode);
									foreach($res_procode as $row_procode)
									{
										$sql_proname="select * from wp_posts where id = '".$row_procode->postid."'";
										$res_proname=$wpdb->get_results($sql_proname);
										foreach($res_proname as $row_proname)
										{
								?>
								<tr>
									<td><?php echo $row_proname->post_title; ?></td>
									<td>
										<?php echo $row_procode->count; ?>
									</td>
									<td>
										<?php echo $row_procode->price; ?>
									</td>
									<td>
										<?php echo $row_procode->count * $row_procode->price; ?>
									</td>
								</tr>
								<?php 
								}
									}
								?>
							  </table>
						</div>
				  </div>
			  </div>
				<?php
			  } 
		  }	
			
		  //// اینجا تموم میشه if
		  }
?>
