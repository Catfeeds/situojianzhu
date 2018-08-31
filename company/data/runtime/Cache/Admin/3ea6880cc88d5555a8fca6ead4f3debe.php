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

	<link href="/company/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/company/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/company/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/company/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
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
	<link rel="stylesheet" href="/company/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/company/",
	    WEB_ROOT: "/company/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/company/public/js/jquery.js"></script>
    <script src="/company/public/js/wind.js"></script>
    <script src="/company/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
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
.row-fluid{
	display:none;position: fixed;  top: 20%;border-radius: 3px;  left: 28%; width: 44%; overflow:hidden; overflow-y: auto;  padding: 8px;  border: 1px solid #E8E9F7;  background-color: white;  z-index:10003;
}
#bg{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}
.row-fluid2{
	display:none;position: fixed;  top: 20%;border-radius: 3px;  left: 28%; width: 44%; overflow:hidden; overflow-y: auto;  padding: 8px;  border: 1px solid #E8E9F7;  background-color: white;  z-index:10003;
}
#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}

.table tr th,.table tr td{
	text-align: center;
}
#isfileupload{margin-top: 10px;}
</style>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;">效果图阶段</a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('Casescheme/index');?>">	
			项目： 
			<select name="project_id" style="width: 150px;" onchange="dochangetype(this.value)">
                <?php if(count($project) != 0): if(is_array($project)): $i = 0; $__LIST__ = $project;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["id"]); ?>" <?php if($formget['project_id'] == $va['id']): ?>selected<?php endif; ?>><?php echo ($va["project_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php else: ?>
				<option>暂未分配项目</option><?php endif; ?> 	                         
            </select>
		</form>
		<ul class="nav nav-tabs pointUl">
			<li><a href="<?php echo U('Casescheme/index',array('project_id'=>$info['id']));?>">沟通记录文件确认<?php if($e1count > 0): ?><span class="pointred">.</span><?php endif; ?></a></li>
			<li class="active"><a href="<?php echo U('Casescheme/indexlist',array('project_id'=>$info['id']));?>">项目风格选选中</a></li>
			<li><a href="<?php echo U('Casescheme/allzylist',array('project_id'=>$info['id']));?>">效果图方案确认<?php if($ecount > 0): ?><span class="pointred">.</span><?php endif; ?></a></li>
		</ul>
		<form class="form-horizontal" id="tagforms" method="post" enctype="multipart/form-data">
		<fieldset>
			<div class="control-group" style="margin-bottom: 0px;">
					<label class="control-label">项目名称：</label>
					<div class="controls" style="margin-top: 5px;">
						<label><?php echo ($info["project_name"]); ?></label>
					</div>
			</div>
			<div class="control-group" style="margin-bottom: 0px;">
					<label class="control-label">项目编号：</label>
					<div class="controls" style="margin-top: 5px;">
						<label><?php echo ($info["project_no"]); ?></label>
					</div>
			</div>
			<div class="control-group" style="margin-bottom: 0px;">
					<label class="control-label" style="margin-left: 30px;">方案师基本信息</label>
			</div>
			<table class="table table-hover table-bordered" style="width: 800px;margin-left:90px;">
				<thead>
					<tr>
						<th style="text-align: center;">姓名</th>
						<th style="text-align: center;">联系方式</th>
						<th style="text-align: center;">职务</th>
						<th style="text-align: center;">qq号</th>
						<th style="text-align: center;">微信号</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="text-align: center;"><?php echo ($fanganer["user_name"]); ?></td>
						<td style="text-align: center;"><?php echo ($fanganer["mobile"]); ?></td>
						<td style="text-align: center;"><?php echo ($fanganer["user_duty"]); ?></td>
						<td style="text-align: center;"><?php echo ($fanganer["qq_no"]); ?></td>
						<td style="text-align: center;"><?php echo ($fanganer["wx_no"]); ?></td>
					</tr>
				</tbody>
			</table>
			<div class="control-group" style="margin-bottom: 0px;">
					<label class="control-label" style="margin-left: 15px;">项目风格选中</label>
					<span style="margin-left: 20px;position: absolute;margin-top: 4px;color:#ccc">注：点击选中，选择您认可的项目风格；您也可以通过“上传沟通记录文件”上传您喜欢的风格图片给方案师</span>
			</div>
			<table class="table table-hover table-bordered" style="width: 800px;margin-left:90px;">
				<thead>
					<tr>
						<th style="text-align: center;min-width: 80px;">上传时间</th>						
						<th style="text-align: center;min-width: 120px;">文件名</th>
						<th style="text-align: center;min-width: 80px;">上传人姓名</th>
						<th style="text-align: center;min-width: 80px;">状态</th>
						<th style="text-align: center;">操作</th>
					</tr>
				</thead>
				<tbody id="messagelist">
					<?php if(is_array($files)): $i = 0; $__LIST__ = $files;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>						
						<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$val["create_time"])); ?></td>
						<td style="text-align: center;"><?php echo ($val["file_name"]); ?></td>
						<td style="text-align: center;"><?php echo ($val["user_name"]); ?></td>
						<td style="text-align: center;">
							<?php if($val['status'] == 0): ?><span style="color:red">未选择</span>	
							<?php else: ?>	<span>选中</span><?php endif; ?>
							</td>
						<td style="text-align: center;">						
						<a href="<?php echo U('Admin/Casescheme/downloadfgfileaaa',array('id'=>$val['id']));?>" class="btn" style="background:#1abc9c">下载</a>	
						<?php if($val['status'] == 0): ?><a href="javascript:;" class="btn" onclick="show_div2('<?php echo ($val["id"]); ?>')" style="background:#1abc9c">选中</a><?php endif; ?>					
						<?php if($val['status'] == 1): ?><a href="javascript:;" onclick="show_div('<?php echo ($val["id"]); ?>');" class="btn" style="background:#1abc9c">我的反馈</a><?php endif; ?>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div class="pagination" style="margin-left: 90px;"><?php echo ($page); ?></div>
			</fieldset>
			</form>
			<form class="form-horizontal" name="tagforms3" method="post" enctype="multipart/form-data" action="<?php echo U('Casescheme/indexlist');?>">
			<fieldset>	
			<div class="row-fluid2" style="display: none">
				<div style="margin-top:70px;margin-left:40px;margin-bottom: 5px">
					<center style="margin-bottom: 50px;">是否确认选中？</center>
					<input type="hidden" name="solution_id" id="solution_id">
					<input type="hidden" id="project_id" name="project_id" value="<?php echo ($project_id); ?>">
						
					<table id="isfileupload">
						<th style="margin-left:300px">
							<td style="text-align: right;width: 300px">上传意见文件：</td>
							<td style="width: 300px">
									<input type="file" name="filename" id="uploadfile" value="">
							</td>
						</th>
					</table>					
				</div>
				<div style="text-align: center;color:red;" id="contenterror"></div>
				<div style="height: 50px;border-bottom: 1px solid #ccc;"></div>
				<div style="text-align: center;margin-top: 10px;">
					<a href="javascript:;" class="btn btn-primary" onclick="close_div2()">取消</a>&nbsp;&nbsp;&nbsp;
					<a href="javascript:;" class="btn btn-primary" onclick="eachSelect()">确认</a>
				</div>
			</div>
			</fieldset>
			</form>					
			<div class="row-fluid" style="display: none">
				<div style="overflow: hidden;"><span style="float: right;float: right;background: #1dccaa;border-radius: 50%;width: 20px;height: 20px;line-height: 18px;text-align: center;color: white;" onclick="close_div();">x</span></div>
				<div style="margin-top: 10px;width: 85%;margin: 0 auto;">					
					<div id="messagecontent" style="max-height: 400px;overflow-y:scroll;height: 200px;border:1px solid #ccc;padding:20px;border-radius:5px;">						
					</div>
				</div>
				<div style="margin-top:10px;text-align:center" id="filedata">					
					<div id="messagefile">文件名：<span id="filename"></span><a class="btn" id="downurl" href="" style="margin-left: 20px;background: #1abc9c">下载</a>						
					</div>
				</div>
			</div>
		
		
	</div>
	<div id="bg" onclick="close_div()"></div>
	<div id="bg2" onclick="close_div2()"></div>
	<script src="/company/public/js/common.js"></script>	
	<script type="text/javascript">
	function close_div() {
        $('.row-fluid').css('display','none');
        $('#bg').css('display','none');
    }
    function close_div2() {
		$("#uploadfile").val('');
        $('.row-fluid2').css('display','none');
        $('#bg2').css('display','none');
    }
    function show_div(id) {
        $("#bg").css('display','block');
        $('#qg_check').css('display','none');
        $('.row-fluid').css('display','block');
        $.ajax({
        	url:"<?php echo U('Admin/Casescheme/getfenggemesage');?>",
        	data:{id:id},
        	type:'post',
        	success:function (data) {  
        		$("#filedata").show();      		
        		$("#messagecontent").html(data.html);
        		if(data.urldata!=null)
        		{
        			$("#filename").html(data.filename);
        			$("#downurl").attr('href',data.url);
        		}else{
        			$("#filedata").hide();
        		}        		
        	}
        })
    }
    function show_div2(id) {
     	$("#solution_id").val(id);
        $("#bg2").css('display','block');
        $('.row-fluid2').css('display','block');
    }
	function  dochangetype(val)
	{
		location.href = '<?php echo U("Casescheme/index");?>'+'&project_id='+val;
	}
	function eachSelect(){   
		document.tagforms3.submit();		
    }
	</script>
</body>
</html>