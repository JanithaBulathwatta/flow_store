	//plugin for delete data----------------------------------------------------------------------------->
	(function ( $ ) {	
		$.fn.del_modal = function(options){	
					
					target  = this;
					//success =data["success"];
					//urlx = data["urlx"];
					//replay = data["reply"];
					//settings.clearQueue();

					var settings = $.extend({
						title: "",
						head : "",
						para : "",
						id : '',
						remove : true,						
						url : '',
						method: 'get',
						btn : 'Delete',
						color:'danger',
						callback : null
					}, options );		
		
			//$(target).closest('tbody > tr').css('background','transparent');
			$(target).closest('tr').css('background','#e2dede');
			
			var t = '<div id="del_modal" class="modal inmodal fade" tabindex="-1"><div class="modal-dialog modal-sm">';
				t += '<div class="modal-content"><div class="modal-header md-head" style="padding: 6px 10px 10px 10px;">';
				t += '<h5 class="modal-title text-left" style="font-size: 16px; padding-left: 10px;">'+settings.title+'</h5></div><form id="del_form_in_modal">';
				t += '<div class="modal-body md-bdy" style="padding: 0px 0px 20px 20px; background-color: #fff;"><p><span class=" text-danger">'+settings.head+'</span></br>'+settings.para+'</p></div>';
				t += '<div class="modal-footer" style="padding: 12px 15px;"><button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: #eceef1; font-size: 13px;">Close</button>';
				t += '<button type="submit"  class="btn btn-'+settings.color+'" style="font-size: 13px;">'+settings.btn+'</button></div></div></form></div></div>';
				$('#modal-area').html(t);
				$('#del_modal').modal();


				
			$('#del_form_in_modal').ajax_submit({
				url :settings.url,
				type : settings.method,
				callback : function(ref){
					//console.log(res);
					//console.log(id);
					$('#del_modal').modal('toggle');
					if(settings.remove == true && ref != 0){
						$(target).closest('tr').remove();
						$(target).closest('.tr').remove();
					}
					//else
						//$(target).closest('tr').css('background','transparent');
						
					if ($.isFunction(settings.callback)) {
						settings.callback.call(this, settings.id);
					}																	

				}
			});				
				
		}
				
	}( jQuery ));
	//end------------------------------------------------------------------------------------------------------------>
	
	(function ( $ ) {	 
		$.change_focus = {	
		func : function(options){
				var settings = $.extend({
					tit : {}
				},options);

			//get the object size or length
			Object.size = function(obj) {
			  var size = 0,
				key;
			  for (key in obj) {
				if (obj.hasOwnProperty(key)) size++;
			  }
			  return size;
			};
			var len = Object.size(settings.tit);
			//end function----------------
			var i=0;
  			if(true)
			{
				var id = settings.tit[Object.keys(settings.tit)[i]];
				var firstId = settings.tit[Object.keys(settings.tit)[0]]
				var type = Object.keys(settings.tit)[i];
				$('#'+firstId).focus();
				if(type == 'text')
				{
								
					$('#'+id).on('keypress',function(e){
						if(e.which == 13) {
							 settings.tit[Object.keys(settings.tit)[i+1]];
							 i +1;
						}
					});
				}
			}  
			//alert(i);
			//alert( settings.tit[Object.keys(settings.tit)[0]]);
			//alert(Object.keys(settings.tit)[0]);
	
			}
		
		}
	}( jQuery ));
	
	//plugin for date range picker commented 2023-10-24 sam not used --------------------->
	// (function($) { 
		// $.datePick = {
			// func : function(){
				// var start = moment().subtract(29, 'days');
				// var end = moment();

				// function cb(start, end) {
					// $('.daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				// }
				
				// $('.daterange').daterangepicker({
					// startDate: start,
					// endDate: end,
					// ranges: {
					   // 'Today': [moment(), moment()],
					   // 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					   // 'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					   // 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					   // 'This Month': [moment().startOf('month'), moment().endOf('month')],
					   // 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					// }
				// }, cb);
				// cb(start, end);
			// }
		// }

	// }( jQuery ));	
	//end------------------------------------------->
	
		// $(document).ready(function(){
			//spinner for autocomplete-----------------



			
			// $(function() {
				// $("body").delegate(".datepicker-menus", "focusin", function(){
					// $(this).datepicker();
				// });
			// });
			
			
			// $.datePick.func();//call daterange picker
		// });		

	$(document).ready(function() {
		$('.custom-file-input').on('change', function() {
			let fileName = $(this).val().split('\\').pop();
			$(this).siblings('.custom-file-label').addClass("selected").text(fileName).css("color", "#000");
		});
	});
	
	
