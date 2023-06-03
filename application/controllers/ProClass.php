<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Proclass extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('ProClass_model', 'proclass');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------分类显示管理-----------------------------------------------------*/
	/**
	 * 分类列表页
	 */
	public function proclass_list()
	{
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 0;
		$user = isset($_GET['user']) ? $_GET['user'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '0';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->proclass->getProClassAllPage($gongsi,$sort);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->proclass->getProClassAll($page, $gongsi,$sort);
		foreach ($list as $k=>$v){
		    $list[$k]['gysclass']=$this->proclass->getProClassgys($v['pid']);
		    if($v['product_sort']==0){
		        $list[$k]['product_sort_name']="一级分类";   
		    }else{
		        $pros=$this->proclass->getProClassEdit($v['product_sort']);  
		        $list[$k]['product_sort_name']=$pros['product_class_name'];
		    }
		}
		$data["gongsiv"] = $gongsi;
		$data["userv"] = $user;
		$data["status"] = $status;
		$data["list"]=$list; 
		$data["sort"] = $sort;
		$data["sortlist"] = $this->proclass->getProClassSort(0);
		//$data["gysnum"] = $gysnum;		
		$this->display("proclass/proclass_list", $data);
	}

	/**-----------------------------------分类添加管理-----------------------------------------------------*/
	/**
	 * 分类列表页
	 */
	/**
	 * 分类添加页
	 */
	public function proclass_add()
	{
	    $data["list"] = $this->proclass->getProClassSort(0);
		$this->display("proclass/proclass_add",$data);
	}

	/**
	 * 分类添加提交
	 */
	public function proclass_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$sort = !empty($_POST["sort"]) ? $_POST["sort"] : ' ';
		$name = !empty($_POST["name"]) ? $_POST["name"] : ' ';
		$desc = !empty($_POST["desc"]) ? $_POST["desc"] : ' ';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : ' ';
		$datetime = time();
		if (empty($name)) {
			echo json_encode(array('error' => false, 'msg' => "请填写分类名称！"));
			return;
		}
		$proclass_info = $this->proclass->getProClassName($name);

		if ($proclass_info) {
			echo json_encode(array('error' => true, 'msg' => "该分类名已经存在,不能重复添加。"));
			return;
		}
		$result = $this->proclass->ProClass_save($name,$desc,$gimg,$datetime,$sort);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**-----------------------------------分类修改管理-----------------------------------------------------*/
	/**
	 *分类修改显示
	 */
	public function proclass_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->proclass->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->proclass->getProClassEdit($uid);
		$data['id'] = $uid;
		$data['name'] = $member_info['product_class_name'];
		$data['desc'] = $member_info['product_desc'];
		$data['gimg'] = $member_info['product_woimg'];
		$data['sort'] = $member_info['product_sort'];
		$data["list"] = $this->proclass->getProClassSort(0);
		
		$this->display("proclass/proclass_edit", $data);
	}


	/**
	 * 供应商添加提交
	 */
	public function proclass_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$uid = !empty($_POST["uid"]) ? $_POST["uid"] : '';
		$name = !empty($_POST["name"]) ? $_POST["name"] : '';
		$namev = !empty($_POST["namev"]) ? $_POST["namev"] : '';
		$desc = !empty($_POST["desc"]) ? $_POST["desc"] : '';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : '';
		$sort = !empty($_POST["sort"]) ? $_POST["sort"] : '';
		$datetime = time();
		if (empty($name)) {
			echo json_encode(array('error' => false, 'msg' => "请填写分类名称！"));
			return;
		}
		
		if(!$name==$namev){
    		$proclass_info = $this->proclass->getProClassName($name);
    		if ($proclass_info) {
    			echo json_encode(array('error' => true, 'msg' => "该分类名称已经存在,不能重复添加。"));
    			return;
    		}
	    }
		$result = $this->proclass->proclass_save_edit($uid,$name,$gimg,$desc,$datetime,$sort);

		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**-----------------------------------分类删除管理-----------------------------------------------------*/
	/**
	 *分类删除显示
	 */
	public function proclass_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->proclass->proclass_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

}
