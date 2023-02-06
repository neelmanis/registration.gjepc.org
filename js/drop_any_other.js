$(document).ready(function(){
	//alert("hello");
	$(".dropOther").click(function(){
		$id = $(this).attr("id")
		var textbox = $id+"_text";
		var input = $id+"_input";
		if($(this).attr("checked"))
			$("#"+textbox).slideDown();
		else
		{
			$("#"+textbox).slideUp();
			$("#"+input).val("");
		}
	});
	
	if($("#wa_jewellery_other").attr("checked"))
		$("#wa_jewellery_other_text").show();
	
	if($("#wa_machinery_other").attr("checked"))
		$("#wa_machinery_other_text").show();
	
	if($("#we_are_other").attr("checked"))
		$("#we_are_other_text").show();
	
	
});
