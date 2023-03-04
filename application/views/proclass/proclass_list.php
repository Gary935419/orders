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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/proclass/proclass_list' ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="gongsi" id="gongsi" value=""
								   placeholder="分类名" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-inline layui-show-xs-block">
							<button class="layui-btn" lay-submit="" lay-filter="sreach"><i
										class="layui-icon">&#xe615;</i></button>
						</div>
					</form>
				</div>
				<button class="layui-btn layui-card-header" style="float: right;margin-top: -40px;margin-right: 20px;"
						onclick="xadmin.open('添加','<?= RUN . '/proclass/proclass_add' ?>',900,600)"><i
							class="layui-icon"></i>添加
				</button>
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th style="">序号</th>
							<th style="">分类名称</th>
							<th style="">分类图片</th>
							<th style="">分类说明</th>
							<th style="">供应商</th>
							<th style="">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['pid'] ?>" sid="<?= $once['pid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['product_class_name'] ?></td>
									<td><img class="layui-upload-img" src="<?php echo $once['product_woimg'] ?>" style="height: 50px;" ></td>
									<td><?= $once['product_desc'] ?></td>
									<td><?= $once['gysclass'] ?>家</td>
									<td class="td-manage">
									    <button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('查看供应商','<?= RUN . '/member/gongyingshang_show?id=' ?>'+<?= $once['pid'] ?>)">
											<i class="layui-icon">&#xe615;</i>查看供应商
										</button>
										<button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('编辑','<?= RUN . '/proclass/proclass_edit?id=' ?>'+<?= $once['pid'] ?>,900,600)">
											<i class="layui-icon">&#xe642;</i>编辑
										</button>
										<button class="layui-btn layui-btn-danger"
												onclick="proclass_delete('<?= $once['pid'] ?>')"><i class="layui-icon">&#xe640;</i>删除
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
	function proclass_delete(id) {
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
						url: "<?= RUN . '/proclass/proclass_delete' ?>",
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
