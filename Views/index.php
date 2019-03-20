<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Test App</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }
	
	#container {
		margin: 30px 10%;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}

	.inner {
		margin: 0 30px;
		padding: 20px 0;
	}
	
	.inner p{
		color: #F00;
	}
	
	#form input{
		width: 100%;
		margin: 10px 0;
		padding: 5px;
	}
	</style>
	<><>
</head>
<body>

<div id="container">
	<div class="inner">
		<form id="form" action="/create" method="post">
			<label for="long">Сокращение ссылок</label>
			<input type="hidden" name="test" value="1">		
			<input type="text" id="long" name="long" placeholder="Укажите URL">		
			<input type="text" id="short" name="short" placeholder="Здесь можно указать короткую ссылку">
			<input type="submit" value="Получить короткую ссылку">
		</form>
	</div>
</div>

</body>
</html>