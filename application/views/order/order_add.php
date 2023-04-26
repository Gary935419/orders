<!DOCTYPE html>
<html class="x-admin-sm">

<head>
	<meta charset="UTF-8">
	<title>我的管理后台-置业友道</title>
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
<style>
	.textpdf{height: 25px; line-height: 25px;border-style: none; background-color:#f1f1f1; width: 500px};
</style>
<body>
<div class="layui-fluid" style="padding-top: 50px;">
	<div class="layui-row">
		<form method="post" class="layui-form" action="" name="basic_validate" id="tab">
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>采购人：
				</label>
				<div class="layui-input-inline layui-show-xs-block">
					<div style="width:600px;" class="layui-input-inline layui-show-xs-block">
						<select name="username" id="username" lay-verify="username">
							<?php foreach ($userlist as $num => $nlist): ?>
								<option value="<?=$nlist['mid'];?>"><?=$nlist['company_name'];?>-<?=$nlist['truename'];?></option>
							<? endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>采购产品分类：
				</label>
				<div class="layui-input-inline layui-show-xs-block">
					<div style="width:600px;" class="layui-input-inline layui-show-xs-block">
						<select name="proclass" id="proclass" lay-verify="proclass">
							<?php foreach ($proclasslist as $num => $plist): ?>
								<option value="<?=$plist['product_class_name'];?>"><?=$plist['product_class_name'];?></option>
							<? endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>商品名称：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="productname" name="productname" lay-verify="productname"
						   autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>采购数量：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="productnum" name="productnum" lay-verify="productnum"
						   autocomplete="off" class="layui-input" placeholder="0">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>交货时间：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input id="gettime" name="gettime" lay-verify="gettime"
						   autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>报价截止时间：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input id="stoptime" name="stoptime" lay-verify="stoptime"
						   autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>采购地区：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="caddress" name="caddress" value=""
						   autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>交货地址：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="jaddress" name="jaddress" value=""
						   autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red">*</span>指导价：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<input type="text" id="zmoney" name="zmoney" value=""
						   autocomplete="off" class="layui-input" placeholder="0">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>说明文件1（pdf）：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<button type="button" class="layui-btn" id="upload1">上传文件</button> &nbsp;&nbsp;
					<input type="text" readonly id="pdfurl" name="pdfurl" value="" autocomplete="off" class="textpdf" placeholder="文件大小不能超过10M">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>说明文件2（压缩包）：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<button type="button" class="layui-btn" id="upload2">上传文件</button> &nbsp;&nbsp;
					<input type="text" readonly id="pdfurl2" name="pdfurl2" autocomplete="off" class="textpdf" placeholder="文件大小不能超过10M">
				</div>
			</div>
			<!--div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>说明文件3（pdf）：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
					<button type="button" class="layui-btn" id="upload3">上传文件</button> &nbsp;&nbsp;
					<input type="text" readonly id="pdfurl3" name="pdfurl3" autocomplete="off" class="textpdf" placeholder="文件大小不能超过10M">
				</div>
			</div-->
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 20%; font-size: 14px">
					<span class="x-red"></span>备注说明：
				</label>
				<div class="layui-input-inline" style="width: 70%;">
						<textarea placeholder="" id="desc" name="desc" class="layui-textarea"
								  lay-verify="jianyi"></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label" style="width: 20%;">
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<span class="x-red">※</span>请确认输入的数据是否正确。
				</div>
			</div>
			<input type="hidden" id="status" name="status" value="<?=$status;?>">
			<div class="layui-form-item">
				<label for="L_repass" class="layui-form-label" style="width: 45%;">
				</label>
				<button class="layui-btn" lay-filter="add" lay-submit="">
					确认提交
				</button>
			</div>
		</form>
	</div>
</div>
<script>
	layui.use(['laydate', 'form'],
		function() {
			var laydate = layui.laydate;
			//执行一个laydate实例
			laydate.render({
				elem: '#gettime' //指定元素
			});
			laydate.render({
				elem: '#stoptime' //指定元素
			});
		});
</script>
<script>
	layui.use('upload', function(){
		var $ = layui.jquery
				,upload = layui.upload;

		//普通图片上传
		var uploadInst = upload.render({
			elem: '#upload11'
			,url: '<?= RUN . '/upload/pushFIlePdf' ?>'
			,before: function(obj){
				//预读本地文件示例，不支持ie8
				obj.preview(function(index, file, result){

				});
			}
			,done: function(res){
				if(res.code == 200){
					return layer.msg('上传成功');
				}else {
					return layer.msg('上传失败');
				}

			}
			,error: function(){
				//演示失败状态，并实现重传
				var demoText = $('#demoText');
				demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
				demoText.find('.demo-reload').on('click', function(){
					uploadInst.upload();
				});
			}
		});

		//多图片上传
		upload.render({
			elem: '#test2'
			,url: '/upload/'
			,multiple: true
			,before: function(obj){
				//预读本地文件示例，不支持ie8
				obj.preview(function(index, file, result){
					$('#demo2').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
				});
			}
			,done: function(res){
				//上传完毕
			}
		});

		//指定允许上传的文件类型
		upload.render({
			elem: '#test3'
			,url: '/upload/'
			,accept: 'file' //普通文件
			,done: function(res){
				console.log(res)
			}
		});
		upload.render({ //允许上传的文件后缀
			elem: '#upload1'
			,url: '<?= RUN . '/upload/pushFIlePdf' ?>'
			,accept: 'file' //普通文件
			,exts: 'pdf' //只允许上传压缩文件
			,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
				layer.load(); //上传loading
			}
			,done: function(res){
				layer.closeAll('loading'); //关闭loading
				console.log(res)
				if(res.code == 200){
					console.log(res.src)
					$('#pdfurl').val(res.src);
					return layer.msg('上传成功');
				}else {
					return layer.msg('上传失败');
				}
			}
		});
        upload.render({ //允许上传的文件后缀
            elem: '#upload2'
            ,url: '<?= RUN . '/upload/pushFIlePdf' ?>'
            ,accept: 'file' //普通文件
            ,exts: 'rar|zip|7z'  //只允许上传压缩文件
            ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                layer.load(); //上传loading
            }
            ,done: function(res){
                layer.closeAll('loading'); //关闭loading
                console.log(res)
                if(res.code == 200){
                    console.log(res.src)
                    $('#pdfurl2').val(res.src);
                    return layer.msg('上传成功');
                }else {
                    return layer.msg('上传失败');
                }
            }
        });
        upload.render({ //允许上传的文件后缀
            elem: '#upload3'
            ,url: '<?= RUN . '/upload/pushFIlePdf' ?>'
            ,accept: 'file' //普通文件
            ,exts: 'pdf' //只允许上传压缩文件
            ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                layer.load(); //上传loading
            }
            ,done: function(res){
                layer.closeAll('loading'); //关闭loading
                console.log(res)
                if(res.code == 200){
                    console.log(res.src)
                    $('#pdfurl3').val(res.src);
                    return layer.msg('上传成功');
                }else {
                    return layer.msg('上传失败');
                }
            }
        });
		upload.render({
			elem: '#test5'
			,url: '/upload/'
			,accept: 'video' //视频
			,done: function(res){
				console.log(res)
			}
		});
		upload.render({
			elem: '#test6'
			,url: '/upload/'
			,accept: 'audio' //音频
			,done: function(res){
				console.log(res)
			}
		});

		//设定文件大小限制
		upload.render({
			elem: '#test7'
			,url: '/upload/'
			,size: 60 //限制文件大小，单位 KB
			,done: function(res){
				console.log(res)
			}
		});

		//同时绑定多个元素，并将属性设定在元素上
		upload.render({
			elem: '.demoMore'
			,before: function(){
				layer.tips('接口地址：'+ this.url, this.item, {tips: 1});
			}
			,done: function(res, index, upload){
				var item = this.item;
				console.log(item); //获取当前触发上传的元素，layui 2.1.0 新增
			}
		})

		//选完文件后不自动上传
		upload.render({
			elem: '#test8'
			,url: '/upload/'
			,auto: false
			//,multiple: true
			,bindAction: '#test9'
			,done: function(res){
				console.log(res)
			}
		});

		//拖拽上传
		upload.render({
			elem: '#test10'
			,url: '/upload/'
			,done: function(res){
				console.log(res)
			}
		});

		//多文件列表示例
		var demoListView = $('#demoList')
				,uploadListIns = upload.render({
			elem: '#testList'
			,url: '/upload/'
			,accept: 'file'
			,multiple: true
			,auto: false
			,bindAction: '#testListAction'
			,choose: function(obj){
				var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
				//读取本地文件
				obj.preview(function(index, file, result){
					var tr = $(['<tr id="upload-'+ index +'">'
						,'<td>'+ file.name +'</td>'
						,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
						,'<td>等待上传</td>'
						,'<td>'
						,'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
						,'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
						,'</td>'
						,'</tr>'].join(''));

					//单个重传
					tr.find('.demo-reload').on('click', function(){
						obj.upload(index, file);
					});

					//删除
					tr.find('.demo-delete').on('click', function(){
						delete files[index]; //删除对应的文件
						tr.remove();
						uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
					});

					demoListView.append(tr);
				});
			}
			,done: function(res, index, upload){
				if(res.code == 0){ //上传成功
					var tr = demoListView.find('tr#upload-'+ index)
							,tds = tr.children();
					tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
					tds.eq(3).html(''); //清空操作
					return delete this.files[index]; //删除文件队列已经上传成功的文件
				}
				this.error(index, upload);
			}
			,error: function(index, upload){
				var tr = demoListView.find('tr#upload-'+ index)
						,tds = tr.children();
				tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
				tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
			}
		});

		//绑定原始文件域
		upload.render({
			elem: '#test20'
			,url: '/upload/'
			,done: function(res){
				console.log(res)
			}
		});

	});
