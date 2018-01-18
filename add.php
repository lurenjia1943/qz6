<!DOCTYPE html>
<html>
	<head>
		<title>添加学生</title>
		<meta charset="utf-8">
	</head>
	<body>
		<center>
			<?php include("menu.php"); ?>
			<form action="action.php" method="post">
				学号：<input type="" name="Sid"><br><br>
				姓名：<input type="" name="Sname"><br><br>
				年龄：<input type="" name="Sage"><br><br>
				性别：<input type="radio" name="Ssex" value="男">男<input type="radio" name="Ssex" value="女">女<br><br>
				<input type="submit" name=""> | <input type="reset" name="">
				<input type="hidden" name="a" value="add">
			</form>
		</center>	
	</body>
</html>