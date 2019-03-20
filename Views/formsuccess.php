<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
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

	</style>
</head>
<body>

<div id="container">
	<div class="inner">
		<a href="/">На главную</a>
		<p>Короткая ссылка:</p>
		<a href="/<?=$shortLink?>"><?=base_url($shortLink)?></a>

		<p>Введённая длинная ссылка:</p>
		<a href="<?=prep_url($longLink)?>"><?=prep_url($longLink)?></a>
	</div>
</div>

</body>
</html>