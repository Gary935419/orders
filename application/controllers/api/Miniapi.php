<?php
/**
 * **********************************************************************
 * サブシステム名  ： MINI
 * 機能名         ：API
 * 作成者        ： Gary
 * **********************************************************************
 */
require_once 'vendor/autoload.php';
use GuzzleHttp\Exception\RequestException;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;
use WechatPay\GuzzleMiddleware\Util\PemUtil;
class Miniapi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// 加载数据库类
		$this->load->model('Mini_model', 'mini');
	}
	//设定信息
    public function get_set_info(){
        $data['setarr'] = $this->mini->getsettinginfo();
        $data['setarr']['fabuliang'] = $this->mini->getfabuliang();
        $data['setarr']['yonghuliang'] = $this->mini->getyonghuliang();
        $data['errorarr'] = $this->mini->geterrorarr();
        $this->back_json(200, '操作成功',$data);
    }
    //产品分类
    public function canpinfenlei_list()
    {
//        $page = isset($_POST["page"]) ? $_POST["page"] : 1;
//        $list = $this->mini->getproduct_classificationAll($page);
        $list = $this->mini->getProclasslist(0);
        foreach ($list as $k=>$v){
            $Proclasslist = $this->mini->getProclasslist($v['pid']);
            foreach ($Proclasslist as $kk=>$vv){
                $Proclasslist[$kk]['parentId'] = $vv['product_sort'];
            }
            $list[$k]['list'] = $Proclasslist;
        }
        $data["list"] = $list;
        $this->back_json(200, '操作成功', $data);
    }
    //行业分类
    public function hangyefenlei_list()
    {
        $page = isset($_POST["page"]) ? $_POST["page"] : 1;
        $list = $this->mini->getindustry_classificationAll($page);
        $data["list"] = $list;
        $this->back_json(200, '操作成功', $data);
    }
    //行业新闻
    public function hangyexinwen_list()
    {
        $page = isset($_POST["page"]) ? $_POST["page"] : 1;
        $list = $this->mini->getindustry_newsAll($page);
        foreach ($list as $k=>$v){
            $list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
        }
        $data["list"] = $list;
        $this->back_json(200, '操作成功', $data);
    }
    //行业新闻详情
    public function hangyexinwen_xiangqing(){
        if (!isset($_POST['inid']) || empty($_POST['inid'])) {
            $this->back_json(205, '请您填写inid！');
        }
        $inid = $_POST['inid'];
        $goodsdetails = $this->mini->hangyexinwen_xiangqing($inid);
        $goodsdetails['addtime']=date('Y-m-d',$goodsdetails['addtime']);
        $data['hangyexinwen_xiangqing'] = $goodsdetails;
        $this->back_json(200, '操作成功', $data);
    }
    //发布list
    public function fabu_list(){

        $page = isset($_POST["page"]) ? $_POST["page"] : 1;
        $keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : '';
        $pagecount = isset($_POST["pagecount"]) ? $_POST["pagecount"] : '';
        
        $token = isset($_POST["token"]) ? $_POST["token"] : '';
        
        $usertype=$this->mini->getMemberInfotoken($token);
        $businesstype=$usertype['business_type'];
 
        $orderlist = $this->mini->fabu_list($page,time(),$keyword,$pagecount,$businesstype);
        foreach ($orderlist as $k=>$v){
            $orderlist[$k]['add_time'] = empty($v['add_time'])?'':date('Y-m-d H:i:s',$v['add_time']);
            $orderlist[$k]['end_time']=empty($v['end_time'])?'':date('Y-m-d',$v['end_time']);
            $orderlist[$k]['purchasing_time']=empty($v['purchasing_time'])?'':date('Y-m-d',$v['purchasing_time']);
            if ($v['product_sort']==0){
                $orderlist[$k]['product_sort_str'] = "已发布";
            }elseif ($v['product_sort']==1){
                $orderlist[$k]['product_sort_str'] = "已投标";
            }elseif ($v['product_sort']==2){
                $orderlist[$k]['product_sort_str'] = "已签约";
            }elseif ($v['product_sort']==3) {
                $orderlist[$k]['product_sort_str'] = "已完成";
            }elseif ($v['product_sort']==4){
                $orderlist[$k]['product_sort_str'] = "订单异常";
            }elseif ($v['product_sort']==5){
                $orderlist[$k]['product_sort_str'] = "已取消";
            }
        }
        $data['list'] = $orderlist;
        $this->back_json(200, '操作成功', $data);
    }
    //发布详情
    public function fabu_xiangqing(){
        //验证loginCode是否传递
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $identity = $_POST['identity'];
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $goodsdetails = $this->mini->fabu_xiangqing($prid);
        if (empty($goodsdetails)){
            $this->back_json(205, 'prid数据错误！');
        }
        $goodsdetails['add_time']=date('Y-m-d',$goodsdetails['add_time']);
        $goodsdetails['end_time']=date('Y-m-d',$goodsdetails['end_time']);
        $goodsdetails['purchasing_time']=date('Y-m-d',$goodsdetails['purchasing_time']);
        if ($goodsdetails['product_sort']==0){
            $goodsdetails['product_sort_str'] = "已发布";
        }elseif ($goodsdetails['product_sort']==1){
            $goodsdetails['product_sort_str'] = "已投标";
        }elseif ($goodsdetails['product_sort']==2){
            $goodsdetails['product_sort_str'] = "已签约";
        }elseif ($goodsdetails['product_sort']==3) {
            $goodsdetails['product_sort_str'] = "已完成";
        }elseif ($goodsdetails['product_sort']==4){
            $goodsdetails['product_sort_str'] = "订单异常";
        }elseif ($goodsdetails['product_sort']==5){
            $goodsdetails['product_sort_str'] = "已取消";
        }
        
        //获取投标人信息
        if($identity==0){
            $userid=$goodsdetails['product_signmemberid'];
        }else{
            $userid=$member['mid'];
        }
        
        $data['toubiao'] = $this->mini->selectapplicationorders($prid,$userid); 
                
        
        //获取发货信息
        $fahuolist = $this->mini->delivery_list($prid); 
        if($fahuolist){
            foreach ($fahuolist as $k=>$v){
                $fahuolist[$k]['delivery_time']=date('Y-m-d',$v['delivery_time']);
            }
            $data['fahuo'] =$fahuolist;
        }else{
            $data['fahuo'] ="";    
        }
        
        //获取订单评价信息
        $data['pingjia'] = $this->mini->getcommentInfo($prid);
        
        $goodsdetails['truename'] = $member['truename'];
        $data['fabu_xiangqing'] = $goodsdetails;
        $this->back_json(200, '操作成功', $data);
    }
    //用户信息
    public function memberinfo(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        $data['setarr'] = $this->mini->getsettinginfo();
        $data['member'] = $member;
        $this->back_json(200, '操作成功', $data);
    }
    //发布信息
    public function member_product_add()
    {
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }

        $mid = $member['mid'];

        if (!isset($_POST['product_class_name']) || empty($_POST['product_class_name'])) {
            $this->back_json(205, '请您填写产品分类！');
        }
        if (!isset($_POST['pid1']) || empty($_POST['pid1'])) {
            $this->back_json(205, '请您填写产品一级分类！');
        }
        if (!isset($_POST['pid2']) || empty($_POST['pid2'])) {
            $this->back_json(205, '请您填写产品二级分类！');
        }
        if (!isset($_POST['product_name']) || empty($_POST['product_name'])) {
            $this->back_json(205, '请您填写产品名称！');
        }
        if (!isset($_POST['quantity_purchased']) || empty($_POST['quantity_purchased'])) {
            $this->back_json(205, '请您填写采购数量！');
        }
        if (!isset($_POST['purchasing_time']) || empty($_POST['purchasing_time'])) {
            $this->back_json(205, '请您填写交付时间！');
        }
        if (!isset($_POST['end_time']) || empty($_POST['end_time'])) {
            $this->back_json(205, '请您填写截止时间！');
        }
        if (!isset($_POST['product_description']) || empty($_POST['product_description'])) {
            $this->back_json(205, '请您填写产品描述！');
        }
        if (!isset($_POST['product_specification1']) || empty($_POST['product_specification1'])) {
            $this->back_json(205, '请您填写产品规格1！');
        }
        if (!isset($_POST['product_specification2']) || empty($_POST['product_specification2'])) {
            $this->back_json(205, '请您填写产品规格2！');
        }
        $is_contact_person = $_POST["is_contact_person"];
        $company_name = isset($_POST["company_name"]) ? $_POST["company_name"] : '';
        $contact_name = isset($_POST["contact_name"]) ? $_POST["contact_name"] : '';
        $contact_tel = isset($_POST["contact_tel"]) ? $_POST["contact_tel"] : '';
        $product_specification1 = isset($_POST["product_specification1"]) ? $_POST["product_specification1"] : '';
        $product_specification2 = isset($_POST["product_specification2"]) ? $_POST["product_specification2"] : '';
        $product_specification3 = isset($_POST["product_specification3"]) ? $_POST["product_specification3"] : '';
        $product_description = isset($_POST["product_description"]) ? $_POST["product_description"] : '';
        $end_time = isset($_POST["end_time"]) ? strtotime($_POST["end_time"]) : '';
        $purchasing_time = isset($_POST["purchasing_time"]) ? strtotime($_POST["purchasing_time"]) : '';
        $quantity_purchased = isset($_POST["quantity_purchased"]) ? $_POST["quantity_purchased"] : '';
        $product_title = isset($_POST["product_title"]) ? $_POST["product_title"] : '';
        $product_name = isset($_POST["product_name"]) ? $_POST["product_name"] : '';
        $product_class_name = isset($_POST["product_class_name"]) ? $_POST["product_class_name"] : '';
        $pid1 = isset($_POST["pid1"]) ? $_POST["pid1"] : '';
        $pid2 = isset($_POST["pid2"]) ? $_POST["pid2"] : '';
        $product_caddress = isset($_POST["product_caddress"]) ? $_POST["product_caddress"] : '';
        $product_jaddress = isset($_POST["product_jaddress"]) ? $_POST["product_jaddress"] : '';
        $product_zmoney = isset($_POST["product_zmoney"]) ? $_POST["product_zmoney"] : '';
        $product_desc = isset($_POST["product_desc"]) ? $_POST["product_desc"] : '';
        $product_signtime = isset($_POST["product_signtime"]) ? $_POST["product_signtime"] : '';
        $add_time = time();
        $audit_status = 0;
        $product_sort = 0;
        $this->mini->product_release_add_save($pid1,$pid2,$product_sort,$product_signtime,$product_desc,$product_zmoney,$product_jaddress,$product_caddress,$mid,$add_time,$audit_status,$company_name,$contact_name,$contact_tel,$is_contact_person,$product_specification1,$product_specification2,$product_specification3,$product_description,$end_time,$purchasing_time,$quantity_purchased,$product_title,$product_name,$product_class_name);
        $data = array();
        $this->back_json(200, '操作成功', $data);
    }
    //修改发布信息
    public function member_product_edit()
    {
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }

        $mid = $member['mid'];

        if (!isset($_POST['product_class_name']) || empty($_POST['product_class_name'])) {
            $this->back_json(205, '请您填写产品分类！');
        }
        if (!isset($_POST['product_name']) || empty($_POST['product_name'])) {
            $this->back_json(205, '请您填写产品名称！');
        }
