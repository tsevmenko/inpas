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
			if(window.location.href.indexOf('/bank/') != -1 && $("#date-pick-2").val() != ''){
				$.ajax({
					url: "/bitrix/components/yadadya/bankdetailwarrantyblock.php",
					data: { DATE_FROM: $(this).val(), DATE_TO: $("#date-pick-2").val() }
				}).done(function(data){
					$('#warrantyBlock').html(data);
					$('#warrantyBlock').css('opacity', '1');
				});
				//hide warranty block
				$('#warrantyBlock').css('opacity', '0.3');
			}
			if(window.location.pathname == "/" && $("#date-pick-2").val() != ''){
				$.ajax({
					url: "/bitrix/components/yadadya/bankdetailwarrantyblock.php",
					data: { DATE_FROM: $(this).val(), DATE_TO: $("#date-pick-2").val() }
				}).done(function(data){
					$('#warrantyBlock').html(data);
					$('#warrantyBlock').css('opacity', '1');
				});
			}
		},
		beforeShow:function(textbox, instance){
	    	var element = $('#ui-datepicker-div').detach();
	    	$('#bank-periods').append(element);
		}
		
	});

	$( "#date-pick-2" ).datepicker({
		showOtherMonths: true,
		onSelect: function(date){
			if(window.location.href.indexOf('/bank/') != -1 && $("#date-pick-1").val() != ''){
				$.ajax({
					url: "/bitrix/components/yadadya/bankdetailwarrantyblock.php",
					data: { DATE_FROM: $(this).val(), DATE_TO: $("#date-pick-1").val() }
				}).done(function(data){
					$('#warrantyBlock').html(data);
					$('#warrantyBlock').css('opacity', '1');
				});
				//hide warranty block
				$('#warrantyBlock').css('opacity', '0.3');
			}
			if(window.location.pathname == "/" && $("#date-pick-2").val() != ''){
				$.ajax({
					url: "/bitrix/components/yadadya/bankdetailwarrantyblock.php",
					data: { DATE_FROM: $(this).val(), DATE_TO: $("#date-pick-1").val() }
				}).done(function(data){
					$('#warrantyBlock').html(data);
					$('#warrantyBlock').css('opacity', '1');
				});
			}
		},
		beforeShow:function(textbox, instance){
	    	var element = $('#ui-datepicker-div').detach();
	    	$('#bank-periods').append(element);
		}
	});

	$(".period-selectors-wrapper .date-clear").click(function(){
		$("#date-pick-1").val("28.06.2015");
		$("#date-pick-2").val("28.06.2015");
	})

	$("#html").click(function(e){
		if($(e.target).parents(".banks-selector").length==0){
			$(".ui-select-variants").hide();
		}
	})
	
    
     $('.splLink').click(function(){
      $('.splLink').toggleClass('bounce').parent().children('div.splCont').toggle('normal');
      return false;
    });


    //-----
    $("body").on("click", ".alert .alert-close", function(){
    	var alert_html = $(this).closest(".alert")
    	$(alert_html).fadeOut("slow", function(){
    		$(alert_html).remove()
    	})
    })

    $("#bank-1-variants-sel").selectize({
    	allowEmptyOption:true,
    	maxOptions: 10000000,
    	onChange: function(value) {
    		sss2[0].selectize.destroy();
    		$(sss2[0]).selectize({
				allowEmptyOption:true,
				maxOptions: 10000000,
				onChange: function(value) {
		    		/*var model = $sel_model[0].selectize
		    		if (value.length > 0) {
		    			model.enable()
		    		} else {
		    			model.disable()
		    			model.setValue("")
		    		}*/
				},
		    	delimiter: ';',
			    labelField: "label",
			    valueField: "value",
			    searchField: "label",
		    	render: {
			        option: function(data, escape) {

			        	if(jQuery.inArray(data.value, borel[borel['selected']]) !== -1) return '<div data-value="'+data.value+'" data-selectable class="option">'+data.label+'</div>';
			        	
			        	return '';
					}
				},
				onDropdownOpen: function($dropdown){
				}
			});

			$('.officeBlock .selectize-input.items.full.has-options.has-items').css('height', '45px')
    		borel['selected'] = value;
    		/*var phil = $sel_phil[0].selectize;
    		var model = $sel_model[0].selectize;

    		if (value.length > 0) {
    			phil.enable();
    		} else {
    			phil.disable();
    			phil.setValue("");
    			model.disable();
    			model.setValue("");
    		}*/
    
    	},
    	delimiter: ';',
	    labelField: "label",
	    valueField: "value",
	    searchField: "label",
    	render: {
	        option: function(data, escape) {
	        	return '<div data-value="'+data.value+'" data-selectable class="option">'+data.label+'</div>';
			}
		}
    });
    $sel_phil2 = $("#bank-2-variants-sel").selectize({
		allowEmptyOption:true,
		maxOptions: 10000000,
		onChange: function(value) {
    		/*var model = $sel_model[0].selectize
    		if (value.length > 0) {
    			model.enable()
    		} else {
    			model.disable()
    			model.setValue("")
    		}*/
		},
    	delimiter: ';',
	    labelField: "label",
	    valueField: "value",
	    searchField: "label",
    	render: {
	        option: function(data, escape) {

	        	if(jQuery.inArray(data.value, borel[borel['selected']]) !== -1) return '<div data-value="'+data.value+'" data-selectable class="option">'+data.label+'</div>';
	        	
	        	return '';
			}
		},
		onDropdownOpen: function($dropdown){
		}
	});
	sss2 = $sel_phil2;
    $("#bank-3-variants-sel").selectize({allowEmptyOption:true});
    $("#bank-4-variants-sel").selectize({allowEmptyOption:true});

    var $sel_bank, $sel_phil, $sel_model;

    $sel_bank = $("#bank-1-variants-selrb").selectize({
    	allowEmptyOption:true,
    	maxOptions: 10000000,
    	onChange: function(value) {
    		sss[0].selectize.destroy();
    		$(sss[0]).selectize({
				allowEmptyOption:true,
				maxOptions: 10000000,
				onChange: function(value) {
		    		var model = $sel_model[0].selectize
		    		if (value.length > 0) {
		    			model.enable()
		    		} else {
		    			model.disable()
		    			model.setValue("")
		    		}
				},
		    	delimiter: ';',
			    labelField: "label",
			    valueField: "value",
			    searchField: "label",
		    	render: {
			        option: function(data, escape) {

			        	if(jQuery.inArray(data.value, borel[borel['selected']]) !== -1) return '<div data-value="'+data.value+'" data-selectable class="option">'+data.label+'</div>';
			        	
			        	return '';
					}
				},
				onDropdownOpen: function($dropdown){
				}
			});
			$('.officeBlock .selectize-input.items.full.has-options.has-items').css('height', '45px')

    		borel['selected'] = value;
    		var phil = $sel_phil[0].selectize;
    		var model = $sel_model[0].selectize;

    		if (value.length > 0) {
    			phil.enable();
    		} else {
    			phil.disable();
    			phil.setValue("");
    			model.disable();
    			model.setValue("");
    		}
    
    	},
    	delimiter: ';',
	    labelField: "label",
	    valueField: "value",
	    searchField: "label",
    	render: {
	        option: function(data, escape) {
	        	return '<div data-value="'+data.value+'" data-selectable class="option">'+data.label+'</div>';
			}
		}
    });

	$sel_phil = $("#bank-2-variants-selrb").selectize({
		allowEmptyOption:true,
		maxOptions: 10000000,
		onChange: function(value) {
    		var model = $sel_model[0].selectize
    		if (value.length > 0) {
    			model.enable()
    		} else {
    			model.disable()
    			model.setValue("")
    		}
		},
    	delimiter: ';',
	    labelField: "label",
	    valueField: "value",
	    searchField: "label",
    	render: {
	        option: function(data, escape) {

	        	if(jQuery.inArray(data.value, borel[borel['selected']]) !== -1) return '<div data-value="'+data.value+'" data-selectable class="option">'+data.label+'</div>';
	        	
	        	return '';
			}
		},
		onDropdownOpen: function($dropdown){
		}
	});
	sss = $sel_phil;
	$sel_model = $("#bank-3-variants-selrb").selectize({allowEmptyOption:true,
		maxOptions: 10000000
	});
	if ($sel_phil[0] !== undefined) {
		$sel_phil[0].selectize.disable()
	}
	if ($sel_model[0] !== undefined) {
		$sel_model[0].selectize.disable()
	}

	var $sel_bank2, $sel_phil2, $sel_model2;

    $sel_bank2 = $("#bank-4-variants-selrb").selectize({
    	allowEmptyOption:true,
    	onChange: function(value) {
    		var phil = $sel_phil2[0].selectize
    		var model = $sel_model2[0].selectize
    		if (value.length > 0) {
    			phil.enable()
    		} else {
    			phil.disable()
    			phil.setValue("")
    			model.disable()
    			model.setValue("")
    		}
    	}
    });
	$sel_phil2 = $("#bank-5-variants-selrb").selectize({
		allowEmptyOption:true,
		onChange: function(value) {
    		var model = $sel_model2[0].selectize
    		if (value.length > 0) {
    			model.enable()
    		} else {
    			model.disable()
    			model.setValue("")
    		}
		}
	});
	$sel_model2 = $("#bank-6-variants-selrb").selectize({allowEmptyOption:true});
	if ($sel_phil2[0] !== undefined) {
		$sel_phil2[0].selectize.disable()
	}
	if ($sel_model2[0] !== undefined) {
		$sel_model2[0].selectize.disable()
	}

	var sutags = $(".su-tags")
	if (sutags.length !== 0) {
		sutags.tagsinput({})
	}

	var selsu = $("#bank-2-variants-selsu").selectize({
		onChange: function(value) {
			if (!value.length) return;
			var ti = $("#taginput input")
			var val = selsu[0].selectize.options[value]
			sutags.tagsinput("add", val.text)
			selsu[0].selectize.clear()
		}		
	})


	$(".button-file-input input[type=file]").on('change', function(){
		var theFile = $(this).val().replace(/.+[\\\/]/, "");
		$(this).closest(".button-file-input").find("input[type=text]").val(theFile);
	})
})

