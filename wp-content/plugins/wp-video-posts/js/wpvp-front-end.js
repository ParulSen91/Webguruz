upload_size = wpvp_vars.upload_size;
file_upload_limit = wpvp_vars.file_upload_limit;
wpvp_ajax = wpvp_vars.wpvp_ajax;
var files;
var filesImg;
jQuery(document).ready(function(){
         jQuery(".image").on("click", function(){
         jQuery(this).hide();
         jQuery('.wpvp_tempImg_progress').hide();
         jQuery("#async-image").val("");
         jQuery("#async-image").reset();
          });
         jQuery(".video").on("click", function(){
         jQuery(this).hide();
         jQuery('.wpvp_tempvideo_progress').hide();
         jQuery("#async-upload").val("");
         jQuery("#async-upload").reset();
         });
         jQuery(".close_v").on("click", function(){
         jQuery(this).hide();
         jQuery('.wpvp_tempvideo_progress').hide();
         jQuery("#async-upload").val("");
         jQuery('.wpvp_mess').html('');
          jQuery('input:submit').removeAttr("disabled");
         jQuery("#async-upload").reset();
         });
	jQuery('.wpvp-submit').on('click',wpvp_uploadFiles);
	jQuery('input#async-upload').on('change', wpvp_prepareUpload);
        jQuery('input#async-image').on('change', wpvp_prepareImage);
        //jQuery('.email').blur(function(){ checkEmail(jQuery(this).val()); });
	jQuery('.video-js').each(function(){
		var objId = jQuery(this).attr('id');
		var vol = jQuery(this).data('audio');
		if(objId !== 'undefined' && (vol < 100 && vol !== 'undefined')){
			var player = videojs(objId);
			player.ready(function(){
				vol = parseFloat("0."+vol);
				var playerObj = this;
			  	playerObj.volume(vol);
			});
		}
	});
});
function checkEmail(str)
{
var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(str)){
   jQuery('.email').next('.wpvp_error').html('This field is required');
  return false;
} else {
jQuery('.email').next('.wpvp_error').html('');
  return true;
}
}
// Grab the files and set them to our variable
function wpvp_prepareUpload(event){
	if(typeof event==='undefined')
		var event = e;
	files = event.target.files;
        setupTempImg(files,'wpvp_tempvideo_progress','video');
}
// Grab the image  and set them to our variable
function wpvp_prepareImage(event){
	if(typeof event==='undefined')
		var event = e;
	filesImg = event.target.files;
        setupTempImg(filesImg,'wpvp_tempImg_progress','image');
}
function setupTempImg(filesT,cl,type){
wpvp_tempImgBar(1,cl,type);
if(type=="image"){
var progressBar = document.getElementById("progress");
var closebar = document.getElementById("closebar");
}
if(type=="video"){
var progressBar = document.getElementById("progress_v");
var closebar = document.getElementById("closebar_v");
var close_v = document.getElementById("close_v");
}
var data = new FormData();
						jQuery.each(filesT, function(key, value){
							data.append(key, value);
                                                        data.append('upType', type);
						});
						
xhrss = jQuery.ajax({
       xhr: function(){
       var xhr = new window.XMLHttpRequest();
       //Upload progress
       xhr.upload.addEventListener("progress", function(evt){
       if (evt.lengthComputable) {
          //jQuery(progressBar).show();
          //jQuery(closebar).show();
          progressBar.max = evt.total;
          progressBar.value = evt.loaded;
         var percentComplete = evt.loaded / evt.total;
        var ratio = Math.floor((evt.loaded / evt.total) * 100) + '%';
         //Do something with upload progress
         console.log(ratio);
         }
       }, 
      xhr.upload.onloadstart = function(evt) {
      jQuery(progressBar).show();
      jQuery(closebar).show();
      jQuery(close_v).show();
      progressBar.value = 0;
      //display.innerText = '0%';
    },
     xhr.upload.onloadend = function(evt) {
      jQuery(progressBar).hide();
      jQuery(closebar).hide();
    },
     false);
       return xhr;
     },
							url: wpvp_ajax+'?action=wpvp_temp_image',
							type: 'POST',
							data: data,
							cache: false,
							dataType: 'json',
							processData: false, // Don't process the files
							contentType: false, // Set content type to false
							success: function(obj, textStatus, jqXHR){
								var status = '';
								var errors = '';
								var html = '';
								var url = '';
								if(obj.hasOwnProperty('status'))
									status = obj.status;
								if(obj.hasOwnProperty('errors'))
									errors = obj.errors;
								if(status=='success'){
									jQuery('.wpvp_mess').html('');
                                                                        jQuery('#async-image').next('.wpvp_error').html('');
                                                                        wpvp_tempImgBar(0,cl,type);
                                                                         jQuery('input:submit').removeAttr("disabled");
                                                                     
								} else if(status=='error'){
                                                                      jQuery('input:submit').attr("disabled", true);
                                                                        jQuery('.wpvp_mess').html(errors);
                                                                        wpvp_tempImgBar(0,cl,type);
								}
							},
							error: function(jqXHR, textStatus, errorThrown){
								// Handle errors here
								console.log('ERRORS: ' + textStatus);
								wpvp_tempImgBar(0,cl,type);
							}
						});
jQuery(".closebar").on("click", function(){
jQuery(this).hide();
jQuery("#progress").hide();
jQuery("#async-image").val("");
jQuery('.wpvp_mess').html('');
xhrss.abort();
        });
jQuery(".closebar_v").on("click", function(){
jQuery(this).hide();
jQuery("#progress_v").hide();
jQuery("#async-upload").val("");
jQuery('.wpvp_mess').html('');
xhrss.abort();
        });		
}
// Catch the form submit and upload the files 
function wpvp_uploadFiles(event){
	if(typeof event==='undefined')
		var event = e;
	event.stopPropagation();
	event.preventDefault();
	var action = jQuery(this).attr('action');
	var deferred_validation = jQuery.Deferred();
	error = false;
	var form = jQuery('form.wpvp-processing-form');
	var formData = form.serialize();
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
	form.find('.wpvp_require').each(function(){
		if(!jQuery(this).val()){
			error = true;
			jQuery(this).next('.wpvp_error').html('This field is required.');
                  } else { jQuery(this).next('.wpvp_error').html('');}
                  if(!jQuery('.email').val()){
                   error = true;
			 jQuery('.email').next('.wpvp_error').html('This field is required.');   
                  }
                else {
                  if(!re.test(jQuery('.email').val())){
			error = true;
			 jQuery('.email').next('.wpvp_error').html('Please enter a valid email address');
                  }else {
			jQuery('.email').next('.wpvp_error').html('');
		}
                }
               	
	}).promise().done(function(){
		deferred_validation.resolve();
	});
	deferred_validation.done(function(){
              
		if(error)
			return false;
		if(action=='update'){
			var data = {
				action: 'wpvp_process_update',
				'cookie': encodeURIComponent(document.cookie),
				formData: formData
			};
			jQuery.post(wpvp_ajax,data,function(response){
				var obj = JSON.parse(response);
				var status = '';
				if(obj.hasOwnProperty('status'))
					status = obj.status;
				var msg = [];
				if(obj.hasOwnProperty('msg'))
					msg = obj.msg;
				if(msg instanceof Array){
					var msgBlock = jQuery('.wpvp_msg');
					msgBlock.html('');
					for(var i=0; i < msg.length; i++){
						msgBlock.append(msg[i]);
					}
				}
			});
		} else if(action=='create'){
			var deferred = jQuery.Deferred();
			var errors = [];
			// Pre-loader Start
			wpvp_progressBar(1);
			// Check files
			error = false;
			jQuery.each(files, function(key, value){
				if(value.size>file_upload_limit){
					error = true;
					errors.push(value.name+' file exceeds allowed size.');
				}
				if(key==(files.length-1))
					deferred.resolve();
			});
                         jQuery.each(filesImg, function(key, value){
				if(value.size>file_upload_limit){
					error = true;
					errors.push(value.name+' file exceeds allowed size.');
				}
				if(key==(filesImg.length-1))
					deferred.resolve();
			});
			deferred.done(function(){
				if(error){
					if(errors instanceof Array){
						for(x=0;x<errors.length;x++){
							jQuery('.wpvp_file_error').append(errors[x]+'<br />');
						}
					}
					//hide loader
					wpvp_progressBar(0);
				} else {
					//clear file errors
					jQuery('.wpvp_file_error').html('');
					//process form
					var data = {
						action: 'wpvp_process_form',
						'cookie': encodeURIComponent(document.cookie),
						data: formData
					};
					var wpvp_form_done = jQuery.post(wpvp_ajax,data);
					jQuery.when(wpvp_form_done).done(function(response){
						var obj = JSON.parse(response);
						var status = '';
						var msg = '';
						var postid = 0;
						if(obj.hasOwnProperty('status'))
							status = obj.status;
						if(obj.hasOwnProperty('msg'))
							msg = obj.msg;
						if(obj.hasOwnProperty('post_id'))
							postid = obj.post_id;
                                                if(status=='error'){ jQuery('.wpvp_title_error').html(msg); wpvp_progressBar(0);
                                           jQuery('.wpvp_mess').html('Error title is already exists');
                                                 } else {
                                               jQuery('.wpvp_mess').html('');
						var data = new FormData();
						jQuery.each(files, function(key, value){
							data.append(key, value);
							data.append('postid',postid);
						});
                                                if(files){
						jQuery.ajax({
							url: wpvp_ajax+'?action=wpvp_process_files',
							type: 'POST',
							data: data,
							cache: false,
							dataType: 'json',
							processData: false, // Don't process the files
							contentType: false, // Set content type to false
							success: function(obj, textStatus, jqXHR){
								var status = '';
								var errors = [];
								var html = '';
								var url = '';
								if(obj.hasOwnProperty('status'))
									status = obj.status;
								if(obj.hasOwnProperty('errors'))
									errors = obj.errors;
								if(obj.hasOwnProperty('html'))
									html = obj.html;
								if(obj.hasOwnProperty('url'))
									url = obj.url;
								if(status=='success'){
									jQuery('.wpvp_file_error').html('');
                                                                        
                                                                        //wpvp_progressBar(0);
                                                                      jQuery( '#wpvp-upload-video' ).each(function(){this.reset();});
									if(url!=''){
										/*setTimeout(function(){
											window.location.href = url;
										},5000);*/
									}
								} else if(status=='error'){
                                                                      wpvp_progressBar(0);
									if( errors instanceof Array){
										for(i=1; i<errors.length ; i++){
											jQuery('.wpvp_file_error').append(errors[i]+'<br />');
										}
									}
								}
							},
							error: function(jqXHR, textStatus, errorThrown){
								// Handle errors here
								console.log('ERRORS: ' + textStatus);
								wpvp_progressBar(0);
							}
						});
                                             }//if-file
                                                var data = new FormData();
						jQuery.each(filesImg, function(key, value){
							data.append(key, value);
							data.append('postid',postid);
						});
var progressBar = document.getElementById("progress_upload");
						jQuery.ajax({
 xhr: function(){
       var xhr = new window.XMLHttpRequest();
       //Upload progress
       xhr.upload.addEventListener("progress", function(evt){
       if (evt.lengthComputable) {
          //jQuery(progressBar).show();
          progressBar.max = evt.total;
          progressBar.value = evt.loaded;
         var percentComplete = evt.loaded / evt.total;
        var ratio = Math.floor((evt.loaded / evt.total) * 100) + '%';
         //Do something with upload progress
         //console.log(ratio);
         }
       }, 
      xhr.upload.onloadstart = function(evt) {
      jQuery(progressBar).show();
      progressBar.value = 0;
      //display.innerText = '0%';
    },
     xhr.upload.onloadend = function(evt) {
      jQuery(progressBar).hide();
    },
     false);
       return xhr;
     },
							url: wpvp_ajax+'?action=wpvp_process_image',
							type: 'POST',
							data: data,
							cache: false,
							dataType: 'json',
							processData: false, // Don't process the files
							contentType: false, // Set content type to false
							success: function(obj, textStatus, jqXHR){
								var status = '';
								var errors = [];
								var html = '';
								var url = '';
                                                                var img = '';
								if(obj.hasOwnProperty('status'))
									status = obj.status;
								if(obj.hasOwnProperty('errors'))
									errors = obj.errors;
								if(obj.hasOwnProperty('html'))
									html = obj.html;
								if(obj.hasOwnProperty('url'))
									url = obj.url;
                                                                if(obj.hasOwnProperty('img'))
									img = obj.img;
								if(status=='success'){
									jQuery('.wpvp_image_error').html('');
									jQuery(".requstpopup").modal('show');
									 window.setTimeout('location.reload()', 3000);
                                                                        wpvp_progressBar(0);
                                                                      jQuery( '#wpvp-upload-video' ).each(function(){this.reset();});
									if(url!=''){
										/*setTimeout(function(){
											window.location.href = url;
										},5000);*/
									}
								} else if(status=='error'){
                                                                           wpvp_progressBar(0);
                                                                          jQuery('.wpvp_mess').html(errors);
									if( errors instanceof Array){
										for(i=1; i<errors.length ; i++){
											jQuery('.wpvp_mess').append(errors[i]+'<br />');
										}
									}
								}
							},
							error: function(jqXHR, textStatus, errorThrown){
								// Handle errors here
								console.log('ERRORS: ' + textStatus);
								wpvp_progressBar(0);
							}
						});
                                           }
					});
				}
			});
		}
	});
}
function wpvp_progressBar(show) {
	if(show){
		jQuery('.wpvp_upload_progress').css('display','block');
	} else {
		jQuery('.wpvp_upload_progress').css('display','none');
	}
};	
function wpvp_tempImgBar(show,cl,type) {
	if(show){
		jQuery('.'+cl).css('display','block');
                jQuery('.'+cl).addClass('tempImg');
                jQuery('.wpvp-submit').css({"background":"rgba(0, 0, 0, 0) linear-gradient(to bottom, #f0f0f0 0px, #dcdcdc 100%) repeat scroll 0 0","pointer-events":" none"});
               jQuery('.'+type).css('display','block');
	} else {
		jQuery('.'+cl).css('display','none');
                jQuery('.'+cl).removeClass('tempImg');
                jQuery('.wpvp-submit').removeAttr("style");
	}
};	
