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


    function GetRandStr($length)
    {
        //字符组合
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($str) - 1;
        $randstr = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }

    /**
     * 登录生成token
     */
    private function _get_token($member_id)
    {
        //生成新的token
        $token = md5($member_id . strval(time()) . strval(rand(0, 999999)));
        return $token;
    }

    /**
     * 获得临时登录凭
     * @param type $appid 小程序 appId
     * @param type $secret 小程序 appSecret
     * @param type $loginCode 登录时获取的 code
     *
     * @return Array 用户信息
     */
    function get_code2Session($appid, $secret, $loginCode)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $secret . '&grant_type=authorization_code&js_code=' . $loginCode;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //禁止调用时就输出获取到的数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $resultnew = json_decode($result, true);
        return $resultnew;
    }


    /**
     * 用户/供应商 注册
     */
    public function register_member()
    {
        //验证loginCode是否传递
        if (!isset($_POST['loginCode']) || empty($_POST['loginCode'])) {
            $this->back_json(201, '未传递loginCode');
        }
        //验证mobile是否传递
        if (!isset($_POST['mobile']) || empty($_POST['mobile'])) {
            $this->back_json(201, '未传递mobile');
        }
        //验证verification_code是否传递
        if (!isset($_POST['verification_code']) || empty($_POST['verification_code'])) {
            $this->back_json(201, '未传递verification_code');
        }
        $is_login = empty($_POST['is_login'])?'0':$_POST['is_login'];
        $mobile = empty($_POST['mobile'])?'':$_POST['mobile'];
        //验证avatarurl是否传递  0用户  1供应商
        $identity = empty($_POST['identity']) ? 0 : 1;
        // 取得信息
        $loginCode = $_POST['loginCode'];
        $abc=substr($mobile,-4);
        if (empty($identity)){
            //获得昵称
            $nickname = "我是用户".$abc;
        }else{
            //获得昵称
            $nickname = "我是供应商".$abc;
        }

        //获得图像
        $avatarurl = "https://or.dltqwy.com/static/images/a2.png";

        $member_info_one = $this->mini->getMemberInfomobile($mobile,$identity);
        if (empty($is_login)){
            if (!empty($member_info_one)){
                $this->back_json(205, '当前手机号已经注册了，请更换手机号。',array());
            }
            // 取得登录凭证
            $resultnew = $this->get_code2Session($this->appid, $this->secret, $loginCode);
            if (!isset($resultnew['openid']) || empty($resultnew['openid'])){
                $this->back_json(205, '获得openid数据错误',array());
            }
            $openid = $resultnew['openid'];
        }else{
            $openid = $member_info_one['openid'];
        }

        $verification_code = empty($_POST['verification_code'])?'':$_POST['verification_code'];
        $sex = empty($_POST['sex'])?'0':$_POST['sex'];

        $company_name = empty($_POST['company_name'])?'':$_POST['company_name'];
        $company_address = empty($_POST['company_address'])?'':$_POST['company_address'];
        $nickname = empty($_POST['nickname'])?'':$_POST['nickname'];
        $truename = empty($_POST['nickname'])?'':$_POST['nickname'];
        $email = empty($_POST['email'])?'':$_POST['email'];


        $getMemberyanzhengma = $this->mini->getMemberyanzhengma($mobile);
        if (empty($getMemberyanzhengma)){
            $this->back_json(201, '未发送验证码');
        }
        $expiration_time = $getMemberyanzhengma['expiration_time'];
        if ($expiration_time<time()){
            $this->back_json(201, '验证码过期');
        }
        $vcode = $getMemberyanzhengma['vcode'];
        if ($vcode != $verification_code){
            $this->back_json(201, '验证码错误');
        }
        //用户是否注册判断
//        $member_info_one = $this->mini->getMemberInfo($mobile,$identity);
//        $member_info_one = $this->mini->getMemberInfomobile($mobile,$identity);
        //验证会员
        if (empty($member_info_one)) {
            if (empty($is_login)){
                $avater = $avatarurl;
                $token = $this->_get_token(666);
                $add_time = time();
                $audit_status = empty($identity)?2:0;
                $business_license = '';
                $review_data = '';
                $business_type = '';
                $business_typenames = '';
                // 注册操作
                $a=$this->mini->register($identity,$openid,$mobile,$truename,$company_address,$company_name,$email,$sex,$business_typenames,$avater,$nickname,$token,$add_time,$audit_status,$business_license,$review_data,$business_type);
                $member_newinfo = $this->mini->getMemberInfomobile($mobile,$identity);
                $member_newinfo['session_key'] = $resultnew['session_key'];
                $liulanliangold = $this->mini->getsettinginfo();
                $liulanliang = $liulanliangold['liulanliang'] + 1;
                $this->mini->setliulanliangbianhua($liulanliang);
                $this->back_json(200, '操作成功',$member_newinfo);
            }else{
                $this->back_json(205, '当前账户未注册，请先去完成注册。',array());
            }
        } else {
            /**登录操作*/
            $token = $this->_get_token($member_info_one['mid']);
            $this->mini->member_edit($member_info_one['mid'], $token);
            $member_info_one = $this->mini->getMemberInfomobile($mobile,$identity);
            $liulanliangold = $this->mini->getsettinginfo();
            $liulanliang = $liulanliangold['liulanliang'] + 1;
            $this->mini->setliulanliangbianhua($liulanliang);
            $this->back_json(200, '操作成功',$member_info_one);
        }
    }
    /**
     * 验证手机号
     * @param $value
     * @param string $match
     * @return bool|int
     */
    function is_mobile($value, $match = "/^1[3|4|5|7|8|][0-9]{9}$/")
    {
        $v = trim($value);
        if (empty($v)) {
            return false;
        }
        return preg_match($match, $v);
    }
    /**
     * 发送验证码
     */
    public function send_verification_code()
    {
        //验证mobile是否传递
        if (!isset($_POST['mobile']) || empty($_POST['mobile'])) {
            $this->back_json(201, '未传递mobile');
        }
        $mobile = empty($_POST['mobile'])?'':$_POST['mobile'];
        if (!$this->is_mobile($mobile)) {
            $this->back_json(201, '手机号格式不正确');
        }

        $identity = empty($_POST['identity']) ? 0 : 1;
        $is_login = empty($_POST['is_login'])?0:$_POST['is_login'];
        if (!empty($is_login)){
            $member_info_one = $this->mini->getMemberInfomobile($mobile,$identity);
            if (empty($member_info_one)){
                $this->back_json(205, '当前手机号没有注册，请先去注册。',array());
            }
        }

        //生成随机验证码
        $vcode = "";
        for ($i = 0; $i < 4; $i++) {
            if($i == 0){
                $vcode .= rand(1, 9);
            }
            else{
                $vcode .= rand(0, 9);
            }
        }
        $vcode = "1234";
        $add_time = time();
        $expiration_time = $add_time + 300;
        // 注册操作
        $this->mini->register_vcode($mobile,$expiration_time,$vcode,$add_time);

        $member_info = array();
        $member_info['vcode'] = $vcode;
        $member_info['mobile'] = $mobile;
        $member_info['expiration_time'] = $add_time + 300;
        $this->back_json(200, '操作成功',$member_info);
    }
}
