$('document').ready(function(){
    savePayment.init();
});

var savePayment = new SavePayment();
var success_handler = function (success_response){
    let show = $("#show_type").val();
    if(show == "signature23"){
        url = "save_payment_signature_test.php";
    }  
    if(show == "tritiya23"){
        url = "save_payment_tritiya_test.php";
    }
	if(show == "igjme23"){
        url = "save_payment_igjme_test.php";
    }
    $.ajax({
      type: 'POST',
      dataType: "json",
      //url: 'save_payment.php',
      url: url,
      data: success_response,
      beforeSend:function(){        
      },
      success: function (response) {
        if(response.status == "success"){         
          window.location.href = response.redirect;        
        }else if(response.status == "fail"){
          alert(response.error);
        }
      }
    });
  };
  
function SavePayment() {
    var basePath  = window.location.origin;
    var bean = {};
    this.init = init;
    this.save = save;
    this.save_payment_signature = save_payment_signature;

    function init() {
        $(".success-div").hide();
        $(".error-div").hide();
    }	
	
    function save(show) {
        /*if(show == "premiere"){
            url = "save_payment.php";
             var net_payable_amount = $('#net_payable_amount').val();
        } else */
        var gidData ;
        // alert(show);
		if(show == "signature23"){
			url = "save_payment_signature_test.php";
            var net_payable_amount = $('#net_payable_amount_signature').val();
            gidData = $('#sign_gidData').val();
        } else if(show == "tritiya23"){
            url = "save_payment_tritiya_test.php";
            var net_payable_amount = $('#net_payable_amount_tritiya').val();
            gidData = $('#tritiya_gidData').val();
        } else if(show == "igjme23"){
            url = "save_payment_igjme.php";
            var net_payable_amount = $('#net_payable_amount_igjme').val();
            gidData = $('#igjme_gidData').val();
        }
        $("#show_type").val(show);
        $('.success-div').hide();       
       
        // if(gidData == '' || gidData == null || gidData == undefined) {
        //    $('.error-div').show().html("EXH ID Missing");
        //     return false;
        // }
		
		if(net_payable_amount == '' || net_payable_amount == null || net_payable_amount == undefined) {
           $('.error-div').show().html("Amount Missing");
            return false;
        }

        $.ajax({
            //url : 'save_payment.php',
            url : url,
            type : 'POST',
            dataType : 'json',
            data: {
				'action':'submit','gidData':gidData,'net_payable_amount':net_payable_amount
            },
            success : function(response){
                if(response.status == "fail") {
                    $('.error-div').show().html(response.message);
                    document.documentElement.scrollTop = 0;
                } else {
                    response.handler = success_handler;
                    response.modal = {
                        ondismiss: function(){
                        },
                        escape: false,
                        backdropclose: false
                    };
                    var rzp = new Razorpay(response);
                    rzp.open();
                }
            }           
        });
        return false;
    }

    function save_payment_signature(show) {
        console.log(show);
        $('.success-div').hide();
        var gidData = $('#gidData').val();
        var net_payable_amount = $('#net_payable_amount').val();

        if(gidData == '' || gidData == null || gidData == undefined) {
           $('.error-div').show().html("EXH ID Missing");
            return false;
        }
        
        if(net_payable_amount == '' || net_payable_amount == null || net_payable_amount == undefined) {
           $('.error-div').show().html("Amount Missing");
            return false;
        }

        $.ajax({
            url : 'save_payment_signature_test.php',
            type : 'POST',
            dataType : 'json',
            data: {
                'action':'submit','gidData':gidData,'net_payable_amount':net_payable_amount
            },
            success : function(response){
                if(response.status == "fail") {
                    $('.error-div').show().html(response.message);
                    document.documentElement.scrollTop = 0;
                } else {
                    response.handler = success_handler;
                    response.modal = {
                        ondismiss: function(){
                        },
                        escape: false,
                        backdropclose: false
                    };
                    var rzp = new Razorpay(response);
                    rzp.open();
                }
            }           
        });
        return false;
    }
}

// function save_payment_signature() {
//     var basePath  = window.location.origin;
//     var bean = {};
//     this.init = init;
//     this.save = save;

//     function init() {
//         $(".success-div").hide();
//         $(".error-div").hide();
//     }   
    
   
// }

function save_payment_tritiya() {
    var basePath  = window.location.origin;
    var bean = {};
    this.init = init;
    this.save = save;

    function init() {
        $(".success-div").hide();
        $(".error-div").hide();
    }   
    
    function save() {
        $('.success-div').hide();
        var gidData = $('#gidData').val();
        var net_payable_amount = $('#net_payable_amount').val();

        if(gidData == '' || gidData == null || gidData == undefined) {
           $('.error-div').show().html("EXH ID Missing");
            return false;
        }
        
        if(net_payable_amount == '' || net_payable_amount == null || net_payable_amount == undefined) {
           $('.error-div').show().html("Amount Missing");
            return false;
        }

        $.ajax({
            url : 'save_payment_tritiya.php',
            type : 'POST',
            dataType : 'json',
            data: {
                'action':'submit','gidData':gidData,'net_payable_amount':net_payable_amount
            },
            success : function(response){
                if(response.status == "fail") {
                    $('.error-div').show().html(response.message);
                    document.documentElement.scrollTop = 0;
                } else {
                    response.handler = success_handler;
                    response.modal = {
                        ondismiss: function(){
                        },
                        escape: false,
                        backdropclose: false
                    };
                    var rzp = new Razorpay(response);
                    rzp.open();
                }
            }           
        });
        return false;
    }
}