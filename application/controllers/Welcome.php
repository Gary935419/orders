<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：首页
 * 作成者        ： Gary
 * **********************************************************************
 */
class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Welcome_model', 'welcome');
		header("Content-type:text/html;charset=utf-8");
	}
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
		$data['kehunum'] = $this->welcome->getyonghunum(0);
		$data['gysnum'] = $this->welcome->getyonghunum(1);
		$data['datenum'] = $this->welcome->getyonghunum(2);
		
		$data['ordersnum'] = $this->welcome->getordernum(1);
		$data['orderendnum'] = $this->welcome->getordernum(2);
		$data['orderdatenum'] = $this->welcome->getordernum(3);
		
		$data['proclass1']=$this->welcome->getproclassnum('铸造','');
	    $data['proclass1end']=$this->welcome->getproclassnum('铸造','1');
	    
	    $data['proclass2']=$this->welcome->getproclassnum('铆焊','');
	    $data['proclass2end']=$this->welcome->getproclassnum('铆焊','1');
	    
	    $data['proclass3']=$this->welcome->getproclassnum('夹具设计','');
	    $data['proclass3end']=$this->welcome->getproclassnum('夹具设计','1');
	    
	    $data['proclass4']=$this->welcome->getproclassnum('伺服机器人','');
	    $data['proclass4end']=$this->welcome->getproclassnum('伺服机器人','1');
	    
	    $data['proclass5']=$this->welcome->getproclassnum('机床设计','');
	    $data['proclass5end']=$this->welcome->getproclassnum('机床设计','1');
	    
	    $data['proclass6']=$this->welcome->getproclassnum('机器人','');
	    $data['proclass6end']=$this->welcome->getproclassnum('机器人','1');
        $this->load->view('welcome_message',$data);
    }
}
