$(document).ready(function(){
  fetchUsers();

  $(".replyWindow").hide();

  $("#sendMessage").on("click", function(e){
    e.preventDefault();        
    
    let caseId = $("#caseId").val();
    let senderId = $("#senderId").val();
    let receiverId = $("#receiverId").val();
    let message = $("#chatMessage").val();
    let name = $("#receiverName").val();
    let pic = $("#receiverPic").val();

    if( message !== "" ){

      let formdata = new FormData();
      formdata.append("caseId", caseId);
      formdata.append("senderId", senderId);
      formdata.append("receiverId", receiverId);
      formdata.append("message", message);

      $.ajax({
        type:'POST',
        data:formdata,
        url: CI_ROOT + "api/message/send",
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend:function(){
          showLoader();
        },
        success:function(result){
          if(result.status == "SUCCESS"){
            $("#chatMessage").val("");

            fetchMessages(receiverId, name, pic);
          }else if(result.status == "ALERT"){
            hideLoader();
            swal({
              title: result.title,
              icon: result.icon,
              text: result.message,
            });
          }else{
            hideLoader();
            $.each(result, function(i, v) {
              $("label[for='"+i+"']").html(v);
            });
            var keys = Object.keys(result);
            $(".error").css("display","block");
            $('input[name="'+keys[0]+'"]').focus();
          }
        }
      });

    }
  });

  $(".select2").select2();
  CKEDITOR.replace("body");

  $("#case").on("change", function(e){
    e.preventDefault();        
    
    let caseId = $("#case").val();
    let senderId = $("#senderId").val();

    if( caseId !== "" ){
      let formdata = new FormData();
      formdata.append("caseId", caseId);
      formdata.append("senderId", senderId);

      $.ajax({
        type:'POST',
        data:formdata,
        url: CI_ROOT + "api/mail/users",
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend:function(){
          showLoader();
        },
        success:function(result){
          $("#toEmails").empty();
          
          if(result.status == "SUCCESS"){
            let mails = result.list.split(",");
            $.each(mails, function (i, item) {
              $("#toEmails").append(new Option(item,item));
            });
          }

          hideLoader();
        }
      });

    }
  });

  $("#sendMail").on("submit", function(e){
    e.preventDefault();        
    
    for (instance in CKEDITOR.instances){
      CKEDITOR.instances[instance].updateElement();
    }  

    let toEmails = $('.select2').val(); 
    let formdata = new FormData(this);
    formdata.append('toEmails', toEmails);

    $.ajax({
      type:'POST',
      data:formdata,
      url: CI_ROOT + "api/mail/send",
      contentType: false,
      processData: false,
      dataType: "json",
      beforeSend:function(){
        showLoader();
      },
      success:function(result){
        hideLoader();

        if(result.status == "SUCCESS"){
          swal({
            title: "Mail Sent",
            icon: "success",
            text: "",
          })
          .then( val => {
            window.location.reload();
          });
        }else if(result.status == "ERROR"){
          swal({
            title: "Message not delivered",
            icon: "error",
            text: "",
          });
        }else{
          $.each(result, function(i, v) {
            $("label[for='"+i+"']").html(v);
          });
          var keys = Object.keys(result);
          $(".error").css("display","block");
          $('input[name="'+keys[0]+'"]').focus();
        }
      }
    });

  });

});

function fetchUsers(){
  let caseId = $("#caseId").val();
  let senderId = $("#senderId").val();

  $.ajax({
    type : "POST",
        data :  { 
              caseId:caseId, 
              senderId:senderId
            },
    url : CI_ROOT + 'api/message/users',
    dataType: "json",

    beforeSend:function(){
      // showLoader();
    },

    success:function(result){ 
      // hideLoader();
      $(".proList").empty();

      if(result.status == "SUCCESS"){
        $(".proList").append(result.list);
      }
    }
  });
}

function fetchMessages(receiverId, name, pic){
  let caseId = $("#caseId").val();
  let senderId = $("#senderId").val();

  let chatHeader = `<i class="fa fa-angle-left" aria-hidden="true"></i><img src="${pic}" class="rounded-circle" /> ${name}`;
  $(".chatHeader").empty();
  $(".chatHeader").append(chatHeader);

  $(".replyWindow").show();
  $("#chatMessage").val("");
  $("#receiverId").val(receiverId);
  $("#receiverName").val(name);
  $("#receiverPic").val(pic);


  $.ajax({
    type : "POST",
    data : { 
          caseId:caseId, 
          senderId:senderId,
          receiverId:receiverId
        },
    url : CI_ROOT + 'api/message/inbox',
    dataType: "json",

    beforeSend:function(){
      showLoader();
    },

    success:function(result){ 
      hideLoader();
      $(".chatWindow").empty();

      if(result.status == "SUCCESS"){
        $(".chatWindow").append(result.messages);
       // $("#lastMessage").scrollIntoView();
      }
    }
  });
}