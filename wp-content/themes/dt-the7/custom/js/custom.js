jQuery(document).ready(function($){$(".jobOpeningNav li").click(function(){$(".jobOpeningNav li").removeClass("active");$(this).addClass("active");var getid=$(this).attr("id");$(".vacany-section li a").each(function(){var fid=$(this).attr("href");var itemId=fid.substring(1,fid.length);$(this).parent().addClass(itemId);});if(getid=='jobAll'){$('.vacany-section li').show();}else if(getid=='JobCreative'){$('.vacany-section li').hide();$('.vc_tta-tabs-list [class^="list-"] , .vc_tta-tabs-list [class*="list-"]').show();$('.vc_tta-tabs-list [class^="list-"] , .vc_tta-tabs-list [class*="list-"]').addClass('desgin');$('.vacany-section li.desgin').eq(0).find('a').trigger('click');}else if(getid=='jobDevelopment'){$('.vacany-section li').hide();$('.vc_tta-tabs-list [class^="dev-"] , .vc_tta-tabs-list [class*="dev-"]').show();$('.vc_tta-tabs-list [class^="dev-"] , .vc_tta-tabs-list [class*="dev-"]').addClass('programing');$('.vacany-section li.programing').eq(0).find('a').trigger('click');}else{$('.vacany-section li').hide();$('.vc_tta-tabs-list [class^="oth-"] , .vc_tta-tabs-list [class*="oth-"]').show();$('.vc_tta-tabs-list [class^="oth-"] , .vc_tta-tabs-list [class*="oth-"]').addClass('other');$('.vacany-section li.other').eq(0).find('a').trigger('click');}});$("#formblogbtn").click(function(){var ajax_url=timeline_um_ajax.timeline_um_ajaxurl;var vars=$("#formblog").serialize();jQuery.ajax({type:'POST',url:ajax_url,data:{action:'formblog_filter',data:vars,},beforeSend:function(){jQuery('#formblog-message').html('<p>Loading....</p>');},success:function(data){jQuery("#formblog-message").text(data);jQuery('#fname,#email').val('');},error:function(){jQuery("#formblog-message").html('<p>There has been an error</p>');}});});});

//*Team form page =======================================*//
jQuery(document).ready(function($){
//$('input#teamimg').on('change', team_prepareUpload);
//jQuery('.team-submit').on('click',team_uploadFiles);
jQuery('.team-submit').on('click',team_testuploadFiles);
$('input#teamimg').on('change', test_team_prepareUpload);


function test_team_prepareUpload(){
var team_name = jQuery('#team_name').val();
error = false;
var team_desc = jQuery('#team_desc').val();
var team_position = jQuery('#team_position').val();
  var file_data = jQuery('#teamimg').prop('files')[0];   
  var form_data = new FormData();                  
  form_data.append('file', file_data);
    form_data.append('name', team_name);
    form_data.append('desc', team_desc);
    form_data.append('team_position', team_position);

           var fileType = file_data["type"];
              var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "image/bmp", "image/gif"];
              if ($.inArray(fileType, ValidImageTypes) < 0) {
             error = true;
             jQuery('#teamimg').next('.wpvp_error').html('The file extension is not supported.Supported extensions are:jpg,png,jpeg,gif,bmp');
             jQuery('.team-submit').attr("disabled", true);
             return false;
              } else {
               jQuery('.team-submit').removeAttr("disabled");
              jQuery(this).next('.wpvp_error').html('');
                 }
         var filesize = file_data["size"];
              var size = 5242880;
              if (filesize > size) {
             error = true;
             jQuery('#teamimg').next('.wpvp_error').html('File size is larger than 5MB!');
               jQuery('.team-submit').attr("disabled", true);
              } else {
               jQuery('.team-submit').removeAttr("disabled");
              jQuery(this).next('.wpvp_error').html('');
                 }
if(error)
return false;
upload(form_data);
}
function upload(data) {
var progressBar = document.getElementById("progress");
var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", ajax_url+'?action=team_file', true);
  if (xhr.upload) {
    xhr.upload.onprogress = function(e) {
      if (e.lengthComputable) {
        progressBar.max = e.total;
        progressBar.value = e.loaded;
        //display.innerText = Math.floor((e.loaded / e.total) * 100) + '%';
      }
    }
    xhr.upload.onloadstart = function(e) {
       jQuery(progressBar).show();
      jQuery("#closebar").show();
      progressBar.value = 0;
     jQuery('.team-submit').attr("disabled", true);
      //display.innerText = '0%';
    }
    xhr.upload.onloadend = function(e) {
      //progressBar.value = e.loaded;
      jQuery(progressBar).hide();
      jQuery("#closebar").hide();
      jQuery('.team-submit').removeAttr("disabled");
    }
     xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response=JSON.parse(this.responseText);
            if(response.status == 'error'){
             //jQuery(".team_testimonial_mess").html(response.msg);
             jQuery('#teamimg').next('.wpvp_error').html(response.msg);
                 } else{
             jQuery('#teamimg').next('.wpvp_error').html('');
           // display.innerHTML = this.responseText;
               }
       } else {
         jQuery('#teamimg').next('.wpvp_error').html('');
         }
    };

  }
  xhr.send(data);
