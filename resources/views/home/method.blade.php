<!DOCTYPE html>
<html>
<head>
	<title>演示: 请求方法伪造</title>
</head>
<body>

<meta charset="utf-8">

<form action="" method="POST">
    请求方法: <input name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ $_token }}">

    <input type="submit" name="submit" value="提交">
</form>

</body>
</html>