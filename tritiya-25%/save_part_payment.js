$('document').ready(function(){
    savePayment.init();
});

var savePayment = new SavePayment();
var success_handler = function (success_response){
    
    $.ajax({
      type: 'POST',
      dataType: "json",
      url: 'save_allotment_payment.php',
      data: success_response,
      beforeSend:function(){        
      },
      success: function (response) {
        if(response.status == "success"){         
		 var delay = 1000;
		 document.getElementById("message").innerHTML = "Payment is Successfully Done";
		 setTimeout(function(){
		  window.location.href = response.redirect; 
		 },delay);
        //  window.location.href = response.redirect; 			
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

    function init() {
        $(".success-div").hide();
        $(".error-div").hide();
    }	
	
    function save() {
        $('.success-div').hide();
        let show = $("#show_type").val();
        var gid = $('#gid').val();        
        var balancePayment = $('#balancePayment').val();
		var cheque_tds_per = $('#cheque_tds_per').val();
        var cheque_tds_amount = $('#cheque_tds_amount').val();
        var cheque_tds_Netamount = $('#cheque_tds_Netamount').val(); 
        var selected_area = $('#selected_area').val();
        var tot_space_cost_rate = $('#tot_space_cost_rate').val();
        var sub_total_cost = $('#sub_total_cost').val();
        var security_deposit = $('#security_deposit').val();
        var govt_service_tax = $('#govt_service_tax').val();
		
        if(show == '' || show == null || show == undefined){
            $('.error').show().html("Please refresh the page and try again...");
            return false;
        }
		if(balancePayment == '' || balancePayment == null || balancePayment == undefined) {
           $('.error').show().html("Balance Amount Missing");
            return false;
        }
		
		if(cheque_tds_per == '' || cheque_tds_per == null || cheque_tds_per == undefined) {
           $('.error').show().html("Please Select TDS Percentage");
            return false;
        }
		
		if(cheque_tds_amount == '' || cheque_tds_amount == null || cheque_tds_amount == undefined) {
           $('.tds_error').show().html("Please Select TDS Amount");
            return false;
        } 
		
		if(cheque_tds_Netamount == '' || cheque_tds_Netamount == null || cheque_tds_Netamount == undefined) {
           $('.error').show().html("Please Enter Net Amount");
            return false;
        } 
		
        if(gid == '' || gid == null || gid == undefined) {
           $('.error').show().html("EXH ID Missing");
            return false;
        }
        var url = '';
        if(show == "signature"){
			url = "save_allotment_payment_signature.php";
        } else if(show == "tritiya"){
            url = "save_allotment_payment_tritiya.php";
        } else if(show == "igjme"){
            url = "save_allotment_payment_igjme.php";
        }
        if(url == '' || url == null || url == undefined){
            $('.error').show().html("URL Missing");
            return false;
        }
        $.ajax({
            // url : url,
            url : 'save_allotment_payment.php',
            type : 'POST',
            dataType : 'json',
            data: {
				'action':'submit','gid':gid,'balancePayment':balancePayment,'cheque_tds_per':cheque_tds_per,'cheque_tds_amount':cheque_tds_amount,'cheque_tds_Netamount':cheque_tds_Netamount,'selected_area':selected_area,'tot_space_cost_rate':tot_space_cost_rate,'tot_space_cost_rate':tot_space_cost_rate,'sub_total_cost':sub_total_cost,'security_deposit':security_deposit,'govt_service_tax':govt_service_tax,'show':show
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