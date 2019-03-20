$(document).ready(function(){
   $('#click').on('click', function(){
	   //$('.tableJS').append('<tr><td>' + $('form').first().val() + '</td><td>Новый пункт</td></tr>');
		console.log($('#form').children().first().val());
		$('#tableJS').append('<tr><td>' + $('form').children().first().val() + '</td><td>' + $('form').children().last().val() + '</td></tr>');
		$('form').children().first().val('');
		$('form').children().last().val('');
   });  
   
   $('#tableJS').on('click', 'td', function(e){
	   $(this).html(prompt());
   });
});

