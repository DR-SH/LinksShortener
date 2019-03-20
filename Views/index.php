<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Test App</title>

	<link rel="stylesheet" type="text/css" href="Views/css/style.css" />
	<script src="Views/js/main.js"></script>
</head>
<body>

<div id="container">
	<div class="inner">
		<div id="sendForm">
			<p>Что нужно укоротить</p>
			<input type="text" id="inputLong" placeholder="Укажите URL длинной ссылки">
			<input type="text" id="inputShort" placeholder="Здесь можно(но не обязательно) указать короткую ссылку">
			<br>
			<button id="button">Получить короткую ссылку</button>
		</div>
		<div id="result">
		</div>
	</div>
</div>

</body>
</html>