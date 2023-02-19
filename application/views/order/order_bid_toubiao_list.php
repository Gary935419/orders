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
              <cite>投标企业列表</cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/order/order_toubiao_list/'.$id ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="gongsi" id="gongsi" value="<?php echo $gongsiv ?>"
								   placeholder="投标企业名" autocomplete="off" class="layui-input">
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
							<th>序号</th>
							<th>投标项目</th>
							<th>投标企业名</th>
							<th>投标时间</th>
							<th>投标价格</th>
							<th>是否中标</th>
							<th>联系人</th>
							<th>联系电话</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['prid'] ?>" sid="<?= $once['prid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['product_name'] ?></td>
									<td><?= $once['company_name'] ?></td>
									<td><?= date("Y-m-d",$once['add_time']) ?></td>
									<td><?= $once['bidding_cost'] ?></td>
									<td><?if($once['order_state']==1){echo '已中标';}else{echo '否';};?></td>
									<td><?= $once['bidder'] ?></td>
									<td><?= $once['contact_tel'] ?></td>
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
