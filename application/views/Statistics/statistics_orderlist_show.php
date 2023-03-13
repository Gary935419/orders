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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/statistics/statistics_orderlist_show' ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="gongsi" id="gongsi" value="<?=$gongsiv;?>"
								   placeholder="项目名" autocomplete="off" class="layui-input">
						</div>
						<input type="hidden" id="sort" name="sort" value="<?=$sort?>">
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
							<th style="">项目状态</th>	
							<th style="">发布时间</th>								
							<th style="">项目名称</th>
							<th style="">发布企业</th>
							<th style="">联系人</th>
							<th style="">中标企业</th>
							<th style="">发货数量</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr>
									<td><?= $num+1;?></td>
									<td>
									    <? 
									    if($once['product_sort']==0){echo '以发布';}
									        elseif($once['product_sort']==1){echo '以投标';}
									        elseif($once['product_sort']==2){echo '以签约';}
									        elseif($once['product_sort']==3){echo '以完成';}
									        elseif($once['product_sort']==4){echo '异常订单';}
									   ?>
									</td>
									<td><?=$once['addtime'];?></td>
									<td><?=$once['product_name'];?></td>
									<td><?=$once['company_name'];?></td>
									<td><?=$once['contact_name'];?>-<?=$once['contact_tel'];?></td>
									<td> <? if($once['product_sort']>1){echo $once['gysname'];}?> </td>
									<td> <? if($once['product_sort']>1){echo $once['gysusername'];}?></td>

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

</html>
<script>
	layui.use(['form', 'layer'],
			function () {
				var form = layui.form,
						layer = layui.layer;
			});
</script>
