<!doctype html>
<html class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>我的管理后台-爱回收</title>
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
              <cite>订单管理</cite></a>
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
							<th style="width: 5%">序号</th>
							<th style="width: 10%">下单时间</th>
							<th style="width: 10%">商品分类</th>
							<th style="width: 10%">回收量</th>
							<th style="width: 10%">实际回收量</th>
							<th style="width: 10%">误差</th>
							<th style="width: 10%">结算费用</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if (isset($list) && !empty($list)) { ?>
							<?php
							$moneys=0;
							foreach ($list as $num => $once):
								//$moneys=$moneys+$once['og_price'];
								?>
								<tr id="p<?= $once['omid'] ?>" sid="<?= $once['omid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['datetime']; ?></td>
									<td><?= $once['ct_name'] ?></td>
									<td><?= $once['m_weight'] ?></td>
									<td><?= $once['q_weight'] ?></td>
									<td><?= $once['m_weight']-$once['q_weight'] ?></td>
									<td><?= $once['q_weight']*$once['price'] ?></td>
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
			</div>
		</div>
	</div>
</div>
</body>
</html>
