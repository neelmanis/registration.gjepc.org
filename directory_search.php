<?php include('header_include.php');
// if(!isset($_SESSION['USERID'])){
		// header("location:login.php");
		// exit;
	//}
?>

<?php
/*$sql_search="select a.Exhibitor_Code,a.Exhibitor_Name,a.Exhibitor_Contact_Person,a.Exhibitor_Address1,a.Exhibitor_Address2,a.Exhibitor_City,a.Exhibitor_Pincode,a.Exhibitor_HallNo,a.Exhibitor_Section,a.Exhibitor_Area,a.Exhibitor_StallNo1,a.Exhibitor_StallNo2,a.Exhibitor_StallNo3,a.Exhibitor_StallNo4,a.Exhibitor_StallNo5,a.Exhibitor_Region,b.Catalog_CompanyLogo,b.Catalog_Brief,b.wa_jewellery,b.pd_jewellery,c.objective,c.wa_other,c.d_size,c.d_clarity,c.d_color_shade,c.cgs_stone from iijs_signature_manualdb.iijs_exhibitor a left join iijs_signature_manualdb.iijs_catalog b on a.Exhibitor_Code=b.Exhibitor_Code left join gjepclivedatabase.member_directory c on a.Exhibitor_Registration_ID=c.registration_id where 1 ";*/

$sql_search="select a.Exhibitor_Code,a.Exhibitor_Name,a.Exhibitor_Contact_Person,a.Exhibitor_Address1,a.Exhibitor_Address2,a.Exhibitor_City,a.Exhibitor_Pincode,a.Exhibitor_HallNo,a.Exhibitor_Section,a.Exhibitor_Area,a.Exhibitor_StallNo1,a.Exhibitor_StallNo2,a.Exhibitor_StallNo3,a.Exhibitor_StallNo4,a.Exhibitor_StallNo5,a.Exhibitor_Region,b.Catalog_CompanyLogo,b.Catalog_Brief,b.wa_jewellery,b.pd_jewellery,c.objective,c.wa_other,c.d_size,c.d_clarity,c.d_color_shade,c.cgs_stone from iijs_exhibitor a left join iijs_catalog b on a.Exhibitor_Code=b.Exhibitor_Code left join member_directory c on a.Exhibitor_Registration_ID=c.registration_id where 1 ";

if(isset($_GET["ak"]))
{
	$akey = $_GET["ak"];
	$_SESSION["SK"]=$akey;
	//$sql_search.= "and a.Exhibitor_Name like '$akey%'";
}

if(isset($_REQUEST['keyword_earch']))
{  
	
	unset($_SESSION["SK"]);
	$_SESSION['checkbox']="";
	$keyword=$_REQUEST['keyword'];
	$company_name=$_REQUEST['company_name'];
	$contact_person=$_REQUEST['contact_person'];
	$hall=$_REQUEST["hall"];
	$section=$_REQUEST["section"];
	
	if(($keyword=="Keyword" ) && ($company_name=="") && ($contact_person=="") & ($hall=="") && ($section==""))
	{
		$_SESSION['error_msg']="Please enter text for which you are searching";
	}
}
if(isset($_REQUEST['reset_company_search']))
{	
	 unset($keyword, $company_name, $contact_person,$_SESSION["SK"],$hall,$section);
}

if(isset($_REQUEST['business_profile_search']))
{
	unset($_SESSION["SK"]);
	$_SESSION['checkbox']=1;
	$wa_jewellery=$_REQUEST['wa_jewellery'];

	$pd_jewellery=$_REQUEST['pd_jewellery'];
	$d_size=$_REQUEST['d_size'];
	$d_clarity=$_REQUEST['d_clarity'];
	$d_color_shade=$_REQUEST['d_color_shade'];
	$cgs_stone=$_REQUEST['cgs_stone'];
	if(count($wa_jewellery)=="0" && count($pd_jewellery)=="0" && count($d_size)=="0" && count($d_clarity)=="0" && count($d_color_shade)=="0" && count($cgs_stone)=="0")
	{
		$_SESSION['error_msg']="Please enter the atleast one value to search under Business Profile Search";
	}
}
if(isset($_SESSION["SK"]))
	$sql_search.= "and a.Exhibitor_Name like '$akey%'";
