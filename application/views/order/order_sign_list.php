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
              <cite><?=$bannername;?></cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/order/order_sign_list/'.$sort ?>">
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
							<th>序号</th>
							<th>订单状态</th>
							<th>采购商品名称</th>
							<th>所属分类</th>
							<th width="80px">签约时间</th>
							<th>发布公司</th>
							<th>签约公司</th>
							<th>订单金额</th>
							<th>交货次数</th>
							<th>交货总量</th>
							<th>操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['prid'] ?>" sid="<?= $once['prid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['sortstr'] ?></td>
									<td><?= $once['product_name'] ?></td>
									<td><?= $once['product_class_name'] ?></td>
									<td><?=date("Y-m-d",$once['product_signtime']) ?></td>
									<td><?= $once['khname'] ?></td>
									<td><?= $once['gysname'] ?></td>
									<td><?= $once['bidding_cost'] ?></td>
									<td><?= $once['signnums'] ?></td>
									<td><?= $once['signsums'] ?></td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('编辑','<?= RUN . '/order/order_show?id=' ?>'+<?= $once['prid'] ?>,900,800)">
											查看订单
										</button>
										<button class="layui-btn layui-btn-header"
												onclick="xadmin.open('详情','<?= RUN . '/order/order_sign_toubiao_list/' ?>'+'<?= $once['prid'] ?>')">
											查看报价单位
										</button>
										<button class="layui-btn layui-btn-header"
												onclick="xadmin.open('发货记录','<?= RUN . '/order/order_sign_send_list/' ?>'+'<?= $once['prid'] ?>')">
											查看发货记录
										</button>
                                        <? if($sort==2){?>
                                        <button class="layui-btn layui-btn-header" style="background-color:red"
                                                onclick="order_sign_error('<?= $once['prid'] ?>')">
                                            订单异常
                                        </button>
                                        <? }?>
										<? if($sort==3){?>
											<button class="layui-btn layui-btn-header"
													onclick="xadmin.open('采购项目评价','<?= RUN . '/order/order_sign_comment/' ?>'+'<?= $once['prid'] ?>',900,600)">
												查看评价
											</button>
										<? }?>
										<? if($sort==4){?>
											<button class="layui-btn layui-btn-header"
													onclick="xadmin.open('采购异常问题','<?= RUN . '/order/order_sign_error/' ?>'+'<?= $once['prid'] ?>',900,600)">
												查看异常
											</button>
										<? }?>
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
	
	 function order_sign_error(id) {
        layer.confirm('您是否确认异常？', {
            title: '温馨提示',
            btn: ['确认', '取消']
            // 按钮
        },
        function (index) {
            $.ajax({
                type: "post",
                data: {
                    "id": id,
                },
                dataType: "json",
                url: "<?= RUN . '/order/order_sign_error' ?>",
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
