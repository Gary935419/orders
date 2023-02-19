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
			$sqlw .= " and ( industry_class_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `industry_classification` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取标签信息
	public function getProclassAll($pg, $user_name)
	{
		$sqlw = " where 1=1";
		if (!empty($user_name)) {
			$sqlw .= " and ( class_title like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `industry_classification` " . $sqlw . " order by iid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//标签delete
	public function proclass1_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM industry_classification WHERE co_id = $id";
		return $this->db->query($sql);
	}

	//----------------------------一级分类add添加-------------------------------------

	//判断是否有重复信息
	public function getProClassName($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `industry_classification` where industry_class_name = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//标签save
	public function ProClass_save($name,$desc,$gimg,$datetime)
	{
		$name = $this->db->escape($name);
		$desc = $this->db->escape($desc);
		$gimg = $this->db->escape($gimg);
		$datetime = $this->db->escape($datetime);

		$sql = "INSERT INTO `industry_classification` (industry_class_name,industry_class_img,industry_class_desc,add_time) VALUES ($name,$gimg,$desc,$datetime)";
		//return $sql;
		return $this->db->query($sql);
	}

	//----------------------------一级edit更新-------------------------------------

	//根据id获取标签信息
	public function getProClassEdit($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `industry_classification` where iid=$id ";
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

		$sql = "UPDATE `industry_classification` SET industry_class_name=$name,industry_class_desc=$desc,industry_class_img=$gimg,add_time=$datetime WHERE iid = $uid";
		//return $sql;
		return $this->db->query($sql);
	}

	//标签delete
	public function proclass_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM industry_classification WHERE iid = $id";
		return $this->db->query($sql);
	}

	//获取角色列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}

}
