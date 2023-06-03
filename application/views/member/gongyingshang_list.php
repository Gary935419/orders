<!doctype html>
<html class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>我的管理后台</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport"
		  content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" href="<?= STA ?>/css/font.css">
	<link rel="stylesheet" href="<?= STA ?>/css/xadmin.css">
	<script src="<?= STA ?>/lib/layui/layui.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?= STA ?>/js/jquery.mini.js"></script>
	<script type="text/javascript" src="<?= STA ?>/js/xadmin.js"></script>
</head>
<body>
<div class="x-nav">
          <span class="layui-breadcrumb">
            <a>
              <cite>供应商管理</cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/member/gongyingshang_list/1/'.$status.'/0' ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="gongsi" id="gongsi" value="<?php echo $gongsiv ?>"
								   placeholder="公司名" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="mobile" id="mobile" value="<?php echo $mobilev ?>"
								   placeholder="联系人账号" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-inline layui-show-xs-block">
							<button class="layui-btn" lay-submit="" lay-filter="sreach"><i
									class="layui-icon">&#xe615;</i></button>
						</div>
					</form>
				</div>
				<? if($status==0){?>
					<button class="layui-btn layui-card-header" style="float: right;margin-top: -40px;margin-right: 20px;"
							onclick="xadmin.open('添加','<?= RUN . '/member/gongyingshang_add/1' ?>',900,800)"><i
							class="layui-icon"></i>添加
					</button>
				<? }?>
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th style="">序号</th>
							<th style="">企业名</th>
							<th style="">联系人</th>
							<th style="">账号(手机号)</th>
							<th style="">地址</th>
							<th style="">所属行业</th>
							<th style="">等级</th>
							<th style="">状态</th>
							<th style="">注册时间</th>
							<th style="">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['mid'] ?>" sid="<?= $once['mid'] ?>">
									<td><?= ($page-1)*10+$num+1 ?></td>
									<td><?= $once['company_name'] ?></td>
									<td><?= $once['truename'] ?></td>
									<td><?= $once['mobile'] ?></td>
									<td><?= $once['company_address'] ?></td>
									<td><?= $once['business_typenames'] ?></td>
									<td><?= $once['grade'] ?></td>
									<?php if ($status == 0) { ?>
										<td style="color: green">注册供应商</td>
									<?php } elseif($status == 1) { ?>
										<td style="color: red">待审核供应商</td>
									<?php } elseif($status == 2) { ?>
										<td style="color: green">高级供应商</td>
									<?php } elseif($status == 3) { ?>
										<td style="color: red">审核未通过</td>
									<?php } elseif($once['company_stop'] == 1) { ?>
										<td style="color: green">停权供应商</td>
									<?php } ?>
									<td><?=date("Y-m-d",$once['add_time']) ?></td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('编辑','<?= RUN . '/member/gongyingshang_edit?id=' ?>'+<?= $once['mid'] ?>,900,500)">
											<i class="layui-icon">&#xe642;</i>编辑
										</button>
										<?php if($once['audit_status']==1){?>
											<button class="layui-btn layui-card-header"
													onclick="gongyingshang_check('<?= $once['mid'] ?>')"><i class="layui-icon">&#xe60e;</i>审核
											</button>
										<?php }?>
										<? if($once['audit_status']==0 || $once['audit_status']==2){?>
											<button class="layui-btn layui-card-header"
												onclick="gongyingshang_stop('<?= $once['mid'] ?>','<?=$once['company_stop'];?>')"><i class="layui-icon">&#xe60e;</i>
												<? if($once['company_stop']==1){echo "恢复";}else{echo "停权";};?>
											</button>
										<? }?>
										<button class="layui-btn layui-btn-danger"
												onclick="gongyingshang_delete('<?= $once['mid'] ?>')"><i class="layui-icon">&#xe640;</i>删除
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php } else { ?>
							<tr>
								<td colspan="6" style="text-align: center;">暂无数据</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="layui-card-body ">
					<div class="page">
						<?= $pagehtml ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
</body>
<script>
	function gongyingshang_delete(id) {
		layer.confirm('您是否确认删除？', {
					title: '温馨提示',
					btn: ['确认', '取消']
					// 按钮
				},

			function (index) {
				$.ajax({
					type: "post",
					data: {"id": id},
					dataType: "json",
					url: "<?= RUN . '/member/gongyingshang_delete' ?>",
					success: function (data) {
						if (data.success) {
							$("#p" + id).remove();
							layer.alert(data.msg, {
									title: '温馨提示',
									icon: 6,
									btn: ['确认']
								},
							);
						} else {
							layer.alert(data.msg, {
									title: '温馨提示',
									icon: 5,
									btn: ['确认']
								},
							);
						}
					},
				});
			});
	}

	function gongyingshang_stop(id,stop) {
		layer.confirm('您是否确认修改使用权限？', {
					title: '温馨提示',
					btn: ['确认', '取消']
					// 按钮
				},
				function (index) {
					$.ajax({
						type: "post",
						data: {"id": id,
							"stop":stop
						},
						dataType: "json",
						url: "<?= RUN . '/member/gongyingshang_stop' ?>",
						success: function (data) {
							console.log(data);
							if (data.success) {
								$("#p" + id).remove();
								layer.alert(data.msg, {
											title: '温馨提示',
											icon: 6,
											btn: ['确认']
										},
								);
							} else {
								layer.alert(data.msg, {
											title: '温馨提示',
											icon: 5,
											btn: ['确认']
										},
								);
							}
						},
					});
				});
	}

	function gongyingshang_check(id) {


		layer.confirm('供应商是否审核通过', {
					title: '温馨提示',
					btn: ['通过','不通过','取消'],
					shade: false,
					closeBtn: 0
				},

		function (index) {
			$.ajax({
				type: "post",
				data: {"id": id,
				"check":2
				},
				dataType: "json",
				url: "<?= RUN . '/member/gongyingshang_check' ?>",
				success: function (data) {
					if (data.success) {
						$("#p" + id).remove();
						layer.alert(data.msg, {
									title: '温馨提示',
									icon: 6,
									btn: ['确认']
								},
						);
					} else {
						layer.alert(data.msg, {
									title: '温馨提示',
									icon: 5,
									btn: ['确认']
								},
						);
					}
				},
			});
		},
		function (index) {
			$.ajax({
				type: "post",
				data: {"id": id,
					"check":3
				},
				dataType: "json",
				url: "<?= RUN . '/member/gongyingshang_check' ?>",
				success: function (data) {
					if (data.success) {
						$("#p" + id).remove();
						layer.alert(data.msg, {
									title: '温馨提示',
									icon: 6,
									btn: ['确认']
								},
						);
					} else {
						layer.alert(data.msg, {
									title: '温馨提示',
									icon: 5,
									btn: ['确认']
								},
						);
					}
				},
			});
		});
	}

</script>
</html>
