$(document).ready(function(){
$("#delivery_id").val($('#address_selection').val());
$("#billing_delivery_id").val($('#billing_address_selection').val());
$('#address_selection').change(function(){
$("#delivery_id").val($(this).val());
});
$('#billing_address_selection').change(function(){
$("#billing_delivery_id").val($(this).val());
});
});
$(document).ready(function(){
$('.multipleSelect').fastselect();
$('#address_selection').change(function(){
var address_selection = $(this).val();
if(address_selection !=""){
localStorage.setItem("address_selection", address_selection);
}
});
$('#billing_address_selection').change(function(){
var billing_address_selection = $(this).val();
if(billing_address_selection !=""){
localStorage.setItem("billing_address_selection", billing_address_selection);
}
});
$(window).load(function(){
var get_address_selection  = localStorage.getItem("address_selection");
var get_billing_address_selection = localStorage.getItem("billing_address_selection");
$('#delivery_id').val(get_address_selection);
$('#billing_delivery_id').val(get_billing_address_selection);
if(get_address_selection !="" || get_address_selection != undefined || get_address_selection != null){
$('#address_selection option').each(function(){
if ($(this).val() == get_address_selection) {
$(this).attr("selected", true);
}
});
}
if(get_billing_address_selection !="" || get_billing_address_selection != undefined || get_billing_address_selection != null){
$('#billing_address_selection option').each(function(){
if ($(this).val() == get_billing_address_selection) {
$(this).attr("selected", true);
}
});
}
});
});
$(document).ready(function(){
$("#payment_made_for").on("change", function(){
var visitors = $("#visitor_id").val();
// var visitorArr = visitors.split(',');
$(".error").css("display","none");
if(visitors ==null){
$("label[for='visitor_id']").html("Please Select Visitors");
$("#visitor_id").focus();
$(".error").css("display","block");
$("#payment_made_for option:selected").prop("selected", false);
return false;
}else{
$("label[for='visitor_id']").html("");
if( visitors.length>0 ){
var totalVisitors = visitors.length;
var action = "visitorsFeesCalculation";
var show = $(this).val();
getVisitorsFees(action,totalVisitors,show);
}
}
});
$("#visitor_id").on("change", function(){
var visitors = $(this).val();
if(visitors !=null){
if(visitors.length>0 ){
var totalVisitors = visitors.length;
var action = "visitorsFeesCalculation";
var show = $("#payment_made_for").val();
getVisitorsFees(action,totalVisitors,show);
}else{
$("#participation_fee").val("");
return false;
}
}else{
$("#payment_made_for option:selected").prop("selected", false);
$("#visitor_id option:selected").prop("selected", false);
$("#participation_fee").val("");
return  false;
}
});
function getVisitorsFees(action,totalVisitors,show)
{
$.ajax({
type: "POST",
url: "visitorsFeesCalculation.php",
data:{action:action,totalVisitors:totalVisitors,show:show},

beforeSend: function(){
$('.loader').show();
},
success: function(response){

$('.loader').hide();
$("#participation_fee").val(response);
$("#add_visitor").removeAttr("disabled");

}
});
}
});
$(document).ready(function(){
$("#add_visitor").on('click',function(){
$(".error").html("");
Item_Data=$("#item_selection").serialize();
if(($("#visitor_id").val()=="" || $("#visitor_id").val()=="0" || $("#visitor_id").val()==null ) && ($("#payment_made_for").val()=="" || $("#payment_made_for").val()=="0")){
$("label[for='visitor_id']").html("Please Select Visitors");
$("#visitor_id").focus();
$("label[for='payment_made_for']").html("Please Select Show");
$("#payment_made_for").focus();
$("label[for='participation_fee']").html("Amount not calculated");
$("#participation_fee").focus();
return false;
}
if($("#visitor_id").val()=="" || $("#visitor_id").val()=="0")
{
$("label[for='visitor_id']").html("Please Select Visitors");
$("#visitor_id").focus();
$("label[for='participation_fee']").html("Amount not calculated");
$("#participation_fee").focus();
return false;
}
if($("#payment_made_for").val()=="" || $("#payment_made_for").val()=="0")
{
$("label[for='payment_made_for']").html("Please Select Show");
$("#payment_made_for").focus();
$("label[for='participation_fee']").html("Amount not calculated");
$("#participation_fee").focus();
return false;
}
$.ajax({
type: 'POST',
url: 'visitorCartAction.php',
data: "actiontype=saveVisitorDetails&Item_Data="+Item_Data,
dataType:'json',
beforeSend: function(){
$('#progress').show();
},
success: function(data)
{	//alert(data);
$('#progress').hide();
if(data.status =="allEmpty"){
$("label[for='visitor_id']").html("Please Select Visitors");
$("#visitor_id").focus();
$("label[for='payment_made_for']").html("Please Select Show");
$("#payment_made_for").focus();
$("label[for='participation_fee']").html("Amount not calculated");
$("#participation_fee").focus();

}else if(data.status =="visEmpty"){
$("label[for='visitor_id']").html("Please Select Visitors");
$("#visitor_id").focus();
}else if(data.status =="showEmpty"){
$("label[for='payment_made_for']").html("Please Select Show");
$("#payment_made_for").focus();
}else if(data.status =="success"){
$('#item_selection')[0].reset();
alert("Visitor has been Added");
window.location.reload();
}
}
});
});
$(".deleteOrder").on('click',function(){
var currentClass = $(this).attr('class');
//alert(currentClass);
var claasArray = currentClass.split(" ");
v_id=claasArray[1]; //alert(id);
if(confirm("Are you sure you want to remove this visitor?"))
{
$.ajax({ type: 'POST',
url: 'actionAjax.php',
data: "actiontype=deleteItemDetails&v_id="+v_id,
dataType:'html',
beforeSend: function(){
},
success: function(data){
//alert(data);
alert("Visitor has been removed");
window.location.reload();
}
});
}
else
{
return false;
}
});
});