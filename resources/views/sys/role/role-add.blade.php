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
<title></title>
</head>
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add" action="/sys/roleAdd">
        {{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" placeholder="" id="roleName" name="roleName">
		</div>
	</div>



        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名备注：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="textarea" class="input-text" value="" placeholder="" id="remark" name="remark">
            </div>
        </div>



	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">选择权限：</label>
		<div class="formControls col-xs-8 col-sm-9">
            <div id="menuTree"></div>
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
<script type="text/javascript">

    let treeMenu = [];
    $.ajax({
        type: 'get',
        url: "/sys/menu/getTreeMenu" ,
        success: function(data){


            for (let i = 0; i < data.length; i++) {
                let MNode = {};
                MNode.title = data[i].menu_name;
                MNode.showCheckbox = true;
                MNode.children = [];
                MNode.id = data[i].menu_id;


                let jdata = data[i].childMenu;


                for (let j = 0; j < jdata.length; j++) {
                    let CNode = {};
                    CNode.title = jdata[j].menu_name;
                    CNode.showCheckbox = true;
                    CNode.children = [];
                    CNode.id = jdata[j].menu_id;


                    let kdata = jdata[j].childMenu;


                    for (let k = 0; k < kdata.length; k++) {
                        let FNode = {};
                        FNode.title = kdata[k].menu_name;
                        FNode.showCheckbox = true;
                        FNode.id = kdata[k].menu_id;

                        CNode.children.push(FNode)
                    }

                    MNode.children.push(CNode)
                }
                treeMenu.push(MNode);


                //console.dir(treeMenu);
                layui.use('tree', function(){
                    let tree = layui.tree;



                    //渲染
                    let inst1 = tree.render({
                        elem: '#menuTree'  //绑定元素
                        ,showCheckbox: true
                        ,data: treeMenu
                        ,id: 'id' //定义索引
                    });
                });



            }
        }

    })



    $('input[type =radio][name= cat]').on('ifChecked', function(event){
        //获取值
        let v = $(event.target).val();

        if (v === 'M'){

            $('#Prole').empty();
            let optionrole = document.createElement('option');
            optionrole.setAttribute('value','0');
            optionrole.innerText = '目录';
            Prole.appendChild(optionrole);

        }else if(v === 'C'){

            $('#Prole').empty();

            $.ajax({
                type: 'get',
                url: "/sys/menu/getAllML" ,
                success: function(data){


                    let Prole = document.getElementById('Prole');

                    for (let i = 0; i < data.length; i++) {
                        let optionrole = document.createElement('option');
                        optionrole.setAttribute('value',data[i].role_id);
                        optionrole.innerText = data[i].role_name;
                        Prole.appendChild(optionrole);
                    }

                },
            })
        }else if (v === 'F'){
            $('#Prole').empty();

            $.ajax({
                type: 'get',
                url: "/sys/menu/getAllCD" ,
                success: function(data){
                    console.log(data);



                    let Prole = document.getElementById('Prole');

                    for (let i = 0; i < data.length; i++) {
                        let optionrole = document.createElement('option');
                        optionrole.setAttribute('value',data[i].role_id);
                        optionrole.innerText = data[i].role_name;
                        Prole.appendChild(optionrole);
                    }

                },
            })
        }
    });



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

            let tree = layui.tree;
            let checkedTree = tree.getChecked('id');

            let checkedMenus = [];

            for (let i = 0; i < checkedTree.length; i++) {
                checkedMenus.push(checkedTree[i].id);

                let MMenu = checkedTree[i].children;

                for (let j = 0; j < MMenu.length; j++) {
                    checkedMenus.push(MMenu[j].id);

                    let FMenu = MMenu[j].children;
                    for (let k = 0; k < FMenu.length; k++) {
                        checkedMenus.push(FMenu[k].id);
                    }
                }
            }

            //console.log(checkedMenus);

            let roleName = document.getElementById('roleName').value;
            let remark = document.getElementById('remark').value;
            let s = JSON.stringify(checkedMenus);

            $(form).ajaxSubmit({
				type: 'post',
				url: "/sys/role/roleAdd" ,
                traditional: true,
                data: {roleName:roleName,remark:remark,checkedMenus:s},
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
