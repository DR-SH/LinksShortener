window.onload = function() {

	var buttonGetLink = document.getElementById('buttonGetLink');
	var buttonBack = document.getElementById('buttonBack');

	buttonGetLink.addEventListener('click', addLink);
	buttonBack.addEventListener('click', getBack);

	/**
	 * Adding link to db using ajax post
	 */
	function addLink(){
		var shortLink =  document.getElementById('inputShort');
		var longLink =  document.getElementById('inputLong');
		var short = shortLink.value;
		var long = encodeURIComponent(longLink.value);
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

	/**
	 * Ajax post handling
	 *
	 * @param {string} short
	 * @param {string} long
	 * @param {string} url
	 * @param {function} callback
	 */
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

	/**
	 * Display errors
	 *
	 * @param {array} errors
	 */
	function printErrors(errors) {
		var ul = document.createElement('ul');
		for (var i = 0; i< errors.length; i++){
			ul.innerHTML = ul.innerHTML + '<li>' + errors[i] + '</li>';
		}
		var errDiv = document.getElementById('result');
		errDiv.innerHTML = '';
		errDiv.appendChild(ul);

	}

	/**
	 * Display short link
	 *
	 * @param {string} short
	 * @param {string} long
	 */
	function showResult(short, long)
	{
		var shortLabel = document.createElement('p');
		shortLabel.innerHTML = 'Ваша сгенерированная короткая ссылка:';

		var longLabel = document.createElement('p');
		longLabel.innerHTML = 'Ваша длинная ссылка:';

		var shortLink = document.createElement('a');
		shortLink.href = short;
		shortLink.innerHTML = document.domain + '/' +  short;

		var longLink = document.createElement('a');
		longLink.href = long;
		longLink.innerHTML = long;

		var errDiv = document.getElementById('result');
		document.getElementById('sendForm').style.display = 'none';

		errDiv.innerHTML = '';
		errDiv.appendChild(shortLabel);
		errDiv.appendChild(shortLink);
		errDiv.appendChild(longLabel);
		errDiv.appendChild(longLink);

		buttonBack.style.display = 'block';
	}

	/**
	 * Erase results and return to input
	 */
	function getBack(e) {
		e.target.style.display = 'none';
		document.getElementById('result').innerHTML = '';
		document.getElementById('inputShort').value = '';
		document.getElementById('inputLong').value = '';
		document.getElementById('sendForm').style.display = 'block';
	}
}