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
	public function getorders($start,$end,$sort)
	{
		$sqlw=" where add_time>=$start and add_time<=$end";
		if($sort>=0){
			$sqlw=$sqlw." and product_sort=$sort";
		}
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

}
