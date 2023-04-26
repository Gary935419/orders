<?php
class Mini_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }

    public function getMemberInfo($openid,$identity)
    {
        $openid = $this->db->escape($openid);
        $identity = $this->db->escape($identity);
        $sql = "SELECT * FROM `member` where openid = $openid and identity = $identity";
        return $this->db->query($sql)->row_array();
    }
    public function getMemberInfomobile($mobile,$identity)
    {
        $mobile = $this->db->escape($mobile);
        $identity = $this->db->escape($identity);
        $sql = "SELECT * FROM `member` where mobile = $mobile and identity = $identity";
        return $this->db->query($sql)->row_array();
    }
    public function member_edit($mid, $token)
    {
        $mid = $this->db->escape($mid);
        $token = $this->db->escape($token);
        $sql = "UPDATE `member` SET token=$token WHERE mid = $mid";
        return $this->db->query($sql);
    }
    public function getMemberyanzhengma($mobile)
    {
        $mobile = $this->db->escape($mobile);
        $sql = "SELECT * FROM `verification_code` where mobile = $mobile order by vid desc LIMIT 1";
        return $this->db->query($sql)->row_array();
    }
    public function register($identity,$openid,$mobile,$truename,$company_address,$company_name,$email,$sex,$business_typenames,$avater,$nickname,$token,$add_time,$audit_status,$business_license,$review_data,$business_type)
    {
        if($identity==1){
            $grade="一般供应商";
        }else{
            $grade="";
        }
        $grade = $this->db->escape($grade);
        $identity = $this->db->escape($identity);
        $openid = $this->db->escape($openid);
        $mobile = $this->db->escape($mobile);
        $truename = $this->db->escape($truename);
        $company_address = $this->db->escape($company_address);
        $company_name = $this->db->escape($company_name);
        $email = $this->db->escape($email);
        $sex = $this->db->escape($sex);
        $business_typenames = $this->db->escape($business_typenames);
        $avater = $this->db->escape($avater);
        $nickname = $this->db->escape($nickname);
        $token = $this->db->escape($token);
        $add_time = $this->db->escape($add_time);
        $audit_status = $this->db->escape($audit_status);
        $business_license = $this->db->escape($business_license);
        $review_data = $this->db->escape($review_data);
        $business_type = $this->db->escape($business_type);

        $sql = "INSERT INTO `member` (identity,openid,mobile,truename,company_address,company_name,email,sex,business_typenames,avater,nickname,token,add_time,audit_status,business_license,review_data,business_type,grade) VALUES ($identity,$openid,$mobile,$truename,$company_address,$company_name,$email,$sex,$business_typenames,$avater,$nickname,$token,$add_time,$audit_status,$business_license,$review_data,$business_type,$grade)";
        
        //return $sql;
        return $this->db->query($sql);
    }
    public function register_vcode($mobile,$expiration_time,$vcode,$add_time)
    {
        $mobile = $this->db->escape($mobile);
        $expiration_time = $this->db->escape($expiration_time);
        $vcode = $this->db->escape($vcode);
        $add_time = $this->db->escape($add_time);
        $sql = "INSERT INTO `verification_code` (mobile,expiration_time,vcode,add_time) VALUES ($mobile,$expiration_time,$vcode,$add_time)";
        return $this->db->query($sql);
    }
    public function getsettinginfo()
    {
        $sql = "SELECT * FROM `setting` where sid = 1 ";
        return $this->db->query($sql)->row_array();
    }
    public function getproduct_classificationAll($pg)
    {
        $sqlw = " 1=1 ";

        $start = ($pg - 1) * 200;
        $stop = 200;

        $sql = "SELECT * FROM `product_classification` where " . $sqlw . " order by pid desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }
    public function getindustry_classificationAll($pg)
    {
        $sqlw = " 1=1 ";

        $start = ($pg - 1) * 200;
        $stop = 200;

        $sql = "SELECT * FROM `industry_classification` where " . $sqlw . " order by iid desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }
    public function getindustry_newsAll($pg)
    {
        $sqlw = " 1=1 ";

        $start = ($pg - 1) * 200;
        $stop = 200;

        $sql = "SELECT * FROM `industry_news` where " . $sqlw . " order by inid desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }
    public function hangyexinwen_xiangqing($inid)
    {
        $inid = $this->db->escape($inid);
        $sql = "SELECT * FROM `industry_news` where inid=$inid ";
        return $this->db->query($sql)->row_array();
    }
    public function fabu_list($pg,$date,$keyword,$pagecount)
    {
        $sqlw = " 1=1 and u.audit_status=1 and u.product_sort<2";
        if (!empty($date)) {
            $date = $this->db->escape($date);
            $sqlw .= " and u.end_time >=" . $date;
        }
        if (!empty($keyword)) {
            $sqlw.=" and (u.product_name like '%".$keyword."%' or u.product_class_name like '%".$keyword."%' ) ";
        }
        $start = ($pg - 1) * 5;
        $stop = 5;

        // $sql = "SELECT r.nickname,r.avater,u.* FROM `product_release` u left join `member` r on u.mid=r.mid  where " . $sqlw . " order by u.prid desc LIMIT $start, $stop";
        

        if($pagecount>0){
            $sql = "SELECT r.nickname,r.avater,u.* FROM `product_release` u left join `member` r on u.mid=r.mid  where " . $sqlw . " order by u.prid desc LIMIT 0, $pagecount";            
        }else{
            $sql = "SELECT r.nickname,r.avater,u.* FROM `product_release` u left join `member` r on u.mid=r.mid  where " . $sqlw . " order by u.prid desc";
        }
        
         //return $sql;
        // print_r($sql);die;
        return $this->db->query($sql)->result_array();
    }
    public function fabu_xiangqing($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "SELECT * FROM `product_release` where prid=$prid ";
        return $this->db->query($sql)->row_array();
    }
    

    
    public function getMemberInfotoken($token)
    {
        $token = $this->db->escape($token);
        $sql = "SELECT * FROM `member` where token = $token ";
        return $this->db->query($sql)->row_array();
    }
    
    
    public function product_release_add_save($product_sort,$product_signtime,$product_desc,$product_zmoney,$product_jaddress,$product_caddress,$mid,$add_time,$audit_status,$company_name,$contact_name,$contact_tel,$is_contact_person,$product_specification1,$product_specification2,$product_specification3,$product_description,$end_time,$purchasing_time,$quantity_purchased,$product_title,$product_name,$product_class_name)
    {
        $mid = $this->db->escape($mid);
        $add_time = $this->db->escape($add_time);
        $audit_status = $this->db->escape($audit_status);
        $company_name = $this->db->escape($company_name);
        $contact_name = $this->db->escape($contact_name);
        $contact_tel = $this->db->escape($contact_tel);
        $is_contact_person = $this->db->escape($is_contact_person);
        $product_specification1 = $this->db->escape($product_specification1);
        $product_specification2 = $this->db->escape($product_specification2);
        $product_specification3 = $this->db->escape($product_specification3);
        $product_description = $this->db->escape($product_description);
        $end_time = $this->db->escape($end_time);
        $purchasing_time = $this->db->escape($purchasing_time);
        $quantity_purchased = $this->db->escape($quantity_purchased);
        $product_title = $this->db->escape($product_title);
        $product_name = $this->db->escape($product_name);
        $product_class_name = $this->db->escape($product_class_name);
        $product_sort = $this->db->escape($product_sort);
        $product_signtime = $this->db->escape($product_signtime);
        $product_desc = $this->db->escape($product_desc);
        $product_zmoney = $this->db->escape($product_zmoney);
        $product_jaddress = $this->db->escape($product_jaddress);
        $product_caddress = $this->db->escape($product_caddress);
        $sql = "INSERT INTO `product_release` (product_sort,product_signtime,product_desc,product_zmoney,product_jaddress,product_caddress,mid,add_time,audit_status,company_name,contact_name,contact_tel,is_contact_person,product_specification1,product_specification2,product_specification3,product_description,end_time,purchasing_time,quantity_purchased,product_title,product_name,product_class_name) VALUES ($product_sort,$product_signtime,$product_desc,$product_zmoney,$product_jaddress,$product_caddress,$mid,$add_time,$audit_status,$company_name,$contact_name,$contact_tel,$is_contact_person,$product_specification1,$product_specification2,$product_specification3,$product_description,$end_time,$purchasing_time,$quantity_purchased,$product_title,$product_name,$product_class_name)";
        return $this->db->query($sql);
    }

    public function product_release_edit_save($prid,$product_sort,$product_signtime,$product_desc,$product_zmoney,$product_jaddress,$product_caddress,$mid,$add_time,$audit_status,$company_name,$contact_name,$contact_tel,$is_contact_person,$product_specification1,$product_specification2,$product_specification3,$product_description,$end_time,$purchasing_time,$quantity_purchased,$product_title,$product_name,$product_class_name)
    {
        $prid = $this->db->escape($prid);
        $mid = $this->db->escape($mid);
        $add_time = $this->db->escape($add_time);
        $audit_status = $this->db->escape($audit_status);
        $company_name = $this->db->escape($company_name);
        $contact_name = $this->db->escape($contact_name);
        $contact_tel = $this->db->escape($contact_tel);
        $is_contact_person = $this->db->escape($is_contact_person);
        $product_specification1 = $this->db->escape($product_specification1);
        $product_specification2 = $this->db->escape($product_specification2);
        $product_specification3 = $this->db->escape($product_specification3);
        $product_description = $this->db->escape($product_description);
        $end_time = $this->db->escape($end_time);
        $purchasing_time = $this->db->escape($purchasing_time);
        $quantity_purchased = $this->db->escape($quantity_purchased);
        $product_title = $this->db->escape($product_title);
        $product_name = $this->db->escape($product_name);
        $product_class_name = $this->db->escape($product_class_name);
        $product_sort = $this->db->escape($product_sort);
        $product_signtime = $this->db->escape($product_signtime);
        $product_desc = $this->db->escape($product_desc);
        $product_zmoney = $this->db->escape($product_zmoney);
        $product_jaddress = $this->db->escape($product_jaddress);
        $product_caddress = $this->db->escape($product_caddress);
        $sql = "UPDATE `product_release` SET product_caddress=$product_caddress,product_jaddress=$product_jaddress,product_zmoney=$product_zmoney,product_desc=$product_desc,product_signtime=$product_signtime,product_sort=$product_sort,product_class_name=$product_class_name,product_name=$product_name,product_title=$product_title,quantity_purchased=$quantity_purchased,purchasing_time=$purchasing_time,end_time=$end_time,product_description=$product_description,product_specification3=$product_specification3,product_specification2=$product_specification2,product_specification1=$product_specification1,is_contact_person=$is_contact_person,contact_tel=$contact_tel,contact_name=$contact_name,mid=$mid,add_time=$add_time,audit_status=$audit_status,company_name=$company_name WHERE prid = $prid";
        return $this->db->query($sql);
    }

    public function memberinfo_edit($mid,$truename,$email,$nickname,$company_address,$company_name)
    {
        $mid = $this->db->escape($mid);
        $truename = $this->db->escape($truename);
        $email = $this->db->escape($email);
        $nickname = $this->db->escape($nickname);
        $company_address = $this->db->escape($company_address);
        $company_name = $this->db->escape($company_name);
        $sql = "UPDATE `member` SET truename=$truename,email=$email,nickname=$nickname,company_address=$company_address,company_name=$company_name WHERE mid = $mid";
        return $this->db->query($sql);
    }

    public function supplier_apply_edit($mid,$business_license,$review_data,$audit_status,$business_typenames,$business_type)
    {
        $mid = $this->db->escape($mid);
        $business_license = $this->db->escape($business_license);
        $review_data = $this->db->escape($review_data);
        $audit_status = $this->db->escape($audit_status);
        $business_typenames = $this->db->escape($business_typenames);
        $business_type = $this->db->escape($business_type);
        $sql = "UPDATE `member` SET business_license=$business_license,review_data=$review_data,audit_status=$audit_status,business_typenames=$business_typenames,business_type=$business_type WHERE mid = $mid";
        return $this->db->query($sql);
    }

    public function supplier_bid_save($delivery_time,$excel_url,$mid,$contact_tel,$description,$bidding_cost,$bidder,$company_name,$prid,$order_state,$add_time,$aftid,$pdf_url)
    {
        
        $mid = $this->db->escape($mid);
        $add_time = $this->db->escape($add_time);
        $contact_tel = $this->db->escape($contact_tel);
        $company_name = $this->db->escape($company_name);
        $description = $this->db->escape($description);
        $bidding_cost = $this->db->escape($bidding_cost);
        $bidder = $this->db->escape($bidder);
        $prid = $this->db->escape($prid);
        $order_state = $this->db->escape($order_state);
        $delivery_time = $this->db->escape($delivery_time);
        $excel_url = $this->db->escape($excel_url); ;
        $pdf_url = $this->db->escape($pdf_url);   
        
        if($aftid){
            $sql = "UPDATE `application_orders` SET delivery_time=$delivery_time,excel_url=$excel_url,pdf_url=$pdf_url,mid=$mid,contact_tel=$contact_tel,description=$description,bidding_cost=$bidding_cost,bidder=$bidder,company_name=$company_name WHERE aftid = $aftid";
        }else{
            $sql = "INSERT INTO `application_orders` (excel_url,pdf_url,delivery_time,mid,contact_tel,description,bidding_cost,bidder,company_name,prid,order_state,add_time) VALUES ($excel_url,$pdf_url,$delivery_time,$mid,$contact_tel,$description,$bidding_cost,$bidder,$company_name,$prid,$order_state,$add_time)";            
        }
        return $this->db->query($sql);
    }

    public function supplier_product_release_edit($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "UPDATE `product_release` SET product_sort=1 WHERE prid = $prid";
        return $this->db->query($sql);
    }

    public function order_yonghu_list($pg,$mid,$product_sort)
    {
        $mid = $this->db->escape($mid);
        $product_sort = $this->db->escape($product_sort);

        $sqlw = " 1=1 and u.mid= ".$mid." and u.product_sort=".$product_sort;

        $start = ($pg - 1) * 10;
        $stop = 10;

        $sql = "SELECT u.* FROM `product_release` u  where " . $sqlw . " order by u.prid desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }

    public function order_gongyingshang_list_new($pg,$mid,$product_sort)
    {
        $mid = $this->db->escape($mid);
        //$product_sort = $this->db->escape($product_sort);
        $sqlw = " ao.mid=$mid and pr.product_sort=$product_sort and ao.order_state!=1 ";

        if($product_sort>1){
          $sqlw =$sqlw."and pr.product_signmemberid=$mid";  
        }

        $start = ($pg - 1) * 10;
        $stop = 10;

        $sql = "SELECT * FROM `application_orders` ao left join `product_release` pr on pr.prid=ao.prid  where " . $sqlw . " order by ao.aftid desc LIMIT $start, $stop";
        
        return $this->db->query($sql)->result_array();
    }

    public function supplier_orders_list($pg,$prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " 1=1 and u.prid=".$prid;

        $start = ($pg - 1) * 10;
        $stop = 10;

        $sql = "SELECT *,u.mid as smid,u.company_name as gysname, u.bidding_cost as biddingcost,u.delivery_time,u.excel_url,u.add_time as pradd_time FROM `application_orders` u  left join `product_release` pr on pr.prid=u.prid  where " . $sqlw . " order by u.aftid desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }

    public function supplier_orders_listg($pg,$prid,$mid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " 1=1 and u.prid= ".$prid." and u.mid= ".$mid;

        $start = ($pg - 1) * 10;
        $stop = 10;

        $sql = "SELECT *,u.mid as smid,u.company_name as gysname, u.bidding_cost as biddingcost,u.delivery_time,u.excel_url FROM `application_orders` u  left join `product_release` pr on pr.prid=u.prid  where " . $sqlw . " order by u.aftid desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }

    public function order_gongyingshang_list_new1($pg,$mid,$product_sort)
    {
        $mid = $this->db->escape($mid);
        $product_sort = $this->db->escape($product_sort);

        $sqlw = " ao.mid=$mid and ao.order_state=$product_sort ";

        $start = ($pg - 1) * 10;
        //$start = -5;
        $stop = 10;

        $sql = "SELECT * FROM `application_orders` ao left join `product_release` pr on pr.prid=ao.prid  where " . $sqlw . " order by ao.aftid desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }

    public function member_select_supplier($prid,$mid)
    {
        $prid = $this->db->escape($prid);
        $mid = $this->db->escape($mid);
        $sql = "UPDATE `application_orders` SET order_state=1 WHERE prid = $prid and mid=$mid";
        return $this->db->query($sql);
    }

    public function member_select_suppliernew($prid,$order_state_new)
    {
        $prid = $this->db->escape($prid);
        $order_state_new = $this->db->escape($order_state_new);
        $sql = "UPDATE `product_release` SET order_state_new=$order_state_new WHERE prid = $prid";
        return $this->db->query($sql);
    }

    public function supplier_select_member($prid,$product_signtime,$product_signmemberid,$bidding_cost,$delivery_time)
    {
        $prid = $this->db->escape($prid);
        $bidding_cost = $this->db->escape($bidding_cost);
        $delivery_time = $this->db->escape($delivery_time);
        $product_signmemberid = $this->db->escape($product_signmemberid);
        $product_signtime = $this->db->escape($product_signtime);
        $sql = "UPDATE `product_release` SET delivery_time=$delivery_time,bidding_cost=$bidding_cost,product_signtime=$product_signtime,product_signmemberid=$product_signmemberid,product_sort=2 WHERE prid = $prid";
        return $this->db->query($sql);
    }
    public function supplier_select_member1($prid,$mid)
    {
        $prid = $this->db->escape($prid);
        $mid = $this->db->escape($mid);
        $sql = "UPDATE `application_orders` SET order_state=2 WHERE prid = $prid and mid=$mid";
        return $this->db->query($sql);
    }

    public function supplier_select_member_new($prid,$mid)
    {
        $prid = $this->db->escape($prid);
        $mid = $this->db->escape($mid);
        $sql = "SELECT * FROM `application_orders` where prid = $prid and mid = $mid";
        return $this->db->query($sql)->row_array();
    }

    public function supplier_cancel_member($prid,$mid)
    {
        $prid = $this->db->escape($prid);
        $mid = $this->db->escape($mid);
        $sql = "UPDATE `application_orders` SET order_state=3 WHERE prid = $prid and mid=$mid";
        return $this->db->query($sql);
    }
    public function getbaojiashulinag($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where prid = " . $prid;
        $sql = "SELECT count(1) as number FROM `application_orders` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }
    public function member_cancel_order($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "UPDATE `product_release` SET product_sort=5 WHERE prid = $prid";
        return $this->db->query($sql);
    }
    public function jiaohuoshuliang($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where identity=1 and prid = " . $prid;
        $sql = "SELECT count(1) as number FROM `delivery` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }
    public function delivery_save($payment_price,$identity,$prid,$batch_number,$delivery_time,$express_img,$add_time,$delivery_number)
    {
        $payment_price = $this->db->escape($payment_price);
        $prid = $this->db->escape($prid);
        $identity = $this->db->escape($identity);
        $add_time = $this->db->escape($add_time);
        $batch_number = $this->db->escape($batch_number);
        $delivery_time = $this->db->escape($delivery_time);
        $express_img = $this->db->escape($express_img);
        $delivery_number = $this->db->escape($delivery_number);
        $sql = "INSERT INTO `delivery` (payment_price,identity,prid,batch_number,delivery_time,express_img,add_time,delivery_number) VALUES ($payment_price,$identity,$prid,$batch_number,$delivery_time,$express_img,$add_time,$delivery_number)";
        return $this->db->query($sql);
    }

    public function delivery_list($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " 1=1 and u.prid=".$prid;

        $sql = "SELECT u.* FROM `delivery` u  where " . $sqlw . " order by u.did desc";
        return $this->db->query($sql)->result_array();
    }

    public function shifoubeikehuxuanzhong($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where order_state = 1 and prid = " . $prid;
        $sql = "SELECT count(1) as number FROM `application_orders` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }

    public function member_complete_order($prid,$overtime)
    {
        $prid = $this->db->escape($prid);
        $overtime = $this->db->escape($overtime);
        $sql = "UPDATE `product_release` SET product_sort=3,product_overtime=$overtime WHERE prid = $prid";
        return $this->db->query($sql);
    }

    public function geterrorarr()
    {
        $sql = "SELECT error_news.enid,error_news.error_title FROM `error_news` order by enid desc";
        return $this->db->query($sql)->result_array();
    }

    public function getorderInfo($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "SELECT * FROM `product_release` where prid = $prid";
        return $this->db->query($sql)->row_array();
    }
    public function getproduct_abnormalInfo($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "SELECT * FROM `product_abnormal` where prid = $prid";
        return $this->db->query($sql)->row_array();
    }
    public function product_abnormal_save($prid,$errorid,$abkehu_desc,$abkehu_addtime,$zhiqianzhuangtai)
    {
        $prid = $this->db->escape($prid);
        $errorid = $this->db->escape($errorid);
        $abkehu_desc = $this->db->escape($abkehu_desc);
        $abkehu_addtime = $this->db->escape($abkehu_addtime);
        $zhiqianzhuangtai = $this->db->escape($zhiqianzhuangtai);
        $sql = "INSERT INTO `product_abnormal` (prid,errorid,abkehu_desc,abkehu_addtime,zhiqianzhuangtai) VALUES ($prid,$errorid,$abkehu_desc,$abkehu_addtime,$zhiqianzhuangtai)";
        return $this->db->query($sql);
    }
    public function product_abnormal_edit($prid,$abgonyingshang_desc,$abgongyingshang_addtime)
    {
        $prid = $this->db->escape($prid);
        $abgonyingshang_desc = $this->db->escape($abgonyingshang_desc);
        $abgongyingshang_addtime = $this->db->escape($abgongyingshang_addtime);
        $sql = "UPDATE `product_abnormal` SET abgonyingshang_desc=$abgonyingshang_desc,abgongyingshang_addtime=$abgongyingshang_addtime WHERE prid = $prid";
        return $this->db->query($sql);
    }
    public function product_release_edit($prid,$product_sort)
    {
        $prid = $this->db->escape($prid);
        $product_sort = $this->db->escape($product_sort);
        $sql = "UPDATE `product_release` SET product_sort=$product_sort WHERE prid = $prid";
        return $this->db->query($sql);
    }
    public function product_abnormal_edit1($prid,$errorid,$abkehu_desc,$abkehu_addtime,$zhiqianzhuangtai)
    {
        $prid = $this->db->escape($prid);
        $errorid = $this->db->escape($errorid);
        $abkehu_desc = $this->db->escape($abkehu_desc);
        $abkehu_addtime = $this->db->escape($abkehu_addtime);
        $zhiqianzhuangtai = $this->db->escape($zhiqianzhuangtai);
        $sql = "UPDATE `product_abnormal` SET errorid=$errorid,abkehu_desc=$abkehu_desc,abkehu_addtime=$abkehu_addtime,zhiqianzhuangtai=$zhiqianzhuangtai WHERE prid = $prid";
        return $this->db->query($sql);
    }

    public function getcommentInfo($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "SELECT * FROM `comment` where prid = $prid";
        return $this->db->query($sql)->row_array();
    }

    public function product_abnormal_save_comment($prid,$gongyingshang_num,$gongyingshang_id,$gongyingshang_desc,$gongyingshang_addtime)
    {
        $prid = $this->db->escape($prid);
        $gongyingshang_num = $this->db->escape($gongyingshang_num);
        $gongyingshang_id = $this->db->escape($gongyingshang_id);
        $gongyingshang_desc = $this->db->escape($gongyingshang_desc);
        $gongyingshang_addtime = $this->db->escape($gongyingshang_addtime);
        $sql = "INSERT INTO `comment` (prid,gongyingshang_num,gongyingshang_id,gongyingshang_desc,gongyingshang_addtime) VALUES ($prid,$gongyingshang_num,$gongyingshang_id,$gongyingshang_desc,$gongyingshang_addtime)";
        return $this->db->query($sql);
    }
    public function product_abnormal_save_comment1($prid,$kehu_num,$kehu_id,$kehu_desc,$kehu_addtime)
    {
        $prid = $this->db->escape($prid);
        $kehu_num = $this->db->escape($kehu_num);
        $kehu_id = $this->db->escape($kehu_id);
        $kehu_desc = $this->db->escape($kehu_desc);
        $kehu_addtime = $this->db->escape($kehu_addtime);
        $sql = "INSERT INTO `comment` (prid,kehu_num,kehu_id,kehu_desc,kehu_addtime) VALUES ($prid,$kehu_num,$kehu_id,$kehu_desc,$kehu_addtime)";
        return $this->db->query($sql);
    }
    public function product_abnormal_edit_comment($prid,$gongyingshang_num,$gongyingshang_id,$gongyingshang_desc,$gongyingshang_addtime)
    {
        $prid = $this->db->escape($prid);
        $gongyingshang_num = $this->db->escape($gongyingshang_num);
        $gongyingshang_id = $this->db->escape($gongyingshang_id);
        $gongyingshang_desc = $this->db->escape($gongyingshang_desc);
        $gongyingshang_addtime = $this->db->escape($gongyingshang_addtime);
        $sql = "UPDATE `comment` SET gongyingshang_num=$gongyingshang_num,gongyingshang_id=$gongyingshang_id,gongyingshang_desc=$gongyingshang_desc,gongyingshang_addtime=$gongyingshang_addtime WHERE prid = $prid";
        return $this->db->query($sql);
    }
    public function product_abnormal_edit_comment1($prid,$kehu_num,$kehu_id,$kehu_desc,$kehu_addtime)
    {
        $prid = $this->db->escape($prid);
        $kehu_num = $this->db->escape($kehu_num);
        $kehu_id = $this->db->escape($kehu_id);
        $kehu_desc = $this->db->escape($kehu_desc);
        $kehu_addtime = $this->db->escape($kehu_addtime);
        $sql = "UPDATE `comment` SET kehu_num=$kehu_num,kehu_id=$kehu_id,kehu_desc=$kehu_desc,kehu_addtime=$kehu_addtime WHERE prid = $prid";
        return $this->db->query($sql);
    }
    public function delivery_count1($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where prid=$prid and identity=1 ";
        $sql = "SELECT count(1) as number FROM `delivery` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }

    public function delivery_count2($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where prid=$prid and identity=0 ";
        $sql = "SELECT count(1) as number FROM `delivery` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }

    public function delivery_count3($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where prid=$prid and identity=1 ";
        $sql = "SELECT sum(delivery_number) as number FROM `delivery` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }
    
    public function supplier_modify_order_price($aftid,$bidding_cost)
    {
        $aftid = $this->db->escape($aftid);
        $bidding_cost = $this->db->escape($bidding_cost);
        $sql = "UPDATE `application_orders` SET bidding_cost=$bidding_cost WHERE aftid = $aftid";
        return $this->db->query($sql);
    }
    public function pingjia_info($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "SELECT * FROM `comment` where prid=$prid ";
        return $this->db->query($sql)->row_array();
    }
    public function getpingjialistinfo($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "SELECT * FROM `comment` where prid = $prid";
        return $this->db->query($sql)->row_array();
    }
    public function member_info($mid)
    {
        $mid = $this->db->escape($mid);
        $sql = "SELECT * FROM `member` where mid = $mid";
        return $this->db->query($sql)->row_array();
    }
    public function getnews($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT news_contents as con FROM `industry_news` where inid =$id ";
        return $this->db->query($sql)->row()->con;
    }
    public function getfabuliang()
    {
        $sqlw = " where audit_status=1 ";
        $sql = "SELECT count(1) as number FROM `product_release` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }
    public function getyonghuliang()
    {
        $sqlw = " where 1=1 ";
        $sql = "SELECT count(1) as number FROM `member` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }
    public function setliulanliangbianhua($liulanliang)
    {
        $liulanliang = $this->db->escape($liulanliang);
        $sql = "UPDATE `setting` SET liulanliang=$liulanliang WHERE sid = 1";
        return $this->db->query($sql);
    }
    
    //获取投标价格
    public function selectapplicationorders($prid,$mid)
    {
        $prid = $this->db->escape($prid);
        $mid = $this->db->escape($mid);
        $sql = "select * from `application_orders` WHERE prid = $prid and mid=$mid";
        return $this->db->query($sql)->row();
    }
    
    //获取异常信息list
    public function geterrorlist()
    {
        $sql = "SELECT * FROM `error_news`";
        return $this->db->query($sql)->result_array();
    }
    
    //保存异常信息
    public function error_update($prid,$errorid,$errordesc,$addtime,$identity,$mid)
    {
        $prid = $this->db->escape($prid);
        $errorid = $this->db->escape($errorid);
        $errordesc = $this->db->escape($errordesc);
        $addtime = $this->db->escape($addtime);
        $identity = $this->db->escape($identity);
        $mid = $this->db->escape($mid);
        $sqli = "INSERT INTO `product_abnormal` (prid,errorid,error_desc,error_addtime,error_identity,error_userid) VALUES ($prid,$errorid,$errordesc,$addtime,$identity,$mid)";
        $this->db->query($sqli);
        
        $sqlu = "UPDATE `product_release` SET product_sort=4 WHERE prid = $prid";
        return $this->db->query($sqlu);
        
    }

    public function product_release_list1($page,$mid,$starttime,$endtime,$pclassname,$proname)
    {
        $sqlw = " 1=1 and product_sort=3 and mid=$mid";
        if($starttime){
            $stime=strtotime($starttime);
            $sqlw = $sqlw. " and product_overtime>=$stime";
        }
        if($endtime){
            $etime=strtotime($endtime);
            $sqlw = $sqlw. " and product_overtime<=$etime";
        }
        if($pclassname){
            $sqlw = $sqlw. " and product_class_name='".$pclassname."'";
        }        
        if($proname){
            $sqlw = $sqlw. " and product_name like '%".$keyword."%'";
        }  
        
        $start = ($page - 1) * 5;
        //$start = -5;
        $stop = 5;

        $sql = "SELECT prid,product_name,product_class_name,mid,product_signmemberid,bidding_cost,delivery_time,is_receipt_invoice,product_overtime FROM `product_release`  where " . $sqlw . " order by product_overtime desc LIMIT $start, $stop";
       
       return $this->db->query($sql)->result_array();
    }
    public function product_release_list2($page,$mid,$starttime,$endtime,$pclassname,$proname)
    {
        $sqlw = " 1=1 and product_sort=3 and product_signmemberid=$mid";

        if($starttime){
            $stime=strtotime($starttime);
            $sqlw = $sqlw. " and product_overtime>=$stime";
        }
        if($endtime){
            $etime=strtotime($endtime);
            $sqlw = $sqlw. " and product_overtime<=$etime";
        }
        if($pclassname){
            $sqlw = $sqlw. " and product_class_name='".$pclassname."'";
        }        
        if($proname){
            $proname=strtotime($proname);
            $sqlw = $sqlw. " and product_name like '%".$keyword."%'";
        } 

        $start = ($page - 1) * 5;
        //$start = -5;
        $stop = 5;

        $sql = "SELECT prid,product_name,product_class_name,mid,product_signmemberid,bidding_cost,delivery_time,is_receipt_invoice,product_overtime FROM `product_release`  where " . $sqlw . " order by product_overtime desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }

    public function select_product_signmemberid($product_signmemberid)
    {
        $mid = $this->db->escape($product_signmemberid);
        $sql = "select * from `member` WHERE mid=$mid";
        return $this->db->query($sql)->row_array();
    }

    public function delivery_count123($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where prid=$prid and identity=0 ";
        $sql = "SELECT sum(payment_price) as number FROM `delivery` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }

    public function delivery_count456($prid)
    {
        $prid = $this->db->escape($prid);
        $sqlw = " where prid=$prid and identity=1 ";
        $sql = "SELECT sum(delivery_number) as number FROM `delivery` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return $number;
    }

    public function modify_is_receipt_invoice($prid,$is_receipt_invoice)
    {
        $prid = $this->db->escape($prid);
        $is_receipt_invoice = $this->db->escape($is_receipt_invoice);

        $sqlu = "UPDATE `product_release` SET is_receipt_invoice=$is_receipt_invoice WHERE prid = $prid";
        return $this->db->query($sqlu);

    }
    
        public function select_baojia($prid,$aftid)
    {
        $sql = "SELECT * from `application_orders` WHERE aftid = $aftid";
        return $this->db->query($sql)->row();

    }
    
        public function select_abnormal($prid)
    {
        $prid = $this->db->escape($prid);
        $sql = "SELECT * from `product_abnormal` a,`error_news` b WHERE a.prid = $prid and a.errorid=b.enid";
        return $this->db->query($sql)->row_array();
    }
    
        //获取用户留言
        public function select_commentlist($token,$identity,$pagenum,$size)
    {
        $token = $this->db->escape($token);
        $start = ($pagenum - 1) * $size;
        if($identity==0){
            $sql = "select a.* from comment a,member b where a.kehu_id=b.mid and b.token=$token order by a.cid desc LIMIT $start, $size";
        }else{
            $sql = "select a.* from comment a,member b where a.gongyingshang_id=b.mid and b.token=$token order by a.cid desc LIMIT $start, $size";           
        }
        return $this->db->query($sql)->result_array();
    }  
    
        //获取新闻信息
        public function getindustrynews($id)
    {
        $sql = "SELECT * FROM `industry_news` where inid = $id";
        return $this->db->query($sql)->row_array();
    }

    
}
