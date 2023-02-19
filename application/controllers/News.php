<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class News extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('News_model', 'news');
		$this->load->model('Common_model', 'common');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------信息显示管理-----------------------------------------------------*/
	/**
	 * 信息列表页
	 */
	public function news_list($type)
	{
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->news->getNewsAllPage($gongsi,$type);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->news->getNewsAll($page, $gongsi,$type);
		$data["gongsiv"] = $gongsi;
		$data['type']=$type;
		$this->display("news/news_list", $data);
	}


	/**-----------------------------------分类添加管理-----------------------------------------------------*/
	/**
	 * 分类列表页
	 */
	/**
	 * 分类添加页
	 */
	public function news_add($type)
	{
		$data['type']=$type;
		$this->display("news/news_add", $data);
	}

	/**
	 * 分类添加提交
	 */
	public function news_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$title = !empty($_POST["title"]) ? $_POST["title"] : ' ';
		$desc = !empty($_POST["gcontent"]) ? $_POST["gcontent"] : ' ';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : ' ';
		$type = !empty($_POST["type"]) ? $_POST["type"] : ' ';
		$url="";
		$datetime = time();
		if (empty($title)) {
			echo json_encode(array('error' => false, 'msg' => "请填写新闻标题！"));
			return;
		}

		$result = $this->news->news_save($title,$desc,$gimg,$datetime,$type,$url);
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
	public function news_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->common->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->news->getNewsEdit($uid);
		$data['id'] = $uid;
		$data['title'] = $member_info['news_title'];
		$data['desc'] = $member_info['news_contents'];
		$data['gimg'] = $member_info['news_img'];
		$this->display("news/news_edit", $data);
	}


	/**
	 * 供应商添加提交
	 */
	public function news_update()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$uid = !empty($_POST["uid"]) ? $_POST["uid"] : ' ';
		$title = !empty($_POST["title"]) ? $_POST["title"] : ' ';
		$desc = !empty($_POST["gcontent"]) ? $_POST["gcontent"] : ' ';
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : ' ';
		$url="";
		$datetime = time();
		if (empty($title)) {
			echo json_encode(array('error' => false, 'msg' => "请填写新闻标题！"));
			return;
		}
		$result = $this->news->news_save_edit($uid,$title,$desc,$gimg,$datetime,$url);
		//echo json_encode(array('error' => false, 'msg' => $result));
		//return;
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**-----------------------------------新闻删除管理-----------------------------------------------------*/
	/**
	 *分类删除显示
	 */
	public function news_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->news->news_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	/**-----------------------------------广告图显示管理-----------------------------------------------------*/
	/**
	 * 广告图列表页
	 */
	public function picture_list($type)
	{
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->news->getNewsAllPage($gongsi,$type);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->news->getNewsAll($page, $gongsi,$type);
		$data["gongsiv"] = $gongsi;
		$data['type']=$type;
		$this->display("news/picture_list", $data);
	}

	/**-----------------------------------广告图添加管理-----------------------------------------------------*/
	/**
	 * 广告图页
	 */
	public function picture_add($type)
	{
		$data['type']=$type;
		$this->display("news/picture_add", $data);
	}

	/**
	 * 广告图添加提交
	 */
	public function picture_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$title = !empty($_POST["title"]) ? $_POST["title"] : '';
		$desc ="";
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : '';
		$type = !empty($_POST["type"]) ? $_POST["type"] : '';
		$url = !empty($_POST["url"]) ? $_POST["url"] : '';

		$datetime = time();
		if (empty($title)) {
			echo json_encode(array('error' => false, 'msg' => "请填写新闻标题！"));
			return;
		}

		$result = $this->news->news_save($title,$desc,$gimg,$datetime,$type,$url);
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
	public function picture_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->common->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->news->getNewsEdit($uid);
		$data['id'] = $uid;
		$data['title'] = $member_info['news_title'];
		$data['url'] = $member_info['news_url'];
		$data['gimg'] = $member_info['news_img'];
		$this->display("news/picture_edit", $data);
	}


	/**
	 * 供应商添加提交
	 */
	public function picture_update()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$uid = !empty($_POST["uid"]) ? $_POST["uid"] : '';
		$title = !empty($_POST["title"]) ? $_POST["title"] : '';
		$desc = "";
		$gimg = !empty($_POST["gimg"]) ? $_POST["gimg"] : '';
		$url = !empty($_POST["url"]) ? $_POST["url"] : '';
		$datetime = time();
		if (empty($title)) {
			echo json_encode(array('error' => false, 'msg' => "请填写新闻标题！"));
			return;
		}
		$result = $this->news->news_save_edit($uid,$title,$desc,$gimg,$datetime,$url);
		//echo json_encode(array('error' => false, 'msg' => $result));
		//return;
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**-----------------------------------新闻删除管理-----------------------------------------------------*/
	/**
	 *分类删除显示
	 */
	public function picture_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->news->news_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}



}
