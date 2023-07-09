<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Statistics extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Statistics_model', 'statistics');
		$this->load->model('Common_model', 'common');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------客户数量统计管理-----------------------------------------------------*/
	/**
	 * 客户数量统计
	 */
	public function statistics_kehu_list()
	{
		$year = isset($_GET['year']) ? $_GET['year'] : '';
		$years=(date("Y"));
		$yearlist[0]=$years-2;
		$yearlist[1]=$years-1;
		$yearlist[2]=$years;

		if(!$year){
			$year="2023";
		}

		for($i=0;$i<12;$i++){
			$datestr=$year."-".($i+1);
			$start=strtotime($datestr." first day of");
			$end=strtotime($datestr." last day of");

			$list[$i]['month']=$i+1;
			$list[$i]['snum']=$this->statistics->getmembers($start,$end,0,0);
			$list[$i]['tnum']=$this->statistics->getmembers($start,$end,2,0);
			$list[$i]['knum']=$this->statistics->getmembers($start,$end,3,0);
			$list[$i]['hnum']=$this->statistics->getkhorders($start,$end);
		}
		//print_r($yearlist);exit();

		$data["yearv"] = $year;
		$data["list"] = $list;
		$data['yearlist']=$yearlist;
		$this->display("statistics/statistics_kehu_list", $data);
	}

	/**-----------------------------------供应商量统计管理-----------------------------------------------------*/
	/**
	 * 供应商数量统计
	 */
	public function statistics_gongyingshang_list()
	{
		$year = isset($_GET['year']) ? $_GET['year'] : '';
		$years=(date("Y"));
		$yearlist[0]=$years-2;
		$yearlist[1]=$years-1;
		$yearlist[2]=$years;

		if(!$year){
			$year="2023";
		}

		for($i=0;$i<12;$i++){
			$datestr=$year."-".($i+1);
			$start=strtotime($datestr." first day of");
			$end=strtotime($datestr." last day of");

			$list[$i]['month']=$i+1;
			$list[$i]['znum']=$this->statistics->getmembers($start,$end,0,1);
			$list[$i]['jnum']=$this->statistics->getmembers($start,$end,1,1);
			$list[$i]['tnum']=$this->statistics->getmembers($start,$end,2,1);
			$list[$i]['wnum']=$this->statistics->getmembers($start,$end,3,1);
		}

		$data["yearv"] = $year;
		$data["list"] = $list;
		$data['yearlist']=$yearlist;
		$this->display("statistics/statistics_gongyingshang_list", $data);
	}

	/**-----------------------------------项目统计管理-----------------------------------------------------*/
	/**
	 * 项目数量统计
	 */
	public function statistics_order_list()
	{
		$year = isset($_GET['year']) ? $_GET['year'] : '';
		$years=(date("Y"));
		$yearlist[0]=$years-2;
		$yearlist[1]=$years-1;
		$yearlist[2]=$years;

		if(!$year){
			$year="2023";
		}

		for($i=0;$i<12;$i++){
			$datestr=$year."-".($i+1);
			$start=strtotime($datestr." first day of");
			$end=strtotime($datestr." last day of");

			$list[$i]['month']=$i+1;
			$list[$i]['num1']=$this->statistics->getorders($start,$end,0);
			$list[$i]['num2']=$this->statistics->getorders($start,$end,1);
			$list[$i]['num3']=$this->statistics->getorders($start,$end,2);
			$list[$i]['num4']=$this->statistics->getorders($start,$end,3);
			$list[$i]['num5']=$this->statistics->getorders($start,$end,4);
			$list[$i]['num6']=$this->statistics->getorders($start,$end,5);
		}

		$data["yearv"] = $year;
		$data["list"] = $list;
		$data['yearlist']=$yearlist;
		$this->display("statistics/statistics_order_list", $data);
	}

	/**----------------------------------评价统计管理-----------------------------------------------------*/
	/**
	 * 评价统计
	 */
	public function statistics_pingjia_list()
	{
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$sort = isset($_GET['sort']) ? $_GET['sort'] : '0';

		$memberlist=$this->statistics->getmemberp($gongsi,$sort);
		foreach ($memberlist as $k=>$v){
		    $list[$k]['mid']=$v['mid'];
			$list[$k]['name']=$v['company_name'];
			$list[$k]['snum']=$this->statistics->getpingjia($sort,$v['mid'],0);
			$list[$k]['num5']=$this->statistics->getpingjia($sort,$v['mid'],5);
			$list[$k]['num4']=$this->statistics->getpingjia($sort,$v['mid'],4);
			$list[$k]['num3']=$this->statistics->getpingjia($sort,$v['mid'],3);
			$list[$k]['num2']=$this->statistics->getpingjia($sort,$v['mid'],2);
			$list[$k]['num1']=$this->statistics->getpingjia($sort,$v['mid'],1);
			if($list[$k]['snum']==0){
				$s=0;
			}else{
				$s=($list[$k]['num5']*5+$list[$k]['num4']*4+$list[$k]['num3']*3+$list[$k]['num2']*2+$list[$k]['num1']*1)/$list[$k]['snum'];
			}
			$list[$k]['nums']=$s;

		}
		$data["gongsiv"] = $gongsi;
		$data["sort"] = $sort;
		$data["list"] = $list;
		$this->display("statistics/statistics_pingjia_list", $data);
	}
	

	public function statistics_show()
	{
        $mid = isset($_GET['mid']) ? $_GET['mid'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$showlist=$this->statistics->getcommentshow($mid,$gongsi);
		
		foreach ($showlist as $k=>$v){
    		$list[$k]['proname']= $v['product_name']; 
    		if($v['kehu_id']){
        		$list[$k]['kname']=$this->statistics->getmembername($v['kehu_id']);
        		$list[$k]['knum']=$v['kehu_num'];  
        		$list[$k]['ktime']=$v['kehu_addtime'];  
        		$list[$k]['kdesc']=$v['kehu_desc']; 
    		}else{
        		$list[$k]['kname']="";
        		$list[$k]['knum']="";
        		$list[$k]['ktime']="";
        		$list[$k]['kdesc']="";
    		}
    		if($v['gongyingshang_id']){
        		$list[$k]['gname']=$this->statistics->getmembername($v['gongyingshang_id']);
        		$list[$k]['gnum']=$v['gongyingshang_num'];  
        		$list[$k]['gtime']=$v['gongyingshang_addtime'];  
        		$list[$k]['gdesc']=$v['gongyingshang_desc']; 
    		}else{
    		    $list[$k]['gname']="";
        		$list[$k]['gnum']="";
        		$list[$k]['gtime']="";
        		$list[$k]['gdesc']="";
    		}     		
        }
        if(!$showlist){
            $list="";
        }
		$data["list"] = $list;
		$data["mid"] = $mid;
		$data["sort"] = $sort;
		$data["gongsiv"] = $gongsi;
		$this->display("statistics/statistics_show", $data);
	}
	
	//项目分类查询
		public function statistics_orderlist_show()
	{
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$sort = $_GET["sort"];
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->statistics->getorderlistAllPage($gongsi,$sort);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->statistics->getorderlistAll($page, $gongsi,$sort);
		foreach ($list as $k=>$v){
		    $list[$k]['addtime']=date('Y-m-d',$v['add_time']);
		    if($sort>1){
		        $gysname= $this->statistics->getgysmember($v['product_signmemberid']);
    		    $list[$k]['gysname']=$gysname['company_name'];
    		    $list[$k]['gysusername']=$gysname['truename']."-".$gysname['mobile'];
		    }else{
		        $list[$k]['gysname']="";
		        $list[$k]['gysusername']="";		        
		    }
        }
		$data["gongsiv"] = $gongsi;
		$data["sort"] = $sort;
		$data["list"]=$list;
		$this->display("statistics/statistics_orderlist_show", $data);
	}
	
	//对账管理
		public function company_list()
	{

		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';
		$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->statistics->getGongyingshangAllPage($gongsi,$mobile);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->statistics->getGongyingshangAll($page,$gongsi,$mobile);

		$data["gongsiv"]=$gongsi;
		$data["mobilev"] = $mobile;
		$this->display("statistics/company_list", $data);
	}
	
		
	//对账管理
		public function duizhang_list($mid)
	{
		$sdate = isset($_GET['sdate']) ? strtotime($_GET['sdate']) : strtotime(date('Y-01-01', strtotime(date("Y-m-d"))));
		$edate = isset($_GET['edate']) ? strtotime($_GET['edate']) : strtotime(date("Y-m-d"));
		//$mid = isset($_GET['mid']) ? $_GET['mid'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->statistics->getDuizhangAllPage($sdate,$edate,$mid);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$list = $this->statistics->getDuizhangAll($page,$sdate,$edate,$mid);
		foreach ($list as $k =>$v){
		    $gys=$this->common->getKehuName($v['product_signmemberid']);
		    $list[$k]['gysname']=$gys['company_name'];
		    
		    //发货数量
		    $gysfhs=$this->common->getdeliverynum($v['prid'],1);
		    $list[$k]['gysfhs']=$gysfhs;
		    //打款金额
		    $gysdks=$this->common->getdeliverynum($v['prid'],0);
		    $list[$k]['gysdks']=$gysdks;
		}
		$data["list"]=$list;
		$data["sdate"]=date("Y-m-d", $sdate);
		$data["edate"]=date("Y-m-d", $edate);
		//$data["edate"] = $edate;
		$data["mid"] = $mid;
		$this->display("statistics/duizhang_list", $data);
	}

	
	
}
