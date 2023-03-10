<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * **********************************************************************
 * サブシステム名  ： TASK
 * 機能名         ：上传
 * 作成者        ： Gary
 * **********************************************************************
 */
class Uploads extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 单图片上传
     */
    public function pushFIle(){
        $src="";
        $_swap = time();
        $fileName = $_swap.".".substr(strrchr($_FILES['file']['name'], '.'), 1);
        move_uploaded_file($_FILES['file']["tmp_name"], "./static/uploads/".$_FILES['file']['size'].$fileName);
        if (file_exists("./static/uploads/".$_FILES['file']['size'].$fileName)) {
            $src="/static/uploads/".$_FILES['file']['size'].$fileName;
        }
        $data = array();
        $data['src'] = "https://or.dltqwy.com".$src;
        $this->back_json(200, '操作成功', $data);
    }
    /**
     * 多图片上传
     */
    public function pushFIles(){
        $count=sizeof($_FILES['file']['name']);
        $src=array();
        for ($i=0;$i<$count;$i++) {
            $_swap = time()."_".$i;
            $fileName = $_swap.".".substr(strrchr($_FILES['file']['name'][$i], '.'), 1);
            move_uploaded_file($_FILES['file']["tmp_name"][$i], "./static/upload/".$fileName);
            if (file_exists("./static/upload/".$fileName)) {
                $src[]="https://or.dltqwy.com/static/upload/".$fileName;
            }
        }
        $data = array();
        $data['src'] = $src;
        $this->back_json(200, '操作成功', $data);
    }
}
