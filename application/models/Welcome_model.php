<?php


class Welcome_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }
	
	//----------------------------商家列表-------------------------------------
	
	//获取用户数
	public function getyonghunum($type)
	{
	    $sqlw = " where company_stop=0 ";
		if($type==2){
		    $sqlw.= " and to_days(add_time) = to_days(now())";
		}else{
		    $sqlw.= " and identity=$type";
		}
		$sql = "SELECT count(1) as number FROM `member` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	
	//获取发布量
	public function getordernum($type)
	{
	    if($type==1){
	        $sqlw = " where product_sort<5 ";	        
	    }elseif($type==2){
	        $sqlw = " where product_sort=4 ";	 	        
	    }else{
		    $sqlw= " where product_sort<5 and to_days(add_time) = to_days(now())";	        
	    }

		$sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	
	//获取商家数
	public function getproclassnum($pcname,$type)
	{
		$sqlw = " where product_class_name='".$pcname."'";
		if(!$type){
	        $sqlw.= " and product_sort<5 ";
		}else{
		    $sqlw.= " and product_sort=4 "; 
		}
		$sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}

	//获取骑手数
	public function getqishounum()
	{
		$sqlw = " where 1=1 ";
		$sql = "SELECT count(1) as number FROM `qishou` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	

		//获取用户数
	public function getdingdannum()
	{
		$sqlw = " where date(delivery_date)=CURDATE() ";
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	

	//获取商家数
	public function getquhuonum()
	{
		$sqlw = " where date(delivery_date)=CURDATE() ";
		$sql = "SELECT count(distinct mid) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}

	//获取骑手数
	public function getzhongliangnum()
	{
		$sqlw = " where date(datetime)=CURDATE() ";
		$sql = "SELECT sum(m_weight) as number FROM `orders_merchants` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}

	//获取骑手数
	public function getzongnum()
	{
		$sqlw = "where 1=1";
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	
}
