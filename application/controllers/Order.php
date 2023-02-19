<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Order extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Order_model', 'order');
		$this->load->model('Common_model', 'common');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------订单显示管理-----------------------------------------------------*/
	/**
	 * 分类列表页
	 */
	public function order_list($status,$sort)
	{
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->order->getOrderAllPage($gongsi,$status,$sort,$start,$end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->order->getOrderAll($page, $gongsi,$status,$sort,$start,$end);

		foreach ($list as $k=>$v){
			//获取项目分类
			//$proclasslist=$this->common->getProclassName($list[$k]['product_class_name']);
			//$list[$k]['proclassname']=$proclasslist['product_class_name'];

			//获取项目进度
			if($list[$k]['product_sort']==0){
				$sortstr="以发布";
			}elseif($list[$k]['product_sort']==1){
				$sortstr="以投标";
			}elseif($list[$k]['product_sort']==2){
				$sortstr="以签约";
			}elseif($list[$k]['product_sort']==3){
				$sortstr="已完成";
			}else{
				$sortstr="异常订单";
			}
			$list[$k]['sortstr']=$sortstr;

			//获取发布人
			$prouserlist=$this->common->getKehuName($list[$k]['mid']);
			$list[$k]['prouser']=$prouserlist['company_name']."-".$prouserlist['truename'];

			//是否查过投标时间
			$endtimetype=true;
			$datetime = time();
			if($datetime<$list[$k]['end_time']){
				$endtimetype=false;
			}
			$list[$k]['endtimetype']=$endtimetype;
		}

		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}

		$data["list"]=$list;
		$data["gongsiv"] = $gongsi;
		$data["status"] = $status;
		$data["sort"]=$sort;
		$this->display("order/order_list", $data);
	}

	/**
	 * 订单列表页
	 */
	public function order_add($status)
	{
		$data["userlist"] = $this->common->getKehuNamelist();
		$data["proclasslist"] = $this->common->getProclassNamelist();
		$data["status"] = $status;
		$this->display("order/order_add", $data);
	}

	/**
	 * 订单添加提交
	 */
	public function order_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$username = !empty($_POST["username"]) ? $_POST["username"]:'';
		$proclass = !empty($_POST["proclass"]) ? $_POST["proclass"]:'';
		$productname = !empty($_POST["productname"]) ? $_POST["productname"]:'';

		$productnum = !empty($_POST["productnum"]) ? $_POST["productnum"] : 0;
		$gettime = !empty($_POST["gettime"]) ? $_POST["gettime"]:'';
		$gettime = strtotime($gettime);
		$stoptime = !empty($_POST["stoptime"]) ? $_POST["stoptime"]:'';
		$stoptime = strtotime($stoptime);

		$caddress = !empty($_POST["caddress"]) ? $_POST["caddress"]:'';
		$jaddress = !empty($_POST["jaddress"]) ? $_POST["jaddress"]:'';
		$zmoney = !empty($_POST["zmoney"]) ? $_POST["zmoney"] : 0;

		$pdfurl1 = !empty($_POST["pdfurl"]) ? $_POST["pdfurl"]:'';
		$pdfurl2 = !empty($_POST["pdfurl2"]) ? $_POST["pdfurl2"]:'';
		$pdfurl3 = !empty($_POST["pdfurl3"]) ? $_POST["pdfurl3"]:'';

		$desc = !empty($_POST["desc"]) ? $_POST["desc"] : 0;
		$datetime = time();

		$result = $this->order->order_save($username,$proclass,$productname,$productnum,$gettime,$stoptime,$caddress,$jaddress,$zmoney,$pdfurl1,$pdfurl2,$pdfurl3,$datetime,$desc);

		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 *订单修改显示
	 */
	public function order_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->common->getRole();
		$data['ridlist'] = $ridlist;
		$data['orderlsit']= $this->order->getOrderEdit($uid);
		$data["userlist"] = $this->common->getKehuNamelist();
		$data["proclasslist"] = $this->common->getProclassNamelist();
		$data['id'] = $uid;
		$this->display("order/order_edit", $data);
	}


	/**
	 * 供应商添加提交
	 */
	public function order_update()
	{

		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$id=$_POST['uid'];
		$username = !empty($_POST["username"]) ? $_POST["username"] : '';
		$proclass = !empty($_POST["proclass"]) ? $_POST["proclass"] : '';
		$productname = !empty($_POST["productname"]) ? $_POST["productname"] : '';

		$productnum = !empty($_POST["productnum"]) ? $_POST["productnum"] : 0;
		$gettime = !empty($_POST["gettime"]) ? $_POST["gettime"] : '';
		$gettime = strtotime($gettime);
		$stoptime = !empty($_POST["stoptime"]) ? $_POST["stoptime"] : '';
		$stoptime = strtotime($stoptime);

		$caddress = !empty($_POST["caddress"]) ? $_POST["caddress"] : '';
		$jaddress = !empty($_POST["jaddress"]) ? $_POST["jaddress"] : '';
		$zmoney = !empty($_POST["zmoney"]) ? $_POST["zmoney"] : 0;

		$pdfurl1 = !empty($_POST["pdfurl"]) ? $_POST["pdfurl"]:'';
		$pdfurl2 = !empty($_POST["pdfurl2"]) ? $_POST["pdfurl2"]:'';
		$pdfurl3 = !empty($_POST["pdfurl3"]) ? $_POST["pdfurl3"]:'';
		$desc = !empty($_POST["desc"]) ? $_POST["desc"] : 0;
		$datetime = time();

		$result = $this->order->order_update($id,$username,$proclass,$productname,$productnum,$gettime,$stoptime,$caddress,$jaddress,$zmoney,$pdfurl1,$pdfurl2,$pdfurl3,$datetime,$desc);

		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 *订单删除显示
	 */
	public function order_del()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->order->order_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	/**
	 *订单审核显示
	 */
	public function order_check()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$check=isset($_POST['check']) ? $_POST['check'] : 0;

		if ($this->order->order_check($id,$check)) {
			echo json_encode(array('success' => true, 'msg' => "审核完成"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "审核失败"));
		}
	}

	/**-----------------------------------投标订单显示管理-----------------------------------------------------*/
	/**
	 * 分类列表页
	 */
	public function order_bid_list($sort)
	{
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->order->getOrderBidAllPage($gongsi,$sort,$start,$end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->order->getOrderBidAll($page, $gongsi,$sort,$start,$end);
		foreach ($list as $k=>$v){
			//获取项目分类
			//$proclasslist=$this->common->getProclassName($list[$k]['product_class_name']);
			//$list[$k]['proclassname']=$proclasslist['product_class_name'];

			//获取项目进度
			if($list[$k]['product_sort']==0){
				$sortstr="以发布";
			}elseif($list[$k]['product_sort']==1){
				$sortstr="以投标";
			}elseif($list[$k]['product_sort']==2){
				$sortstr="以签约";
			}elseif($list[$k]['product_sort']==3){
				$sortstr="已完成";
			}else{
				$sortstr="异常订单";
			}
			$list[$k]['sortstr']=$sortstr;

			//获取发布人
			$prouserlist=$this->common->getKehuName($list[$k]['mid']);
			$list[$k]['prouser']=$prouserlist['company_name']."-".$prouserlist['truename'];

			//获取投标公司信息

			//获取投标公司数量
			$list[$k]['toubiaonum']=$this->common->getToubiaoNum($list[$k]['prid']);

			//是否查过投标时间
			$endtimetype=true;
			$datetime = time();
			if($datetime<$list[$k]['end_time']){
				$endtimetype=false;
			}
			$list[$k]['endtimetype']=$endtimetype;
		}
		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}

		$data["sort"]=$sort;
		$data["list"]=$list;
		$data["gongsiv"] = $gongsi;
		$this->display("order/order_bid_list", $data);
	}

	//查看所有投标企业的信息
	public function order_bid_toubiao_list($id)
	{
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->order->getOrderToubiaoAllPage($gongsi,$id);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["gongsiv"] = $gongsi;
		$data["id"] = $id;
		$data["list"]= $this->order->getOrderToubiaoAll($page, $gongsi,$id);
		$this->display("order/order_bid_toubiao_list", $data);
	}

	/**-----------------------------------签约订单显示管理-----------------------------------------------------*/
	/**
	 * 签约订单列表页
	 */
	public function order_sign_list($sort)
	{
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->order->getOrderSignAllPage($gongsi,$sort,$start,$end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->order->getOrderSignAll($page, $gongsi,$sort,$start,$end);
		foreach ($list as $k=>$v){
			//获取项目分类
			//$proclasslist=$this->common->getProclassName($list[$k]['product_class_name']);
			//$list[$k]['proclassname']=$proclasslist['product_class_name'];

			//获取项目进度
			if($list[$k]['product_sort']==0){
				$sortstr="以发布";
			}elseif($list[$k]['product_sort']==1){
				$sortstr="以投标";
			}elseif($list[$k]['product_sort']==2){
				$sortstr="以签约";
			}elseif($list[$k]['product_sort']==3){
				$sortstr="已完成";
			}else{
				$sortstr="异常订单";
			}
			$list[$k]['sortstr']=$sortstr;

			//获取发布人
			$prouserlist=$this->common->getKehuName($list[$k]['mid']);
			$list[$k]['khname']=$prouserlist['company_name'];

			//获取发货数量
			$list[$k]['signsums']=$this->order->getSignSums($list[$k]['prid']);

			//获取发货次数
			$list[$k]['signnums']=$this->order->getSignNums($list[$k]['prid']);
		}
		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}
		$data["sort"]=$sort;
		$data["list"]=$list;
		$data["gongsiv"] = $gongsi;
		$this->display("order/order_sign_list", $data);
	}

	//查看中标企业的发货信息
	public function order_sign_send_list($id)
	{
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->order->getOrderSignSendAllPage($id);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["id"] = $id;
		$data["list"]= $this->order->getOrderSignSendAll($page, $id);
		$this->display("order/order_sign_send_list", $data);
	}

	/**-----------------------------------完成订单评价显示管理-----------------------------------------------------*/
	/**
	 * 完成订单列表页
	 */
	//查看完成订单的留言
	public function order_sign_comment($id)
	{
		$data["id"] = $id;
		$list= $this->order->getOrderComment($id);
		$proname = $this->common->getProductName($id);
		$data["proname"]=$proname['product_name'];

		$gongyingshangname = $this->common->getKehuName($list['gongyingshang_id']);
		$data["gongyingshangname"]=$gongyingshangname['company_name'];

		$kehuname = $this->common->getKehuName($list['kehu_id']);
		$data["kehuname"]=$kehuname['company_name'];

		$data["list"]=$list;

		$this->display("order/order_sign_comment", $data);
	}

	/**-----------------------------------订单异常显示管理-----------------------------------------------------*/
	/**
	 * 完成订单列表页
	 */
	//查看完成订单的留言
	public function order_sign_abnormal($id)
	{
		$data["id"] = $id;
		$list= $this->order->getOrderAbnormal($id);

		$errors= $this->common->geterrornews($list['errorid']);
		$data["errornews"]=$errors['error_desc'];

		$proname = $this->common->getProductName($id);
		$data["proname"]=$proname['product_name'];

		$data["list"]=$list;

		$this->display("order/order_sign_abnormal", $data);
	}



	/**-----------------------------------取消订单显示管理-----------------------------------------------------*/
	/**
	 * 分类列表页
	 */
	public function order_del_list($sort)
	{
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->order->getOrderDelAllPage($gongsi,$sort,$start,$end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->order->getOrderDelAll($page, $gongsi,$sort,$start,$end);
		foreach ($list as $k=>$v){
			//获取项目分类
			$proclasslist=$this->common->getProclassName($list[$k]['product_class_name']);
			$list[$k]['proclassname']=$proclasslist['product_class_name'];

			//获取发布人
			$prouserlist=$this->common->getKehuName($list[$k]['mid']);
			$list[$k]['prouser']=$prouserlist['company_name']."-".$prouserlist['truename'];

			//是否查过投标时间
			$endtimetype=true;
			$datetime = time();
			if($datetime<$list[$k]['end_time']){
				$endtimetype=false;
			}
			$list[$k]['endtimetype']=$endtimetype;
		}
		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}
		$data["sort"]=$sort;
		$data["list"]=$list;
		$data["gongsiv"] = $gongsi;
		$this->display("order/order_del_list", $data);
	}

	//恢复订单，恢复为未审核状态
	public function order_del_update()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->order->order_del_update($id)) {
			echo json_encode(array('success' => true, 'msg' => "恢复完成"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "恢复失败"));
		}
	}


	/**-----------------------------------取消订单显示管理-----------------------------------------------------*/
	/**
	 * 查看订单详情
	 */
	public function order_show()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->common->getRole();
		$data['ridlist'] = $ridlist;
		$data['orderlsit']= $this->order->getOrderEdit($uid);
		$data["userlist"] = $this->common->getKehuNamelist();
		$data["proclasslist"] = $this->common->getProclassNamelist();
		$data['id'] = $uid;
		$this->display("order/order_show", $data);
	}


}
