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
					<span class="x-red">*</span>采购项目名称：
				</label>
				<div class="layui-input-inline" style="width: 70%;padding-top: 10px;font-size: 14px"">
				<?=$proname;?>
			</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>供应商评价：
				</label>
				<div class="layui-input-inline" style="width: 70%;padding-top: 10px;font-size: 14px"">
				<?=$gongyingshangname;?>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php for($i=1;$i<=$list['gongyingshang_num'];$i++){ ?>
					<i class="layui-icon">&#xe658;</i>
				<? }?>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>
				</label>
				<div class="layui-input-inline" style="width: 70%;">
						<textarea placeholder="" id="desc" name="desc" class="layui-textarea"
								  lay-verify="jianyi"><?=$list['gongyingshang_desc'];?> / <?=date("Y-m-d",$list['gongyingshang_addtime']);?></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>客户评价：
				</label>
				<div class="layui-input-inline" style="width: 70%;padding-top: 10px;font-size: 14px"">
				<?=$kehuname;?>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php for($i=0;$i<=$list['kehu_num'];$i++){ ?>
					<i class="layui-icon">&#xe658;</i>
				<? }?>
			</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<textarea placeholder="" id="desc" name="desc" class="layui-textarea"
							  lay-verify="jianyi"><?=$list['kehu_desc'];?> / <?=date("Y-m-d",$list['gongyingshang_addtime']);?></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_repass" class="layui-form-label" style="width: 45%;">
				</label>
			</div>
		</form>
	</div>
</div>
</body>
</html>
