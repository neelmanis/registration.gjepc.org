<?php include('header_include.php');
	if(!isset($_SESSION['USERID'])){
		header("location:login.php");
		exit;
	}
?>
<?php 
$registration_id=$_SESSION['USERID'];
if(isset($_REQUEST['add_more']))
{
	$registration_id=$_SESSION['USERID'];
	$product_title=$_REQUEST['product_title'];
	$product_description=addslashes($_REQUEST['product_description']);
	$product_category=addslashes($_REQUEST['product_category']);
	$product_category_other=addslashes($_REQUEST['product_category_other']);
	$password=generatePassword();
	$product_sub_category=addslashes($_REQUEST['product_sub_category']);
	$product_sub_category_other=addslashes($_REQUEST['product_sub_category_other']);
	$metal_category=addslashes($_REQUEST['metal_category']);
	$metal_category_other=addslashes($_REQUEST['metal_category_other']);
	$metal_sub_category=addslashes($_REQUEST['metal_sub_category']);
	$metal_sub_category_other=$_REQUEST['metal_sub_category_other'];
	$metal_carat=addslashes($_REQUEST['metal_carat']);
	$metal_weight=$_REQUEST['metal_weight'];
	$diamond_carat=$_REQUEST['diamond_carat'];
	$diamond_weight=$_REQUEST['diamond_weight'];

	//-------------------------------Product Catalogue  -------------------------------
		$profile_detail = '';
		$target_folder = 'product_catalogue/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		if($_FILES['product_image_fid']['name']!='')
		{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['product_image_fid']['name'];
				if(@move_uploaded_file($_FILES['product_image_fid']['tmp_name'], $target_path))
				{
				echo $product_image_fid = $temp_code.'_'.$_FILES['product_image_fid']['name'];
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='product_catalogue.php';</script>";
				return;
				}
		}
	$ip=$_SERVER['REMOTE_ADDR'];
	$created=date('Y-m-d');
	
	$sql="insert into product_catalogue set uid='$registration_id',product_title='$product_title',product_description='$product_description',product_category='$product_category',product_category_other='$product_category_other',product_sub_category='$product_sub_category',product_sub_category_other='$product_sub_category_other',metal_category='$metal_category',metal_category_other='$metal_category_other',metal_sub_category='$metal_sub_category',metal_sub_category_other='$metal_sub_category_other',metal_carat='$metal_carat',metal_weight='$metal_weight',diamond_carat='$diamond_carat',diamond_weight='$diamond_weight',product_image_fid='$product_image_fid',ip='$ip',created='$created',adminstatus='1'";	
	$ok = $conn->query($sql);
	$_SESSION['msg']="Added successfully";
	header("location:product_catalogue.php");
	exit;
}

if(isset($_REQUEST['action']) && $_REQUEST['action']="delete")
{
	$id=$_REQUEST['id'];
	$conn->query("delete from product_catalogue where id='$id'");
	$_SESSION['msg']="Deleted successfully";
	header("location:product_catalogue.php");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Product Catalog</title>

<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/form.css" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>  
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script> 
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
    
<script src="jsvalidation/jquery.js" type="text/javascript"></script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 

<script type="text/javascript" src="js/product_catalogue.js"></script>
<script type="text/javascript" src="js/obmp_product_catalogue.js"></script>

<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
			//var member_id=$("#member_type_id").val();
		rules: {  
			product_title: {
				required: true,
			},
			product_description: {
			required: true,
			},  
			product_category: {
				required: true,
			},  
			product_sub_category: {
				required: true,
			},
			metal_category: {
				required: true,
			}, 	 
			metal_sub_category: {
				required: true,
			},
			metal_carat:
			{
				required: true,
			},
			metal_weight: {
				required: "Please enter metal weight",
			},
			metal_weight:{
			required: true,
			},
			diamond_carat:{
			required: true,
			},
			diamond_weight:{
			required: true,
			}
			
		},
		messages: {
			product_title: {
				required: "Please enter a project title",
			},
			product_description: {
				required: "Please enter product description",
			},
			product_category: {
				required: "Please select product category",
			},
			product_sub_category: {
				required: "Please select product sub category",
			},   
			metal_category: {
				required: "Please select metal category",
			},  
			metal_sub_category: {
				required: "Please select metal sub category",
			},   
			metal_carat: {
				required: "Please enter metal carat",
			},
			metal_weight: {
				required: "Please enter metal weight",
			},
			metal_weight: {
				required: "Please enter metal weight",
			},  
			diamond_carat: {
				required: "Please enter diamond_carat",
			},
			diamond_weight: {
				required: "Please enter diamond weight",
			}
	 	}
	});
});
</script>

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="inner_container">
	<div class="container">
    	<div class="container_left">
        	
            <div class="breadcrum"><a href="index.php">Home</a> > OBMP > Product Catalogue</div>  
        	<?php 
			if($_SESSION['msg']!=""){
			echo "<span class='notification n-success'>".$_SESSION['msg']."</span>";
			$_SESSION['msg']="";
			}
            ?>
        	<div class="clear"></div>
    
    <div class="content_area">
    
    <div class="pg_title">
    
    <div class="title_cont">
        <span class="top">OBMP <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">Product Catalogue</span>
        <div class="clear"></div>
    </div>
    
    </div> 
    <div class="clear"></div>
       
