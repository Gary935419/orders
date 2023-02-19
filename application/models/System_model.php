<?php


class System_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}
	//----------------------------异常信息查看-------------------------------------
	//异常信息管理页数
	public function getAbnormalAllPage($desc)
	{
		$sqlw = " where 1=1 ";
		if (!empty($desc)) {
			$sqlw .= " and ( error_desc like '%" . $desc . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `error_news` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}
	//获取异常信息
	public function getAbnormalAll($pg, $desc)
	{
		$sqlw = " where 1=1 ";
		if (!empty($desc)) {
			$sqlw .= " and ( error_desc like '%" . $desc . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `error_news` " . $sqlw. "order by enid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	//获取异常信息使用次数
	public function getAbnormalNum($id)
	{
		$sqlw = " where errorid=$id ";
		$sql = "SELECT count(*) as num FROM `product_abnormal` " . $sqlw;
		return $this->db->query($sql)->row_array();
	}
	//异常信息添加
	public function abnormalSave($desc,$datetime)
	{
		$desc = $this->db->escape($desc);
		$datetime = $this->db->escape($datetime);
		$sql = "INSERT INTO `error_news` (error_desc,error_addtime) VALUES ($desc,$datetime)";
		return $this->db->query($sql);
	}

	//异常信息读取
	public function abnormalSelect($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `error_news` where enid=$id";
		return $this->db->query($sql)->row_array();
	}

	//异常信息修改
	public function abnormalUpdate($id,$desc,$datetime)
	{
		$id = $this->db->escape($id);
		$desc = $this->db->escape($desc);
		$datetime = $this->db->escape($datetime);
		$sql = "UPDATE `error_news` SET error_desc=$desc,error_addtime=$datetime WHERE enid = $id";
		return $this->db->query($sql);
	}
	//异常信息删除
	public function abnormalDel($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM error_news WHERE enid = $id";
		return $this->db->query($sql);
	}


	//----------------------------广告信息查看-------------------------------------
	//广告图片信息管理页数
	public function getPictureAllPage($desc)
	{
		$sqlw = " where 1=1 ";
		if (!empty($desc)) {
			$sqlw .= " and ( error_desc like '%" . $desc . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `error_news` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}
	//获取广告图片信息
	public function getPictureAll($pg, $desc)
	{
		$sqlw = " where 1=1 ";
		if (!empty($desc)) {
			$sqlw .= " and ( error_desc like '%" . $desc . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `error_news` " . $sqlw. "order by enid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//广告图片信息添加
	public function pictureSave($desc,$datetime)
	{
		$desc = $this->db->escape($desc);
		$datetime = $this->db->escape($datetime);
		$sql = "INSERT INTO `error_news` (error_desc,error_addtime) VALUES ($desc,$datetime)";
		return $this->db->query($sql);
	}

	//广告图片信息读取
	public function pictureSelect($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `error_news` where enid=$id";
		return $this->db->query($sql)->row_array();
	}

	//异常信息修改
	public function pictureUpdate($id,$desc,$datetime)
	{
		$id = $this->db->escape($id);
		$desc = $this->db->escape($desc);
		$datetime = $this->db->escape($datetime);
		$sql = "UPDATE `error_news` SET error_desc=$desc,error_addtime=$datetime WHERE enid = $id";
		return $this->db->query($sql);
	}

	//异常信息删除
	public function pictureDel($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM error_news WHERE enid = $id";
		return $this->db->query($sql);
	}

}
