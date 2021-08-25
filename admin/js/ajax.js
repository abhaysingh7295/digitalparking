jQuery(document).ready(function(){
	jQuery('.songfrm .song_base_category').on('change', function() {
	 var bas_cat_val = jQuery(this).val();
	jQuery('.songfrm .song_sub_category').html('<option value="">loading...</option>');
	jQuery.ajax({
		url:'get_sub_cats.php',
		type:'POST',
		data:{sbcatval:bas_cat_val},
		success:function(data){
		jQuery('.songfrm .song_sub_category').html(data);
		
		}
	});
	});
	
	jQuery('.songfrm #addnewfrm').click(function() {
	 var songfrmlelenght = jQuery(".songfrmle").length;
	jQuery('#addloaddiv').html('loading...');
	jQuery.ajax({
		url:'get_song_form.php',
		type:'POST',
		data:{newform:songfrmlelenght},
		success:function(data){
		jQuery('.songfrm #appenddivs').append(data);
		jQuery('#addloaddiv').html('');
		
		}
	});
	 	e.preventDefault(); //STOP default action
	     e.unbind();
	  	return true;

	});


	/* Ajax User select by Alpha  */
	
	jQuery('#selectuseralpha a').click(function(e) {
	// var songfrmlelenght = jQuery(".songfrmle").length;
	var os = $('#opratingsystems').val();
	var alpha = $(this).attr("id");
	jQuery('#loaddiv').html('loading...');
	 jQuery.ajax({
		url:'ajax-select-users.php',
		type:'POST',
		data:{alpha:alpha,os:os},
		success:function(data){
		//alert(data);
		jQuery('#userselect').html(data);
		//jQuery('#userselect').append(data);
		jQuery('#loaddiv').html('');
		}
	});
	 	e.preventDefault(); //STOP default action
	     e.unbind();
 
 		return true;

	});



      /* Ajax user Unsubscribe */
      
      jQuery('.unsubscribeusers').live('click',function(e) {

 
    var ret = confirm("Are You Sure Unsubscribe this User");
    if (ret  == true) {

        var getid = $(this).attr("id");
	jQuery('#loaddiv').html('loading...');
	jQuery.ajax({
		url:'ajax-unsubscribe-users.php',
		type:'POST',
		data:{userid:getid},
		success:function(data){
		//alert(data);
		if(data=='success') {
		jQuery('#lableuser-'+getid).remove();
		} else {
		alert('Fail')
		}
		jQuery('#loaddiv').html('');
		}
	});
       
    } 
       
	 	e.preventDefault(); //STOP default action
	     e.unbind();
 
 		return true;	
	 

	});

	
	
		
	jQuery('.select_audio_type').click(function () {
	var audio_type = jQuery(this).attr("value");
	if(audio_type=='acc'){
	jQuery('.facc-file').show('slow');
	jQuery('.fmp3-file').hide('slow');
	} else if(audio_type=='mp3') {
	jQuery('.facc-file').hide('slow');
	jQuery('.fmp3-file').show('slow');
	} else if(audio_type=='both') {
	jQuery('.facc-file').show('slow');
	jQuery('.fmp3-file').show('slow');
	}
        
         });
       

     jQuery("#image_name").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        jQuery("#image_slug").val(Text);        
     });
           
           
           
       /* Ajax Edit user Form */
      
      jQuery('.edit-user-ajax').live('click',function(e) {
 	var getid = $(this).attr("id"); 
        jQuery('#user-edit-frm').html('loading...');
	jQuery.ajax({
		url:'ajax-edit-user.php',
		type:'POST',
		data:{userid:getid},
		success:function(data){
		 jQuery('#user-edit-frm').html(data);
		}
	});
       	e.preventDefault(); //STOP default action
	 e.unbind();
          return true;	
	});     
      
       /* Ajax Edit user Update */ 
 jQuery('#edit-user-submit').live('submit',function(e){ 
  
   jQuery('#user-edit-frm-loading').html('loading...');
  
  var postData = jQuery(this).serializeArray();
  jQuery.ajax(
  {
   url : 'ajax-update-user.php',
   type: "POST",
   data : postData,
   success:function(data, textStatus, jqXHR) 
   {  alert(data);
    jQuery("#user-edit-frm-loading").html(data);
	    setTimeout(function() {
	    jQuery(".close").trigger('click');
	    }, 2000);
    }
  });
     e.preventDefault(); //STOP default action
     e.unbind();
 
 return true;
 });
     
     
     /* Ajax user Delete */
      
      jQuery('.delete-user-ajax').live('click',function(e) {
     var ret = confirm("Are You Sure Delete this User");
    if (ret  == true) {
 	var getid = $(this).attr("id");
	//jQuery('#loaddiv').html('loading...');
	jQuery.ajax({
		url:'ajax-delete-user.php',
		type:'POST',
		data:{userid:getid},
		success:function(data){
		//alert(data);
		if(data=='success') {
		jQuery('#user-details-'+getid).remove();
		} else {
		alert('Fail')
		}
		//jQuery('#loaddiv').html('');
		}
	});
       } 
        e.preventDefault(); //STOP default action
	 e.unbind();
        return true;	
	 });
	 
	 /* Ajax Change User Notifications Status */
      
      jQuery('.changeuserstatus').live('click',function(e) {
     var ret = confirm("Are You Sure Change user Status");
    if (ret  == true) {
 	var getid = $(this).attr("id");
 	var subscribe = $(this).attr("data-subscribe");
	//jQuery('#loaddiv').html('loading...');
	jQuery.ajax({
		url:'ajax-user-notification-status.php',
		type:'POST',
		data:{userid:getid,subscribe:subscribe},
		success:function(data){
		
		jQuery('#user-action-'+getid).html(data);
		if(subscribe==1){
		jQuery('#user-subscription-'+getid).html('Subscribe');
		} else {
		jQuery('#user-subscription-'+getid).html('Unsubscribe');
		}
		}
	});
       } 
        e.preventDefault(); //STOP default action
	 e.unbind();
        return true;	
	 });
     
     
                 
});
