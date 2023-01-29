<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * **********************************************************************
 * サブシステム名  ： TASK
 * 機能名         ：登录
 * 作成者        ： Gary
 * **********************************************************************
 */
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// 加载数据库类
		$this->load->model('Mini_model', 'mini');
	}

}
