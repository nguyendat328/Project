<?php
/**
 * class ShoppingCart 
 */
class ShoppingCart{
	var $num_items, $total, $weight;
	var $cart_items;
 	function addCart($product_id,$qty=1){	
	  	global $_SESSION;
	 	$check_existed = '0';
		if($qty=='') $qty=1;
		$num_item_in_cart = count($_SESSION["ses_cart"]);
		if($num_item_in_cart > 0)
		{
			foreach($_SESSION["ses_cart"] as $key=>$value)
			{	
				$item_id =  $key;
				$item_qty = $value;
				//check product_id exist?
				// if it already exists addition qty to cart.
				if($product_id==$item_id) 
				{  
					$_SESSION["ses_cart"][$item_id] =  $item_qty + $qty;
					$check_existed = '1';
					break;
				}
				
			}
			if($check_existed=='0')// if product not in cart then add to cart.
			{  
				
				$_SESSION["ses_cart"][$product_id] 	=  $qty;
			}
		} 
		else 
		{  
			$_SESSION["ses_cart"][$product_id] 	=  $qty;
		}
	 }
	 
	 
	 function displayCart($db,$baseUrl)
	 {	
	 	global $_SESSION;
		$str = '<table width="98%" border="0"  class="tblCart" id="addTable" >';
		$str.='<tr align="center">
				<th align="center">Delete</th>
				<th>Image</th>
				<th>Code/Name</th>
				<th>Quantity</th>
				<th>Total</th>
			  </tr>';
			  //var_dump($_SESSION["ses_cart"]);
		if(count($_SESSION["ses_cart"]) > 0)
		{
			$sum=0;
			foreach($_SESSION["ses_cart"] as $id=>$qty)
			{	
				$sql = "SELECT P.* FROM tblproducts P
						INNER JOIN tblcategories C ON C.id =P.cat_id
						WHERE P.id='{$id}'";
				$rs = $db->fetchOne($sql);
				//print_r($rs);
				$rs['Total']=floatval($qty);
				//$rs['sh_des']=cutBrief($rs[pro_description], 50);
				if(strlen($rs['pro_img'])==0){
					$rs['pro_img']='no_photo.gif';
				}
				$sum+=floatval($rs['Total']);
				$str.='<tr align="center" height="30">
					<td style="text-align:center;"><a id="delonecart" onclick="delOne('.$rs['id'].');" />Delete</a></td>
					<td style="text-align:center;"><img src="'.$baseUrl.'/admin/'.$rs['pro_img'].'" width="50" height="50" border="0"></td>
					<td style="text-align:left;"><strong>'.$rs['pro_code'].'</strong><br>'.$rs['pro_name'].'</td>
					<td style="text-align:center;"><input type="text" size="3" name="arr_qty['.$rs['id'].']" maxlength="7" id="quantity" value="'.$qty.'" /></td>
					<td style="text-align:center;">'.$rs['Total'].'</td>
				  </tr>';
					  
			}
					$str.='<tr align="center" height="30" id="total">
						<td colspan="5" style="text-align:right"><strong>Total: '.$sum.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
					  </tr>
					  <tr>
						<td colspan="5" align="center">
							<input id="shopping" type="button" value="Continue Shopping" class="btn" >
							<input id="updatecart" type="button" value="Update your cart" class="btn" >
							<input id="checkout" type="button" value="Check out" class="btn" >
						</td>
					  </tr>';
		}
		else
		{
			$str .= '<tfoot><tr align="center" height="30">
						<td colspan="5"><h4 style="color:#CC0000">Not found product</h3></td> 
					  </tr></tfoot>';
		}
		
		$str .= '</table>';
		return $str;
	 }
	 
	  function displayCartOrder()
	 {	
	 	global $_SESSION;
		global $db;
		global $baseUrl;
		$str = '<table width="98%" border="0" id="addTable">';
		$str.='<tr align="center">
				<th>STT</th>
				<th>Ảnh</th>
				<th align="left">Code/Tên Sản phẩm</th>
				<th>Số lượng theo đơn vị</th>
			  </tr>';
		if(count($_SESSION["ses_cart"]) > 0)
		{
			$sum=0;
			$nbr=0;
			foreach($_SESSION["ses_cart"] as $id=>$qty)
			{	
				$sql = "SELECT * FROM tblshops WHERE sh_id='$id'";
				$rs = $db->fetchOne($sql);
				if($rs['sh_img']==''){
					$rs['sh_img']='no_photo.gif';
				}
				$total=floatval($qty);
				$sum+=floatval($total);
				$nbr++;
				$str.='<tr align="center" height="30">
					<td align="center">'.$nbr.'</td>
					<td style="text-align:center;"><img src="'.$baseUrl.'/img/shop/thumb/thumb_'.$rs['sh_img'].'" width="50" height="50" border="0"></td>
					<td style="text-align:left;"><strong>'.$rs['sh_code'].'</strong><br>'.$rs['sh_name'].'</td>
					<td style="text-align:center;">'.$qty.'</td>
				  </tr>';
					  
			}
					$str.='<tr align="center" height="30" id="total">
						<td colspan="4" style="text-align:right"><strong>Tổng số: '.$sum.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
					  </tr>';
		}
		else
		{
			$str .= '<tfoot><tr align="center" height="30">
						<td colspan="4"><h4 style="color:#CC0000">Không có sản phẩm nào được Order, mời bạn chọn sản phẩm theo danh mục kế bên</h3></td> 
					  </tr></tfoot>';
		}
		
		$str .= '</table>';
		return $str;
	 }
	 
	 function deleteItem($index)
	 {
	 	unset($_SESSION["ses_cart"][$index]);
	 }
	 
	 function updateCart()
	 {	
	 	$arr_qty = _POST('arr_qty');
		if($arr_qty)
		{
			if(count($_SESSION["ses_cart"]) > 0)
			{
				foreach($_SESSION["ses_cart"] as $id=>$qty)
				{	
					$new_qty = $arr_qty[$id];
					
					if(is_numeric($new_qty) && intval($new_qty)>0)
					{
						$_SESSION["ses_cart"][$id] 	=  intval($new_qty);
					}
					else
					{
						$_SESSION["ses_cart"][$id] 	=  $qty;
					}
				}	
			}
		}
	 }
	 
	 function emptyCart()
	 {
	 	unset($_SESSION['ses_cart']);
		session_unregister('ses_cart');
	 }	 
	 /*--End Shopcart--*/
}