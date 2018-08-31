<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
		.pointUl>li{position: relative;}
		.pointred{
			position: absolute;
			right: 10px;
			top:-20px;
			color: red;
		    font-size: 60px;
		    position: absolute;
		}
		.form-search select{height: 36px;}
		#messagecontent::-webkit-scrollbar {display:none}
		
</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/",
	    WEB_ROOT: "/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	
	</style><?php endif; ?>
</head>
<style>
	input[type="text"],input[type="number"]{padding:3.5px 6px;}

	.row-fluid{
		display:none;position: fixed;  top: 20%;border-radius: 3px;  left: 28%; width: 30%; overflow:hidden; overflow-y: auto;  padding: 8px;  border: 1px solid #E8E9F7;  background-color: white;  z-index:10003;
	}
	.row-fluid-edit{
		display:none;position: fixed;  top: 20%;border-radius: 3px;  left: 28%; width: 30%; overflow:hidden; overflow-y: auto;  padding: 8px;  border: 1px solid #E8E9F7;  background-color: white;  z-index:10003;
	}
	#bg{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}
	#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}

	.table tr th,.table tr td{
		text-align: center;
	}
	.add-btn{
		margin-left: 22px;
	}
	#addmessage{text-align:center;color:red;}
	#editmessage{text-align:center;color:red;}
</style>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('Company/index');?>">公司管理</a></li>
		</ul>
		<form class="form-horizontal">
			<div class="controls">
				<a onclick="show_add()">
					<span class="btn" style="margin-left: -180px;background:#3b97d7;width: 80px;height: 25px;border-radius: 6px;margin-bottom: 10px;">添加</span>
				</a>
			</div>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th style="text-align: center;">公司名称</th>
						<th style="text-align: center;">创建时间</th>
						<th style="text-align: center;">登录账号</th>
						<th style="text-align: center;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($company)): foreach($company as $key=>$vo): ?><tr>
							<td style="text-align: center;"><?php echo ($vo["company_name"]); ?></td>
							<td style="text-align: center;"><?= date('Y-m-d H:i:s',$vo['create_time'])?></td>
							<td style="text-align: center;"><?php echo ($vo["user_login"]); ?></td>
							<td style="text-align: center;">
								<a onclick="show_edit('<?php echo ($vo["id"]); ?>')"  class="btn btn-primary" style="padding: 2px 15px;color: white;background-color: #1dccaa;">编辑</a>
								<a onclick="delete_post('<?php echo ($vo["id"]); ?>')"  class="btn btn-primary" style="padding: 2px 15px;color: white;background-color: #990000;">删除</a>
							</td>
						</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
			<div class="pagination"><?php echo ($page); ?></div>
			<div class="control-group" id="category-list">
				<div class="row-fluid" id="company_add" style="display: none">
					<div style="margin-top:70px;margin-left:40px;margin-bottom: 5px">
						<div style="margin-bottom: 30px">
							<tr>
								<td>公司名称：</td>
								<td>
									<input type="text" name="company_name" value="" maxlength='30' id="company_name" placeholder="不超过三十个字" style="width: 240px"/>
								</td>
							</tr>
						</div>
						<div style="margin-bottom: 30px">
							<tr>
								<td>登录账号：</td>
								<td>
									<input type="text" name="user_login" value="" id="user_login" maxlength='20' placeholder="6~20位数字或字母" style="width: 240px"/>
								</td>
							</tr>
						</div>
						<div style="margin-bottom: 30px">
							<tr>
								<td>登录密码：</td>
								<td>
									<input type="password" name="user_pass" value="" id="user_pass" maxlength='20' placeholder="6~20位数字或字母" style="width: 240px"/>
								</td>
							</tr>
						</div>					
					</div>
					<div id="addmessage" style="display:none;"></div>
					<div style="height: 50px;border-bottom: 1px solid #ccc;"></div>
					<div style="text-align: center;margin-top: 10px;">
						<a href="javascript:;" class="btn btn-primary" onclick="close_div2()">取消</a>&nbsp;&nbsp;&nbsp;
						<a href="javascript:;" class="btn btn-primary" onclick="add_post()">确认</a>
					</div>
					<div class="row" id="page-info">
					</div>
				</div>

				<div class="row-fluid-edit" id="company_edit" style="display: none">
					<div style="margin-top:70px;margin-left:40px;margin-bottom: 5px">
						<div style="margin-bottom: 30px">
							<tr>
								<td>公司名称：</td>
								<td>
									<input type="text" name="company_name" value="" maxlength='30' id="edit_company_name" placeholder="不超过三十个字" style="width: 240px"/>
								</td>
							</tr>
						</div>
						<div style="margin-bottom: 30px">
							<tr>
								<td>登录账号：</td>
								<td>
									<input type="text" name="user_login" value="" id="edit_user_login" maxlength='20' placeholder="6~20位数字或字母" style="width: 240px"/>
								</td>
							</tr>
						</div>
						<div style="margin-bottom: 30px">
							<tr>
								<td>登录密码：</td>
								<td>
									<input type="password" name="user_pass" value="" id="edit_user_pass" maxlength='20' placeholder="6~20位数字或字母" style="width: 240px"/>
								</td>
							</tr>
						</div>
						<input type="hidden" id="edit_company_id" value="">
						<input type="hidden" id="olduser_pass" value="">
					</div>
					<div id="editmessage" style="display:none;"></div>
					<div style="height: 50px;border-bottom: 1px solid #ccc;"></div>
					<div style="text-align: center;margin-top: 10px;">
						<a href="javascript:;" class="btn btn-primary" onclick="close_div()">取消</a>&nbsp;&nbsp;&nbsp;
						<a href="javascript:;" class="btn btn-primary" onclick="edit_post()">确认</a>
					</div>
					<div class="row">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div id="bg" onclick="close_div()"></div>
	<div id="bg2" onclick="close_div2()"></div>
