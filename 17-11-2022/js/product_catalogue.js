$(function() { 
	$(document).ready(function () {
		$product_category = '';
		$("#product_category").change(function () {
												
				if ($(this).val() == "Any Other")
				{
					$('#product_category_other_show').show("slow");
					$product_category = $(this).val();
				}
				else
				{
					$('#product_category_other_show').hide("slow");
				}
        });
		
		$product_sub_category = '';
		$("#product_sub_category").change(function () {
												
				if ($(this).val() == "Any Other")
				{
					$('#product_sub_category_other_show').show("slow");
					$product_sub_category = $(this).val();
				}
				else
				{
					$('#product_sub_category_other_show').hide("slow");
				}
        });
		
		
		$metal_category = '';
		$("#metal_category").change(function () {
												
				if ($(this).val() == "Any Other")
				{
					$('#metal_category_other_show').show("slow");
					$metal_category = $(this).val();
				}
				else
				{
					$('#metal_category_other_show').hide("slow");
				}
        });
		
		$metal_sub_category = '';
		$("#metal_sub_category").change(function () {
												
				if ($(this).val() == "Any Other")
				{
					$('#metal_sub_category_other_show').show("slow");
					$metal_sub_category = $(this).val();
				}
				else
				{
					$('#metal_sub_category_other_show').hide("slow");
				}
        });
		
		
		
	});
});
