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
<!--[if IE 6]>
<script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title></title>
</head>
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add" action="/sys/menuAdd">
        {{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" placeholder="" id="adminName" name="menuName">
		</div>
	</div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单url：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="adminName" name="menuUrl">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单名权限标志：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="adminName" name="menuPerms">
            </div>
        </div>


	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单类型：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box" >
				<input  value="M" name="cat" type="radio" id="cat-M" checked>
				<label for="sex-1">目录</label>
			</div>
			<div class="radio-box">
				<input value="C" type="radio" id="cat-C" name="cat">
				<label for="sex-2">菜单</label>
			</div>
            <div class="radio-box">
                <input value="F" type="radio" id="cat-F" name="cat">
                <label for="sex-2">按钮</label>
            </div>
		</div>
	</div>

	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">父菜单：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" id="Pmenu" name="Pmenu" size="1">
                    <option value="0">目录</option>

			</select>
			</span> </div>
	</div>

	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>

<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">



    $('input[type =radio][name= cat]').on('ifChecked', function(event){
        //获取值
        let v = $(event.target).val();

        if (v === 'M'){

            $('#Pmenu').empty();
            let optionMenu = document.createElement('option');
            optionMenu.setAttribute('value','0');
            optionMenu.innerText = '目录';
            Pmenu.appendChild(optionMenu);

        }else if(v === 'C'){

            $('#Pmenu').empty();

            $.ajax({
                type: 'get',
                url: "/sys/menu/getAllML" ,
                success: function(data){


                    let Pmenu = document.getElementById('Pmenu');

                    for (let i = 0; i < data.length; i++) {
                        let optionMenu = document.createElement('option');
                        optionMenu.setAttribute('value',data[i].menu_id);
                        optionMenu.innerText = data[i].menu_name;
                        Pmenu.appendChild(optionMenu);
                    }

                },
            })
        }else if (v === 'F'){
            $('#Pmenu').empty();

            $.ajax({
                type: 'get',
                url: "/sys/menu/getAllCD" ,
                success: function(data){
                    console.log(data);



                    let Pmenu = document.getElementById('Pmenu');

                    for (let i = 0; i < data.length; i++) {
                        let optionMenu = document.createElement('option');
                        optionMenu.setAttribute('value',data[i].menu_id);
                        optionMenu.innerText = data[i].menu_name;
                        Pmenu.appendChild(optionMenu);
                    }

                },
            })
        }
    });

    console.log(1)
    function test(){
        console.log(1)
    }

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
			adminRole:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "/sys/menu/menuAdd" ,
				success: function(data){
					layer.msg('添加成功!',{icon:1,time:1000});
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
</body>
</html>
