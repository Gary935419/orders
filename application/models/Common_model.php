<?php


class Common_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//获取客户信息
	//identity 身份 0用户1供应商
	//audit_status 2审核通过
	public function getKehuNamelist()
	{
		$sql = "SELECT * FROM `member` where audit_status=2 and identity=0";
		return $this->db->query($sql)->result_array();
	}

	//获取产品分类list
	public function getProclassNamelist()
	{
		$sql = "SELECT * FROM `product_classification`";
		return $this->db->query($sql)->result_array();
	}

	//获取产品分类名称
	public function getProclassName($id)
	{
		$sql = "SELECT * FROM `product_classification` where pid=$id";
		return $this->db->query($sql)->row_array();
	}

	//获取客户名称
	public function getKehuName($id)
	{
		$sql = "SELECT * FROM `member` where mid=$id";
		return $this->db->query($sql)->row_array();
	}

	//获取项目投标数量
	public function getToubiaoNum($id)
	{
		$sql = "SELECT count(1) as number FROM `application_orders` where prid=$id";
		return $this->db->query($sql)->row()->number;
	}

	//获取订单名称
	public function getProductName($id)
	{
		$sql = "SELECT * FROM `product_release` where prid=$id";
		return $this->db->query($sql)->row_array();
	}

	//获取异常信息
	public function geterrornews($id)
	{
		$sql = "SELECT * FROM `error_news` where enid=$id";
		return $this->db->query($sql)->row_array();
	}

	//获取角色列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}

	//获取项目发布数量
	public function getFabNum($id)
	{
		$sql = "SELECT count(1) as number FROM `product_release` where mid=$id";
		return $this->db->query($sql)->row()->number;
	}
	
		//获取产品分类list
	public function getProclasslist($id)
	{
		$sql = "SELECT * FROM `product_classification` where product_sort=$id";
		return $this->db->query($sql)->result_array();
	}

    //获取产品分类一二级
    	//获取供应商信息
	public function getProclassarray()
	{
		$sql = "SELECT * FROM `product_classification` where product_sort=0";
		return $this->db->query($sql)->result_array();
	}


}



