<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
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
    <title>菜单列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 菜单管理 <span class="c-gray en">&gt;</span> 菜单列表 <a class="btn  btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加菜单','/sys/menu/menuAddPage','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加菜单</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
    <table id="tree_table" class="table table-border table-bordered table-bg ">
        <thead>
        <tr>
            <th scope="col" colspan="9">菜单列表</th>
        </tr>
        <tr class="text-c">
            <th width="50">菜单类型</th>
            <th width="150">菜单名</th>
            <th width="150">菜单url</th>
            <th width="150">权限标志</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody id="menus_id">

        </tbody>
    </table>
</div>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<script type="text/javascript" src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/datatables/1.10.15/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>

<link href="https://cdn.bootcdn.net/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/jquery-treetable/3.2.0/jquery.treetable.min.js"></script>
<script type="text/javascript">

    $.ajax({
        type:"GET",
        url:"/sys/menu/getTreeMenu",
        dataType:"JSON",
        success:function(result){//回调函数


            let menusTable = document.getElementById('menus_id');


            for (let i = 0; i <result.length; i++) {
                let tr = document.createElement('tr');
                tr.setAttribute('class', 'text-c');
                tr.setAttribute('data-tt-id', result[i].menu_id);
                tr.setAttribute('data-tt-parent-id', '0');


                tr.innerHTML = `<td>目录</td>
                    <td>${result[i].menu_name}</td>
                    <td>${result[i].menu_url}</td>
                    <td>${result[i].menu_perms}</td>
                    <td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('菜单编辑','/sys/menu/menuEditPage','800','500',${result[i].menu_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,${result[i].menu_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>`;

                menusTable.appendChild(tr);


                result1 = result[i].childMenu;

                for (let i = 0; i < result1.length; i++) {
                    let tr = document.createElement('tr');
                    tr.setAttribute('class', 'text-c');
                    tr.setAttribute('data-tt-id', result1[i].menu_id);
                    tr.setAttribute('data-tt-parent-id', result1[i].parent_id);


                    tr.innerHTML = `<td>菜单</td>
                    <td>${result1[i].menu_name}</td>
                    <td>${result1[i].menu_url}</td>
                    <td>${result1[i].menu_perms}</td>
                    <td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('菜单编辑','/sys/menu/menuEditPage','800','500',${result1[i].menu_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,${result1[i].menu_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>`;

                    menusTable.appendChild(tr);


                    result2 = result1[i].childMenu;
                    for (let i = 0; i < result2.length; i++) {
                        let tr = document.createElement('tr');
                        tr.setAttribute('class', 'text-c');
                        tr.setAttribute('data-tt-id', result2[i].menu_id);
                        tr.setAttribute('data-tt-parent-id', result2[i].parent_id);


                        tr.innerHTML = `<td>按钮</td>
                    <td>${result2[i].menu_name}</td>
                    <td>${result2[i].menu_url}</td>
                    <td>${result2[i].menu_perms}</td>
                    <td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('菜单编辑','/sys/menu/menuEditPage','800','500',${result2[i].menu_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,${result2[i].menu_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>`;

                        menusTable.appendChild(tr);
                    }


                }


            }

            $("#tree_table").treetable({
                expandable: true,
            });

            menusTable.appendChild(top_tr);
        }
    })
    /*
        参数解释：
        title	标题
        url		请求的url
        id		需要操作的数据id
        w		弹出层宽度（缺省调默认值）
        h		弹出层高度（缺省调默认值）
    */
    /*管理员-增加*/
    function admin_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-删除*/
    function admin_del(obj,id){

        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/sys/menu/menuRemove?menuId=' + id,
                success: function(data){

                    if(data === '没有权限'){
                        layer.msg('没有权限!',{icon:2,time:1000});
                        return;
                    }else if(data === '有角色使用该菜单，无法删除！'){
                        layer.msg('有角色使用该菜单，无法删除！',{icon:2,time:1000});
                        return;
                    }

                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*管理员-编辑*/
    function admin_edit(title,url,w,h,par){
        url = url + '?par=' +par;
        console.log(url)
        layer_show(title,url,w,h);
    }





</script>
</body>
</html>
