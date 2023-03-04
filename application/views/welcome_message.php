<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" href="<?= STA ?>/css/font.css">
	<link rel="stylesheet" href="<?= STA ?>/css/xadmin.css">
	<link type="text/css" href="<?= STA ?>/css/jquery-ui.css" rel="stylesheet"/>
	<script src="<?= STA ?>/lib/layui/layui.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?= STA ?>/js/jquery.mini.js"></script>
	<script type="text/javascript" src="<?= STA ?>/js/xadmin.js"></script>
</head>
<body>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<blockquote class="layui-elem-quote">欢迎您登录加工来了后台管理系统
					</blockquote>
				</div>
			</div>
		</div>
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">平台用户量：</div>
				<div class="layui-card-body ">
					<ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
						<li class="layui-col-md4">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>入住平台发包方</h3>
								<p>
									<cite><?=$kehunum;?></cite></p>
							</a>
						</li>
						<li class="layui-col-md4">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>入住平台供应商</h3>
								<p>
									<cite><?=$gysnum;?></cite></p>
							</a>
						</li>
												<li class="layui-col-md4">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>当日新注册用户</h3>
								<p>
									<cite><?=$datenum;?></cite></p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">平台任务订单量统计：</div>
				<div class="layui-card-body ">
					<ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
						<li class="layui-col-md4">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>平台需求发布量</h3>
								<p>
									<cite><?=$ordersnum;?></cite></p>
							</a>
						</li>
						<li class="layui-col-md4">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>平台完成订单量</h3>
								<p>
									<cite><?=$orderendnum;?></cite></p>
							</a>
						</li>
												<li class="layui-col-md4">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>当日新发布需求</h3>
								<p>
									<cite><?=$orderdatenum;?></cite></p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">订单分类统计</div>
				<div class="layui-card-body ">
					<ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
						
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>铸造项目数量（发布量/完成量）</h3>
								<p>
									<cite><?=$proclass1;?>/<?=$proclass1end;?></cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>铆焊项目数量（发布量/完成量）</h3>
								<p>
									<cite><?=$proclass2;?>/<?=$proclass2end;?></cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>夹具设计项目数量（发布量/完成量）</h3>
								<p>
									<cite><?=$proclass3;?>/<?=$proclass3end;?></cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>伺服机器人项目数量（发布量/完成量）</h3>
								<p>
									<cite><?=$proclass4;?>/<?=$proclass4end;?></cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>机床设计项目数量（发布量/完成量）</h3>
								<p>
									<cite><?=$proclass5;?>/<?=$proclass5end;?></cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>机器人项目说明（发布量/完成量）</h3>
								<p>
									<cite><?=$proclass6;?>/<?=$proclass6end;?></cite></p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">开发团队</div>
				<div class="layui-card-body ">
					<table class="layui-table">
						<tbody>
						<tr>
							<th>开发者</th>
							<td>大连微服科技有限公司-18698693593</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>
