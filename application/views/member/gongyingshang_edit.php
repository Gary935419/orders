<!DOCTYPE html>
<html class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>我的管理后台</title>
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
<div class="layui-fluid" style="padding-top: 50px;">
	<div class="layui-row">
		<form method="post" class="layui-form" action="" name="basic_validate" id="tab">
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>供应商名称：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="gongsi" name="gongsi" lay-verify="gongsi"
						   autocomplete="off" class="layui-input" value="<?=$gongsi;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>联系人：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="user" name="user" lay-verify="user"
						   autocomplete="off" class="layui-input" value="<?=$user;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>手机号：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="tel" name="tel"
						   autocomplete="off" class="layui-input" value="<?=$tel;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>邮箱：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="mail" name="mail" lay-verify="mail"
						   autocomplete="off" class="layui-input" value="<?=$mail;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>地址：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="address" name="address"
						   autocomplete="off" class="layui-input" value="<?=$address;?>">
				</div>
			</div>
									<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>供应商等级：
				</label>
				<div class="layui-input-inline layui-show-xs-block">
					<div style="width: 610px" class="layui-input-inline layui-show-xs-block">
						<select name="grade" id="grade" lay-verify="sort">
						    <option value="一般供应商" <?php if($grade=='一般供应商'){echo 'selected';}?>>一般供应商</option>
							<option value="优质供应商" <?php if($grade=='优质供应商'){echo 'selected';}?>>优质供应商</option>
							<option value="优选供应商" <?php if($grade=='优选供应商'){echo 'selected';}?>>优选供应商</option>
						</select>
					</div>
				</div>
			</div>
						<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>当前状态：
				</label>
				<div class="layui-input-inline layui-show-xs-block">
					<div style="width: 610px" class="layui-input-inline layui-show-xs-block">
						<select name="status" id="status" lay-verify="sort">
							<option value="0" <?php if($status=='0'){echo 'selected';}?>>普通供应商</option>
							<option value="1" <?php if($status=='1'){echo 'selected';}?>>待审核供应商</option>
							<option value="2" <?php if($status=='2'){echo 'selected';}?>>高级供应商</option>
							<option value="1" <?php if($status=='3'){echo 'selected';}?>>审核未通过供应商</option>
							<option value="4" <?php if($status=='4'){echo 'selected';}?>>暂停使用</option>
						</select>
					</div>
				</div>
			</div>
			<? if($gimg1){?>
    			<div class="layui-form-item">
    				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
    					<span class="x-red"></span>审核信息：
    				</label>
    				<div class="layui-input-inline" style="width: 300px;">
    					<a href='<?php echo $gimg1 ?>' download="<?=$gongsi;?>资料1">
    					    <img class="layui-upload-img" src="<?php echo $gimg1 ?>" style="width: 100px;height: 100px;" id="gimgimg" name="gimgimg">
    					</a>&nbsp;&nbsp;&nbsp;&nbsp;   
    					<? if($gimg2){?>
        					<a href='<?php echo $gimg2 ?>' download="<?=$gongsi;?>资料2">
        					    <img class="layui-upload-img" src="<?php echo $gimg2 ?>" style="width: 100px;height: 100px;" id="gimgimg" name="gimgimg">
        					</a>
    					<? }?>
    				</div>
    			</div>
			<? }?>
			
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>所属分类：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<?php foreach ($list as $num => $once): ?>
					    <div style=" display: flex">
					        <div style="width:100px; padding-top:10px"><?=$once['name']?></div>
					        <div style=" width:100%;">		    
    					        <?php foreach ($list[$num]['pid2list'] as $num2 => $once2): ?>
            					    <input type="checkbox" name="type[]" lay-skin="primary"
            							   title="<?=$once2['product_class_name']?>" value="<?=$once2['pid']?>"
            							   <?php if(in_array($once2['pid'],$type)){echo 'checked';}?>>
        					    <?php endforeach; ?>
                            </div>
					    </div>
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class="layui-form-item">
				<label class="layui-form-label" style="width: 20%;">
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<span class="x-red">※</span>请确认输入的数据是否正确。
				</div>
			</div>
			<input type="hidden" id="id" name="id" value="<?=$id?>">
			<input type="hidden" id="sort" name="sort" value="<?=$sort?>">
			<input type="hidden" id="tels" name="tels" value="<?=$tel?>">
			<div class="layui-form-item">
				<label for="L_repass" class="layui-form-label" style="width: 45%;">
				</label>
				<button class="layui-btn" lay-filter="add" lay-submit="">
					确认提交
				</button>
			</div>
		</form>
	</div>
</div>
<script>
	layui.use('upload', function(){
		var $ = layui.jquery
			,upload = layui.upload;

		//普通图片上传
		var uploadInst = upload.render({
			elem: '#upload1'
			,url: '<?= RUN . '/upload/pushFIle' ?>'
			,before: function(obj){
				//预读本地文件示例，不支持ie8
				obj.preview(function(index, file, result){
					$('#gimgimg').attr('src', result); //图片链接（base64）
					var img = document.getElementById("gimgimg");
					img.style.display="block";
				});
			}
			,done: function(res){
				if(res.code == 200){
					$('#gimg').val(res.src); //图片链接（base64）
					return layer.msg('上传成功');
				}else {
					return layer.msg('上传失败');
				}
			}
			,error: function(){
				//演示失败状态，并实现重传
				var demoText = $('#demoText');
				demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
				demoText.find('.demo-reload').on('click', function(){
					uploadInst.upload();
				});
			}
		});
		//多图片上传
		upload.render({
			elem: '#uploads'
			,url: '<?= RUN . '/upload/pushFIle' ?>'
			,multiple: true
			,before: function(obj){
				//预读本地文件示例，不支持ie8
				var timestamp = (new Date()).valueOf();
				obj.preview(function(index, file, result){
					$('#imgnew').append('<img id="avaterimg'+ timestamp +'" style="width:100px;height:100px;" src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img"><p id="avaterimgp'+ timestamp +'" style="margin-top: -70px;margin-left: -43px;" class="layui-btn layui-btn-xs layui-btn-danger demo-delete" onclick="jusp('+ timestamp +')">删除</p>')
				});
			}
			,done: function(res){
				//上传完毕
				if(res.code == 200){
					var timestamp = (new Date()).valueOf();
					$('#newinp').append('<input type="hidden" name="avater[]" id="avater'+ timestamp +'" value="'+ res.src +'">')
					return layer.msg('上传成功');
				}else {
					return layer.msg('上传失败');
				}
			}
		});
	});
	function jusp(index) {
		$("#avater"+index).remove();
		$("#avaterimg"+index).remove();
		$("#avaterimgp"+index).remove();
	}
</script>
<script>
	layui.use(['form', 'layer'],
		function () {
			var form = layui.form,
				layer = layui.layer;
			//自定义验证规则
			form.verify({
				gongsi: function (value) {
					if ($('#gongsi').val() == "") {
						return '请输入供应商名称';
					}
				},
				user: function (value) {
					if ($('#user').val() == "") {
						return '请输入联系人姓名';
					}
				},
				tel: function (value) {
					if ($('#tel').val() == "") {
						return '请输入联系人手机号（登录账号）';
					}
				},
				address: function (value) {
					if ($('#address').val() == "") {
						return '请输入公司地址';
					}
				},
			});

			$("#tab").validate({
				submitHandler: function (form) {
					$.ajax({
						cache: true,
						type: "POST",
						url: "<?= RUN . '/member/gongyingshang_edit_save' ?>",
						data: $('#tab').serialize(),//
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
