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
              <cite>人员管理</cite></a>
          </span>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/users/users_list' ?>">
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="user_name" id="user_name" value="<?php echo $user_name1 ?>"
                                   placeholder="账号" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn" lay-submit="" lay-filter="sreach"><i
                                        class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <button class="layui-btn layui-card-header" style="float: right;margin-top: -40px;margin-right: 20px;"
                        onclick="xadmin.open('添加','<?= RUN . '/users/users_add' ?>',900,500)"><i
                            class="layui-icon"></i>添加
                </button>
                <div class="layui-card-body ">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th style="width: 10%">序号</th>
                            <th style="width: 20%">账号</th>
                            <th style="width: 20%">权限</th>
                            <th style="width: 10%">状态</th>
                            <th style="width: 20%">操作</th>
                        </thead>
                        <tbody>
                        <?php if (isset($list) && !empty($list)) { ?>
                            <?php foreach ($list as $num => $once): ?>
                                <tr id="p<?= $once['id'] ?>" sid="<?= $once['id'] ?>">
                                    <td><?= $num + 1 ?></td>
                                    <td><?= $once['username'] ?></td>
                                    <td><?= $once['rname'] ?></td>
                                    <?php if ($once['userstate'] == 1) { ?>
                                        <td style="color: green">正常</td>
                                    <?php } else { ?>
                                        <td style="color: red">禁用</td>
                                    <?php } ?>
                                    <td class="td-manage">
										<?php if ($once['id'] != 1) { ?>
											<button class="layui-btn layui-btn-normal"
													onclick="xadmin.open('编辑','<?= RUN . '/users/users_edit?id=' ?>'+<?= $once['id'] ?>,900,500)">
												<i class="layui-icon">&#xe642;</i>编辑
											</button>
											<button class="layui-btn layui-btn-danger"
													onclick="users_delete('<?= $once['id'] ?>')"><i class="layui-icon">&#xe640;</i>删除
											</button>
										<?php } ?>
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
    function users_delete(id) {
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
                    url: "<?= RUN . '/users/users_delete' ?>",
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
