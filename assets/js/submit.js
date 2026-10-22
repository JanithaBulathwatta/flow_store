		
		// add data in ajax
	(function ( $ ) {	
		$.fn.ajax_submit = function(options){	
					
					form_id= this;

					var settings = $.extend({
						url: "",
						type : 'post',
						rest : true,
						modal_hide:true,
						callback : null
					}, options );
							
					$(form_id).ajaxForm({
							url: settings.url,
							type: settings.type,
							beforeSubmit : function(){
								
								var inLen = $(form_id).find('.required').length;
								var check = true;
								for(var i=0; i< inLen; i++)
								{
									if($('.required').eq(i).val() == ''){
										check = false;
										$(form_id).find('.req-error').eq(i).html('<i class="icon-shield-notice"></i> This is a required field!!')
										$(form_id).find('.req-error').eq(i).fadeIn(300);
									}
								}

								/* var fileSelected = $('.required-file').get(0).files.length;
								if(fileSelected == 0){
									check = false;
									$(form_id).find('.req-error').html('<i class="icon-shield-notice"></i> This is a required field!!');
									$(form_id).find('.req-error').fadeIn(300);
								} */

								if(check ==  false){
									return false;
								}
								
								form_id.find('button[type="submit"]').attr('disabled',true);
								   
								toastr.clear();
								toastr.info('Waiting for responce...')
								
							},
							success:function(res){
								
								form_id.find('button[type="submit"]').attr('disabled',false);
								
								try{

									jd=JSON.parse(res);
									if(jd["stt"] == 'ok'){
										
										toastr.clear();
										toastr.success(jd["msg"])
											
										if ($.isFunction(settings.callback)) {
											var relt = true;
											var id = jd["data"];
											settings.callback.call(this, id);
										}
									//clear form
									if(settings.rest)
										$(form_id)[0].reset();	
									 
									$('.form-control').val('');	
									//empty selections
									$('.select').val(null).trigger('change');
											
									form_id.find('button[type="submit"]').attr('disabled',false);
									
									if(settings.modal_hide)
										$('.modal').modal('hide');
											
									}else if(jd["stt"] == 'error'){

										toastr.clear();
										toastr.warning(jd["msg"])
											
										if ($.isFunction(settings.callback)) {
											var relt = false;
											var id = jd["data"];
											settings.callback.call(this,id);
										}							
										form_id.find('button[type="submit"]').attr('disabled',false);
									}
								
								} catch (e){
									console.log(e);
										
									toastr.clear();
									toastr.error('Something went wrong...')
										
									form_id.find('button[type="submit"]').attr('disabled',false);
								}	 	
					
						},
						error : function(){
							toastr.clear();
							toastr.error('Something went wrong...')
								
							form_id.find('button[type="submit"]').attr('disabled',false);
						}
						
					});	
				}	
			}( jQuery ));	 			