//        if (!isset($_POST['product_title']) || empty($_POST['product_title'])) {
//            $this->back_json(205, '请您填写产品标题！');
//        }
        if (!isset($_POST['quantity_purchased']) || empty($_POST['quantity_purchased'])) {
            $this->back_json(205, '请您填写采购数量！');
        }
        if (!isset($_POST['purchasing_time']) || empty($_POST['purchasing_time'])) {
            $this->back_json(205, '请您填写交付时间！');
        }
        if (!isset($_POST['end_time']) || empty($_POST['end_time'])) {
            $this->back_json(205, '请您填写截止时间！');
        }
        if (!isset($_POST['product_description']) || empty($_POST['product_description'])) {
            $this->back_json(205, '请您填写产品描述！');
        }
        if (!isset($_POST['product_specification1']) || empty($_POST['product_specification1'])) {
            $this->back_json(205, '请您填写产品规格1！');
        }
        if (!isset($_POST['product_specification2']) || empty($_POST['product_specification2'])) {
            $this->back_json(205, '请您填写产品规格2！');
        }
        if (!isset($_POST['product_specification3']) || empty($_POST['product_specification3'])) {
            $this->back_json(205, '请您填写产品规格3！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $fabu_xiangqing = $this->mini->fabu_xiangqing($prid);
        if (!empty($fabu_xiangqing['product_sort'])){
            $this->back_json(205, '当前状态不属于可修改范围内！');
        }
        $is_contact_person = $_POST["is_contact_person"];
        $company_name = isset($_POST["company_name"]) ? $_POST["company_name"] : '';
        $contact_name = isset($_POST["contact_name"]) ? $_POST["contact_name"] : '';
        $contact_tel = isset($_POST["contact_tel"]) ? $_POST["contact_tel"] : '';
        $product_specification1 = isset($_POST["product_specification1"]) ? $_POST["product_specification1"] : '';
        $product_specification2 = isset($_POST["product_specification2"]) ? $_POST["product_specification2"] : '';
        $product_specification3 = isset($_POST["product_specification3"]) ? $_POST["product_specification3"] : '';
        $product_description = isset($_POST["product_description"]) ? $_POST["product_description"] : '';
        $end_time = isset($_POST["end_time"]) ? strtotime($_POST["end_time"]) : '';
        $purchasing_time = isset($_POST["purchasing_time"]) ? strtotime($_POST["purchasing_time"]) : '';
        $quantity_purchased = isset($_POST["quantity_purchased"]) ? $_POST["quantity_purchased"] : '';
        $product_title = isset($_POST["product_title"]) ? $_POST["product_title"] : '';
        $product_name = isset($_POST["product_name"]) ? $_POST["product_name"] : '';
        $product_class_name = isset($_POST["product_class_name"]) ? $_POST["product_class_name"] : '';
        $product_caddress = isset($_POST["product_caddress"]) ? $_POST["product_caddress"] : '';
        $product_jaddress = isset($_POST["product_jaddress"]) ? $_POST["product_jaddress"] : '';
        $product_zmoney = isset($_POST["product_zmoney"]) ? $_POST["product_zmoney"] : '';
        $product_desc = isset($_POST["product_desc"]) ? $_POST["product_desc"] : '';
        $product_signtime = isset($_POST["product_signtime"]) ? $_POST["product_signtime"] : '';
        $add_time = time();
        $audit_status = 0;
        $product_sort = 0;
        $this->mini->product_release_edit_save($prid,$product_sort,$product_signtime,$product_desc,$product_zmoney,$product_jaddress,$product_caddress,$mid,$add_time,$audit_status,$company_name,$contact_name,$contact_tel,$is_contact_person,$product_specification1,$product_specification2,$product_specification3,$product_description,$end_time,$purchasing_time,$quantity_purchased,$product_title,$product_name,$product_class_name);
        $data = array();
        $this->back_json(200, '操作成功', $data);
    }
    //修改个人信息
    public function memberinfo_edit(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        $mid = $member['mid'];
        $company_name = empty($_POST['company_name'])?'':$_POST['company_name'];
        $company_address = empty($_POST['company_address'])?'':$_POST['company_address'];
        $nickname = empty($_POST['nickname'])?'':$_POST['nickname'];
        $truename = empty($_POST['nickname'])?'':$_POST['nickname'];
        $email = empty($_POST['email'])?'':$_POST['email'];
        $this->mini->memberinfo_edit($mid,$truename,$email,$nickname,$company_address,$company_name);

        $this->back_json(200, '操作成功', array());
    }
    //供应商审核提交
    public function supplier_apply(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        $mid = $member['mid'];
        if($member['audit_status'] == 2){
            $this->back_json(205, '目前审核通过状态，不要重复提交审核！');
        }
        $business_license = empty($_POST['business_license'])?'':$_POST['business_license'];
        $review_data = empty($_POST['review_data'])?'':$_POST['review_data'];
        $business_typenames = empty($_POST['business_typenames'])?'':$_POST['business_typenames'];
//        $business_typenames = implode(",",$business_typenames);
        $business_type = empty($_POST['business_type'])?'':$_POST['business_type'];
//        $business_type = implode(",",$business_type);
        $audit_status = 1;
        $this->mini->supplier_apply_edit($mid,$business_license,$review_data,$audit_status,$business_typenames,$business_type);

        $this->back_json(200, '操作成功', array());
    }
    //供应商投标
    public function supplier_bid_save(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $aftid = $_POST['aftid'];
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $mid = $member['mid'];
        if(empty($member['identity'])){
            $this->back_json(205, '身份不匹配，当前不是供应商身份！');
        }
//        if ($member['audit_status'] != 2) {
//            $this->back_json(205, '抱歉，供应商审核通过之后才能投标！');
//        }
        $delivery_time = empty($_POST['delivery_time'])?'':$_POST['delivery_time'];
        $excel_url = empty($_POST['excel_url'])?'':$_POST['excel_url'];
        $pdf_url = empty($_POST['pdf_url'])?'':$_POST['pdf_url'];
        $contact_tel = empty($_POST['contact_tel'])?'':$_POST['contact_tel'];
        $description = empty($_POST['description'])?'':$_POST['description'];
        $bidding_cost = empty($_POST['bidding_cost'])?'':$_POST['bidding_cost'];
        $bidder = empty($_POST['bidder'])?'':$_POST['bidder'];
        $company_name = empty($_POST['company_name'])?'':$_POST['company_name'];;
        $order_state = 0;
        $add_time = time();
        
        $a=$this->mini->supplier_bid_save($delivery_time,$excel_url,$mid,$contact_tel,$description,$bidding_cost,$bidder,$company_name,$prid,$order_state,$add_time,$aftid,$pdf_url);
        if(!$aftid){
            $this->mini->supplier_product_release_edit($prid);
        }
        $this->back_json(200, '操作成功', array());
    }
    //用户和供应商订单list
    public function orders_list(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        $mid = $member['mid'];
        $page = isset($_POST["page"]) ? $_POST["page"] : 1;
        //验证avatarurl是否传递  0用户  1供应商
        $identity = empty($member['identity']) ? 0 : 1;

        if (empty($identity)){
            $product_sort = empty($_POST['product_sort']) ? 0 : $_POST['product_sort'];
            //用户
            $orderlist = $this->mini->order_yonghu_list($page,$mid,$product_sort);
        }else{
            $product_sort = empty($_POST['product_sort']) ? 1 : $_POST['product_sort'];
            //供应商
            if ($product_sort == 100){
                $orderlist = $this->mini->order_gongyingshang_list_new1($page,$mid,1);
            }else{
                $orderlist = $this->mini->order_gongyingshang_list_new($page,$mid,$product_sort);
            }
        }
        foreach ($orderlist as $k=>$v){
            $orderlist[$k]['add_time'] = empty($v['add_time'])?'':date('Y-m-d H:i:s',$v['add_time']);
            $orderlist[$k]['end_time']=empty($v['end_time'])?'':date('Y-m-d',$v['end_time']);
            $orderlist[$k]['purchasing_time']=empty($v['purchasing_time'])?'':date('Y-m-d',$v['purchasing_time']);
            $orderlist[$k]['product_signtime']=empty($v['product_signtime'])?'':date('Y-m-d',$v['product_signtime']);
            if ($v['audit_status']==0){
                $orderlist[$k]['audit_status_str'] = "审核中";
            }elseif ($v['audit_status']==1){
                $orderlist[$k]['audit_status_str'] = "审核通过";
            }elseif ($v['audit_status']==2){
                $orderlist[$k]['audit_status_str'] = "审核驳回";
            }
            if ($v['product_sort']==0){
                $orderlist[$k]['product_sort_str'] = "已发布";
            }elseif ($v['product_sort']==1){
                if($product_sort == 100){
                    $orderlist[$k]['product_sort_str'] = "已选定";
                }else{
                    $orderlist[$k]['product_sort_str'] = "已投标";
                }
            }elseif ($v['product_sort']==2){
                $orderlist[$k]['product_sort_str'] = "已签约";
            }elseif ($v['product_sort']==3) {
                $orderlist[$k]['product_sort_str'] = "已完成";
            }elseif ($v['product_sort']==4){
                $orderlist[$k]['product_sort_str'] = "订单异常";
            }elseif ($v['product_sort']==5){
                $orderlist[$k]['product_sort_str'] = "已取消";
            }
            if ($v['order_state_new']==0){
                $orderlist[$k]['order_state_new_str'] = "未选定供应商";
            }elseif ($v['order_state_new']==1){
                $orderlist[$k]['order_state_new_str'] = "已选定供应商";
            }
            $sum = $this->mini->getbaojiashulinag($v['prid']);
            $orderlist[$k]['quotation_sum'] = $sum;
            $pingjialistinfo = $this->mini->getpingjialistinfo($v['prid']);
            $orderlist[$k]['shangjiapingfen'] = empty($pingjialistinfo['gongyingshang_num'])?'':$pingjialistinfo['gongyingshang_num'];
            $orderlist[$k]['yonghupingfen'] = empty($pingjialistinfo['kehu_num'])?'':$pingjialistinfo['kehu_num'];
            
            //获取中标方信息
            if($v['product_signmemberid']){
                $gysnamelist = $this->mini->member_info($v['product_signmemberid']);
                $orderlist[$k]['gyscompany'] =$gysnamelist['company_name'];
                $orderlist[$k]['gysname'] =  $gysnamelist['truename'];
                $orderlist[$k]['gystel'] =  $gysnamelist['mobile'];
            }
            
            //获取发货次数
            if($v['product_sort']==3){
                $gysnum = $this->mini->delivery_count1($v['prid']);
                $orderlist[$k]['gysnum'] =$gysnum;
            }
            //获取发货总数
            if($v['product_sort']==3){
                $gyssum = $this->mini->delivery_count3($v['prid']);
                $orderlist[$k]['gyssum'] =$gyssum;
            }

        }
        $data['list'] = $orderlist;
        $this->back_json(200, '操作成功', $data);
    }
    //客户选定供应商
    public function member_select_supplier(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        if (!isset($_POST['supplier_id']) || empty($_POST['supplier_id'])) {
            $this->back_json(205, '请您填写supplier_id！');
        }
        $supplier_id = $_POST['supplier_id'];
        $this->mini->member_select_supplier($prid,$supplier_id);
        $this->mini->member_select_suppliernew($prid,1);
        $this->back_json(200, '操作成功', array());
    }
    //查看当前发布有那些供应商投标
    public function supplier_orders_list(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $page = isset($_POST["page"]) ? $_POST["page"] : 1;

        //验证avatarurl是否传递  0用户  1供应商
        $identity = empty($member['identity']) ? 0 : 1;

        if (empty($identity)){
            //用户
            $orderlist = $this->mini->supplier_orders_list($page,$prid);
        }else{
            //供应商
            $mid = $member['mid'];
            $orderlist = $this->mini->supplier_orders_listg($page,$prid,$mid);
        }

        foreach ($orderlist as $k=>$v){
            $orderlist[$k]['add_time'] = empty($v['add_time'])?'':date('Y-m-d H:i:s',$v['add_time']);
            if ($v['order_state']==0){
                $orderlist[$k]['order_state_str'] = "洽谈中";
            }elseif ($v['order_state']==1){
                $orderlist[$k]['order_state_str'] = "已选中";
            }elseif ($v['order_state']==2){
                $orderlist[$k]['order_state_str'] = "已签约";
            }elseif ($v['order_state']==3) {
                $orderlist[$k]['order_state_str'] = "已放弃";
            }
        }
        $data['list'] = $orderlist;
        $shifoubeikehuxuanzhong = $this->mini->shifoubeikehuxuanzhong($prid);
        $data['cooperation_flg'] = $shifoubeikehuxuanzhong;
        $this->back_json(200, '操作成功', $data);
    }
    //中标供应商确定
    public function supplier_select_member(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $mid = $member['mid'];
        $supplier_select_member_new = $this->mini->supplier_select_member_new($prid,$mid);
        $bidding_cost = $supplier_select_member_new['bidding_cost'];
        $delivery_time = $supplier_select_member_new['delivery_time'];
        $this->mini->supplier_select_member($prid,time(),$mid,$bidding_cost,$delivery_time);
        $this->mini->supplier_select_member1($prid,$mid);
        $this->back_json(200, '操作成功', array());
    }
    //中标供应商取消
    public function supplier_cancel_member(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $mid = $member['mid'];
        $this->mini->supplier_cancel_member($prid,$mid);
        $this->mini->member_select_suppliernew($prid,0);
        $this->back_json(200, '操作成功', array());
    }
    //用户作废订单
    public function member_cancel_order(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $this->mini->member_cancel_order($prid);
        $this->back_json(200, '操作成功', array());
    }
    //供应商和用户填写订单记录
    public function delivery_save(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        if (!isset($_POST['express_img']) || empty($_POST['express_img'])) {
            $this->back_json(205, '请您上传资料图片！');
        }
        if (!isset($_POST['delivery_time']) || empty($_POST['delivery_time'])) {
            $this->back_json(205, '请您选择处理时间！');
        }
        //验证是否传递  0用户  1供应商
        $identity = empty($member['identity']) ? 0 : 1;
        $prid = $_POST['prid'];
        $payment_price = empty($_POST['payment_price'])?0.0:$_POST['payment_price'];
        $express_img = empty($_POST['express_img'])?'':$_POST['express_img'];
        $delivery_time = empty($_POST['delivery_time'])?'':strtotime($_POST['delivery_time']);
        $delivery_number = empty($_POST['delivery_number'])?0:$_POST['delivery_number'];
        $add_time = time();

        if (empty($identity)){
            $batch_number = 0;
        }else{
            $jiaohuoshuliang = $this->mini->jiaohuoshuliang($prid);
            $batch_number = $jiaohuoshuliang + 1;
        }
        $this->mini->delivery_save($payment_price,$identity,$prid,$batch_number,$delivery_time,$express_img,$add_time,$delivery_number);
        $this->back_json(200, '操作成功', array());
    }
    //查看当前发布有那些订单记录
    public function delivery_list(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];


        $product_release_info = $this->mini->getorderInfo($prid);

        $yonghu_mid=$product_release_info['mid'];
        $memberyonghu = $this->mini->member_info($yonghu_mid);
        $yonghu_company_name =$memberyonghu['company_name'];

        $gongyingshang_mid=$product_release_info['product_signmemberid'];
        $membergongyingshang = $this->mini->member_info($gongyingshang_mid);
        $gongyingshang_company_name =$membergongyingshang['company_name'];

        $orderlist = $this->mini->delivery_list($prid);
        foreach ($orderlist as $k=>$v){
            $orderlist[$k]['delivery_time'] = empty($v['delivery_time'])?'':date('Y-m-d',$v['delivery_time']);
            $orderlist[$k]['add_time'] = empty($v['add_time'])?'':date('Y-m-d',$v['add_time']);
            if (empty($v['identity'])){
                $orderlist[$k]['batch_number_str'] = "";
                $orderlist[$k]['company_name'] = $yonghu_company_name;
            }else{
                $orderlist[$k]['batch_number_str'] = "第".$v['batch_number']."批交货";
                $orderlist[$k]['company_name'] = $gongyingshang_company_name;
            }
        }
        $data['list'] = $orderlist;
        $pingjia_info = $this->mini->pingjia_info($prid);
        if (empty($pingjia_info)){
            $data['yonghupingjia_flg'] = 0;
            $data['gongyingshangpingjia_flg'] = 0;
        }else{
            if (empty($pingjia_info['kehu_id']) && !empty($pingjia_info['gongyingshang_id'])){
                $data['yonghupingjia_flg'] = 0;
                $data['gongyingshangpingjia_flg'] = 1;
            }elseif (!empty($pingjia_info['kehu_id']) && empty($pingjia_info['gongyingshang_id'])){
                $data['yonghupingjia_flg'] = 1;
                $data['gongyingshangpingjia_flg'] = 0;
            }elseif (!empty($pingjia_info['kehu_id']) && !empty($pingjia_info['gongyingshang_id'])){
                $data['yonghupingjia_flg'] = 1;
                $data['gongyingshangpingjia_flg'] = 1;
            }
        }
        $this->back_json(200, '操作成功', $data);
    }
    //用户已完成订单
    public function member_complete_order(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $count_comlate1= $this->mini->delivery_count1($prid);
        $count_comlate2= $this->mini->delivery_count2($prid);
        $count_comlate = $count_comlate1 + $count_comlate2;
        if ($count_comlate<1){
            $this->back_json(205, '目前订单履历不全，不能完成！');
        }
        $overtime = time();
        $this->mini->member_complete_order($prid,$overtime);
        $this->back_json(200, '操作成功', array());
    }
    //供应商和用户填写订单异常
    public function product_abnormal_save(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        //验证avatarurl是否传递  0用户  1供应商
        $identity = empty($member['identity']) ? 0 : 1;
        $prid = $_POST['prid'];
        $product_abnormalInfo = $this->mini->getproduct_abnormalInfo($prid);
        if (empty($identity)){
            //用户
            $orderInfo = $this->mini->getorderInfo($prid);
            $zhiqianzhuangtai = $orderInfo['product_sort'];
            $errorid = empty($_POST['errorid'])?'':$_POST['errorid'];
            $abkehu_desc = empty($_POST['abkehu_desc'])?'':$_POST['abkehu_desc'];
            $abkehu_addtime = time();
            if (empty($product_abnormalInfo)){
                $this->mini->product_abnormal_save($prid,$errorid,$abkehu_desc,$abkehu_addtime,$zhiqianzhuangtai);
            }else{
                $this->mini->product_abnormal_edit1($prid,$errorid,$abkehu_desc,$abkehu_addtime,$zhiqianzhuangtai);
            }
            $this->mini->product_release_edit($prid,4);
        }else{
            //供应商
            $abgonyingshang_desc = empty($_POST['abgonyingshang_desc'])?'':$_POST['abgonyingshang_desc'];
            $abgongyingshang_addtime =  time();
            $this->mini->product_abnormal_edit($prid,$abgonyingshang_desc,$abgongyingshang_addtime);

            $product_sort = $product_abnormalInfo['zhiqianzhuangtai'];
            $this->mini->product_release_edit($prid,$product_sort);
        }

        $this->back_json(200, '操作成功', array());
    }
    //供应商和用户评价
    public function product_abnormal_comment(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);

        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        if (!isset($_POST['dafen']) || empty($_POST['dafen'])) {
            $this->back_json(205, '请您填写打分！');
        }

        //验证avatarurl是否传递  0用户  1供应商
        $identity = empty($member['identity']) ? 0 : 1;
        $prid = $_POST['prid'];
        $product_abnormalInfo = $this->mini->getcommentInfo($prid);

        if (empty($identity)){
            //用户
            $kehu_id = $member['mid'];
            $kehu_num = empty($_POST['dafen'])?'':$_POST['dafen'];
            $kehu_desc = empty($_POST['dafenshuoming'])?'':$_POST['dafenshuoming'];
            $kehu_addtime =  time();
            if (empty($product_abnormalInfo)){
                $this->mini->product_abnormal_save_comment1($prid,$kehu_num,$kehu_id,$kehu_desc,$kehu_addtime);
            }else{
                $this->mini->product_abnormal_edit_comment1($prid,$kehu_num,$kehu_id,$kehu_desc,$kehu_addtime);
            }
        }else{
            //供应商
            $gongyingshang_desc = empty($_POST['dafenshuoming'])?'':$_POST['dafenshuoming'];
            $gongyingshang_addtime = time();
            $gongyingshang_num = empty($_POST['dafen'])?'':$_POST['dafen'];
            $gongyingshang_id = $member['mid'];
            if (empty($product_abnormalInfo)){
                $this->mini->product_abnormal_save_comment($prid,$gongyingshang_num,$gongyingshang_id,$gongyingshang_desc,$gongyingshang_addtime);
            }else{
                $this->mini->product_abnormal_edit_comment($prid,$gongyingshang_num,$gongyingshang_id,$gongyingshang_desc,$gongyingshang_addtime);
            }
        }

        $this->back_json(200, '操作成功', array());
    }
    //供应商修改投标报价信息
    public function supplier_modify_order_price(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['aftid']) || empty($_POST['aftid'])) {
            $this->back_json(205, '请您填写aftid！');
        }
        $aftid = $_POST['aftid'];
        if (!isset($_POST['bidding_cost']) || empty($_POST['bidding_cost'])) {
            $this->back_json(205, '请您填写投标费用！');
        }
        $bidding_cost = $_POST['bidding_cost'];
        $this->mini->supplier_modify_order_price($aftid,$bidding_cost);
        $this->back_json(200, '操作成功', array());
    }
    //异常信息分类
    public function geterrorlist()
    {
        $prid = $_POST['prid'];
        $data['errorlist'] = $this->mini->geterrorlist();
        $data['prolist'] = $this->mini->getorderInfo($prid);
        
        $this->back_json(200, '操作成功', $data);
    }
    //异常信息保存
    public function error_update()
    {
        $prid = $_POST['prid'];
        $errorid = $_POST['errorid'];
        $errordesc = $_POST['errordesc'];
        $identity = $_POST['identity'];
        $addtime =  time();
        $token=$_POST['token'];
        
        $member = $this->mini->getMemberInfotoken($token);
        $mid = $member['mid'];
        
        $this->mini->error_update($prid,$errorid,$errordesc,$addtime,$identity,$mid);
        $this->back_json(200, '操作成功', array());
    }
    //对账list
    public function product_release_list(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        
        $starttime=isset($_POST["starttime"]) ? $_POST["starttime"] : '';
        $endtime=isset($_POST['endtime']) ? $_POST['endtime'] :'';
        $pclassname=isset($_POST['classname']) ? $_POST['classname'] :'';
        $proname=isset($_POST['proname']) ? $_POST['proname'] :'';

        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        $mid = $member['mid'];
        $identity = $member['identity'];
        $page = isset($_POST["page"]) ? $_POST["page"] : 1;

        if (empty($identity)){
            $product_release_list = $this->mini->product_release_list1($page,$mid,$starttime,$endtime,$pclassname,$proname);
        }else{
            $product_release_list = $this->mini->product_release_list2($page,$mid,$starttime,$endtime,$pclassname,$proname);
        }
        foreach ($product_release_list as $k=>$v){
            $prid = $v['prid'];
            $is_receipt_invoice = $v['is_receipt_invoice'];
            if (empty($is_receipt_invoice)){
                $product_release_list[$k]['is_receipt_invoice'] = false;
            }else{
                $product_release_list[$k]['is_receipt_invoice'] = true;
            }
            $product_release_list[$k]['payment_price'] = $this->mini->delivery_count123($prid);
            $product_release_list[$k]['delivery_number'] = $this->mini->delivery_count456($prid);
            $product_signmemberid = $v['product_signmemberid'];
            $select_product_signmemberid = $this->mini->select_product_signmemberid($product_signmemberid);
            $product_release_list[$k]['company_name'] = $select_product_signmemberid['company_name'];
            $product_release_list[$k]['delivery_time'] = empty($v['delivery_time'])?'':$v['delivery_time'];
            $product_release_list[$k]['product_overtime'] = date('Y-m-d',$v['product_overtime']);
        }

        $data['list'] = $product_release_list;
        $this->back_json(200, '操作成功', $data);
    }
    //修改对账是否收到发票
    public function modify_receipt_of_invoice(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        if (!isset($_POST['prid']) || empty($_POST['prid'])) {
            $this->back_json(205, '请您填写prid！');
        }
        $prid = $_POST['prid'];
        $is_receipt_invoice = empty($_POST['is_receipt_invoice'])?0:1;

        $this->mini->modify_is_receipt_invoice($prid,$is_receipt_invoice);
        $this->back_json(200, '操作成功', array());
    }
    
    //获取用户报价信息
    public function select_baojia(){
        $prid = $_POST['prid'];
        $aftid = $_POST['aftid'];
        $data=$this->mini->select_baojia($prid,$aftid);
        $this->back_json(200, '操作成功', $data);
    }


    //获取异常信息
    public function select_abnormal(){
        $prid = $_POST['prid'];
        $data=$this->mini->select_abnormal($prid);
        $data['error_addtime']=date('Y-m-d',$data['error_addtime']);
        $this->back_json(200, '操作成功',$data);
    }  
    
        //获取评价信息
    public function select_commentlist(){
        $token = $_POST['token'];
        $identity = $_POST['identity'];
        $pagenum = $_POST['pagenum'];
        $size =$_POST['size'];;
        $commentlist=$this->mini->select_commentlist($token,$identity,$pagenum,$size);
        foreach ($commentlist as $key=>$value){
            if($value['gongyingshang_addtime']){
                $commentlist[$key]['gongyingshang_addtime']=date('Y-m-d',$value['gongyingshang_addtime']);    
            }
            if($value['kehu_addtime']){
                $commentlist[$key]['kehu_addtime']=date('Y-m-d',$value['kehu_addtime']);                    
            }
            
            $prid=$commentlist[$key]['prid'];
            $proname=$this->mini->fabu_xiangqing($prid);
            $commentlist[$key]['proname']=$proname['product_name'];
        }
        $data['list'] = $commentlist;
        $this->back_json(200, '操作成功',$data);
    }  
    
        //新闻信息
    public function select_industrynews(){
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            $this->back_json(205, '请您先去授权登录！');
        }
        $id = $_POST['id'];
        $token = $_POST['token'];
        $member = $this->mini->getMemberInfotoken($token);
        if (empty($member)){
            $this->back_json(205, '请您先去授权登录！');
        }
        $data['setarr'] = $this->mini->getindustrynews($id);
        $this->back_json(200, '操作成功', $data);
    }
    

}
