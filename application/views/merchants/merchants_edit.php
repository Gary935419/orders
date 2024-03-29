<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>我的管理后台-爱回收</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <link rel="stylesheet" href="<?= STA ?>/css/font.css">
    <link rel="stylesheet" href="<?= STA ?>/css/xadmin.css">
    <script type="text/javascript" src="<?= STA ?>/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?= STA ?>/js/xadmin.js"></script>
    <script type="text/javascript" src="<?= STA ?>/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?= STA ?>/js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?= STA ?>/js/upload/jquery_form.js"></script>
</head>
<body>
<div class="layui-fluid" style="padding-top: 66px;">
    <div class="layui-row">
        <form method="post" class="layui-form" action="" name="basic_validate" id="tab">
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>店铺名称
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="mename" name="mename" lay-verify="mename"
						   autocomplete="off" value="<?php echo $mename ?>" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>账号
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="account" name="account" lay-verify="account"
						   autocomplete="off" value="<?php echo $account ?>" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>密码
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="password" id="password" name="password" lay-verify="password"
						   autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>地址
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="meaddress" name="meaddress" lay-verify="meaddress"
						   autocomplete="off" value="<?php echo $meaddress ?>" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>联系人
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="contactname" name="contactname" lay-verify="contactname"
						   autocomplete="off" value="<?php echo $contactname ?>" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
                <label for="L_pass" class="layui-form-label" style="width: 30%;">
                    <span class="x-red">*</span>联系电话
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="text" id="metel" name="metel" lay-verify="metel"
                           autocomplete="off" value="<?php echo $metel ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label" style="width: 30%;">
                    <span class="x-red"></span>显示排序
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="text" id="morder" name="morder" lay-verify="morder"
                           autocomplete="off" class="layui-input" value="<?php echo $morder ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label" style="width: 30%;">
                    <span class="x-red"></span>指标数量
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="text" id="zhibiaoliang" name="zhibiaoliang" lay-verify="zhibiaoliang"
                           autocomplete="off" class="layui-input" value="<?php echo $zhibiaoliang ?>">
                </div>
            </div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>会员等级
				</label>
				<div class="layui-input-inline layui-show-xs-block">
					<div style="width: 300px" class="layui-input-inline layui-show-xs-block">
						<select name="lid" id="lid" lay-verify="lid">
							<?php foreach ($level as $num => $once){?>
								<option value="<?=$once['lid'];?>" <?php if($lid==$once['lid']){echo 'selected="selected"';};?>><?=$once['lname'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>商家标签
				</label>
				<div class="layui-input-inline" style="width: 500px;">
					<?php foreach ($lablelist as $num => $once): ?>
						<input type="checkbox" name="laid[]" lay-skin="primary" title="<?= $once['ltitle'];?>"
							   value="<?= $once['laid'];?>" <?php if(in_array($once['laid'],$laid)){echo 'checked';}?>>
					<?php endforeach; ?>
				</div>
			</div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label" style="width: 30%;">
                    <span class="x-red">*</span>状態
                </label>
                <div class="layui-input-inline" style="width: 500px;">
                    <input type="radio" name="merchants_state" lay-skin="primary" title="开通"
                           value="0" <?php echo $merchants_state == 0 ? 'checked' : '' ?>>
                    <input type="radio" name="merchants_state" lay-skin="primary" title="关闭"
                           value="1" <?php echo $merchants_state== 1 ? 'checked' : '' ?>>
                </div>
            </div>
            <input type="hidden" name="uid" id="uid" value="<?php echo $merchantsid ?>">
			<input type="hidden" name="pwsd" id="pwsd" value="<?php echo $password ?>">
			<input type="hidden" name="mename1" id="mename1" value="<?php echo $mename ?>">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 30%;">
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <span class="x-red">※</span>请确认输入的数据是否正确。
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label" style="width: 30%;">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    确认提交
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form', 'layer'],
        function () {
            var form = layui.form,
                layer = layui.layer;
            //自定义验证规则
            form.verify({
				mename: function (value) {
					if ($('#mename').val() == "") {
						return '请输入商家名称。';
					}
				},
				account: function (value) {
					if ($('#account').val() == "") {
						return '请输入账号。';
					}
				},
				contactname: function (value) {
					if ($('#contactname').val() == "") {
						return '请输入联系人。';
					}
				},
				metel: function (value) {
					if ($('#metel').val() == "") {
						return '请输入联系人电话。';
					}
				},
                rid: function (value) {
                    if ($("#rid option:selected").val() == "") {
                        return '请选择权限。';
                    }
                },
            });

            $("#tab").validate({

                submitHandler: function (form) {
                    $.ajax({
                        cache: true,
                        type: "POST",
                        url: "<?= RUN . '/merchants/merchants_save_edit' ?>",
                        data: $('#tab').serialize(),
                        async: false,
                        error: function (request) {
                            alert("error");
                        },
                        success: function (data) {
                            var data = eval("(" + data + ")");
                            if (data.success) {
                                layer.msg(data.msg);
                                setTimeout(function () {
                                    cancel();
                                }, 2000);
                            } else {
                                layer.msg(data.msg);
                            }
                        }
                    });
                }
            });
        });

    function cancel() {
        //关闭当前frame
        xadmin.close();
    }
</script>
</body>
</html>
