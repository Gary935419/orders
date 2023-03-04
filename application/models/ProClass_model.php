<?php


class ProClass_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//----------------------------一级分类list列表-------------------------------------

	//获取标签页数
	public function getProclassAllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( product_class_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `product_classification` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取标签信息
	public function getProclassAll($pg, $user_name)
	{
		$sqlw = " where 1=1";
		if (!empty($user_name)) {
			$sqlw .= " and ( product_class_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `product_classification` " . $sqlw . " order by pid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//----------------------------一级分类add添加-------------------------------------

	//判断是否有重复信息
	public function getProClassName($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `product_classification` where product_class_name = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//标签save
	public function ProClass_save($name,$desc,$gimg,$datetime)
	{
		$name = $this->db->escape($name);
		$desc = $this->db->escape($desc);
		$gimg = $this->db->escape($gimg);
		$datetime = $this->db->escape($datetime);

		$sql = "INSERT INTO `product_classification` (product_class_name,product_woimg,product_desc,add_time) VALUES ($name,$gimg,$desc,$datetime)";
		//return $sql;
		return $this->db->query($sql);
	}

	//----------------------------一级edit更新-------------------------------------

	//根据id获取标签信息
	public function getProClassEdit($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `product_classification` where pid=$id ";
		return $this->db->query($sql)->row_array();
	}

	//标签更新
	public function proclass_save_edit($uid,$name,$gimg,$desc,$datetime)
	{
		$uid = $this->db->escape($uid);
		$name = $this->db->escape($name);
		$desc = $this->db->escape($desc);
		$gimg = $this->db->escape($gimg);
		$datetime = $this->db->escape($datetime);

		$sql = "UPDATE `product_classification` SET product_class_name=$name,product_desc=$desc,product_woimg=$gimg,add_time=$datetime WHERE pid = $uid";
		//return $sql;
		return $this->db->query($sql);
	}

	//标签delete
	public function proclass_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM product_classification WHERE pid = $id";
		return $this->db->query($sql);
	}

	//获取角色列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}

	//获取角色列表
	public function getProClassgys($id)
	{
	    $id = $this->db->escape($id);
		$sql = "SELECT count(*) as number FROM `member`where identity=1 and find_in_set($id,business_type)";
		return $this->db->query($sql)->row()->number;
	}

}
