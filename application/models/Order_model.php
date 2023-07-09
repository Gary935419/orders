<?php


class Order_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//----------------------------订单列表-------------------------------------

	//获取标签页数
	public function getOrderAllPage($user_name,$status,$sort,$start,$end)
	{
		if($status==0){
			$sqlw = " where audit_status in(0,2) and product_sort=$sort";
		}else{
			$sqlw = " where audit_status=$status and product_sort=$sort";
		}
		if ($start) {
			$sqlw .= " and add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and add_time<=$end";
		}

		if (!empty($user_name)) {
			$sqlw .= " and ( product_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取标签信息
	public function getOrderAll($pg, $user_name,$status,$sort,$start,$end)
	{
		if($status==0){
			$sqlw = " where audit_status in(0,2) and product_sort=$sort";
		}else{
			$sqlw = " where audit_status=$status and product_sort=$sort";
		}
		if ($start) {
			$sqlw .= " and add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and add_time<=$end";
		}

		if (!empty($user_name)) {
			$sqlw .= " and ( product_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `product_release` " . $sqlw . " order by prid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	//----------------------------一订单add添加-------------------------------------
	//订单save
	public function order_save($username,$proclass1,$proclass2,$productname,$productnum,$gettime,$stoptime,$caddress,$jaddress,$zmoney,$pdfurl1,$pdfurl2,$pdfurl3,$datetime,$desc,$companyname,$truename,$mobile,$number)
	{
		$username = $this->db->escape($username);
		$proclass1 = $this->db->escape($proclass1);
		$proclass2 = $this->db->escape($proclass2);
				$number = $this->db->escape($number);
		$productname = $this->db->escape($productname);

		$productnum = $this->db->escape($productnum);
		$gettime = $this->db->escape($gettime);
		$stoptime = $this->db->escape($stoptime);

		$caddress = $this->db->escape($caddress);
		$jaddress = $this->db->escape($jaddress);
		$zmoney = $this->db->escape($zmoney);

		$pdfurl1 = $this->db->escape($pdfurl1);
		$pdfurl2 = $this->db->escape($pdfurl2);
		$pdfurl3 = $this->db->escape($pdfurl3);
		$datetime = $this->db->escape($datetime);
		
		$companyname = $this->db->escape($companyname);
		$truename = $this->db->escape($truename);
		$mobile = $this->db->escape($mobile);
		
		$desc = $this->db->escape($desc);


		$sql = "INSERT INTO `product_release` 
				(mid,pid1,pid2,product_name,quantity_purchased,purchasing_time,
				end_time,product_caddress,product_jaddress,product_zmoney,product_specification1,
				product_specification2,product_specification3,add_time,audit_status,product_sort,product_description,company_name,contact_name,contact_tel,number) 
				VALUES
				($username,$proclass1,$proclass2,$productname,$productnum,$gettime,
				$stoptime,$caddress,$jaddress,$zmoney,$pdfurl1,
				$pdfurl2,$pdfurl3,$datetime,1,0,$desc,$companyname,$truename,$mobile,$number)";
		//return $sql;
		return $this->db->query($sql);
	}

	//----------------------------订单edit更新-------------------------------------

	//根据id获取标签信息
	public function getOrderEdit($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `product_release` where prid=$id ";
		return $this->db->query($sql)->row_array();
	}

	//标签更新
	public function order_update($id,$username,$proclass1,$proclass2,$productname,$productnum,$gettime,$stoptime,$caddress,$jaddress,$zmoney,$pdfurl1,$pdfurl2,$pdfurl3,$datetime,$desc,$number)
	{
		$id = $this->db->escape($id);
		$username = $this->db->escape($username);
		$proclass1 = $this->db->escape($proclass1);
		$proclass2 = $this->db->escape($proclass2);
						$number = $this->db->escape($number);
		$productname = $this->db->escape($productname);

		$productnum = $this->db->escape($productnum);
		$gettime = $this->db->escape($gettime);
		$stoptime = $this->db->escape($stoptime);

		$caddress = $this->db->escape($caddress);
		$jaddress = $this->db->escape($jaddress);
		$zmoney = $this->db->escape($zmoney);

		$pdfurl1 = $this->db->escape($pdfurl1);
		$pdfurl2 = $this->db->escape($pdfurl2);
		$pdfurl3 = $this->db->escape($pdfurl3);
		$datetime = $this->db->escape($datetime);
		$desc = $this->db->escape($desc);

		$sql = "UPDATE `product_release` SET 
				mid=$username,pid1=$proclass1,pid2=$proclass2,product_name=$productname,quantity_purchased=$productnum,purchasing_time=$gettime,  
				end_time=$stoptime,product_caddress=$caddress,product_jaddress=$jaddress,product_zmoney=$zmoney,product_specification1=$pdfurl1,
				product_specification2=$pdfurl2,product_specification3=$pdfurl3,add_time=$datetime,product_description=$desc,number=$number
				WHERE prid = $id";
		//return $sql;
		return $this->db->query($sql);
	}

	//标签delete
	public function order_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "UPDATE `product_release` SET  product_sort=5 WHERE prid = $id";
		return $this->db->query($sql);
	}

	//标签delete
	public function order_check($id,$check)
	{
		$id = $this->db->escape($id);
		$check = $this->db->escape($check);
		$sql = "UPDATE `product_release` SET  audit_status=$check WHERE prid = $id";
		//return $sql;
		return $this->db->query($sql);
	}
	
		//标签delete
	public function order_sign_error($id)
	{
		$id = $this->db->escape($id);
		$sql = "UPDATE `product_release` SET  product_sort=5 WHERE prid = $id";
		//return $sql;
		return $this->db->query($sql);
	}

	//----------------------------投标订单列表-------------------------------------

	//获取投标项目标签页数
	public function getOrderBidAllPage($user_name,$sort,$start,$end)
	{
		$sqlw = " where product_sort=$sort";
		if (!empty($user_name)) {
			$sqlw .= " and ( product_name like '%" . $user_name . "%' ) ";
		}

		if ($start) {
			$sqlw .= " and add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and add_time<=$end";
		}
		$sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取投标项目标签信息
	public function getOrderBidAll($pg, $user_name,$sort,$start,$end)
	{
		$sqlw = " where product_sort=$sort";
		if (!empty($user_name)) {
			$sqlw .= " and ( product_name like '%" . $user_name . "%' ) ";
		}

		if ($start) {
			$sqlw .= " and add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and add_time<=$end";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `product_release` " . $sqlw . " order by prid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取投标人list页数
	public function getOrderToubiaoAllPage($user_name,$id)
	{
		$sqlw = " where prid=$id";
		if (!empty($user_name)) {
			$sqlw .= " and ( company_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `application_orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取投标人list信息
	public function getOrderToubiaoAll($pg, $user_name,$id)
	{
		$sqlw = "";
		if (!empty($user_name)) {
			$sqlw .= " and ( a.company_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT a.*,p.product_name,p.product_sort FROM `application_orders` a,`product_release` p where a.prid=$id and a.prid = p.prid" . $sqlw . " order by a.aftid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	
		public function getOrderSignToubiaoAllPage($user_name,$id)
	{
		$sqlw = " where prid=$id and order_state=2";
		if (!empty($user_name)) {
			$sqlw .= " and ( company_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `application_orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取投标人list信息
	public function getOrderSignToubiaoAll($pg, $user_name,$id)
	{
		$sqlw = " and order_state=2";
		if (!empty($user_name)) {
			$sqlw .= " and ( a.company_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT a.*,p.product_name,p.product_sort FROM `application_orders` a,`product_release` p where a.prid=$id and a.prid = p.prid" . $sqlw . " order by a.aftid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	
	
	//选定投标企业
	public function order_bid_toubiao_edit($id,$str)
	{
		$id = $this->db->escape($id);
		$str = $this->db->escape($str);
		$sql = "UPDATE `application_orders` SET  order_state=$str WHERE aftid = $id";
	    //return $sql;
		return $this->db->query($sql);
	}


	//----------------------------中标订单列表-------------------------------------

	//获取投标项目标签页数
	public function getOrderSignAllPage($user_name,$sort,$start,$end,$title)
	{
		$sqlw = " ";
		if ($start) {
			$sqlw .= " and p.add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and p.add_time<=$end";
		}

		if (!empty($user_name)) {
			$sqlw .= " and ( p.product_name like '%" . $user_name . "%' ) ";
		}
		if (!empty($title)) {
			$sqlw .= " and ( a.company_name like '%" . $title . "%' ) ";
		}
		
		$sql = "SELECT count(1) as number FROM `product_release` p,`application_orders` a where p.product_sort=$sort and p.prid=a.prid and a.order_state=2  " . $sqlw ;
		
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取投标项目标签信息
	public function getOrderSignAll($pg, $user_name,$sort,$start,$end,$title)
	{
		$sqlw = " ";
		if (!empty($user_name)) {
			$sqlw .= " and ( p.product_name like '%" . $user_name . "%' ) ";
		}
				if (!empty($title)) {
			$sqlw .= " and ( a.company_name like '%" . $title . "%' ) ";
		}
		
		if ($start) {
			$sqlw .= " and p.add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and p.add_time<=$end";
		}

		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT p.*,a.company_name as gysname FROM `product_release` p,`application_orders` a where p.product_sort=$sort and p.prid=a.prid and a.order_state=2  " . $sqlw . " order by p.prid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取投标项目总发货量
	public function getSignSums($id)
	{
		$sql = "SELECT sum(delivery_number) as number FROM `delivery` where prid=$id";
		return $this->db->query($sql)->row()->number;
	}


	//获取投标项目总发货次数
	public function getSignNums($id)
	{
		$sql = "SELECT count(delivery_number) as number FROM `delivery` where prid=$id";
		return $this->db->query($sql)->row()->number;
	}

	//获取投标项目发货信息页数
	public function getOrderSignSendAllPage($id)
	{
		$sqlw = " where prid=$id";
		$sql = "SELECT count(1) as number FROM `delivery` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取投标项目发货信息
	public function getOrderSignSendAll($pg, $id)
	{
		$sqlw = " where b.prid=$id";
		$start = ($pg - 1) * 10;
		$stop = 10;
		//$sql = "SELECT b.*,a.company_name FROM `delivery` b, `application_orders` a where b.prid=a.prid and b.prid=$id order by did desc LIMIT $start, $stop";
		$sql = "SELECT b.*,a.company_name as khname,c.company_name as gysname from `delivery` b, `product_release` a,member c where b.prid=a.prid and b.prid=$id and a.product_signmemberid=c.mid order by did desc LIMIT $start, $stop";
		
		return $this->db->query($sql)->result_array();
	}

	//----------------------------完成订单留言查看-------------------------------------
	//完成订单留言查看
	public function getOrderComment($id)
	{
		$sqlw = " where prid=$id";
		$sql = "SELECT * FROM `comment` " . $sqlw;
		return $this->db->query($sql)->row_array();
	}

	//----------------------------订单异常查看-------------------------------------
	//完成订单留言查看
	public function getOrderAbnormal($id)
	{
		$sqlw = " where prid=$id";
		$sql = "SELECT * FROM `product_abnormal` " . $sqlw;
		return $this->db->query($sql)->row_array();
	}


	//----------------------------取消订单列表-------------------------------------

	//获取标签页数
	public function getOrderDelAllPage($user_name,$sort,$start,$end)
	{
		$sqlw = " where product_sort=$sort";
		if (!empty($user_name)) {
			$sqlw .= " and ( product_name like '%" . $user_name . "%' ) ";
		}
		if ($start) {
			$sqlw .= " and add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and add_time<=$end";
		}
		$sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取标签信息
	public function getOrderDelAll($pg, $user_name,$sort,$start,$end)
	{
		$sqlw = " where product_sort=$sort";
		if (!empty($user_name)) {
			$sqlw .= " and ( product_name like '%" . $user_name . "%' ) ";
		}
		if ($start) {
			$sqlw .= " and add_time>=$start";
		}
		if ($end) {
			$sqlw .= " and add_time<=$end";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `product_release` " . $sqlw . " order by prid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//恢复订单
	public function order_del_update($id)
	{
		$id = $this->db->escape($id);
		$sql = "UPDATE `product_release` SET  audit_status=0 and product_sort=0 WHERE prid = $id";
		//return $sql;
		return $this->db->query($sql);
	}
	
	
	//根据id获取标签信息
	public function getMemberCompnay($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `member` where mid=$id ";
		return $this->db->query($sql)->row_array();
	}
	
		//根据id获取标签信息
	public function getOrderSignSendEdit($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `delivery` where did=$id ";
		return $this->db->query($sql)->row_array();
	}
	
		//根据id获取标签信息
	public function orderSignSendNumber($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT batch_number as mumber FROM `delivery` where prid=$id and identity=0";
		$row = $this->db->query($sql)->row_array();
		$number=$row['mumber'];
		if($number!=""){
		    $numbers=$number+1;
		}else{
		 	$numbers=0;   
		}
		return $numbers;
	}
	
		public function order_sign_send_save($moeny,$gettime,$gimg,$id,$number)
	{
		$moeny = $this->db->escape($moeny);
		$gettime = $this->db->escape($gettime);
		$gimg = $this->db->escape($gimg);
		$id = $this->db->escape($id);
		$number = $this->db->escape($number);
        $datetime=strtotime(date("Y-m-d"));
		$sql = "INSERT INTO `delivery` 
				(payment_price,delivery_time,express_img,prid,identity,delivery_number,add_time,batch_number) 
				VALUES
				($moeny,$gettime,$gimg,$id,0,0,$datetime,$number)";
		//return $sql;
		return $this->db->query($sql);
	}
	
			public function order_sign_send_update($moeny,$gettime,$gimg,$id)
	{
		$moeny = $this->db->escape($moeny);
		$gettime = $this->db->escape($gettime);
		$gimg = $this->db->escape($gimg);
		$id = $this->db->escape($id);

		$sql = "UPDATE `delivery` SET 
				payment_price=$moeny,delivery_time=$gettime,express_img=$gimg
				WHERE did = $id";
		//return $sql;
		return $this->db->query($sql);
	}
	
		//标签delete
	public function order_sign_send_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "delete from `delivery` WHERE did = $id";
		//return $sql;
		return $this->db->query($sql);
	}
	
			//订单作废
	public function order_bid_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "UPDATE `product_release` SET 
				product_sort=5
				WHERE prid = $id";
		//return $sql;
		return $this->db->query($sql);
	}


}
