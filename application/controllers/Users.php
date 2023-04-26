<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_name'])) {
            header("Location:" . RUN . '/login/logout');
        }
        $this->load->model('Users_model', 'users');
        header("Content-type:text/html;charset=utf-8");
    }
    /**
     * 管理员列表页
     */
    public function users_list()
    {
        $user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $allpage = $this->users->getUserAllPage($user_name);
        $page = $allpage > $page ? $page : $allpage;
        $data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
        $data["page"] = $page;
        $data["allpage"] = $allpage;
        $data["list"] = $this->users->getUserAll($page, $user_name);
        $data["user_name1"] = $user_name;
        $this->display("users/users_list", $data);
    }
    /**
     * 管理员添加页
     */
    public function users_add()
    {
        $data = array();
        $ridlist = $this->users->getRole();
        $data['ridlist'] = $ridlist;
        $this->display("users/users_add", $data);
    }
	/**
     * 管理员添加提交
     */
    public function users_save()
    {
        if (empty($_SESSION['user_name'])) {
            echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
            return;
        }

        $user_name = isset($_POST["user_name"]) ? $_POST["user_name"] : '';
        $user_pass = isset($_POST["user_pass"]) ? $_POST["user_pass"] : '';
        $rid = isset($_POST["rid"]) ? $_POST["rid"] : '';
        $user_state = isset($_POST["user_state"]) ? $_POST["user_state"] : 1;
        $add_time = time();
        $user_pass = md5($user_pass);

        $user_info = $this->users->getmemberById($user_name);
        if (!empty($user_info)) {
            echo json_encode(array('error' => true, 'msg' => "该账号已经存在。"));
            return;
        }
        $result = $this->users->member_save($user_name, $user_pass, $rid, $user_state, $add_time);
        if ($result) {
            echo json_encode(array('success' => true, 'msg' => "操作成功。"));
        } else {
            echo json_encode(array('error' => false, 'msg' => "操作失败"));
        }
    }
    /**
     * 管理员删除
     */
    public function users_delete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if ($this->users->users_delete($id)) {
            echo json_encode(array('success' => true, 'msg' => "删除成功"));
        } else {
            echo json_encode(array('success' => false, 'msg' => "删除失败"));
        }
    }
    /**
     * 管理员修改
     */
    public function users_edit()
    {
        $uid = isset($_GET['id']) ? $_GET['id'] : 0;
        $data = array();
        $ridlist = $this->users->getRole();
        $data['ridlist'] = $ridlist;

        $member_info = $this->users->getUserByIdnew($uid);
        $data['user_namenew'] = $member_info['username'];
        $data['ridnew'] = $member_info['rid'];
        $data['user_statenew'] = $member_info['userstate'];
        $data['uidnew'] = $uid;

        $this->display("users/users_edit", $data);
    }
    /**
     * 管理员修改提交
     */
    public function users_save_edit()
    {
        if (empty($_SESSION['user_name'])) {
            echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
            return;
        }
        $uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
        $user_name = isset($_POST["user_name"]) ? $_POST["user_name"] : '';
        $user_info = $this->users->getmemberById2($user_name,$uid);
        $user_pass = !empty($_POST["user_pass"]) ? md5($_POST["user_pass"]) : $user_info['userpwd'];
        $rid = isset($_POST["rid"]) ? $_POST["rid"] : '';
        $user_state = isset($_POST["user_state"]) ? $_POST["user_state"] : '1';
        $result = $this->users->users_save_edit($uid, $user_name, $user_pass, $rid, $user_state);
        if ($result) {
            echo json_encode(array('success' => true, 'msg' => "操作成功。"));
        } else {
            echo json_encode(array('error' => false, 'msg' => "操作失败"));
        }
    }


	/**
	 * 角色列表页
	 */
	public function role_list()
	{
		$username = isset($_GET["username"]) ? $_GET["username"] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->users->getroleAllPage();
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->users->getroleAllNew($page);
		$data["username1"] = $username;
		$this->display("users/role_list", $data);
	}
	/**
	 * 角色添加页
	 */
	public function role_add()
	{
		$this->display("users/role_add");
	}
	/**
	 * 角色添加提交
	 */
	public function role_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$rname = isset($_POST["rname"]) ? $_POST["rname"] : '';
		$rdetails = isset($_POST["rdetails"]) ? $_POST["rdetails"] : '';
		$menu = isset($_POST["menu"]) ? $_POST["menu"] : '';

		$add_time = time();
		if (empty($rname) || empty($rdetails)) {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
			return;
		}
		$role_info = $this->role->getroleByname($rname);
		if (!empty($role_info)) {
			echo json_encode(array('error' => true, 'msg' => "该角色已经存在。"));
			return;
		}
		$rid = $this->users->role_save($rname, $rdetails, $add_time);
		if ($rid) {
			foreach ($menu as $k=>$v){
				$this->users->rtom_save($rid,$v);
			}
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
	/**
	 * 角色删除
	 */
	public function role_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->users->role_delete($id)) {
			$this->users->role_delete_rtom($id);
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}
	/**
	 * 角色修改页
	 */
	public function role_edit()
	{
		$rid = isset($_GET['rid']) ? $_GET['rid'] : 0;
		$role_info = $this->users->getroleById($rid);
		if (empty($role_info)) {
			echo json_encode(array('error' => true, 'msg' => "数据错误"));
			return;
		}
		$data = array();
		$data['rname'] = $role_info['rname'];
		$data['rdetails'] = $role_info['rdetails'];
		$data['rid'] = $rid;

		$this->display("users/role_edit", $data);
	}
	/**
	 * 角色修改提交
	 */
	public function role_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$rid = isset($_POST["rid"]) ? $_POST["rid"] : '';
		$rname = isset($_POST["rname"]) ? $_POST["rname"] : '';
		$rdetails = isset($_POST["rdetails"]) ? $_POST["rdetails"] : '';
		$menu = isset($_POST["menu"]) ? $_POST["menu"] : '';
		if (empty($rname) || empty($rdetails)) {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
			return;
		}
		$this->users->role_delete_rtom($rid);
		if ($rid) {
			foreach ($menu as $k=>$v){
				$this->users->rtom_save($rid,$v);
			}
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
}
