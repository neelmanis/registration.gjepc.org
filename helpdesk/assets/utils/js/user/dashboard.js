					
					var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 2, mirror: false });

					scanner.addListener('scan',function(content){
						if(content !==""){
							// alert(content);
							let device_type = $("#device_type").val();
							let zone = $("#zone").val();
							if(device_type ==""){
								swal({
										title: "Warning !",
										icon: "warning",
										text: "Please Select Check-in / check-out "
									  });
								return false;
							}
							if(zone ==""){
								swal({
										title: "Warning !",
										icon: "warning",
										text: "Please Select Zone "
									  });
								return false;
							}

							$.ajax({
							  type:'POST',
					          data:{qr_content:content,device_type:device_type,zone:zone},
					          url: CI_ROOT + "user/scanVisitor",
					          dataType: "json",
					          beforeSend:function(){
					           showLoader();
					          },
					          success:function(result){
					            hideLoader(100,"fast");
					            var audio = new Audio('https://scanapp.kwebmaker.com/assets/admin/audio/beep_1.mp3');
					            navigator.vibrate(200);
								audio.play();
								scanner.stop();
								//alert(result.result.name);
								if(result.status =="success"){
									// $("#video_preview").hide();
									// $("#preview").hide();
									 $(".video_container").hide();


									$("#scan_preview").show();
									$("#vis_photo_url").attr("src",result.result.photo_url);
									$("#vis_name").html(result.result.name);
									$("#vis_company").html(result.result.company);
									$("#vis_category").html(result.result.category);
									$("#vis_description").html(result.result.description);
									$("#scan").html("Rescan");

									if(result.result.status =="APPROVED"){
										
                                       $("#response_message_section").addClass("alert alert-success");
									}else{
 									   $("#response_message_section").addClass("alert alert-danger");
									} 
									// $("#response_status").html(result.result.status);
									$("#response_message").html(result.result.message);
									// alert(result.result.message);

								}else{
									swal({
										title: "Warning !",
										icon: "warning",
										text: result.message
									  });
								}
					          }
					        });
						}else{
							alert("Qr Code Currupted..!");
						}

			            scanner.stop();
						
					});

					Instascan.Camera.getCameras().then(function (cameras){
						if(cameras.length>0){
							if(cameras.length == 1){
								$('#scan').on('click',function(e){
	                                e.preventDefault();
	                                navigator.vibrate(50);
	                                if(cameras[0]!=""){
	                                	 $(".video_container").show();
	                                	$("#video_preview").addClass("d-none").removeClass("d-flex");
						            	$("#scan_preview").hide();
										scanner.start(cameras[0]);
									}else{
										alert('No Back camera found!');
									}
								});
							}else if(cameras.length == 2){
								$('#scan').on('click',function(e){
	                                e.preventDefault();
	                                navigator.vibrate(50);
	                                if(cameras[1]!=""){
	                                	 $(".video_container").show();
	                                	$("#video_preview").addClass("d-none").removeClass("d-flex");
						            	$("#scan_preview").hide();
										scanner.start(cameras[1]);
									}else{
										alert('No Back camera found!');
									}
								});
							}else if(cameras.length == 4){
								$('#scan').on('click',function(e){
	                                e.preventDefault();
	                                navigator.vibrate(50);
	                                if(cameras[2]!=""){
	                                	 $(".video_container").show();
	                                	$("#video_preview").addClass("d-none").removeClass("d-flex");
						            	$("#scan_preview").hide();
										scanner.start(cameras[2]);
									}else{
										alert('No Back camera found!');
									}
								});
							}
							


						}else{
							console.error('No cameras found.');
							alert('No cameras found.');
						}
					}).catch(function(e){
						console.error(e);
						alert(e);
					});

$(document).ready(function(){
	$(document).on("change","#zone",function(e){
	    e.preventDefault();
	    let zone = $(this).val();
	    if(zone !==""){
	     	var data = {zone:zone};
		    var postLink = 'user/changeZoneAction';
		  	confirmPostData(data,postLink,function(response){
		        if(response.status == "success"){
		          navigator.vibrate(200);
		          swal({
		            title: response.message,
		            icon: "success",
		            buttons: true,
		            dangerMode: false,
		            timer: 3000
		          });
		        }
		  	});
	    }else{
	    	navigator.vibrate(200);
	    	return false;
	    }
  	});
  	$(document).on("change","#device_type",function(e){
	    e.preventDefault();
	    let device_type = $(this).val();
	    if(device_type !==""){
	        var data = {device_type:device_type};
	    	var postLink = 'user/changeDeviceTypeAction';
	      	confirmPostData(data,postLink,function(response){
		        if(response.status == "success"){
		          navigator.vibrate(200);
		          swal({
		            title: response.message,
		            icon: "success",
		            buttons: true,
		            dangerMode: false,
		            timer: 3000
		          });
		        }
	      	});
	    }else{
	    	navigator.vibrate(200);
	    	return false;
	    }
  	});
});