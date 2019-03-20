window.onload = function() {

	var butt = document.getElementById('button');

	butt.addEventListener('click', addLink);

	function addLink(){
		var shortLink =  document.getElementById('inputShort');
		var longLink =  document.getElementById('inputLong');
		var short = shortLink.value;
		var long = longLink.value;
		postAjax(short, long, 'create/', function(){
			var array = JSON.parse(this.responseText);
			if(array.status == 0){
				printErrors(array.errors);
			}
			else if(array.status == 1){
				showResult(array.short, array.long);
			}

		});
	}

	function postAjax(short, long, url, callback) {
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200){
				callback.call(request);
			}
			else{
				//console.log(request.readyState);
			}
		}
		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		request.send('short=' + short + '&long=' + long);
	}


	function printErrors(errors) {
		var ul = document.createElement('ul');
		for (var i = 0; i< errors.length; i++){
			ul.innerHTML = ul.innerHTML + '<li>' + errors[i] + '</li>';
		}
		var errDiv = document.getElementById('result');
		errDiv.innerHTML = '';
		errDiv.appendChild(ul);
	}

	function showResult(short, long)
	{
		var shortLabel = document.createElement('p');
		shortLabel.innerHTML = 'Ваша сгенерированная короткая ссылка:';

		var longLabel = document.createElement('p');
		longLabel.innerHTML = 'Ваша длинная ссылка:';

		shortLink = document.createElement('a');
		shortLink.href = short;
		shortLink.innerHTML = document.domain + '/' +  short;

		var longLink = document.createElement('a');
		longLink.href = long;
		longLink.innerHTML = long;

		var errDiv = document.getElementById('result');

		errDiv.innerHTML = '';
		errDiv.appendChild(shortLabel);
		errDiv.appendChild(shortLink);
		errDiv.appendChild(longLabel);
		errDiv.appendChild(longLink);
	}

}