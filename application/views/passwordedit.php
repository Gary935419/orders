<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>我的管理后台-爱回收</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <link rel="stylesheet" href="<?= STA ?>/css/font.css">
    <link rel="stylesheet" href="<?= STA ?>/css/xadmin.css">
    <script type="text/javascript" src="<?= STA ?>/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?= STA ?>/js/xadmin.js"></script>
    <script type="text/javascript" src="<?= STA ?>/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?= STA ?>/js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?= STA ?>/js/upload/jquery_form.js"></script>
</head>
<body>
<div class="layui-fluid" style="padding-top: 66px;">
    <div class="layui-row">
        <form method="post" class="layui-form" action="" name="basic_validate" id="tab">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 30%;">
                    <span class="x-red">*</span>旧密码
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="password" id="passold" name="passold" lay-verify="passold"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>请输入旧密码。
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label" style="width: 30%;">
                    <span class="x-red">*</span>新密码
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="password" id="L_pass" name="pass" lay-verify="pass"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>请输入新密码。
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label" style="width: 30%;">
                    <span class="x-red">*</span>请在此输入新密码确认
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="password" id="L_repass" name="repass" lay-verify="repass"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 30%;">
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <span class="x-red">※</span>请确认你输入的密码。
                    <br>
                    <span class="x-red">※</span>请用英文数字混合并且8个以上的文字来设定。
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label" style="width: 30%;">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    确认修改
                </button>
                <button class="layui-btn" onclick="cancel()" lay-filter="cancel">
                    取消
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form', 'layer'],
        function () {
            var form = layui.form,
                layer = layui.layer;
            //自定义验证规则
            form.verify({
                passold: function (value) {
                    if ($('#passold').val() == "") {
                        return '请输入旧密码。';
                    }
                },
                pass: [/([0-9].*[a-zA-Z]|[a-zA-Z].*[0-9])/, '请将密码设置为英文数字混合。'],
                repass: function (value) {
                    if ($('#L_pass').val() != $('#L_repass').val()) {
                        return '“新密码”和“新密码(确认)”不同。';
                    }
                }
            });

            $("#tab").validate({
                submitHandler: function (form) {
                    $.ajax({
                        cache: true,
                        type: "POST",
                        url: "<?= RUN . '/admin/us爱回收assportsave' ?>",
                        data: $('#tab').serialize(),//
                        async: false,
                        error: function (request) {
                            alert("error");
                        },
                        success: function (data) {
                            var data = eval("(" + data + ")");
                            if (data.success) {
                                layer.msg(data.msg);
                                setTimeout(function () {
                                    cancel();
                                }, 2000);
                            } else {
                                layer.msg(data.msg);
                            }
                        }
                    });
                }
            });
        });

    function cancel() {
        //关闭当前frame
        xadmin.close();
    }
</script>
</body>
</html>