jQuery("#closebar").on("click", function(){
jQuery(this).hide();
jQuery("#progress").hide();
jQuery("#teamimg").val("");
jQuery('.wpvp_mess').html('');
xhr.abort();
        });
}

//===========up post

function team_testuploadFiles(){
var progressBar = document.getElementById("progress_data");
error = false;
var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
//var data = $("#team_testimonial").serialize();
 var team_name = jQuery('#team_name').val();
  var team_desc = jQuery('#team_desc').val();
var team_position = jQuery('#team_position').val();
  var file_data = jQuery('#teamimg').prop('files')[0];   
  var form_data = new FormData();                  
  form_data.append('file', file_data);
    form_data.append('name', team_name);
    form_data.append('desc', team_desc);
  form_data.append('team_position', team_position);

//alert(form_data);
//console.log(form_data);
            
	jQuery('form.team_testimonial_form').find('.team_require').each(function(){
		if(!jQuery(this).val()){
			error = true;
			jQuery(this).next('.wpvp_error').html('This field is required.');
                        return false;
                  } else {
                 jQuery(this).next('.wpvp_error').html('');
                }
            
	});
            // var file = jQuery('#teamimg').file_data[0];
             if(!jQuery('#teamimg').val()){
			error = true;
			jQuery('#teamimg').next('.wpvp_error').html('This field is required.');
                        return false;
                  } 
                   else {
              jQuery('#teamimg').next('.wpvp_error').html('');
                 }
              var fileType = file_data["type"];
              var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "image/bmp", "image/gif"];
              if ($.inArray(fileType, ValidImageTypes) < 0) {
             error = true;
             jQuery('#teamimg').next('.wpvp_error').html('The file extension is not supported.Supported extensions are:jpg,png,jpeg,gif,bmp');
            return false;
              } else {
               
              jQuery('#teamimg').next('.wpvp_error').html('');
                 }
            var filesize = file_data["size"];
              var size = 5242880;
              if (filesize > size) {
             error = true;
             jQuery('#teamimg').next('.wpvp_error').html('File size is larger than 5MB!');
              } else {
               
              jQuery('#teamimg').next('.wpvp_error').html('');
                 }
if(error)
return false;
post_upload(form_data);
}
function post_upload(data) {
var progressBar = document.getElementById("progress_data");
var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", ajax_url+'?action=team_form', true);
  if (xhr.upload) {
    xhr.upload.onprogress = function(e) {
      if (e.lengthComputable) {
        progressBar.max = e.total;
        progressBar.value = e.loaded;
        //display.innerText = Math.floor((e.loaded / e.total) * 100) + '%';
      }
    }
    xhr.upload.onloadstart = function(e) {
       jQuery(progressBar).show();
      //jQuery("#closebar").show();
      progressBar.value = 0;
      //display.innerText = '0%';
    }
    xhr.upload.onloadend = function(e) {
      //progressBar.value = e.loaded;
      jQuery(progressBar).hide();
      //jQuery("#closebar").hide();
    }
     xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response=JSON.parse(this.responseText);
            if(response.status == 'error'){
             jQuery(".team_testimonial_mess").html(response.msg);
                 } else{
            jQuery('#team_name,#team_desc,#teamimg').val('');
                                jQuery(".team_testimonial_mess").html('');
                                //alert(data);
                       jQuery("#dialog-message").html('Thank you for taking the time to provide us with your valuable feedback.  We strive to provide our team with excellent care and we take your comments to heart.').dialog("open");
               }
       } else {
        jQuery(".team_testimonial_mess").html('error');
         }
    };

  }
  xhr.send(data);
}