</script>

<script>
	layui.use(['form', 'layer'],
			function () {
				var form = layui.form,
						layer = layui.layer;
				//自定义验证规则
				form.verify({
					productname: function (value) {
						if ($('#productname').val() == "") {
							return '请输入采购商品名称。';
						}
					},
					productnum: function (value) {
						if ($('#productnum').val() == "") {
							return '请输入采购商品数量。';
						}
					},
					productnum: function (value) {
						var re = /^[0-9]+.?[0-9]*$/;
						var pronum=$('#productnum').val();
						if (!re.test(pronum)){
							return '采购数量只能是数字。';
						}
					},
					stoptime: function (value) {
						if ($('#stoptime').val() == "") {
							return '请选择报价截止时间。';
						}
					},

					gettime: function (value) {
						if ($('#gettime').val() == "") {
							return '请选择交货时间。';
						}
					},
					stoptime: function (value) {
						if ($('#stoptime').val() == "") {
							return '请选择报价截止时间。';
						}
					},
					pdfurl1: function (value) {
						if ($('#pdfurl1').val() == "") {
							return '请上传pdf文件。';
						}
					},
				});

				$("#tab").validate({
					submitHandler: function (form) {
						$.ajax({
							cache: true,
							type: "POST",
							url: "<?= RUN . '/order/order_save' ?>",
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
