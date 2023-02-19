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
              <cite>中标企业发货列表</cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th>序号</th>
							<th>发货公司</th>
							<th>发货时间</th>
							<th>发货量</th>
							<th>快递记录</th>
							<th>打款记录</th>
						</tr>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) {
							$snum=0;
							?>
							<?php foreach ($list as $num => $once):
								$snum=$snum+$once['delivery_number'];
								?>
								<tr id="p<?= $once['prid'] ?>" sid="<?= $once['prid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['company_name'] ?></td>
									<td><?= date("Y-m-d",$once['delivery_time']) ?></td>
									<td><?= $once['delivery_number'] ?></td>
									<td><?= $once['express_img'] ?></td>
									<td><?= $once['bank_payment_img'] ?></td>
								</tr>
							<?php endforeach; ?>
							<tr>
								<td colspan="6" style="text-align: center;">合计：<?=$snum;?>件</td>
							</tr>
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
	function order_update(id) {
		layer.confirm('您是否确认恢复订单？', {
				title: '温馨提示',
				btn: ['确认', '取消']
				// 按钮
			},
			function (index) {
				$.ajax({
					type: "post",
					data: {"id": id},
					dataType: "json",
					url: "<?= RUN . '/order/order_del_update' ?>",
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
<?php
