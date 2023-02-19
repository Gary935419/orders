<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Abnormal extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('System_model', 'system');
		$this->load->model('Common_model', 'common');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------分类显示管理-----------------------------------------------------*/
	/**
	 * 分类列表页
	 */
	public function abnormal_list()
	{
		$desc = isset($_GET['desc']) ? $_GET['desc'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->system->getAbnormalAllPage($desc);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->system->getAbnormalAll($page, $desc);
		foreach ($list as $key => $value){
			$ablist=$this->system->getAbnormalNum($value['enid']);
			$list[$key]['num']=$ablist['num'];
		}
		$data["descv"] = $desc;
		$data["list"]=$list;
		$this->display("abnormal/abnormal_list", $data);
	}

	/**-----------------------------------异常信息添加管理-----------------------------------------------------*/
	/**
	 * 异常信息添加页
	 */
	public function abnormal_add()
	{
		$this->display("abnormal/abnormal_add");
	}

	/**
	 * 异常信息添加提交
	 */
	public function abnormal_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$desc = !empty($_POST["desc"]) ? $_POST["desc"] : ' ';
		$datetime = time();
		$result = $this->system->abnormalSave($desc,$datetime);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**-----------------------------------异常信息修改管理-----------------------------------------------------*/
	/**
	 *异常信息修改显示
	 */
	public function abnormal_edit($id)
	{
		$data = array();
		$ridlist = $this->common->getRole();
		$data['ridlist'] = $ridlist;
		$data['list']  = $this->system->abnormalSelect($id);
		$this->display("abnormal/abnormal_edit", $data);
	}

	/**
	 * 异常信息修改提交
	 */
	public function abnormal_update()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$uid = !empty($_POST["uid"]) ? $_POST["uid"] : ' ';
		$desc = !empty($_POST["desc"]) ? $_POST["desc"] : ' ';
		$datetime = time();

		$result = $this->system->abnormalUpdate($uid,$desc,$datetime);

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
	public function abnormal_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->system->abnormalDel($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

}
