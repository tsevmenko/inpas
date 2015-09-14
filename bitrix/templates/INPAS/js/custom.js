	jQuery(function() {
	
		$('.input-search-class').keyup(function(){
			var theInput = $('.input-search-class').val();
			var theData = $(this).attr('id');
			if(theInput.length > 0){
				$('.' + theData + ' a').css('visibility', 'hidden');
			}else{
				$('.' + theData + ' a').css('visibility', 'visible');
			}
		});
    
		$('.input-placeholder a').click(function(){
			var theData = $(this).attr('data-id');
			var theValue = $(this).attr('data-value');
			$('.' + theData + ' a').css('visibility', 'hidden');
			$('#' + theData).val(theValue);
		});
		
		$('.input-file-hidden').change(function(){
			var theFile = $(this).val().replace(/.+[\\\/]/, "");
			$('.input-file span').html(theFile);
			if(theFile.length > 0){
				$('.input-file span').css('background','none');
			}else{
				$(".input-file span").css("background","url(images/ico-sprites.png) -15px -714px no-repeat");
				$(".input-file span").html("Выбрать");
			}
		});
	});