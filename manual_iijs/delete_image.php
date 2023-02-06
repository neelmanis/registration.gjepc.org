<?php 
include('db.inc.php');
?>

<?php
	$querry1="select * from iijs_catalog order by Exhibitor_Code";
	$run=mysql_query($querry1);
	while($row=mysql_fetch_array($run))
	{	
		echo $Exhibitor_Code=$row['Exhibitor_Code']; echo ' --> ';
		echo $company_image=$row['Catalog_CompanyLogo']; echo ' --> ';
		echo $product_image=$row['Catalog_ProductLogo'];	echo '<hr/>'; echo '<br/>';
		
			
	/*	$file1 = 'images/catalog/test/'. $Exhibitor_Code.'/'.$company_image; echo '<br/>';
		$file2 = 'images/catalog/test/'. $Exhibitor_Code.'/'.$product_image; 
	*/	
		$file = 'images/catalog/'. $Exhibitor_Code.'/'.$company_image;
		$newfile = 'images/catalog/OG/'. $Exhibitor_Code.'/'.$company_image;
		
		$file1 = 'images/catalog/'. $Exhibitor_Code.'/'.$product_image;
		$newfile1 = 'images/catalog/OG/'. $Exhibitor_Code.'/'.$product_image;
		
		$create_folder= 'images/catalog/OG/'.$Exhibitor_Code;
		mkdir($create_folder,0777);

	if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
	}else{
		echo "copied $file into $newfile\n";
	}	
		
	if (!copy($file1, $newfile1)) {
    echo "failed to copy $file...\n";
	}else{
		echo "copied $file into $newfile\n";
	}
	
	}


?>