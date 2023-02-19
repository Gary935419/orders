<?php


class News_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//----------------------------供应商列表-------------------------------------

	//获取订单页数
	public function getNewsAllPage($gongsi,$type)
	{
		$sqlw = " where news_type=$type";
		if (!empty($gongsi)) {
			$sqlw .= " and ( news_title like '%" . $gongsi . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `industry_news` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取供应商信息
	public function getNewsAll($pg, $gongsi,$type)
	{
		$sqlw = " where news_type=$type";
		if (!empty($gongsi)) {
			$sqlw .= " and ( news_title like '%" . $gongsi . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `industry_news` " . $sqlw . " order by inid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	//会員save
	public function news_save($title,$desc,$gimg,$add_time,$type,$url)
	{
		$data = array(
			'news_title'=>$title,
			'news_contents'=>$desc,
			'addtime'=>$add_time,
			'news_img'=>$gimg,
			'news_url'=>$url,
			'news_type'=>$type
		);
		return $this->db->insert('industry_news',$data);
	}

	//会員信息获取
	public function getNewsEdit($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `industry_news` where inid=$id";
		return $this->db->query($sql)->row_array();
	}

	//会員update
	public function news_save_edit($id,$title,$desc,$gimg,$add_time,$url)
	{
		$id = $this->db->escape($id);
		$title = $this->db->escape($title);
		$gimg = $this->db->escape($gimg);
		$desc = $this->db->escape($desc);
		$url = $this->db->escape($url);
		$add_time = $this->db->escape($add_time);

		$sql = "UPDATE `industry_news`  SET news_title=$title,news_contents=$desc,addtime=$add_time,news_img=$gimg,news_url=$url where inid=$id";
		//return $sql;
		return $this->db->query($sql);
	}


	//会員delete
	public function news_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM  `industry_news` WHERE inid = $id";
		return $this->db->query($sql);
	}

}



