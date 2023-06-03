<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Member extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Member_model', 'member');
		$this->load->model('Common_model', 'common');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------用户管理-----------------------------------------------------*/
	/**
	 * 用户列表页
	 */
	public function gongyingshang_list($sort,$status,$stop)
	{

		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getGongyingshangAllPage($gongsi,$mobile,$sort,$status,$stop);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->member->getGongyingshangAll($page,$gongsi,$mobile,$sort,$status,$stop);

		$data["gongsiv"]=$gongsi;
		$data["mobilev"] = $mobile;
		$data["status"] = $status;
		$this->display("member/gongyingshang_list", $data);
	}

	/**
	 * 角色添加页
	 */
	public function gongyingshang_add($sort)
	{
		$pids = $this->common->getProclasslist(0);
		foreach($pids as $k =>$v){
		    $pid2s=$this->common->getProclasslist($v['pid']);
		    $pidlist[$k]['name']=$v['product_class_name'];
		    $pidlist[$k]['pid2list']=$pid2s;		    
		}
		print_r($pidlist[0]['pid2list'][0]['pid']);
		$data["list"]=$pidlist;
		$data["sort"] = $sort;
		$this->display("member/gongyingshang_add",$data);
	}

	/**
	 * 供应商添加提交
	 */
	public function gongyingshang_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$sort=$_POST["sort"];
		$gongsi = !empty($_POST["gongsi"]) ? $_POST["gongsi"] : '';
		$user = !empty($_POST["user"]) ? $_POST["user"] : '';
		$tel = !empty($_POST["tel"]) ? $_POST["tel"] : '';
		$address = !empty($_POST["address"]) ? $_POST["address"] : '';
		$mail = !empty($_POST["mail"]) ? $_POST["mail"] : '';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : '';
		//获取分类名称
		$type = isset($_POST["type"]) ? $_POST["type"] : '';
		$grade = $_POST["grade"];
		
		$typenames="";
		if($type){
			foreach ($type as $num => $once) {
				$typename= $this->member->getProclassName($once);
				$typenames=$typenames.",".$typename;
			}
			$type =implode($type,",");
		}
		$typenames=substr($typenames,1);
		$status = $_POST["status"];
		$add_time = time();

		if (empty($gongsi) || empty($user) || empty($tel)) {
			echo json_encode(array('error' => false, 'msg' => "请填写公司名或联系人姓名或手机！"));
			return;
		}
		$gongsi_info = $this->member->getGongsiName($tel,$sort);
		if ($gongsi_info) {
			echo json_encode(array('error' => true, 'msg' => "该供应商手机号已注册,不能重复添加。"));
			return;
		}

		$result = $this->member->Gongyingshang_save($sort,$gongsi,$user,$tel,$address,$mail,$gimg,$type,$typenames,$status,$add_time,$grade);


		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	/**
	 * 账号删除
	 */
	public function gongyingshang_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->member->gongyingshang_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 账号停用
	 */
	public function gongyingshang_stop()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$stop = isset($_POST['stop']) ? $_POST['stop'] : 0;
		if ($this->member->gongyingshang_stop($id,$stop)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}


	/**-----------------------------------供应商修改管理-----------------------------------------------------*/
	/**
	 * 用户列表页
	 */
	public function gongyingshang_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->member->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->member->getGongyingshangEdit($uid);
		$data['id'] = $uid;
		$data['gongsi'] = $member_info['company_name'];
		$data['user'] = $member_info['truename'];
		$data['tel'] = $member_info['mobile'];
		$data['mail'] = $member_info['email'];
		$data['address'] = $member_info['company_address'];
		$data['gimg1'] = $member_info['business_license'];
		$data['gimg2'] = $member_info['review_data'];
		$data['type'] = explode(",",$member_info['business_type']);
		$data['status'] = $member_info['audit_status'];
		$data['sort'] = $member_info['identity'];
		$data['grade'] = $member_info['grade'];
		$data["list"] = $this->member->getProclassAll();
		$this->display("member/gongyingshang_edit", $data);
	}

	/**
	 * 供应商添加提交
	 */
	public function gongyingshang_edit_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$id=$_POST["id"];
		$sort=$_POST["sort"];
		$tels =$_POST["tels"];
		$gongsi = !empty($_POST["gongsi"]) ? $_POST["gongsi"] : '';
		$user = !empty($_POST["user"]) ? $_POST["user"] : '';
		$tel = !empty($_POST["tel"]) ? $_POST["tel"] : '';
		$address = !empty($_POST["address"]) ? $_POST["address"] : '';
		$mail = !empty($_POST["mail"]) ? $_POST["mail"] : '';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : '';
		$type = isset($_POST["type"]) ? $_POST["type"] : '';
		$status = $_POST["status"];
		$grade = $_POST["grade"];

		//获取分类名称
		$typenames="";
		if($type){
			foreach ($type as $num => $once) {
				$typename= $this->member->getProclassName($once);
				$typenames=$typenames.",".$typename;
			}
			$type =implode($type,",");
		}
		$typenames=substr($typenames,1);

		if (empty($gongsi) || empty($user) || empty($tel)) {
			echo json_encode(array('error' => false, 'msg' => "请填写公司名或联系人姓名或手机！"));
			return;
		}
		
		if($tels<>$tel){
			$gongsi_info = $this->member->getGongsiName($tel,$sort);
			if ($gongsi_info) {
				echo json_encode(array('error' => true, 'msg' => "该供应商手机号已注册,不能重复添加。"));
				return;
			}
		}

		$result = $this->member->Gongyingshang_save_edit($id,$gongsi,$user,$tel,$address,$mail,$type,$typenames,$status,$grade);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 账号审核
	 */
	public function gongyingshang_check()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$check=$_POST['check'];
		if ($this->member->gongyingshang_check($id,$check)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}


	/**
	 * **********************************************************************
	 * 客户管理
	 * **********************************************************************
	 */
	public function kehu_list($sort,$status,$stop)
	{
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getKehuAllPage($gongsi,$mobile,$sort,$status,$stop);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list= $this->member->getKehuAll($page,$gongsi,$mobile,$sort,$status,$stop);

		foreach ($list as $key=>$value){
			$list[$key]['fabunum']= $this->common->getFabNum($value['mid']);

		}

		$data["list"]=$list;
		$data["gongsiv"]=$gongsi;
		$data["mobilev"] = $mobile;
		$data["status"] = $status;
		$this->display("member/kehu_list", $data);
	}

	/**
	 * 客户添加页
	 */
	public function kehu_add($sort)
	{
		$data["list"] = $this->member->getProclassAll();
		$data["sort"] = $sort;
		$this->display("member/kehu_add",$data);
	}

	/**
	 * 供应商添加提交
	 */
	public function kehu_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$gongsi = !empty($_POST["gongsi"]) ? $_POST["gongsi"] : '';
		$user = !empty($_POST["user"]) ? $_POST["user"] : '';
		$tel = !empty($_POST["tel"]) ? $_POST["tel"] : '';
		$address = !empty($_POST["address"]) ? $_POST["address"] : '';
		$mail = !empty($_POST["mail"]) ? $_POST["mail"] : '';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : '';
		$add_time = time();

		if (empty($gongsi) || empty($user) || empty($tel)) {
			echo json_encode(array('error' => false, 'msg' => "请填写公司名或联系人姓名或手机！"));
			return;
		}
		$gongsi_info = $this->member->getGongsiName($tel,0);
		if ($gongsi_info) {
			echo json_encode(array('error' => true, 'msg' => "该供应商手机号已注册,不能重复添加。"));
			return;
		}
		$result = $this->member->kehu_save($gongsi,$user,$tel,$address,$mail,$gimg,$add_time);

		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 用户详情页面
	 */
	public function kehu_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->member->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->member->getGongyingshangEdit($uid);
		$data['id'] = $uid;
		$data['gongsi'] = $member_info['company_name'];
		$data['user'] = $member_info['truename'];
		$data['tel'] = $member_info['mobile'];
		$data['mail'] = $member_info['email'];
		$data['address'] = $member_info['company_address'];
		$data['gimg'] = $member_info['business_license'];
		$data['status'] = $member_info['audit_status'];
		$data["list"] = $this->member->getProclassAll();
		$this->display("member/kehu_edit", $data);
	}

	/**
	 * 供应商添加提交
	 */
	public function kehu_edit_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$id=$_POST["id"];
		$tels =$_POST["tels"];
		$gongsi = !empty($_POST["gongsi"]) ? $_POST["gongsi"] : '';
		$user = !empty($_POST["user"]) ? $_POST["user"] : '';
		$tel = !empty($_POST["tel"]) ? $_POST["tel"] : '';
		$address = !empty($_POST["address"]) ? $_POST["address"] : '';
		$mail = !empty($_POST["mail"]) ? $_POST["mail"] : '';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : '';
		$status = $_POST["status"];

		if (empty($gongsi) || empty($user) || empty($tel)) {
			echo json_encode(array('error' => false, 'msg' => "请填写公司名或联系人姓名或手机！"));
			return;
		}

		if($tels<>$tel){
			$gongsi_info = $this->member->getGongsiName($tel,$sort);
			if ($gongsi_info) {
				echo json_encode(array('error' => true, 'msg' => "该供应商手机号已注册,不能重复添加。"));
				return;
			}
		}

		$result = $this->member->kehu_save_edit($id,$gongsi,$user,$tel,$address,$mail,$gimg,$status);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	/**
	 * 账号删除
	 */
	public function kehu_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->member->kehu_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 账号停用
	 */
	public function kehu_stop()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$stop = isset($_POST['stop']) ? $_POST['stop'] : 0;
		if ($this->member->kehu_stop($id,$stop)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 账号审核1111
	 */
	public function kehu_check()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$check=$_POST['check'];
		if ($this->member->kehu_check($id,$check)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}
	
	public function gongyingshang_show()
	{
	    $id = isset($_GET['id']) ? $_GET['id'] : 0;
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getgysshowAllPage($id);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->member->getgysshowAll($page,$id);
		$this->display("member/gongyingshang_show", $data);
	}




}
