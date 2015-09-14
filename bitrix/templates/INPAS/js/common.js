$(document).ready(function(){

	$(".ui-select-input .ui-select-value").each(function(){
		var default_value = $(this).attr("data-default");
		$(this).html(default_value);
	})

	$(".ui-select-input .ui-select-value").click(function(){
		$(".ui-select-variants").hide();
		$(this).parents(".ui-select-wrapper").children(".ui-select-variants").slideToggle(150);
	})

	$(".ui-select-variants li").click(function(){
		var val_selected = $(this).attr("data-val");
		var val_text = $(this).html();
		$(this).parents(".ui-select-wrapper").find(".ui-select-value").html(val_text).removeClass("default-value");
		$(this).parents(".ui-select-wrapper").find("input[type=hidden]").val(val_selected);
		$(this).parent().slideUp(150);
	})

	$( "#date-pick-1" ).datepicker({
		showOtherMonths: true,
		onSelect: function(date){
			var dateFrom = $("#date-pick-1").val();
			var dateTo = $("#date-pick-2").val();
			var link = $(this).data('link');
			if(link == undefined) link = "/bitrix/components/yadadya/lastActivity.php";

			$.ajax({
				url: link,
				data: { DATE_FROM: dateFrom, DATE_TO: dateTo }
			}).done(function(res){
				if(link.indexOf('bankdetailwarrantyblock') != -1)
				{
					$("#warrantyBlock").html(res);
				}
				else{
					$("#lastActivityWrapper").html(res);
				}
			});
		},
		beforeShow:function(textbox, instance){
	    	var element = $('#ui-datepicker-div').detach();
	    	$('#bank-periods').append(element);
		}

	});

	$( "#date-pick-2" ).datepicker({
		showOtherMonths: true,
		onSelect: function(date){
			var dateFrom = $("#date-pick-1").val();
			var dateTo = $("#date-pick-2").val();
			var link = $(this).data('link');
			if(link == undefined) link = "/bitrix/components/yadadya/lastActivity.php";
			$.ajax({
				url: link,
				data: { DATE_FROM: dateFrom, DATE_TO: dateTo }
			}).done(function(res){
				if(link.indexOf('bankdetailwarrantyblock') != -1)
				{
					$("#warrantyBlock").html(res);
				}
				else{
					$("#lastActivityWrapper").html(res);
				}
			});
		},
		beforeShow:function(textbox, instance){
	    	var element = $('#ui-datepicker-div').detach();
	    	$('#bank-periods').append(element);
		}
	});

	$(".period-selectors-wrapper .date-clear").click(function(){
		$.ajax({
			url: "/bitrix/components/yadadya/lastActivity.php",
			data: {'DATE_FROM': 'none', "DATE_TO": 'none'}
		}).done(function(res){
			$('#lastActivityWrapper').html(res);
		});
	})

	$("#html").click(function(e){
		if($(e.target).parents(".banks-selector").length==0){
			$(".ui-select-variants").hide();
		}
	})
	$("#bank-1-variants-sel").selectize({allowEmptyOption:true});
	$("#bank-2-variants-sel").selectize({allowEmptyOption:true});
	$("#bank-3-variants-sel").selectize({allowEmptyOption:true});
	$("#bank-4-variants-sel").selectize({allowEmptyOption:true});

     $('.splLink').click(function(){
      $('.splLink').toggleClass('bounce').parent().children('div.splCont').toggle('normal');
      return false;
    });

});

$(function(){

		var fd = new FormData();

		function sendSearchRequest(region, bankname, searchtext, changeableDiv){
			$.ajax({
				url: "/bitrix/components/yadadya/bank_search.php",
				data: { reg: region, bank: bankname, text: searchtext }
			}).done(function(res){
				$('#'+changeableDiv).html(res);
			});
		}
		function sendSearchProductRequest(changeableDiv){
			
			$.ajax({
				url: "/bitrix/components/yadadya/product_search.php",
				type: 'POST',
			    data: fd,
			    cache: false,
	            contentType: false,
	            processData: false,
			}).done(function(res){
				$('#'+changeableDiv).html(res);
			});
		}

		$('.letters a').on('click', function(){
			sendSearchRequest('none', 'none', $(this).text(), 'all-banks-table-div');
			return false;
		});

		$('#search.bank-block .blue-btn').on('click', function(){
			var region = $("#bank-2-variants-sel").val();
			var bankname = $("#bank-1-variants-sel").val();
			var searchtext = $('#input-search-1').val();

			sendSearchRequest(region, bankname, searchtext, 'all-banks-table-div');

			return false;
		});

		$('#search.device-block .blue-btn').on('click', function(){
			
			if($('#search.device-block #input-file').val() != ''){

			}

			fd.append("text", $('#input-search-2').val());

			sendSearchProductRequest('all-banks-table-div-device');

			return false;
		});

		$(':file').change(function(){

		    var file = this.files[0];
		    var type = file.type;
		    
		    if(type == "text/plain" || type == "application/vnd.ms-excel" || type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
		    	fd.append('files[]', file, file.name);
		    }
		    else{
		    	alert("Поддерживаются форматы .txt, .csv, .xls, .xlsx");
		    	return;
		    }

		});

	});