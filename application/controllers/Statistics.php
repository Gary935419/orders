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
			$list[$i]['hnum']=$this->statistics->getorders($start,$end,"");
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
			$list[$i]['snum']=$this->statistics->getorders($start,$end,"");
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
			$list[$i]['num6']=$this->statistics->getorders($start,$end,54);
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
		$mid = $_GET['mid'];
		$sort = $_GET['sort'];
		$pingjia = $_GET['pingjia'];
		$gongsi = isset($_GET['gongsi']) ? $_GET['gongsi'] : '';

		$showlist=$this->statistics->getcommentshow($mid,$gongsi);
		foreach ($showlist as $k=>$v){
    		$list[$k]['proname']= $v['product_name']; 
    		$list[$k]['kname']=$this->statistics->getmembername($v['kehu_id']);
    		$list[$k]['knum']=$v['kehu_num'];  
    		$list[$k]['ktime']=$v['kehu_addtime'];  
    		$list[$k]['kdesc']=$v['kehu_desc']; 	    		
    		$list[$k]['gname']=$this->statistics->getmembername($v['gongyingshang_id']);
    		$list[$k]['gnum']=$v['gongyingshang_num'];  
    		$list[$k]['gtime']=$v['gongyingshang_addtime'];  
    		$list[$k]['gdesc']=$v['gongyingshang_desc'];      		
        }
		$data["list"] = $list;
		$data["pingjia"] = $pingjia;
		$data["gongsiv"] = $gongsi;
		$this->display("statistics/statistics_show", $data);
	}
}
