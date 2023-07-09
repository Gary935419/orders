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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/statistics/company_list'?>">
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
			
		
									<td><?=date("Y-m-d",$once['add_time']) ?></td>
									<td class="td-manage">
                                        <a href="#" onclick="xadmin.open('订单详情','<?= RUN . '/statistics/duizhang_list/'.$once['mid'];?>')">对账</a>
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