<script src="/public/js/common.js"></script>
<script src="/public/js/artDialog/artDialog.js"></script>
<script type="text/javascript">
	var istap=0;
    function close_div() {
		
		$("#editmessage").hide();        
        $('.row-fluid-edit').css('display','none');
        $('#bg').css('display','none');
    }
	function close_div2() {
		$("#company_name").val('');
		$("#user_login").val('');
		$("#user_pass").val('');
		$("#addmessage").hide();		
        $('.row-fluid').css('display','none');       
        $('#bg2').css('display','none');
    }
    function show_add() {
        $("#bg2").css('display','block');
        $('#company_add').css('display','block');
    }

    function add_post(){   
		if(istap==1){return;}
        var company_name = $('#company_name').val();
        var user_login = $('#user_login').val();
        var user_pass = $('#user_pass').val();
		if(company_name == '' || user_login=='' || user_pass=='')
		{			
			$("#addmessage").show();
            $("#addmessage").html('请输入完整信息');
			istap=1;
			setTimeout(function(){
				$("#addmessage").hide();
				istap=0;
			},2000)
		}else{
			$.ajax({
				url: "<?php echo U('Company/add');?>",
				type: 'POST',
				data: {company_name:company_name,user_login:user_login,user_pass:user_pass},
				dataType:"json",
				success:function (res) {
					if(res.status == 0){ 
						close_div2();
						$.dialog({id:'popup',lock:true,icon:"succeed", content: res.msg, time: 200});
						location.href='<?php echo U("Company/index");?>';                    
					} else {
						$("#addmessage").show();
						$("#addmessage").html(res.msg);
						istap=1;
						setTimeout(function(){
							$("#addmessage").hide();
							istap=0;
						},2000)
					}
				}
			});
		}        
	}

    function show_edit(id) {
        $.ajax({
            url: "<?php echo U('Company/edit');?>",
            type: 'POST',
            data: {id:id},
            dataType:"json",
            success:function (res) {
                if(res.status == 0){
                    console.dir(res.data);
                    $("#bg").css('display','block');
                    $('#company_edit').css('display','block');
                    document.getElementById('edit_company_name').value = res.data.company_name;
                    document.getElementById('edit_user_login').value = res.data.user_login;
                    document.getElementById('edit_user_pass').value = res.data.user_pass;
					 document.getElementById('olduser_pass').value = res.data.user_pass;
                    document.getElementById('edit_company_id').value = res.data.id;
                } else {
                    $.dialog({id: 'popup', lock: true,icon:"warning", content: res.msg, time: 2});
                }
            }
        });
    }

    function edit_post(){
		if(istap==1){return;}
        var company_name = $('#edit_company_name').val();
        var user_login = $('#edit_user_login').val();
        var user_pass = $('#edit_user_pass').val();
		var olduser_pass = $('#olduser_pass').val();
        var id = $('#edit_company_id').val();
		if(company_name == '' || user_login=='' || user_pass=='')
		{			
			$("#editmessage").show();
            $("#editmessage").html('请输入完整信息');
			istap=1;
			setTimeout(function(){
				$("#editmessage").hide();
				istap=0;
			},2000)
		}else{
			$.ajax({
				url: "<?php echo U('Company/edit_post');?>",
				type: 'POST',
				data: {company_name:company_name,user_login:user_login,user_pass:user_pass,olduser_pass:olduser_pass,id:id},
				dataType:"json",
				success:function (res) {
					if(res.status == 0){  
						close_div();
						$.dialog({id: 'popup', lock: true,icon:"succeed", content: res.msg, time: 2});
						location.href='<?php echo U("company/index");?>';                    
					} else {
						$("#editmessage").show();
						$("#editmessage").html(res.msg);
						istap=1;
						setTimeout(function(){
							$("#editmessage").hide();
							istap=0;
						},2000)
					}
				}
			});
		}
    }

    function delete_post(id){
         $.dialog({id: 'popup', lock: true,icon:"question", content: "是否确认删除该公司？",cancel: true, ok: function () {
            $.ajax({
                url: "<?php echo U('Company/delete');?>",
                type: 'POST',
                data: {id:id,isdel:1},
                success:function (res) {
                    if(res.status == 0){  
						$.dialog({id: 'popup', lock: true,icon:"succeed", content: res.msg, time: 2});
                        location.href='<?php echo U("Company/index");?>';                        
                    } else {
                        $.dialog({id: 'popup', lock: true,icon:"warning", content: res.msg, time: 2});
                    }
                }
            });
        }})
    }
</script>
</body>
</html>