<div id="formContainer">

        <form class="cmxform" method="post" name="from1" id="form1" enctype="multipart/form-data">
            
            <div id="form">
            <div class="title">
            <h4>Product Details</h4>
            </div>
            
            <div class="clear"></div>
            <div class="borderBottom"></div>
            <div class="field">
            <label>Product Title : <sup>*</sup></label>
            <input name="product_title" id="product_title" type="text"  class="textField"/>             
            <div class="clear"></div>            
            </div>
            
            <div class="field">
            <div class="leftTitle">Product Description : <sup>*</sup> </div>
            <textarea name="product_description" id="product_description" cols="" rows="" class="textField"></textarea>           
            <div class="clear"></div>
            </div>
            
            <div class="field">
            <div class="leftTitle">Product Category : <sup>*</sup> </div>
            <select name="product_category" id="product_category" class="textField">
          	   <option value="">Please Select</option>
           		<option value="rings">Rings</option>
                <option value="bangles">Bangles</option>
                <option value="pendants">Pendants</option>
                <option value="earrings">Earrings</option>
                <option value="bridal">Bridal</option>
                <option value="chains">Chains</option>
                <option value="necklace">Necklace</option>
                <option value="Any Other">Any Other</option>	
			</select>            
            <div class="clear"></div>
            </div>
            
            <div class="field" style="display:none;" id="product_category_other_show">
            <label>Any other, please specify : </label>
            <input name="product_category_other" id="product_category_other" type="text"  class="textField"/>            
            <div class="clear"></div>
            </div> 
            
           <div class="field">
            <div class="leftTitle">Product Sub Category: <sup>*</sup> </div>
            <select name="product_sub_category" id="product_sub_category" class="textField">
                <option selected="selected" value="">Please Select</option>
                <option value="plain" style="display: none;">Plain</option>
                <option value="diamond studded" style="display: none;">Diamond Studded</option>
                <option value="colorstone studded" style="display: none;">Colorstone Studded</option>
                <option value="bracelet" style="display: none;">Bracelet</option>
                <option value="studs" style="display: none;">Studs</option>
                <option value="hoops" style="display: none;">Hoops</option>
                <option value="drops" style="display: none;">Drops</option>
                <option value="clusters" style="display: none;">Clusters</option>
                <option value="solitaire earrings" style="display: none;">Solitaire Earrings</option>
                <option value="wedding bands" style="display: none;">Wedding Bands</option>
                <option value="engagement rings" style="display: none;">Engagement Rings</option>
                <option value="matching wedding sets" style="display: none;">Matching Wedding Sets</option>
                <option value="grooms rings" style="display: none;">Groom's Rings</option>
                <option value="Any Other">Any Other</option>	
			</select>                        
            <div class="clear"></div>
            </div> 
            
            <div class="field" style="display:none;" id="product_sub_category_other_show">
            <label>Any other, please specify  : <sup>*</sup></label>
            <input name="product_sub_category_other" id="product_sub_category_other" type="text"  class="textField"/>                        
            <div class="clear"></div>
            </div>
            <div class="clear"></div>
			          
            <div class="bottomSpace"></div>
            <div class="title"><h4>Metal Details</h4></div>
            <div class="clear"></div>
            <div class="borderBottom"></div>
                        
            <div class="field">
            <div class="leftTitle">Metal Category : <sup>*</sup> </div>
            <select name="metal_category" id="metal_category" class="textField">
                <option selected="selected" value="">Please Select</option>
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
                <option value="platinum">Platinum</option>
                <option value="Any Other">Any Other</option>	
			</select>
            <div class="clear"></div>
            </div>
            
            <div class="field" style="display:none;" id="metal_category_other_show">
            <label>Any other, please specify : </label>
            <input name="metal_category_other" id="metal_category_other" type="text"  class="textField"/>            
            <div class="clear"></div>
            </div>
            
            <div class="field">
            <div class="leftTitle">Metal Sub Category  : <sup>*</sup> </div>
            <select name="metal_sub_category" id="metal_sub_category" class="textField">
                <option  value="">Please Select</option>
                <option value="yellow" style="display: none;">Yellow</option>
                <option value="white" style="display: none;">White</option>
                <option value="rose" style="display: none;">Rose</option>
                <option value="Any Other">Any Other</option>
			</select>            
            <div class="clear"></div>
            </div>
            
            <div class="field" style="display:none;" id="metal_sub_category_other_show">
            <label>Any other, please specify : </label>
            <input name="metal_sub_category_other" id="metal_sub_category_other" type="text"  class="textField"/>            
             <div class="clear"></div>
            </div>
            
            <div class="field">
            <label>Enter Carats : </label>
            <input name="metal_carat" id="metal_carat" type="text" class="textField"/>            
            <div class="clear"></div>
            </div>
            
            <div class="field">
            <div class="leftTitle">Enter Weight (in grams) :  </div>
            <input name="metal_weight" id="metal_weight" type="text" class="textField"/>            
            <div class="clear"></div>
            </div>            
            
            <div class="clear"></div>
            <div class="bottomSpace"></div>
            <div class="title"><h4>Diamond Details</h4></div>
            
            <div class="clear"></div>
            <div class="borderBottom"></div>
            <div class="field">
            <label>Enter Carats : <sup>*</sup></label>
            <input name="diamond_carat" id="diamond_carat" type="text"  class="textField"/>            
            <div class="clear"></div>
            </div>
            
            <div class="field">
            <div class="leftTitle">Enter Weight (in grams) : <sup>*</sup> </div>
            <input name="diamond_weight" id="diamond_weight" type="text"  class="textField"/>            
            <div class="clear"></div>
            </div>  
            <div class="clear"></div>			          
            <div class="bottomSpace"></div>
            <div class="title"><h4>Product Image</h4></div>            
            <div class="clear"></div>
            
            <div class="borderBottom"></div>
            <div class="field bottomSpace">
            <div class="userPic">
            <img src="images/user_pic.jpg" width="100" height="100" alt="" /></div>
            <div class="leftFile">
         
         <p><strong>Filename</strong></p>
         <input type="file" class="textField" name="product_image_fid" id="product_image_fid" style="margin-bottom:10px; background:#fff;" />
         <!--<div class="maroonBtn"><a href="#">Upload File</a></div>-->
  </div>
	<div class="clear"></div>
