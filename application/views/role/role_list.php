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
              <cite>角色管理</cite></a>
          </span>

</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">
					<button class="layui-btn" onclick="xadmin.open('添加','<?= RUN . '/role/role_add' ?>',900,500)"><i
								class="layui-icon"></i>添加
					</button>
				</div>
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th style="width: 10%">序号</th>
							<th style="width: 20%">角色名</th>
							<th style="width: 30%">描述</th>
							<th style="width: 20%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['rid'] ?>" sid="<?= $once['rid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['rname'] ?></td>
									<td><?= $once['rdetails'] ?></td>
									<td class="td-manage">
										<?php if ($once['rid'] != 1) { ?>
											<button class="layui-btn layui-btn-normal"
													onclick="xadmin.open('编辑角色','<?= RUN . '/role/role_edit?rid=' ?>'+<?= $once['rid'] ?>,900,500)">
												<i class="layui-icon">&#xe642;</i>编辑
											</button>
											<button class="layui-btn layui-btn-danger"
													onclick="role_delete('<?= $once['rid'] ?>')"><i class="layui-icon">&#xe640;</i>删除
											</button>
										<?php } ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php } else { ?>
							<tr>
								<td colspan="5" style="text-align: center;">暂无数据</td>
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
	function role_delete(id) {
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
						url: "<?= RUN . '/role/role_delete' ?>",
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
