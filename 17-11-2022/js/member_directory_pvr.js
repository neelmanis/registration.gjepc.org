$(function() { 
	$(document).ready(function () {
		/*memberhip id check */
		$("#membership_id_y").click(function () {
			if($(this).attr("checked"))
				$('#member_of_gjf').show("slow");
		});
		
		$("#membership_id_n").click(function () {
			if($(this).attr("checked"))
				$('#member_of_gjf').hide("slow");
		});
		
		if($("#membership_id_y").attr("checked"))
		{
			$('#member_of_gjf').show("slow");
		}
		
		/* memberhip id check end */
		
		/* member of local association */
		
		$("#member_of_any_other_local_assoc_y").click(function () {
			if($(this).attr("checked"))
				$('#member_of_assoc_specify').show("slow");
		});
		
		$("#member_of_any_other_local_assoc_n").click(function () {
			if($(this).attr("checked"))
				$('#member_of_assoc_specify').hide("slow");
		});
		
		if($("#member_of_any_other_local_assoc_y").attr("checked"))
		{
			$('#member_of_assoc_specify').show("slow");
		}
		
		/* member of local association end */
		
		/* how do you learn about show */
		
		$("#how_do_you_learn_about_show_other").click(function () {
			if($(this).attr("checked"))
				$('#how_do_you_learn_about_show_specify').show("slow");
			else
				$('#how_do_you_learn_about_show_specify').hide("slow");
		});
		
		if($("#how_do_you_learn_about_show_other").attr("checked"))
				$('#how_do_you_learn_about_show_specify').show("slow");
				
		/* how do you learn about show */
		
		
		
		
		/* selection of obmp_profile_pvr */
		$('input[name="wa_jewellery[]"]').click(function(){
			if( $('input[name="wa_jewellery[]"]:checked').length != 0)
			{
				$("#wa_error").text("");
			}
		});
		
		$('input[name="pd_jewellery[]"]').click(function(){
			if( $('input[name="pd_jewellery[]"]:checked').length != 0)
			{
				$("#pd_error").text("");
			}
		});
			
		$('input[name="objective[]"]').click(function(){	
			if( $('input[name="objective[]"]:checked').length != 0)
			{
				$("#objective_error").text("");
			}
		});
		
		$('input[name="item_interest[]"]').click(function(){	
			if( $('input[name="item_interest[]"]:checked').length != 0)
			{
				$("#item_error").text("");
			}
		});	
		
		/* end selection of obmp_profile_pvr */
		
		
		
		/* show color gems on check */
		$("#color_gems").click(function () {
			if($(this).attr("checked"))
				$('#color_gems_view').show("slow");
			else
				$('#color_gems_view').hide("slow");
		});
		if($("#color_gems").attr("checked"))
			$('#color_gems_view').show("slow");
		/* end color gems */
		
		/* show loose diamonds on check */
		$("#loose_diamonds").click(function () {
			if($(this).attr("checked"))
				$('#loose_diamonds_view').show("slow");
			else
				$('#loose_diamonds_view').hide("slow");
		});
		if($("#loose_diamonds").attr("checked"))
			$('#loose_diamonds_view').show("slow");
		/* end loose diamonds */
		
		/* wa_jewellery check */
		$("#other-wa-jewellery").click(function () {
			if($(this).attr("checked"))
				$('#wa-jewellery-other-id').show("slow");
			else
				$('#wa-jewellery-other-id').hide("slow");
		});
		if($("#other-wa-jewellery").attr("checked"))
			$('#wa-jewellery-other-id').show("slow");
		/* end wa_jewellery check */
		
		/* pd_jewellery check */
		$("#other-pd-jewellery").click(function () {
			if($(this).attr("checked"))
				$('#pd-jewellery-other-id').show("slow");
			else
				$('#pd-jewellery-other-id').hide("slow");
		});
		if($("#other-pd-jewellery").attr("checked"))
			$('#pd-jewellery-other-id').show("slow");
		/* end pd_jewellery check */	
			
		/* other-obj-of-visit check */
		$("#other-obj-of-visit").click(function () {
			if($(this).attr("checked"))
				$('#obj-of-visit-other-id').show("slow");
			else
				$('#obj-of-visit-other-id').hide("slow");
		});
		if($("#other-obj-of-visit").attr("checked"))
			$('#obj-of-visit-other-id').show("slow");
		/* end other-obj-of-visit check */
		
		/* items_interested check */
		$("#items_interested_other").click(function () {
			if($(this).attr("checked"))
				$('#items_interested_other_id').show("slow");
			else
				$('#items_interested_other_id').hide("slow");
		});
		if($("#items_interested_other").attr("checked"))
			$('#items_interested_other_id').show("slow");
		/* end items_interested check */
	});
});

