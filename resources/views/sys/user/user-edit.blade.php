<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/lib/html5shiv.js"></script>
<script type="text/javascript" src="/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    <!-- 引入 layui.css -->
<!--[if IE 6]>
<script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>添加管理员 - 管理员管理 - H-ui.admin v3.1</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
        {{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" placeholder="" id="userName">
		</div>
	</div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="password">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>电话：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="phone">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box" >
                    <input  value="1" name="gender" type="radio" id="cat-M" checked>
                    <label for="sex-1">男</label>
                </div>
                <div class="radio-box">
                    <input value="0" type="radio" id="cat-C" name="gender">
                    <label for="sex-2">女</label>
                </div>

            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">选择角色：</label>
            <div id="myDlist" class="formControls col-xs-8 col-sm-9 xm-select-1">
            </div>
        </div>





	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>


</article>


<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/messages_zh.js"></script>

<!-- 引入 layui.css -->
<link href="/lib/layui/css/layui.css" rel="stylesheet">

<!-- 引入 layui.js -->
<script src="/lib/layui//layui.js"></script>
<script src="/static/h-ui.admin/js/xm-select.js"></script>
<script type="text/javascript">


    let userId = window.location.href.split('=')[1];
    $.ajax({
        type:'get',
        url: "/sys/user/getUser?userId=" + userId,
        success: function(data){
            let user= data[0];

            let inputs = document.getElementsByTagName('input');

            inputs[1].setAttribute('value',user.user_name);
            inputs[2].setAttribute('value','');
            inputs[3].setAttribute('value',user.phone);

        }
    })


let XmSelect = {};

$.ajax({
    type:'get',
    url: '/sys/role/roleList',
    success: function(data){

        let roles = [];

        for (let i = 0; i < data.length; i++) {
            let role = {};
            role.name = data[i].role_name;
            role.value = data[i].role_id;
            roles.push(role);
        }


        XmSelect = xmSelect.render({
            el: '.xm-select-1',
            repeat: true,
            clickClose: true,
            theme: {
                color: '#1cbbb4',
            },
            data: roles
        })
    }
})







$(function(){


	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

	$("#form-admin-add").validate({
		rules:{
			adminName:{
				required:true,
				minlength:4,
				maxlength:16
			},
			password:{
				required:true,
			},
			password2:{
				required:true,
				equalTo: "#password"
			},
			sex:{
				required:true,
			},
			phone:{
				required:true,
				isPhone:true,
			},
			email:{
				required:true,
				email:true,
			},
			adminuser:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){


            let userName = document.getElementById('userName').value;
            let password = document.getElementById('password').value;
            let phone = document.getElementById('phone').value;

            let gender = $('input:radio[name="gender"]:checked').val();

            let selectedRoles = XmSelect.getValue('valueStr');


            $(form).ajaxSubmit({
				type: 'post',
				url: "/sys/user/userEdit" ,
                traditional: true,
                data: {userId:userId,userName:userName,password,password,phone:phone,gender:gender,selectedRoles:selectedRoles},
				success: function(data){
					layer.msg('修改成功!',{icon:1,time:1000});
					var index = parent.layer.getFrameIndex(window.name);

                    window.parent.location.reload();//刷新父页面
                    parent.layer.close(index);


                },
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!',{icon:1,time:1000});
				}
			});
		}
	});
});
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
