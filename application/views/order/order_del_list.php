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
              <cite>取消订单管理</cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/order/order_list/'.$sort ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="gongsi" id="gongsi" value="<?php echo $gongsiv ?>"
								   placeholder="采购商品名" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="开始日期" value="<?php echo $start; ?>" name="start" id="start"></div>
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="截止日期" value="<?php echo $end; ?>" name="end" id="end"></div>
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
							<th style="width: 3%">序号</th>
							<th style="width: 7%">发布时间</th>
							<th style="width: 7%">订单状态</th>
							<th style="width: 7%">采购商品名称</th>
							<th style="width: 10%">所属分类</th>
							<th style="width: 15%">发布公司</th>
							<th style="width: 5%">采购数量</th>
							<th style="width: 7%">截止时间</th>
							<th style="width: 13%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['prid'] ?>" sid="<?= $once['prid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?=date("Y-m-d",$once['add_time']) ?></td>
									<td style="color: #CC0000">取消订单</td>
									<td><?= $once['product_name'] ?></td>
									<td><?= $once['proclassname'] ?></td>
									<td><?= $once['prouser'] ?></td>
									<td><?= $once['quantity_purchased'] ?>件</td>
									<td <? if($once['endtimetype']){echo 'style="color: #CC0000"';};?> ><?=date("Y-m-d",$once['end_time']) ?></td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('编辑','<?= RUN . '/order/order_edit?id=' ?>'+<?= $once['prid'] ?>,900,800)">
											<i class="layui-icon">&#xe642;</i>编辑
										</button>
										<button class="layui-btn layui-card-header"
												onclick="order_update('<?= $once['prid'] ?>')"><i class="layui-icon">&#xe60e;</i>恢复订单
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
	layui.use(['laydate', 'form'],
			function() {
				var laydate = layui.laydate;
				//执行一个laydate实例
				laydate.render({
					elem: '#start' //指定元素
				});
				//执行一个laydate实例
				laydate.render({
					elem: '#end' //指定元素
				});
			});
</script>
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