//==============================


function team_uploadFiles(event){
var progressBar = document.getElementById("progress_data");
error = false;
var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
//var data = $("#team_testimonial").serialize();
 var team_name = jQuery('#team_name').val();
  var team_desc = jQuery('#team_desc').val();
var team_position = jQuery('#team_position').val();
  var file_data = jQuery('#teamimg').prop('files')[0];   
  var form_data = new FormData();                  
  form_data.append('file', file_data);
    form_data.append('name', team_name);
    form_data.append('desc', team_desc);
  form_data.append('team_position', team_position);

//alert(form_data);
//console.log(form_data);
	jQuery('form.team_testimonial_form').find('.team_require').each(function(){
		if(!jQuery(this).val()){
			error = true;
			jQuery(this).next('.wpvp_error').html('This field is required.');
                        return false;
                  } else {
                 jQuery(this).next('.wpvp_error').html('');
                }
              
	});
            // var file = jQuery('#teamimg').file_data[0];
  
              var fileType = file_data["type"];
              var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "image/bmp", "image/gif"];
              if ($.inArray(fileType, ValidImageTypes) < 0) {
             error = true;
             jQuery('#teamimg').next('.wpvp_error').html('The file extension is not supported.Supported extensions are:jpg,png,jpeg,gif,bmp');
              } else {
               
              jQuery(this).next('.wpvp_error').html('');
                 }
              var filesize = file_data["size"];
              var size = 502400;
              if (filesize > size) {
             error = true;
             jQuery('#teamimg').next('.wpvp_error').html('File size is larger than 5MB!');
              } else {
               
              jQuery(this).next('.wpvp_error').html('');
                 }
if(error)
return false;
jQuery.ajax({
xhr: function(){
       var xhr = new window.XMLHttpRequest();
       //Upload progress
       xhr.upload.addEventListener("progress", function(evt){
       if (evt.lengthComputable) {
          //jQuery(progressBar).show();
          //jQuery("#closebar_data").show();
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
      //jQuery("#closebar").show();
      progressBar.value = 0;
      //display.innerText = '0%';
    },
     xhr.upload.onloadend = function(evt) {
      jQuery(progressBar).hide();
      //jQuery("#closebar").hide();
    },
     false);
       return xhr;
     },
			type: 'POST',
			url: ajax_url+'?action=team_form',
                        processData: false,
                        contentType: false,
			data: form_data,
			beforeSend: function ()
			{
				//Show loader here
                                //jQuery('.team_upload_progress').html('<p>Loading....</p>');
			},
			success: function(data)
			{
                                var obj = JSON.parse(data);
			        var status = '';
			        var msg = '';
		                if(obj.hasOwnProperty('status'))
			        status = obj.status;
			        if(obj.hasOwnProperty('msg'))
			        msg = obj.msg;
				//Hide loader here
                                if(status=='error'){
				jQuery(".team_testimonial_mess").html(msg);
                                } else {
                                jQuery('#team_name,#team_desc,#teamimg').val('');
                                jQuery(".team_testimonial_mess").html('');
                                //alert(data);
                       jQuery("#dialog-message").html('Thank you for taking the time to provide us with your valuable feedback.  We strive to provide our clients and patients with excellent care and we take your comments to heart.').dialog("open");
                              }
			},
			error: function()
			{
				jQuery(".team_testimonial_mess").html('<p>There has been an error</p>');
			}
		});
}

//*end team form page*//
});