</div>             
    <div class="button"> 
     <input type="submit" name="add_more" id="add_more" value="Add More Catalogue" class="grayButton"/>
    </div>
    <div class="clear"></div>
</div>
  </form>      
    <div class="title">
    <h4>List of Product Catalogue</h4>
    </div>
    <div class="clear"></div>
  	<div class="catalogue_detail">
            
<table width="575" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="115">&nbsp;</td>
    <td width="20">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="15">&nbsp;</td>
    <td width="180">&nbsp;</td>
    <td width="65">&nbsp;</td>
  </tr>
  <?php 
  		/*................................................................*/
       $ans = "select * from product_catalogue where uid='$registration_id'";
	   $sql=$conn->query("select * from product_catalogue where uid='$registration_id'");
	   $num=$sql->num_rows;;
	   if($num>0){
  	   while($result=$sql->fetch_assoc()){
  ?>
  
  <tr>
    <td rowspan="16" valign="top" style="padding-left:5px;"><img src="product_catalogue/<?php echo $result['product_image_fid'];?>" width="100" height="100" alt=""  /></td>
    <td>&nbsp;</td>
    <td><strong>Product Details</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="product_catalogue.php?id=<?php echo $result['id'];?>&action=delete"><img src="images/red_cross.png" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Product Title</td>
    <td>:<?php echo strtoupper($result['product_title']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Product Description</td>
    <td>:<?php echo strtoupper($result['product_description']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Product Category</td>
    <td>:<?php if($result['product_category']!=""){echo strtoupper($result['product_category']);} else {echo $result['product_category_other'];}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Product Sub Category</td>
    <td>:<?php if($result['product_sub_category']!=""){echo strtoupper($result['product_sub_category']);} else {echo $result[' 	product_sub_category_other'];}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Metal Details</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Metal Category</td>
    <td>:<?php if($result['metal_category']!=""){echo strtoupper($result['metal_category']);} else {echo strtoupper($result['metal_category_other']);}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Metal Sub Category</td>
    <td>:<?php if($result['metal_sub_category']!=""){echo strtoupper($result['metal_sub_category']);} else {echo strtoupper($result['metal_sub_category_other']);}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Carats </td>
    <td>:<?php echo strtoupper($result['metal_weight']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Weight (in grams)</td>
    <td>:<?php echo strtoupper($result['diamond_carat']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td><strong>Diamond  Details</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Enter Carats</td>
    <td>:<?php echo strtoupper($result['diamond_carat']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Enter Weight (in grams)</td>
    <td>:<?php echo strtoupper($result['diamond_weight']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
   <tr>
    <td colspan="6" style="border-top:solid 1px #CCCCCC;">&nbsp;</td>
    </tr>
    
 <?php } } else { ?>  
   <tr>
    	<td>No records found</td>
   </tr>
    <?php } ?>
 </table>
	</div>
  </div>
</div>
</div>
        <div class="clear"></div>
    </div>
</div>
<!--container ends-->

<!--footer starts-->
<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>