?> 
<?php 
    $_SESSION['checkbox']="";
	$page_name="directory_search.php?action=search";
	$start=$_GET['start'];
	 	
	if(strlen($start) > 0 and !is_numeric($start))
	{
		echo "Data Error";
		exit;
	}

	$limit = 20;
	if(!isset($_GET["start"]) || intval($_GET["start"])==1)
		$eu=0;
	else
		$eu = ($start * $limit)-19;
	
	$this1 = $eu + $limit;
	$back = $start - 1;
	$next = $start + 1;
   //$sql_search="select * from [exh_directory] where 1";

  	if($keyword!="")
	{
  		$sql_search.=" and ( a.Exhibitor_Name like '%$keyword%' or a.Exhibitor_Contact_Person like '%$keyword%' or a.Exhibitor_Designation like '%$keyword%' or  c.wa_jewellery like '%$keyword%' or c.pd_jewellery like '%$keyword%' or c.cgs_stone like '%$keyword%' )";
	}
	if($company_name!="")
	{
		$sql_search.=" and a.Exhibitor_Name like '%$company_name%'";
	}
	if($contact_person!="")
	{
    	$sql_search.=" and a.Exhibitor_Contact_Person like '%$contact_person%'";
	}
	if($hall!="")
	{
		$sql_search.=" and a.Exhibitor_HallNo like '%$hall%'";
		}
	if($section!="")
	{
		 $sql_search.=" and a.Exhibitor_Section like '%$section%'";
	}
  	if(count($wa_jewellery)>0)
  	{
		$i=0;
		foreach($wa_jewellery as $val)
		{
	  		if($i!=0){$wa_jewellery_where.=" OR ";}
	  		$wa_jewellery_where.=" c.wa_jewellery LIKE '%".$val."%'";
	  		$i++;
		}
		$sql_search.=" AND (".$wa_jewellery_where.")";
  	}
  
  	if(count($pd_jewellery)>0)
  	{
		$i=0;
		foreach($pd_jewellery as $val)
		{
	  		if($i!=0){$pd_jewellery_where.=" OR ";}
	  		$pd_jewellery_where.=" c.pd_jewellery LIKE '%".$val."%'";
	  		$i++;
		}
		$sql_search.=" AND (".$pd_jewellery_where.")";
  	}
  
  	if(count($d_size)>0)
  	{
		$i=0;
		foreach($d_size as $val)
		{
	  		if($i!=0)
				$d_size_where.=" OR ";
				
	  		$d_size_where.=" c.d_size LIKE '%".$val."%'";
	  		$i++;
		}
		$sql_search.=" AND (".$d_size_where.")";
  	}
  
  	if(count($d_clarity)>0)
  	{
		$i=0;
		foreach($d_clarity as $val)
		{
	  		if($i!=0)
				$d_clarity_where.=" OR ";
	  		
			$d_clarity_where.=" c.d_clarity LIKE '%".$val."%'";
	  		$i++;
		}
		$sql_search.=" AND (".$d_clarity_where.")";
  	}
  
  	if(count($d_color_shade)>0)
  	{
		$i=0;
		foreach($d_color_shade as $val)
		{
	  		if($i!=0)
				$d_color_shade_where.=" OR ";
	 
	 		$d_color_shade_where.=" c.d_color_shade LIKE '%".$val."%'";
	  		$i++;
		}
		$sql_search.=" AND (".$d_color_shade_where.")";
  	}
  
  	if(count($cgs_stone)>0)
  	{
		$i=0;
		foreach($cgs_stone as $val)
		{
	  		if($i!=0)
				$cgs_stone_where.=" OR ";
				
	  		$cgs_stone_where.=" c.cgs_stone LIKE '%".$val."%'";
	  		$i++;
		}
		$sql_search.=" AND (".$cgs_stone_where.")";
  	}
	
    $sql_search.=" order by a.Exhibitor_Name ASC";
	$query_search=$conn->query($sql_search);
	
	//$rCount=0;
	  $rCount = $query_search->num_rows;	

	$sql_search=$sql_search." limit $eu, $limit ";
	 $query_search=$conn->query($sql_search);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Advance Directory Search :: Welcome to SIGNATURE</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->
