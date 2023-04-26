<?php


class Member_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//----------------------------供应商列表-------------------------------------

	//获取订单页数
	public function getGongyingshangAllPage($gongsi,$mobile,$sort,$status,$stop)
	{
		$sqlw = " where identity=$sort and company_stop=$stop";
		if($status<4){
			$sqlw .= " and audit_status=$status";
		}
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
	public function getGongyingshangAll($pg, $gongsi,$mobile,$sort,$status,$stop)
	{
		$sqlw = " where identity=$sort and company_stop=$stop";
		if($status<4){
			$sqlw .= " and audit_status=$status";
		}
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

	//获取供应商信息
	public function getProclassAll()
	{
		$sql = "SELECT * FROM `product_classification`";
		return $this->db->query($sql)->result_array();
	}

	//获取分类标签名称
	public function getProclassName($id)
	{
		$sql = "SELECT product_class_name as proname FROM `product_classification` where pid=$id";
		return $this->db->query($sql)->row()->proname;
	}


	//获取供应商名称信息
	public function getGongsiName($tel,$sort)
	{
		$sql = "SELECT * FROM `member` where mobile= '".$tel."'and identity='".$sort."'";
		return $this->db->query($sql)->result_array();
	}

	//会員save
	public function Gongyingshang_save($sort,$gongsi,$user,$tel,$address,$mail,$gimg,$type,$typenames,$status,$add_time,$grade)
	{
		$data = array(
			'audit_status'=>$status,
			'business_license'=>$gimg,
			'business_type'=>$type,
			'business_typenames'=>$typenames,
			'company_name'=>$gongsi,
			'company_address'=>$address,
			'add_time'=>$add_time,
			'mobile'=>$tel,
			'email'=>$mail,
			'identity'=>$sort,
			'truename'=>$user,
			'grade'=>$grade
		);
		
		return $this->db->insert('member',$data);
		//return $this->db->last_query();
	}

	//会員信息获取
	public function getGongyingshangEdit($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `member` where mid=$id";
		return $this->db->query($sql)->row_array();
	}

	//会員update
	public function Gongyingshang_save_edit($id,$gongsi,$user,$tel,$address,$mail,$type,$typenames,$status,$grade)
	{

		$data = array(
			'audit_status'=>$status,
			'business_type'=>$type,
			'business_typenames'=>$typenames,
			'company_name'=>$gongsi,
			'company_address'=>$address,
			'mobile'=>$tel,
			'email'=>$mail,
			'truename'=>$user,
			'grade'=>$grade
		);

        return $this->db->update('member',$data,array('mid'=>$id));
        //return $this->db->last_query();
	}


	//会員delete
	public function gongyingshang_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM  `member` WHERE mid = $id";
		return $this->db->query($sql);
	}

	//会員stop
	public function gongyingshang_stop($id,$stop)
	{
		$id = $this->db->escape($id);
		if($stop==0){
			$stops=1;
		}else{
			$stops=0;
		}
		$sql = "UPDATE `member` SET company_stop=$stops WHERE mid = $id";
		return $this->db->query($sql);
	}


	//会員delete
	public function gongyingshang_check($id,$check)
	{
		$id = $this->db->escape($id);
		$check = $this->db->escape($check);
		$sql = "UPDATE `member` SET audit_status=$check WHERE mid = $id";
		return $this->db->query($sql);
	}

	//获取角色列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}


	//----------------------------客户列表-------------------------------------

	//获取客户订单页数
	public function getkehuAllPage($gongsi,$mobile,$sort,$status,$stop)
	{
		$sqlw = " where identity=$sort and company_stop=$stop";
		if($status<4){
			$sqlw .= " and audit_status=$status";
		}
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

	//获取客户信息
	public function getkehuAll($pg, $gongsi,$mobile,$sort,$status,$stop)
	{
		$sqlw = " where identity=$sort and company_stop=$stop";
		if($status<4){
			$sqlw .= " and audit_status=$status";
		}
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

	//客户save
	public function kehu_save($gongsi,$user,$tel,$address,$mail,$gimg,$add_time)
	{
		$data = array(
			'audit_status'=>2,
			'business_license'=>$gimg,
			'company_name'=>$gongsi,
			'company_address'=>$address,
			'add_time'=>$add_time,
			'mobile'=>$tel,
			'email'=>$mail,
			'identity'=>0,
			'truename'=>$user
		);
		return $this->db->insert('member',$data);
	}

	//会員update
	public function kehu_save_edit($id,$gongsi,$user,$tel,$address,$mail,$gimg,$status)
	{
		$id = $this->db->escape($id);
		$gongsi = $this->db->escape($gongsi);
		$user = $this->db->escape($user);
		$tel = $this->db->escape($tel);
		$address = $this->db->escape($address);
		$mail = $this->db->escape($mail);
		$gimg = $this->db->escape($gimg);
		$status = $this->db->escape($status);

		$sql = "UPDATE `member`  SET business_license=$gimg,company_name=$gongsi,company_address=$address,mobile=$tel,email=$mail,audit_status=$status,truename=$user where mid=$id";
		//return $sql;
		return $this->db->query($sql);
	}


	//客户delete
	public function kehu_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM  `member` WHERE mid = $id";
		return $this->db->query($sql);
	}

	//客户stop
	public function kehu_stop($id,$stop)
	{
		$id = $this->db->escape($id);
		if($stop==0){
			$stops=1;
		}else{
			$stops=0;
		}
		$sql = "UPDATE `member` SET company_stop=$stops WHERE mid = $id";
		return $this->db->query($sql);
	}


	//客户审核
	public function kehu_check($id,$check)
	{
		$id = $this->db->escape($id);
		$check = $this->db->escape($check);
		$sql = "UPDATE `member` SET audit_status=$check WHERE mid = $id";
		return $this->db->query($sql);
	}
	
		//----------------------------供应商列表-------------------------------------

	//获取订单页数
	public function getgysshowAllPage($id)
	{
		$sqlw = " where identity=1 and find_in_set($id,business_type)";
		$sql = "SELECT count(1) as number FROM `member` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取供应商信息
	public function getgysshowAll($pg, $id)
	{
		$sqlw = " where identity=1 and find_in_set($id,business_type)";
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `member` " . $sqlw . " order by mid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	


}



