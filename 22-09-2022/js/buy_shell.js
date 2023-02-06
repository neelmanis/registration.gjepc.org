$(function() { 
	$(document).ready(function () {
	
	  $item_description = '';
		$("#edit-item-description").live('click',function () {
				if($(this).attr("checked") && $(this).val() == "any other")
				{
					$('#item-description-other-id').show("slow");
					$item_description = $(this).text();
				}
				else if($(this).val() == "any other")
				{
					$('#item-description-other-id').hide("slow");
				}
        });
		if($item_description != "any other") {
				$('#edit-item-description-other').val("");
		}

								
								
		$wa_jewellery = '';
		$("#edit-wa-jewellery").live('click',function () {
			if($(this).attr("checked") && $(this).val() == "any other")
			{
				$('#wa-jewellery-other-id').show("slow");
				$wa_jewellery = $(this).val();
			}
			else if($(this).val() == "any other")
			{
				$('#wa-jewellery-other-id').hide("slow");
			}
        });
		if($wa_jewellery != "any other") {
				$('#edit-wa-jewellery-other').val("");
		}
		
		$wa_machinery = '';
		$("#edit-wa-machinery").live('click',function () {
		if($(this).attr("checked") && $(this).val() == "any other")
		{
			$('#wa-machinery-other-id').show("slow");
			$wa_machinery = $(this).val();
		}
		else if($(this).val() == "any other")
		{
			$('#wa-machinery-other-id').hide("slow");
		}
        });
		if($wa_machinery != "Any Other") {
				$('#edit-wa-machinery-other').val("");
		}
	
		$wa_other = '';
		$("#edit-wa-other").live('click',function () {
		if($(this).attr("checked") && $(this).val() == "any other")
		{
			$('#wa-other-other-id').show("slow");
			$wa_other = $(this).val();
		}
		else if($(this).val() == "any other")
		{
			$('#wa-other-other-id').hide("slow");
		}
        });
		if($wa_other != "Any Other") {
				$('#edit-wa-other-other').val("");
		}

		$pd_jewellery = '';
		$("#edit-pd-jewellery").live('click',function () { 
		if($(this).attr("checked") && $(this).val() == "any other")
		{
			$('#pd-jwellery-other-id').show("slow");
			$pd_jewellery = $(this).val();
		}
		else if($(this).val() == "any other")
		{
			$('#pd-jwellery-other-id').hide("slow");
		}
		
		if($(this).attr("checked") && $(this).val() == "loose diamonds")
		{
			$('#diamond-requirement-id').show("slow");
			$pd_jewellery = $(this).val();
		}
		else if($(this).val() == "loose diamonds")
		{
			$('#diamond-requirement-id').hide("slow");
		}
		if($(this).attr("checked") && $(this).val() == "coloured gemstones")
		{
			$('#coloured-gem-stone-requirement-id').show("slow");
			$pd_jewellery = $(this).val();
		}
		else if($(this).val() == "coloured gemstones")
		{
			$('#coloured-gem-stone-requirement-id').hide("slow");
		}
		
        });
		if($pd_jewellery != "any other") {
				$('#edit-pd-jewellery-othe').val("");
		}

		$pd_machinery = '';
		$("#edit-pd-machinery").live('click',function () { 
		if($(this).attr("checked") && $(this).val() == "any other")
		{
			$('#pd-machinery-other-id').show("slow");
			$pd_machinery = $(this).val();
		}
		else if($(this).val() == "any other")
		{
			$('#pd-machinery-other-id').hide("slow");
		}
        });
		if($pd_machinery != "any other") {
				$('#edit-pd-machinery-other').val("");
		}
	});
});
