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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/statistics/statistics_show' ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="gongsi" id="gongsi" value="<?=$gongsiv;?>"
								   placeholder="项目名" autocomplete="off" class="layui-input">
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
							<th style="">编号</th>
							<th style="">评价项目</th>
							<th style="">评价人</th>
							<th style="">评价企业</th>
							<th style="">评价时间</th>
							<th style="">评价分数</th>
							<th style="">评价内容</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								  <tr>
								    <td rowspan="2"><?= $num+1;?></td>
                                    <td rowspan="2"><?= $once['proname'];?></td>
                                    <td>客户评价</td>
                                    <td><?= $once['kname'];?></td>
                                    <td><?= $once['ktime'];?></td>
                                    <td><?= $once['knum'];?></td>
                                    <td><?= $once['kdesc'];?></td>
                                  </tr>
                                  <tr>
                                    <td>供应商评价</td>
                                    <td><?= $once['gname'];?></td>
                                    <td><?= $once['gtime'];?></td>
                                    <td><?= $once['gnum'];?></td>
                                    <td><?= $once['gdesc'];?></td>
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
