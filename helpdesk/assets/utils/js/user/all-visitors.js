
  
  
  $(document).ready(function(){
          
      $("#onspot-form").on("submit", function(e){
      e.preventDefault();
      $(".error").html("");
      $(".error").css("display", "none");
  
      var nri_card_check = $('input[name="nri_card_check"]').val();
      var category = $("#category").val();

      if(category == "OV"){
        var pass_port = document.getElementById('pass_port').value;
        if(pass_port == null || pass_port == undefined || pass_port == ''){
          alert("Passport photo required");return false; 
        }
        var business_card = document.getElementById('business_card').value;
        if(business_card == null || business_card == undefined || business_card == ''){
          alert("Business card photo required");return false; 
        }
        if(nri_card_check == "yes"){
          var nri_card = document.getElementById('nri_card').value;
          if(nri_card == null || nri_card == undefined || nri_card == ''){
            alert("Nri Card photo required");return false;  
          }
        }
      }

      var formdata = new FormData(this);
      postForm(formdata,"user/visitors/addOnspotAction");
      
      // var t = new FormData(this);
      // t.append("nri_card_check", check);
      // $.ajax({
      //   type: "POST",
      //   data: t,
      //   url: CI_ROOT + "user/visitors/addOnspotAction",
      //   mimeType: "multipart/form-data",
      //   contentType: !1,
      //   processData: !1,
      //   dataType: "json",
      //   beforeSend: function(){
      //     showLoader();
      //   },
      //   success: function(result) {
      //     hideLoader(100,"fast");
      //     if(result.status == "success"){
      //       window.location.href = CI_ROOT + "user/dashboard";
      //     } else if(result.status == "alert"){
      //       swal({
      //         title: result.title,
      //         icon: result.icon,
      //         text: result.message
      //       });
      //     } else{
      //       $.each(result, function(e, t) {
      //         $("label[for='" + e + "']").html(t)
      //       });
      //       var t = Object.keys(result);
      //       $(".error").css("display", "block");
      //       $('input[name="' + t[0] + '"]').focus();
      //     }
      //   }
      // });
    });

      $(document).on("change","#category", function(e){
        e.preventDefault();
        let category = $(this).val();
        if(category == "OV"){
          $("#nri_ov_div").slideDown("slow");
        }else{
          $("#nri_ov_div").slideUp("slow");
        }
      });

      $(document).on("change","#country", function(e){
        e.preventDefault();

        let country = $(this).val();

        if(country == "107"){
          $("#state-div-select").show();
          $("#state-div-input").hide();
          
        }else{
          alert();
          $("#state-div-input").show();
          $("#state-div-select").hide();
         
        }
      });

      $(document).on("change",'input[name="nri_card_check"]', function(e){
        e.preventDefault();
        let value = $(this).val();
        if(value == "yes"){
          $("#nri_card_div").show();
        }else{
          $("#nri_card_div").hide();
        }
      });
    
    
    $("#update_visitor").on("submit", function(e){
      e.preventDefault();
  
      $(".error").html("");
      $(".error").css("display", "none");
      var category = $("#category").val();
      var check ='';
      if(category == "OV"){
        var nri_card = document.getElementById('nri_card').value;
        check = $('#nri_card_check').is(':checked');
        var ov = $("#category").val();
      }
      var t = new FormData(this);
      t.append("nri_card_check", check);
      $.ajax({
        type: "POST",
        data: t,
        url: CI_ROOT + "user/visitors/updateOnspotVisitorAction",
        mimeType: "multipart/form-data",
        contentType: !1,
        processData: !1,
        dataType: "json",
        // beforeSend: function(){
        //  showLoader();
        // },
        success: function(result) {
          //hideLoader();
          if(result.status == "success"){
            //window.location.href = CI_ROOT + "user/visitors/all_visitors";
            window.location.href = CI_ROOT + "user/dashboard";
          }else{
            $.each(result, function(e, t) {
              $("label[for='" + e + "']").html(t)
            });
            var t = Object.keys(result);
            $(".error").css("display", "block");
            $('input[name="' + t[0] + '"]').focus();
          }
        }
      })
    });
  
    
   
  
  });
  
