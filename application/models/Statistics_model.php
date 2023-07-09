<?php


class Statistics_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}
	//统计客户注册量
	public function getmembers($start,$end,$sort,$identity)
	{
		$sqlw=" where identity=$identity and add_time>=$start and add_time<=$end";
		if($sort>0){
			$sqlw=$sqlw." and audit_status=$sort";
		}
		$sql = "SELECT count(*) as num FROM `member` ".$sqlw;
		return $this->db->query($sql)->row()->num;
	}
	
		//统计订单当月发布
	public function getkhorders($start,$end)
	{
		$sqlw=" where add_time>=$start and add_time<=$end";
		$sql = "SELECT count(*) as num FROM `product_release` ".$sqlw;
		return $this->db->query($sql)->row()->num;
	}
	
	//统计订单当月发布
	public function getorders($start,$end,$sort)
	{
		$sqlw=" where add_time>=$start and add_time<=$end";
		$sqlw=$sqlw." and product_sort=$sort";
		$sql = "SELECT count(*) as num FROM `product_release` ".$sqlw;
		return $this->db->query($sql)->row()->num;
	}

	//统计订单当月发布
	public function getmemberp($gongsi,$sort)
	{
		$sqlw=" where identity=$sort";
		$sql = "SELECT mid,company_name FROM `member` ".$sqlw;
		return $this->db->query($sql)->result_array();
	}

	//统计订单当月发布
	public function getpingjia($sort,$id,$num)
	{
		$sqlw=" where 1=1";
		if($num>0){
			if($sort==0){
				$sqlw.=" and kehu_id=$id and kehu_num=$num";
			}else{
				$sqlw.=" and gongyingshang_id=$id and gongyingshang_num=$num";
			}
		}else{
			if($sort==0){
				$sqlw.=" and kehu_id=$id";
			}else{
				$sqlw.=" and gongyingshang_id=$id";
			}
		}
		$sql = "SELECT count(*) as num FROM `comment` ".$sqlw;
		return $this->db->query($sql)->row()->num;
	}
	
		//统计订单当月发布
	public function getcommentshow($mid,$gongsi)
	{
	    $sqlw="";
		if (!empty($gongsi)) {
			$sqlw.=" and a.product_name like '%" . $gongsi . "%'";
		}
		$sql = "SELECT * FROM `product_release` a,`comment` b where a.prid=b.prid and a.mid=$mid ".$sqlw;
		return $this->db->query($sql)->result_array();
	}
	
	//获取用户姓名
	public function getmembername($mid)
	{
		$sqlw=" where 1=1";
		$sql = "SELECT company_name as name FROM `member` where mid=$mid";
		return $this->db->query($sql)->row()->name;
	}
	
		//----------------------------供应商列表-------------------------------------

	//获取订单页数
	public function getorderlistAllPage($gongsi,$sort)
	{
		$sqlw = " where 1=1";
		$sqlw .= " and product_sort=$sort";
		if (!empty($gongsi)) {
			$sqlw .= " and ( product_name like '%" . $gongsi . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取供应商信息
	public function getorderlistAll($pg, $gongsi,$sort)
	{
		$sqlw = " where 1=1";
		$sqlw .= " and product_sort=$sort";
		if (!empty($gongsi)) {
			$sqlw .= " and ( product_name like '%" . $gongsi . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `product_release` " . $sqlw . " order by prid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取gys信息
	public function getgysmember($mid)
	{
		$sqlw=" where 1=1";
		$sql = "SELECT * FROM `member` where mid=$mid";
		return $this->db->query($sql)->row_array();
	}
	
		//获取订单页数
	public function getGongyingshangAllPage($gongsi,$mobile)
	{
		$sqlw = " where identity=1 and audit_status=2 and company_stop=0";

		if (!empty($gongsi)) {
			$sqlw .= " and ( company_name like '%" . $gongsi . "%' ) ";
		}
		if (!empty($mobile)) {
			$sqlw .= " and ( mobile like '%" . $mobile . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `member` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取供应商信息
	public function getGongyingshangAll($pg, $gongsi,$mobile)
	{
		$sqlw = " where identity=1 and audit_status=2 and company_stop=0";
		if (!empty($gongsi)) {
			$sqlw .= " and ( company_name like '%" . $gongsi . "%' ) ";
		}
		if (!empty($mobile)) {
			$sqlw .= " and ( mobile like '%" . $mobile . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `member` " . $sqlw . " order by mid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	
		
		//获取订单页数
	public function getDuizhangAllPage($sdate,$edate,$mid)
	{
		$sqlw = " where (product_sort=2 or product_sort=3) and product_signmemberid=$mid";

		if ($sdate) {
			$sqlw .= " and product_signtime>=$sdate";
		}
		if ($edate) {
			$sqlw .= " and product_signtime<=$edate";
		}
		$sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取供应商信息
	public function getDuizhangAll($pg, $sdate,$edate,$mid)
	{
		$sqlw = " where (product_sort=2 or product_sort=3) and product_signmemberid=$mid";

		if ($sdate) {
			$sqlw .= " and product_signtime>=$sdate";
		}
		if ($edate) {
			$sqlw .= " and product_signtime<=$edate";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `product_release` " . $sqlw . " order by prid desc LIMIT $start, $stop";
		//print_r($sql);
		
		return $this->db->query($sql)->result_array();
	}
	

	


}