<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
<style>
.char_links {
padding: 6px;
font-size: 16px}
</style>

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

<script>
$(function() { 
	$(document).ready(function () {
		if($("input[@name='checkbox']:checked").val()) {
				$('#company-profile-search-id').show("slow");
				$('#business-profile-search-id').show("slow");
		}
		else {
				$('#company_profile-search-id').hide("slow");
				$('#business-type-id').hide("slow");
		}
	});

	$("#advanced-search-checkbox-id").click(function () {
		if($("input[@name='checkbox']:checked").val()) {
			$('#company-profile-search-id').show("slow");
			$('#business-profile-search-id').show("slow");
		}
		else {
			$('#company-profile-search-id').hide("slow");
			$('#business-profile-search-id').hide("slow");
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

	<div class="breadcrum"><a href="index.php">Home</a> > OBMP > Advance Directory Search</div>    
    <div class="clear"></div>
    
    <div class="content_area">
    
    <div class="pg_title">
    
    <div class="title_cont">
        <span class="top">OBMP <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">Advance Directory Search</span>
        <div class="clear"></div>
    </div>
    
    </div> 
    <div class="clear"></div>
       <div id="loginForm">
<div id="formContainer">
     
			<?php 
			if($_SESSION['error_msg']!=""){
			echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
			$_SESSION['error_msg']="";
			}
			if($_SESSION['error_msg']!=""){
			echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
			$_SESSION['error_msg']="";
			}
			if($_SESSION['error_msg']!=""){
			echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
			$_SESSION['error_msg']="";
		    }
			?>
   
  <form action="" method="post">
        <div id="form">
            <div class="bottomSpace"></div>
            <div class="title">
            <h4>Search</h4>
            </div>
            <div class="clear"></div>
            <div class="borderBottom"></div>
			
          <div class="field">
           <div class="leftTitle">Keywords :  </div>
           <input type="text" class="textField" value="<?php echo $keyword;?>" name="keyword" id="keyword" />
          </div>
            
           <div class="field">
            <label>Company Name : </label>
            <input type="text" class="textField"  name="company_name" id="company_name" value="<?php echo $company_name;?>" />
           </div>
           
           <div class="field">
            <div class="leftTitle">Contact Name :  </div>
            <input type="text" class="textField" name="contact_person" id="contact_person" value="<?php echo $contact_person;?>" />
           </div>
		   
		   <div class="field">
            <div class="leftTitle">Section :  </div>
			<select name="section" id="section" class="bgcolor" style="height:28px; width:212px;">
			<?php			 
			$query=$conn->query("SELECT distinct Exhibitor_Section from  iijs_exhibitor WHERE 1");
			?>
			<option value="">------------Select Section---------------</option>
			<?php while($result=$query->fetch_assoc()){?>
			<option value="<?php echo $result['Exhibitor_Section'];?>"><?php echo $result['Exhibitor_Section'];?></option>
			<?php }?>
		    </select>
			
			<!--<input type="text" class="textField" name="section" id="section" value="<?php echo $section;?>" />-->
           </div>
		   
		   <div class="field">
            <div class="leftTitle">Hall :  </div>
			<select name="hall" id="hall" class="bgcolor" style="height:28px; width:212px;">			
			<option value="">---------------Select Hall--------------</option>
			<option value="1">1</option>
			<option value="5">5</option>			
		    </select>
           </div>
            <div class="clear"></div>
			
             <div class="button">
              <input name="keyword_earch" id="keyword_earch" type="submit" class="submitButton" value="Search" />
              <input name="reset_company_search" id="reset_company_search" type="submit" class="submitButton" value="Reset" />
             </div>
             <div class="clear"></div>
            
			<div style="margin-bottom:15px;">
			<?php 
			$i=65;
			while($i<=90)
			{
				$char=chr($i);
				echo "<a href='directory_search.php?ak=$char&action=search&start=1' class='char_links'>$char</a>";
				$i++;
			}
			?>
</div>
	<div class="advance_search" id="advanced-search-checkbox-id"><!--<a href="#"> Advance Search</a>-->
	<input type="checkbox" name="checkbox" id="edit-checkbox" value="1"   class="form-checkbox" <?php if($_SESSION['checkbox']!=""){?> checked="checked"<?php }?> />&nbsp;Advance Search
	</div>
	</div>
  </form>
  
  
<div class="clear"></div>

<form action="" method="post"> 
<div id="business-profile-search-id" style="display:none;">
<div class="advancetablle1">
<div class="dotet_line"></div>
<div class="padding_width_head">Business Profile Search</div>
<div class="dotet_line"></div>

<div class="clear"></div>


<div class="advance_tab1">
<div class="strong_text1">We Are:</div>

<div class="strong_bold">Jewellery:</div>

<div class="clear"></div>
<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery"  type="checkbox" value="importers" <?php if(in_array("importers", $wa_jewellery)){echo 'checked="checked"'; } ?>  /></div>
<div class="chexbox_text">Importers</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="wholesalers" <?php if(in_array("wholesalers", $wa_jewellery)){echo 'checked="checked"'; } ?>  /></div>
<div class="chexbox_text">Wholesalers</div>
</div>
<div class="clear"></div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="students" <?php if(in_array("students", $wa_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Students</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="agents" <?php if(in_array("agents", $wa_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Agents</div>
</div>

<div class="clear"></div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="manufacturers" <?php if(in_array("manufacturers", $wa_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Manufacturers</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="artists/craftsmen"  <?php if(in_array("artists/craftsmen", $wa_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text"> Artists/Craftsmen</div>
</div>

<div class="clear"></div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="retailers" <?php if(in_array("retailers", $wa_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Retailers</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="exporters" <?php if(in_array("exporters", $wa_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Exporters</div>
</div>

<div class="clear"></div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="goldsmiths" <?php if(in_array("goldsmiths", $wa_jewellery)){echo 'checked="checked"'; } ?>  /></div>
<div class="chexbox_text">Goldsmiths</div>
</div>


<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="chain stores"  <?php if(in_array("chain stores", $wa_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Chain Stores</div>
</div>
<div class="clear"></div>

<div class="chexbox_border1">
<div class="chexbox"><input name="wa_jewellery[]" id="wa_jewellery" type="checkbox" value="designers" <?php if(in_array("designers", $wa_jewellery)){echo 'checked="checked"'; } ?>  /></div>
<div class="chexbox_text">Designers</div>
</div>

<div class="clear"></div>
<div class="dotline1"></div>

<div class="strong_text1">Product Dealing In:</div>

<div class="strong_bold">Jewellery:</div>

<div class="clear"></div>
<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="plain gold jewellery" <?php if(in_array("plain gold jewellery", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text"> Plain Gold Jewellery</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="costume jewellery" <?php if(in_array("costume jewellery", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Costume Jewellery</div>
</div>
<div class="clear"></div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="publications"  <?php if(in_array("publications", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Publications</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="studded gold jewellery" <?php if(in_array("studded gold jewellery", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Studded Gold Jewellery</div>
</div>

<div class="clear"></div>
<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="platinum jewellery" <?php if(in_array("platinum jewellery", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Platinum Jewellery</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="educational institutions" <?php if(in_array("educational institutions", $pd_jewellery)){echo 'checked="checked"'; } ?>  /></div>
<div class="chexbox_text"> Educational Insitutions</div>
</div>

<div class="clear"></div>
<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="loose diamonds" <?php if(in_array("loose diamonds", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Loose Diamonds</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="silver jewellery" <?php if(in_array("silver jewellery", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Silver Jewellery</div>
</div>

<div class="clear"></div>
<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="associations" <?php if(in_array("associations", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Associations</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="coloured gemstones" <?php if(in_array("coloured gemstones", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Coloured Gemstones</div>
</div>

<div class="clear"></div>
<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="software products" <?php if(in_array("software products", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Software Products</div>
</div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="service providers" <?php if(in_array("service providers", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text"> Service Providers</div>
</div>

<div class="clear"></div>

<div class="chexbox_border1">
<div class="chexbox"><input name="pd_jewellery[]" id="pd_jewellery" type="checkbox" value="pearls" <?php if(in_array("Pearls", $pd_jewellery)){echo 'checked="checked"'; } ?> /></div>
<div class="chexbox_text">Pearls</div>
</div>
<div class="clear"></div>

<div class="dotline1"></div>

<div class="strong_text1">Diamond Offers:</div>

<div class="tablewidth_103"> 
<div class="member_text">Size: </div>
<div class="size_text_bg">
<select name="d_size[]"  multiple="multiple" class="size_text_bg_text" id="edit-size"  size="4">
<option value="0.004 - 0.008" <?php if(in_array("0.004 - 0.008", $d_size)){echo 'selected="selected"';}?>>0.004 - 0.008</option>
<option value="0.09 - 0.02" <?php if(in_array("0.09 - 0.02", $d_size)){echo 'selected="selected"'; } ?>>0.09 - 0.02</option>
<option value="0.025 - 0.07" <?php if(in_array("0.025 - 0.07", $d_size)){echo 'selected="selected"'; } ?>>0.025 - 0.07</option>
<option value="0.08 - 0.13" <?php if(in_array("0.08 - 0.13", $d_size)){echo 'selected="selected"'; } ?>>0.08 - 0.13</option>
<option value="0.14 - 0.17" <?php if(in_array("0.14 - 0.17", $d_size)){echo 'selected="selected"'; } ?>>0.14 - 0.17</option>
<option value="0.18 - 0.22" <?php if(in_array("0.18 - 0.22", $d_size)){echo 'selected="selected"'; } ?>>0.18 - 0.22</option>
<option value="0.23 - 0.29" <?php if(in_array("0.23 - 0.29", $d_size)){echo 'selected="selected"'; } ?>>0.23 - 0.29</option>
<option value="0.30 - 0.37" <?php if(in_array("0.30 - 0.37", $d_size)){echo 'selected="selected"'; } ?>>0.30 - 0.37</option>
<option value="0.38 - 0.45" <?php if(in_array("0.38 - 0.45", $d_size)){echo 'selected="selected"'; } ?>>0.38 - 0.45</option>
<option value="0.46 - 0.69" <?php if(in_array("0.46 - 0.69", $d_size)){echo 'selected="selected"'; } ?>>0.46 - 0.69</option>
<option value="0.70 - 0.89" <?php if(in_array("0.70 - 0.89", $d_size)){echo 'selected="selected"'; } ?>>0.70 - 0.89</option>
<option value="0.90 - 1.00" <?php if(in_array("0.90 - 1.00", $d_size)){echo 'selected="selected"'; } ?>>0.90 - 1.00</option>
<option value="1.00 - 2.00" <?php if(in_array("1.00 - 2.00", $d_size)){echo 'selected="selected"'; } ?>>1.00 - 2.00</option>
<option value="2.00 - 3.00" <?php if(in_array("2.00 - 3.00", $d_size)){echo 'selected="selected"'; } ?>>2.00 - 3.00</option>
<option value="3.00 plus" <?php if(in_array("3.00 plus", $d_size)){echo 'selected="selected"'; } ?>>3.00 plus</option>
</select>

</div>
</div>

<div class="clear"></div>
<div class="tablewidth_103"> 
<div class="member_text">Clarity: </div>
<div class="size_text_bg">
<select name="d_clarity[]"  multiple="multiple" class="size_text_bg_text" id="edit-clarity" >
<option value="SI1 - SI2" <?php if(in_array("SI1 - SI2", $d_clarity)){echo 'selected="selected"'; } ?>>SI1 - SI2</option>
<option value="IF" <?php if(in_array("IF", $d_clarity)){echo 'selected="selected"'; } ?>>IF</option>
<option value="VVS1 - VVS2" <?php if(in_array("VVS1 - VVS2", $d_clarity)){echo 'selected="selected"'; } ?>>VVS1 - VVS2</option>
<option value="VS1 - VS2" <?php if(in_array("VS1 - VS2", $d_clarity)){echo 'selected="selected"'; } ?>>VS1 - VS2</option>
</select>
</div>
</div>

<div class="clear"></div>
<div class="tablewidth_103"> 
<div class="member_text">Color/Shade:</div>
<div class="size_text_bg">
<select name="d_color_shade[]" multiple="multiple"  class="size_text_bg_text" id="edit-color-shade"  size="4">
<option value="DE" <?php if(in_array("DE", $d_color_shade)){echo 'selected="selected"'; } ?>>D/E</option>
<option value="FG" <?php if(in_array("FG", $d_color_shade)){echo 'selected="selected"'; } ?>>F/G</option>
<option value="HI" <?php if(in_array("HI", $d_color_shade)){echo 'selected="selected"'; } ?>>H/I</option>
<option value="JK" <?php if(in_array("JK", $d_color_shade)){echo 'selected="selected"'; } ?>>J/K</option>
<option value="TTLC" <?php if(in_array("TTLC", $d_color_shade)){echo 'selected="selected"'; } ?>>TTLC</option>
<option value="TLC" <?php if(in_array("TLC", $d_color_shade)){echo 'selected="selected"'; } ?>>TLC</option>
<option value="LC" <?php if(in_array("LC", $d_color_shade)){echo 'selected="selected"'; } ?>>LC</option>
<option value="TTLB" <?php if(in_array("TTLB", $d_color_shade)){echo 'selected="selected"'; } ?>>TTLB</option>
<option value="TLB" <?php if(in_array("TLB", $d_color_shade)){echo 'selected="selected"'; } ?>>TLB</option>
<option value="LB" <?php if(in_array("LB", $d_color_shade)){echo 'selected="selected"'; } ?>>LB</option>
<option value="M" <?php if(in_array("M", $d_color_shade)){echo 'selected="selected"'; } ?>>M</option>
</select>
</div>
</div>

<div class="clear"></div>
<div class="dotline1"></div>

<div class="strong_text1">Colour Gemstone Offers:</div>

<div class="tablewidth_103"> 
<div class="member_text">Name of the stone: </div>
<div class="size_text_bg">
<select name="cgs_stone[]" multiple="multiple"  class="size_text_bg_text"  id="edit-colour-gemstone"  size="4">
<option value="actinolite" <?php if(in_array("actinolite", $cgs_stone)){echo 'selected="selected"'; } ?>>Actinolite</option>
<option value="alexandrite" <?php if(in_array("alexandrite", $cgs_stone)){echo 'selected="selected"'; } ?>>Alexandrite</option>
<option value="almandite garnet" <?php if(in_array("almandite garnet", $cgs_stone)){echo 'selected="selected"'; } ?>>Almandite Garnet</option>
<option value="amazonite" <?php if(in_array("amazonite", $cgs_stone)){echo 'selected="selected"'; } ?>>Amazonite</option>
<option value="amber" <?php if(in_array("amber", $cgs_stone)){echo 'selected="selected"'; } ?>>Amber</option>
</select>

</div>
</div>

<div class="clear"></div>

<div class="member_text"></div>
<div class="">
<div class="">
<!--<input type="image" src="images/search_bt.png" alt="Search" width="76" height="29" />-->
<input type="submit" name="business_profile_search" id="business_profile_search" value="Search"  class="submitButton"  />

<!--<input type="image" src="images/reset_bt.jpg" alt="Search" width="76" height="29" />-->
<input type="submit" name="reset_bussiness_search" id="reset_bussiness_search" value="Reset"  class="submitButton" width="76" height="29"/>

<div class="clear"></div>
</div>
</div>



<div class="clear"></div>
</div>
</div>
</div>
</form>
<!-- ///////////////////////////////////////////////////////////////////////////////-->

<?php 
    // $_SESSION['checkbox']="";
	// $page_name="directory_search.php?action=view";
	// $start=$_GET['start'];
	// if(strlen($start) > 0 and !is_numeric($start)){
	// echo "Data Error";
	// exit;
	// }
	// $eu = ($start - 0);
	// $limit = 20;
	// $this1 = $eu + $limit;
	// $back = $start - 1;
	// $next = $start + 1;
    // $sql_search="select * from member_directory where status=1";
	
  // if($keyword!="")
  // {
  	// $sql_search.=" and ( company_name like '%$keyword%' or contact_person like '%$keyword%' or designation like '%$keyword%' or  	wa_jewellery like '%$keyword%' or pd_jewellery like '%$keyword%' or cgs_stone like '%$keyword%' )";
  // }	
  // if($company_name!="")
  // {
	  // $sql_search.=" and company_name like '%$company_name%'";
  // }
  // if($contact_person!="")
  // {
      // $sql_search.=" and contact_person like '%$contact_person%'";
  // }
  
  // if(count($wa_jewellery)>0)
  // {
	// $i=0;
	// foreach($wa_jewellery as $val)
	// {
	  // if($i!=0){$wa_jewellery_where.=" OR ";}
	  // $wa_jewellery_where.=" wa_jewellery LIKE '%".$val."%'";
	  // $i++;
	// }
	// $sql_search.=" AND (".$wa_jewellery_where.")";
  // }
  
  // if(count($pd_jewellery)>0)
  // {
	// $i=0;
	// foreach($pd_jewellery as $val)
	// {
	  // if($i!=0){$pd_jewellery_where.=" OR ";}
	  // $pd_jewellery_where.=" wa_other LIKE '%".$val."%'";
	  // $i++;
	// }
	// $sql_search.=" AND (".$pd_jewellery_where.")";
  // }
  
  // if(count($d_size)>0)
  // {
	// $i=0;
	// foreach($d_size as $val)
	// {
	  // if($i!=0){$d_size_where.=" OR ";}
	  // $d_size_where.=" d_size LIKE '%".$val."%'";
	  // $i++;
	// }
	// $sql_search.=" AND (".$d_size_where.")";
  // }
  
  // if(count($d_clarity)>0)
  // {
	// $i=0;
	// foreach($d_clarity as $val)
	// {
	  // if($i!=0){$d_clarity_where.=" OR ";}
	  // $d_clarity_where.=" d_clarity LIKE '%".$val."%'";
	  // $i++;
	// }
	// $sql_search.=" AND (".$d_clarity_where.")";
  // }
  // if(count($d_color_shade)>0)
  // {
	// $i=0;
	// foreach($d_color_shade as $val)
	// {
	  // if($i!=0){$d_color_shade_where.=" OR ";}
	  // $d_color_shade_where.=" d_color_shade LIKE '%".$val."%'";
	  // $i++;
	// }
	// $sql_search.=" AND (".$d_color_shade_where.")";
  // }
  // if(count($cgs_stone)>0)
  // {
	// $i=0;
	// foreach($cgs_stone as $val)
	// {
	  // if($i!=0){$cgs_stone_where.=" OR ";}
	  // $cgs_stone_where.=" cgs_stone LIKE '%".$val."%'";
	  // $i++;
	// }
	// $sql_search.=" AND (".$cgs_stone_where.")";
  // }
 // $sql_search.=" order by company_logo desc";
// $query_search=$conn->query($sql_search);
// $rCount=0;
// $rCount = @mysql_num_rows($query_search);	
// $sql_search=$sql_search." limit $eu, $limit ";
// $query_search=$conn->query($sql_search);
 ?>


<div class="clear"></div> 
<div class="dotet_line"></div>
<div class="padding_width_head">Directory Search</div>
<div class="dotet_line"></div>
<div class="clear"></div>  
<?php  
if($rCount>0){
while($result_search=$query_search->fetch_assoc()){ 
		$Exhibitor_StallNo="";
	
	for($i=0;$i<8;$i++)
	{
		if($result_search["Exhibitor_StallNo".($i+1)]!="")
			$Exhibitor_StallNo.=$result_search["Exhibitor_StallNo".($i+1)].",";
	}

?>      
    <div class="padding_width">
        <div class="clear"></div>
        <div class="auto_match_img"><!--<img src="images/shasvat.jpg" width="100" height="106" />-->
     <?php if($result_search['Catalog_CompanyLogo']!=''){?><img src="manual/images/catalog/<?php echo $result_search['Exhibitor_Code'];?>/<?php echo $result_search['Catalog_CompanyLogo'];?>" width="100" height="106" /><?php } else {?><img src="images/upload_img.jpg" /><?php }?>

        </div>
            <div class="auto_textwidth_new">
            <div><strong style="color:#0066CC;"> <?php echo $result_search['Exhibitor_Name'];?></strong> ( <?php echo $result_search['Exhibitor_Contact_Person'];?>)</div>
    <br>
    <div><span><?php echo stripslashes(substr($result_search['Catalog_Brief'],0,250));if(strlen($result_search['Catalog_Brief'])>250){echo "...";}?></span></div>
            
            <div style="margin-top:8px;">
            <div><span>We are : </span> <strong><?php echo $result_search['wa_jewellery'];?></strong> <!--<img src="images/blue_bullet.gif" />--> </div>
            <div><span>We deal in : </span> <strong><?php echo $result_search['pd_jewellery'];?></strong> <!--<img src="images/blue_bullet.gif" /> --></div>
            <div><span><strong>Exhibitor Stall No </strong> <img src="images/blue_bullet.gif" /> </span> <?php echo $Exhibitor_StallNo;?> </div>
            <div><span><strong>Address </strong> <img src="images/blue_bullet.gif" /> </span> <?php echo $result_search['Exhibitor_Address1'].' '.$result_search['Exhibitor_Address2'].' '.$result_search['Exhibitor_City'].' - '.$result_search['Exhibitor_Pincode'];?> </div>
            <div><span><strong>Hall No </strong> <img src="images/blue_bullet.gif" /> </span> <?php echo $result_search['Exhibitor_HallNo'];?>&nbsp;&nbsp;<strong>Area : </strong><?php echo $result_search['Exhibitor_Area'];?> </div>
            <div><span><strong>Section </strong> <img src="images/blue_bullet.gif" /> </span> <?php echo $result_search['Exhibitor_Section'];?> </div>
    
			</div>
            </div>
    
    <!--<div class="auto_match_view"><a href="view_store_front.php?registration_id=<?php echo $result_search['registration_id'];?>" target="_blank">View Storefront</a></div>
    <div class="auto_enquiry"><a href="send_enquiry.php?registration_id=<?php echo $result_search['registration_id'];?>" target="_blank">Send Enquiry</a></div>-->
    <div class="clear"></div>
    </div>  
    <div class="clear"></div> 
    <div class="dotet_line"></div>
          
<?php }} else {?>
<div class="padding_width">No Records Found.</div>
<?php }?>  
<div class="clear"></div>
&nbsp;&nbsp; Number of search result : <?php echo $rCount;?>          
<div class="dotet_line"></div>
 <div class="padding_width">
<div class="number_page" style="margin-top:10px;">
	<?php 
        if($rCount>$limit)
        {
        if($back >=0) {
			if(isset($_SESSION["SK"]))
				echo "<div class='prev'><a href='$page_nameak=".$_SESSION['SK']."&start=$back'>PREV</a></div>";
			else
				echo "<div class='prev'><a href='$page_name&start=$back'>PREV</a></div>";
        }
        echo "<div class='number_1'>";
        $min = max($start - 5, 1); 
        $max = min($start + 5, $rCount); 
        for($i = $min; $i <= $max; ++$i) {
            if($i == $start) {
                echo "<a href='#' class='active'>{$i}</a>";
            } 
            else {
			
               if(isset($_SESSION["SK"]))
	                echo "<a href='$page_name&ak=".$_SESSION['SK']."&start={$i}'>{$i}</a>";
				else
				    echo "<a href='$page_name&start={$i}'>{$i}</a>";
            }
        }
        echo "</div>";
        if($this1 < $rCount) {
			if(isset($_SESSION["SK"]))
				echo "<div class='next'><a href='$page_nameak=".$_SESSION['SK']."&start=$next'>NEXT</a></div>";		
			else
				echo "<div class='next'><a href='$page_name&start=$next'>NEXT</a></div>";		
		}
		
        }  
    ?>
</div>
            
            </div>
            
            <div class="clear"></div>
            
            <div class="dotet_line"></div>

            </div>
            
            
            </div>
 
        </div>

        <?php // include ('rightContent.php'); ?>

        <div class="clear"></div>
    </div>
<div class="clear"></div> 
</div>
<!--container ends-->

<!--footer starts-->

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>