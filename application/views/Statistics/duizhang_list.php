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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/statistics/duizhang_list/'.$mid ?>">
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="开始日期" value="<?php echo $sdate; ?>" name="sdate" id="sdate"></div>
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="截止日期" value="<?php echo $edate; ?>" name="edate" id="edate"></div>
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
							<th style="">订单名</th>
							<th style="">订单状态</th>
							<th style="">签约时间</th>
							<th style="">采购数量</th>
							<th style="">总发货量</th>
							<th style="">打款金额</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php 
							$ms=0;
							foreach ($list as $num => $once): 
							    $ms=$ms+$once['gysdks'];
							?>
								<tr id="p<?= $once['mid'] ?>" sid="<?= $once['mid'] ?>">
									<td><?= ($page-1)*10+$num+1 ?></td>
									<td><?= $once['gysname'] ?></td>
									<td><?= $once['product_name'] ?></td>
									<td><? if($once['product_sort']==2){echo '已签约';}else{echo '已完成';};?></td>
									<td><?= $once['product_signtime'] ?></td>
									<td><?= $once['quantity_purchased'] ?></td>
									<td><?= $once['gysfhs'] ?></td>
			                        <td><?= $once['gysdks'] ?></td>
								</tr>
								<tr>
									<td colspan="1">合计：</td>
									<td colspan="7"><?= $ms; ?></td>
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
	layui.use(['laydate', 'form'],
			function() {
				var laydate = layui.laydate;
				//执行一个laydate实例
				laydate.render({
					elem: '#sdate' //指定元素
				});
				//执行一个laydate实例
				laydate.render({
					elem: '#edate' //指定元素
				});
			});
</script>
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
