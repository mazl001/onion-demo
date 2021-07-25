<!DOCTYPE html>
<html>
<head>
	<title>演示: CRSF 保护</title>
</head>
<body>

<meta charset="utf-8">
<form action="" method="post">
	昵称：<input type="text" name="user" id="user">
	<input type="hidden" name="_token" value="{{ $_token }}">
	<input type="submit" name="submit" value="提交">
</form>

</body>
</html>