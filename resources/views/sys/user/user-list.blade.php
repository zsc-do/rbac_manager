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
    <title>用户列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span class="c-gray en">&gt;</span> 用户列表 <a class="btn  btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <input type="text" class="input-text" style="width:250px" placeholder="输入用户名称" id="userName" name="">
        <button onclick="searchUserList()" type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加用户','/sys/user/userAddPage','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">用户列表</th>
        </tr>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="40">ID</th>
            <th width="100">用户名</th>
            <th width="150">电话</th>
            <th width="100">性别</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody id="users_id">


        </tbody>


    </table>
    <div id="laypage" style="float: right"></div>
</div>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<script type="text/javascript" src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/datatables/1.10.15/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>
<!-- 引入 layui.css -->
<link href="/lib/layui/css/layui.css" rel="stylesheet">

<!-- 引入 layui.js -->
<script src="/lib/layui//layui.js"></script>
<script type="text/javascript">



    function loadUserList(){

        let userName = document.getElementById('userName').value || '';

        $.ajax({
            type:"GET",
            url:"/sys/user/userList?userName=" + userName + "&perPage=" + 5,
            dataType:"JSON",
            success:function(result){//回调函数

                $('#users_id').empty();

                let usersTable = document.getElementById('users_id');

                let users = result.data;
                for (let i = 0; i <users.length; i++) {
                    let tr = document.createElement('tr');
                    tr.setAttribute('class','text-c');



                    tr.innerHTML = `<td><input type="checkbox" value="1" name=""></td>
                    <td>1</td>
                    <td>${users[i].user_name}</td>
                    <td>${users[i].phone}</td>
                    <td>${users[i].gender}</td>
                    <td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('用户编辑','/sys/user/userEditPage','800','500',${users.user_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,${users[i].user_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>`;

                    usersTable.appendChild(tr);

                }


                let laypage = layui.laypage;

                //执行一个laypage实例
                laypage.render({
                    elem: 'laypage' //注意，这里的 test1 是 ID，不用加 # 号
                    ,count: result.total //数据总数，从服务端得到
                    ,limit:result.per_page
                    ,jump: function(obj, first){
                        //obj包含了当前分页的所有参数，比如：
                        console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
                        console.log(obj.limit); //得到每页显示的条数
                        //首次不执行
                        if(!first){
                            //do something

                            $('#users_id').empty();

                            $.ajax({
                                type:"GET",
                                url:"/sys/user/userList?page=" +obj.curr + "&perPage="  + obj.limit +"&userName=" + userName,
                                dataType:"JSON",
                                success:function(result){//回调函数


                                    let usersTable = document.getElementById('users_id');

                                    let users = result.data;
                                    for (let i = 0; i <users.length; i++) {
                                        let tr = document.createElement('tr');
                                        tr.setAttribute('class','text-c');



                                        tr.innerHTML = `<td><input type="checkbox" value="1" name=""></td>
                                <td>1</td>
                                <td>${users[i].user_name}</td>
                                <td>${users[i].phone}</td>
                                <td>${users[i].gender}</td>
                                <td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('用户编辑','/sys/user/userEditPage','800','500',${users.user_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,${users[i].user_id})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>`;

                                        usersTable.appendChild(tr);

                                    }
                                }})
                        }
                    }
                });

            }
        })
    }


    loadUserList();

    function searchUserList(){
        loadUserList();
    }

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
                url: '/sys/user/userRemove?userId=' + id,
                success: function(data){
                    if(data === '没有权限'){
                        layer.msg('没有权限!',{icon:2,time:1000});
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
        layer_show(title,url,w,h);
    }





</script>
</body>
</html>
