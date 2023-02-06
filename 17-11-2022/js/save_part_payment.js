$('document').ready(function(){
    savePartPayment.init();
});

var savePartPayment = new SavePartPayment();
var success_handler = function (success_response){
    
    $.ajax({
      type: 'POST',
      dataType: "json",
      url: 'save_part_payment.php',
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
  
function SavePartPayment() {
    var basePath  = window.location.origin;
    var bean = {};
    this.init = init;
    this.savePart = savePart;

    function init() {
        $(".success-div").hide();
        $(".error-div").hide();
    }	
	
    function savePart() { 
        $('.success-div').hide();
        let shows = $("#show_type").val();
        var gid = $('#gid').val();        
        var payment_percentage = $('#payment_percentage').val();
        var balancePayment = $('#balancePayment').val();
		var cheque_tds_per = $('#cheque_tds_part_per').val();
        var cheque_tds_amount = $('#cheque_tds_amount').val();
        var cheque_tds_Netamount = $('#cheque_tds_Netamount').val(); 
        var selected_area = $('#selected_area').val();
        var tot_space_cost_rate = $('#tot_space_cost_rate').val();
        var sub_total_cost = $('#sub_total_cost').val();
        var security_deposit = $('#security_deposit').val();
        var govt_service_tax = $('#govt_service_tax').val();
		
        if(shows == '' || shows == null || shows == undefined){
            $('.error').show().html("Please refresh the page and try again...");
            return false;
        }
		
		if(payment_percentage == '' || payment_percentage == null || payment_percentage == undefined) {
           $('.payment_percentage_error').show().html("Select Part payment");
            return false;
        }
		
		if(balancePayment == '' || balancePayment == null || balancePayment == undefined) {
           $('.error').show().html("Balance Amount Missing");
            return false;
        }
		
		if(cheque_tds_per == '' || cheque_tds_per == null || cheque_tds_per == undefined) {
           $('.cheque_tds_per_error').show().html("Please Select TDS in Percentage");
            return false;
        }
		
		if(cheque_tds_amount == '' || cheque_tds_amount == null || cheque_tds_amount == undefined) {
           $('.cheque_tds_amount_error').show().html("Please Enter TDS Amount");
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
		if(shows == "tritiya"){
            url = "save_part_payment.php";
        }
        /*if(shows == "signature"){
			url = "save_allotment_payment_signature.php";
        } else if(shows == "tritiya"){
            url = "save_allotment_payment_tritiya.php";
        } else if(shows == "igjme"){
            url = "save_allotment_payment_igjme.php";
        } */
        if(url == '' || url == null || url == undefined){
            $('.error').show().html("URL Missing");
            return false;
        }
        $.ajax({
             url : url,
            //url : 'save_part_payment.php',
            type : 'POST',
            dataType : 'json',
            data: {
				'action':'submit','gid':gid,'balancePayment':balancePayment,'cheque_tds_per':cheque_tds_per,'payment_percentage':payment_percentage,'cheque_tds_amount':cheque_tds_amount,'cheque_tds_Netamount':cheque_tds_Netamount,'selected_area':selected_area,'tot_space_cost_rate':tot_space_cost_rate,'tot_space_cost_rate':tot_space_cost_rate,'sub_total_cost':sub_total_cost,'security_deposit':security_deposit,'govt_service_tax':govt_service_tax,'shows':shows
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