<?php  
	//导入配置文件
	include("config.php");

	//连接数据库
	$link = mysqli_connect(HOST,USER,PASS) or die("数据库连接失败:".mysqli_connect_error());

	//选择数据库
	mysqli_select_db($link,DBNAME);

	//设置字符集
	mysqli_set_charset($link,"utf8");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>学生管理系统</title>
		<meta charset="utf-8">
	</head>
	<body>
		<center>
			<?php  
				include("menu.php");
				switch ($_POST['a']){
					case 'add':
						//接受传参
						$Sid = $_POST['Sid'];
						$Sname = $_POST['Sname'];
						$Sage = $_POST['Sage'];
						$Ssex = $_POST['Ssex'];
						//定义sql语句
						$sql = "insert into student values (id,{$Sid},'{$Sname}',{$Sage},'{$Ssex}')";

						if(mysqli_query($link,$sql)){
							echo "<h2>添加成功</h2>";
						}else{
							echo "<h2>添加失败</h2>";
						}

						//关闭数据库连接
						mysqli_close($link);
					break;
					case 'del':
						//删除
						break;
					case 'update':
						//修改
						break;
				}
				
			?>
		</center>	
	</body>
</html>