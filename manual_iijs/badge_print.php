<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))	{		header("location:index.php");		exit; }	
?>

<?php 


$hostname = "localhost";
$uname = "gjepcliveuserdb";
$pwd = "KGj&6(pcvmLk5";
$database = "gjepclivedatabase";

// Create connection
$conn1 = new mysqli($hostname, $uname, $pwd, $database);


?>

<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc(); 
$registration_id=$fetch_data['Exhibitor_Registration_ID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!--navigation script end-->
<script type="text/javascript">
$(document).ready(function(){

  $("#scroller .item").css("width", 986);
	$("#scroller").scrollable({
			circular: true,
			speed: 1500
	}).autoscroll({ interval: 9000 }).navigator();
	api = $('#scroller').data("scrollable");
	$(window).resize(function() {
		if($('#scroller .items:animated').length == 0) {
			$("#scroller .item").css("width", $(document).width());
			nleft = $(document).width() * (api.getIndex() + 1);
			$("#scroller .items").css("left", "-"+nleft+"px");
		}
	});
}); 


</script>
<!--  SLIDER Ends  -->

<!-- place holder script for ie -->
<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();
            $(active).focus();
        }
    });
</script>    
	<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	<link rel="stylesheet" href="../css/style.css" />
	<script type="text/javascript">
		$(document).ready(function() {
			$(".example2").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
		});
	</script>
 <!--fancybox ends-->
<!--manual form css-->
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
</head>
<body>
<!-- header starts -->
<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>
<!-- header ends -->
<div class="clear"></div>
<div class="clear"></div>
<div class="container_wrap">
<div class="container">
<h1>Online Manual </h1>

<h3> Print Badges</h3>
<table id="example" class="display" cellspacing="0" border="1" width="100%">
	<tr>                
		<td><strong>Person Name</strong></td>
		<td><strong>Action</strong></td>
	</tr>  
	<?php 
		 $query_sel = "SELECT * FROM `globalExhibition` where registration_id='$registration_id' and participant_Type='EXH'";
		$result = $conn1->query($query_sel);
		while($row = $result->fetch_assoc()){
			$unique_code=$row['uniqueIdentifier'];
			
	?>	
	<tr>                
		<td><?php echo $row['fname'];?></td>
		<td><a href="https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier=<?php echo $unique_code; ?>" target="_blank" >Print</a></td>
	</tr> 
	<?php }?>
</table>
<div class="clear"></div>   
</tbody>
</table>
<div class="clear"></div>

</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>
