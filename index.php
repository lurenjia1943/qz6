<?php  
	//连接本地的 Redis 服务    
	$redis = new Redis();    
	$redis->connect('127.0.0.1', 6379);
	//从redis里请求数据

	//定义sql语句
	$sql = "select * from student";

	$key = md5($sql);

	$json = $redis->get($key);

	$arr = json_decode($json,true);
	if (!$arr) {
		//导入配置文件
		include("config.php");

		//连接数据库
		$link = mysqli_connect(HOST,USER,PASS) or die("数据库连接失败:".mysqli_connect_error());

		//选择数据库
		mysqli_select_db($link,DBNAME);

		//设置字符集
		mysqli_set_charset($link,"utf8");

		//执行sql语句
		$result = mysqli_query($link,$sql);

		//把结果转换成关联数组
		$arr = mysqli_fetch_all($result,MYSQLI_ASSOC);

		//把结果转换成json格式
		$json = json_encode($arr);

		//写入redis
		$redis->setex($key,0.01,$json);

		//释放结果集
		mysqli_free_result($result);

		//关闭数据库连接
		mysqli_close($link);

		echo "从mysql里拿的数据";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>学生管理系统</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="bootstrap-table-develop/dist/bootstrap-table.css">
	</head>
	<body>
		<div class="container">
			<?php include("menu.php"); ?>
			<div class="btn-group hidden-xs" id="stutar" role="group">
                <button type="button" class="btn btn-outline btn-default">
                    <a class="glyphicon glyphicon-plus" aria-hidden="true" href="form_basic.html#modal-form" data-toggle="modal" style="color: black">新增</a>
                </button>
                <button type="button" class="btn btn-outline btn-default">
                    <i class="glyphicon glyphicon-pencil edit" aria-hidden="true">修改</i>
                </button>
                <button type="button" class="btn btn-outline btn-default">
                    <i class="glyphicon glyphicon-remove delete" aria-hidden="true">删除</i>
                </button>
            </div>
			<table data-toggle="table" id="stutable">
				<thead>
					<tr>
						<th data-checkbox="true"></th>
						<th>id</th>
						<th data-sortable="true">学号</th>
						<th>姓名</th>
						<th data-sortable="true">年龄</th>
						<th data-sortable="true">性别</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						//循环遍历结果集
						foreach ($arr as $key => $stu) {
							echo "<tr>";
							echo "<td></td><td>{$stu['id']}</td><td>{$stu['Sid']}</td><td>{$stu['Sname']}</td><td>{$stu['Sage']}</td><td>{$stu['Ssex']}</td><td>删除 | 修改</td>";
							echo "</tr>";
						}
					?>
					
				</tbody>
				
			</table>
			<?php  
				
			?>

			
		</div>
		<script type="text/javascript" src="jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="bootstrap-table-develop/dist/bootstrap-table.js"></script>
		<script type="text/javascript" src="bootstrap-table-develop/docs/dist/locale/bootstrap-table-zh-CN.js"></script>
		<script type="text/javascript">
			(function() {
	            $('#stutable').bootstrapTable({
	              search: true,
	              showRefresh: true,
	              showColumns: true,
	              cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
	              pagination: true,                   //是否显示分页（*）
	              iconSize: 'outline',
	              toolbar: '#stutar',
	              singleSelect:true
	            });
	        })()
		</script>
	</body>
</html>