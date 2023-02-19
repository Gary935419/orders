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
              <cite>项目分类管理</cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/statistics/statistics_kehu_list' ?>">
						<!--div class="layui-inline layui-show-xs-block">
							<input type="text" name="gongsi" id="gongsi" value="<?=$yearv;?>"
								   placeholder="年查询" autocomplete="off" class="layui-input">
						</div-->
						<div class="layui-inline layui-show-xs-block">
							<select name="year" id="year">
								<?php foreach ($yearlist as $k => $v): ?>
								<option value="<?=$v;?>" <? if($yearv==$v){echo 'selected';}?>><?=$v;?>年</option>
								<? endforeach;?>
							</select>
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
							<th style="">月份</th>
							<th style="">总项目发布量</th>
							<th style="">以投标量</th>
							<th style="">以签约量</th>
							<th style="">以完成量</th>
							<th style="">异常项目量</th>
							<th style="">取消项目量</th>
							<th style="">查看</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr>
									<td><?= $once['month'];?>月</td>
									<td><?= $once['num1'];?>次</td>
									<td><?= $once['num2']; ?>次</td>
									<td><?= $once['num3'];?>次</td>
									<td><?= $once['num4']; ?>次</td>
									<td><?= $once['num5']; ?>次</td>
									<td><?= $once['num6']; ?>次</td>
									<td><a onclick="changeSrc('<?= RUN . '/statistics/statistics_gongyingshang_list' ?>')">aaaaa</a></td>
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
<script>
	layui.use(['form', 'layer'],
			function () {
				var form = layui.form,
						layer = layui.layer;
			});
</script>