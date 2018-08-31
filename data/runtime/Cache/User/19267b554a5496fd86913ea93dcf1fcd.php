<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>登录</title>
	    <link rel="stylesheet" href="/public/app/lib/weui/jquery-weui.css" />
	    <link rel="stylesheet" href="/public/app/lib/weui/weui.min.css" />
	    <link rel="stylesheet" href="/public/app/lib/swiper/swiper.min.css" />
	    <link rel="stylesheet" href="/public/app/css/public.css" />
	    <link rel="stylesheet" href="/public/app/css/style.css" />
	    <script type="text/javascript" src="/public/app/lib/jq/jquery-1.10.2.js" ></script>
	    <script type="text/javascript" src="/public/app/lib/weui/jquery-weui.js" ></script>
	    <script type="text/javascript" src="/public/app/js/v.min.js" ></script>
	    <script type="text/javascript" src="/public/app/js/common.js" ></script>
	</head>
	<style>
		body .weui-toast{ min-width:40%}
		input.weui-input{ font-size:1rem; height:2rem;line-height:2rem}
		input.weui-input::-webkit-input-placeholder{ font-size:1rem; line-height:2rem}
		.weui-cells{ margin-top: 7rem;}
		.weui-cells:before{ display: none;}
		.weui-cells .weui-cell{ padding-top: 3rem;}
		.weui-cell:before{ left: 50px;}
		.weui-cells:after{ left: 50px;}
		.getCode{ color: #3179fc; padding-left: 1rem; border-left: 1px solid #eee; font-size:1rem}
		.getCode.active{ color: #999;}
		.loginBtn{ display: inline-block; background: #3179fc; color: #fff; padding: 1rem 4.5rem; text-align: center; border-radius: 50px; box-shadow: 0 2px 10px rgba(49,121,252,.7); margin: 5rem 0; font-size:1rem}
	</style>
	<body>
		<section id="app" class="mainSec">
			<div class="loginBox center">
				<div class="weui-cells">
		            <div class="weui-cell">
		                <div class="weui-cell__hd"><img src="/public/app/img/shoujihao@2x.png" alt="" style="width:25px;margin-right:5px;display:block"></div>
		                <div class="weui-cell__bd" style="padding: 0 1rem;">
		                   <input type="number" pattern="[0-9]*" v-model="mobile" class="weui-input" placeholder="请输入手机号码" />
		                </div>
		            </div>
		            <div class="weui-cell">
		                <div class="weui-cell__hd"><img src="/public/app/img/yanzhengma@2x.png" alt="" style="width:25px;margin-right:5px;display:block"></div>
		                <div class="weui-cell__bd" style="padding: 0 1rem;">
		                    <input type="number" pattern="[0-9]*" v-model="code" class="weui-input" placeholder="请输入验证码" />
		                </div>
		               
		                <button :disabled="!validate" class="weui-cell__ft getCode on active" id="yzCxmAndCxmm" @click="getCode($event);">获取验证码</button>
		            </div>
		        </div>
		        <button id="showTooltips" class="loginBtn" @click="loginFn($event)">登录</button>
			</div>
		</section>
		
	</body>
</html>
<script>
	var app = new Vue({
		el:'#app',
		data:{
			mobile:'',     //电话
			code:'',     //验证码
			bj:0,
			validate:false,
			countdown:60
		},
		methods:{
			getCode:function(evt){
				var self=this;
				if($(evt.target).hasClass("on")){
					$('#yzCxmAndCxmm').attr("disabled","disabled");	
					$.ajax({
							url:"<?php echo U('Api/Mobileverify/send_msg');?>",
							data:{send_address:this.mobile,send_type:1},
							type:'POST',
							success:function(data){	
								$("#yzCxmAndCxmm").removeAttr("disabled"); 					
								if(data.state == 0)
								{
									app.settime(app.countdown);
									$(evt.target).removeClass('on').addClass('active');
								}else
								{
									$.toast(data.error,'text');
								}
							}
					})
			       
			    }
			},
			settime:function(val) {
				var self=this;
				if(this.countdown == 0) {
					$('.getCode').text('获取验证码').addClass('on');
					$('.getCode').removeClass("active");
					this.countdown = 60;
					bj = 0;
					return;
				} else {
					$('.getCode').text(this.countdown + 's后再获取');
					$('.getCode').addClass("active");
					this.countdown--;
				}
				setTimeout(function() {
					settime(val)
				}, 1000)
			},
			loginFn:function(evt){
				var self=this;
				if(self.mobile.length!=11){
					$.toast('请输入合法手机号','text');
					return false;
				}
				if(self.code.length<1){
					$.toast('请输入验证码','text');
					return false;
				}
				//提交信息
				var profileInfo = { 
	                        "mobile" : self.mobile,	                        
	                        "yzcode": self.code	                      
		            };
		        $.ajax({
		        	url:"<?php echo U('User/Login/dologin');?>",
		        	data:profileInfo,
		        	type:'post',
		        	success:function(data)
		        	{
		        		if (data.status==0) {                               
                            //数据提交成功后关闭提示
								setTimeout(function(){								
									$.toast("登录成功",'text',function(){
										setTimeout(function(){
											//跳转会员中心
											location.href=data.url;
										},500);
									})
								},500)
                        }
                        else {
                            //跳转到预定失败界面                           
                            $.toast(data.msg,'text');
                        }
		        	}
		        })
				
			}
		},
		watch : {
	        mobile:function(val) {
	        	var self=this;
	        	if(val.length==11){
					$('.getCode').removeClass('active');
					this.validate = true;
				}
				else{
					$('.getCode').addClass('active');
					this.validate = false;
				}
	        }
	    }
	})
</script>