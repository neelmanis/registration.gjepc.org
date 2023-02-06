$(function() { 

	$(document).ready(function () {
		// Product Type Category Starts
		$product_category = '';
		$("#product_category").change(function () {									  
				//alert($(this).val());											  
			if ($(this).val() == "Please Select")
			{
				$("#product_sub_category option[value='plain']").hide();
				$("#product_sub_category option[value='diamond studded']").hide();
				$("#product_sub_category option[value='colorstone studded']").hide();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").hide();
			}

			if ($(this).val() == "rings")
			{
				$("#product_sub_category option[value='plain']").hide();
				$("#product_sub_category option[value='diamond studded']").hide();
				$("#product_sub_category option[value='colorstone studded']").hide();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "bangles")
			{
				$("#product_sub_category option[value='plain']").show();
				$("#product_sub_category option[value='diamond studded']").show();
				$("#product_sub_category option[value='colorstone studded']").show();
				$("#product_sub_category option[value='bracelet']").show();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "pendants")
			{
				$("#product_sub_category option[value='plain']").show();
				$("#product_sub_category option[value='diamond studded']").show();
				$("#product_sub_category option[value='colorstone studded']").show();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "earrings")
			{
				$("#product_sub_category option[value='plain']").hide();
				$("#product_sub_category option[value='diamond studded']").hide();
				$("#product_sub_category option[value='colorstone studded']").hide();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").show();
				$("#product_sub_category option[value='hoops']").show();
				$("#product_sub_category option[value='drops']").show();
				$("#product_sub_category option[value='clusters']").show();
				$("#product_sub_category option[value='solitaire earrings']").show();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "bridal")
			{
				$("#product_sub_category option[value='plain']").hide();
				$("#product_sub_category option[value='diamond studded']").hide();
				$("#product_sub_category option[value='colorstone studded']").hide();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").show();
				$("#product_sub_category option[value='engagement rings']").show();
				$("#product_sub_category option[value='matching wedding sets']").show();
				$("#product_sub_category option[value='grooms rings']").show();
				$("#product_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "chains")
			{
				$("#product_sub_category option[value='plain']").hide();
				$("#product_sub_category option[value='diamond studded']").hide();
				$("#product_sub_category option[value='colorstone studded']").hide();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "necklace")
			{
				$("#product_sub_category option[value='plain']").hide();
				$("#product_sub_category option[value='diamond studded']").hide();
				$("#product_sub_category option[value='colorstone studded']").hide();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "Any Other")
			{
				$("#product_sub_category option[value='plain']").hide();
				$("#product_sub_category option[value='diamond studded']").hide();
				$("#product_sub_category option[value='colorstone studded']").hide();
				$("#product_sub_category option[value='bracelet']").hide();
				$("#product_sub_category option[value='studs']").hide();
				$("#product_sub_category option[value='hoops']").hide();
				$("#product_sub_category option[value='drops']").hide();
				$("#product_sub_category option[value='clusters']").hide();
				$("#product_sub_category option[value='solitaire earrings']").hide();
				$("#product_sub_category option[value='wedding bands']").hide();
				$("#product_sub_category option[value='engagement rings']").hide();
				$("#product_sub_category option[value='matching wedding sets']").hide();
				$("#product_sub_category option[value='grooms rings']").hide();
				$("#product_sub_category option[value='any other']").show();
			}
        });
		

		// Metal Category Starts
		$metal_category = '';
		$("#metal_category").change(function () {
			if ($(this).val() == "Please Select")
			{
				$("#edit-metal-sub-category option[value='yellow']").hide();
				$("#edit-metal-sub-category option[value='white']").hide();
				$("#edit-metal-sub-category option[value='rose']").hide();
				$("#edit-metal-sub-category option[value='any other']").hide();
			}

			if ($(this).val() == "silver")
			{
				$("#metal_sub_category option[value='yellow']").hide();
				$("#metal_sub_category option[value='white']").hide();
				$("#metal_sub_category option[value='rose']").hide();
				$("#metal_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "gold")
			{
				$("#metal_sub_category option[value='yellow']").show();
				$("#metal_sub_category option[value='white']").show();
				$("#metal_sub_category option[value='rose']").show();
				$("#metal_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "platinum")
			{
				$("#metal_sub_category option[value='yellow']").hide();
				$("#metal_sub_category option[value='white']").hide();
				$("#metal_sub_category option[value='rose']").hide();
				$("#metal_sub_category option[value='any other']").show();
			}

			if ($(this).val() == "Any Other")
			{
				$("#metal_sub_category option[value='yellow']").hide();
				$("#metal_sub_category option[value='white']").hide();
				$("#metal_sub_category option[value='rose']").hide();
				$("#metal_sub_category option[value='any other']").show();

				$('#metal-category-other-id').show("slow");
				$metal_category = $(this).val();
			}

  		});
	});
});