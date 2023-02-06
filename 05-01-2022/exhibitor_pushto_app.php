				<?php
				$host = "localhost";
				$user = "appadmin";
				$password = "G@k593#sgtk";
				$dbname = "manual_iijs2021";

                // Create connection
                $conn2 = new mysqli($host, $user, $password, $dbname);
                // Check connection
                if($conn2->connect_error) {
                    die("Connection failed: " . $conn2->connect_error);
                } else {
                    
                }
				
				$hostname = "localhost";
				$uname = "gjepcliveuserdb";
				$pwd = "KGj&6(pcvmLk5";
				$database = "gjepclivedatabase";

				// Create connection
				$conn = new mysqli($hostname, $uname, $pwd, $database);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} else {
					//echo "connected";
				}
			
			/*
			$sexh="SELECT * FROM manual_iijs2021.iijs_exhibitor";			
			$qexh = $conn2->query($sexh); 
			while($fetch_data = $qexh->fetch_assoc())
			{
			
			$Exhibitor_Login=$fetch_data['Exhibitor_Login'];
			$Exhibitor_Password=$fetch_data['Exhibitor_Password'];
			$Exhibitor_Code=$fetch_data['Exhibitor_Code'];
			$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
			$Exhibitor_Gid=$fetch_data['Exhibitor_Gid'];
			$sale_order_number=$fetch_data['sale_order_number'];
			$billing_bp_no=$fetch_data['billing_bp_no'];
			$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
			$Exhibitor_Designation=$fetch_data['Exhibitor_Designation'];
			$Exhibitor_Mobile=$fetch_data['Exhibitor_Mobile'];
			$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
			$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

			$Exhibitor_StallNo[]="";

			for($i=0;$i<12;$i++){
				if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
					$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
			}

			$stall_no=implode(", ",$Exhibitor_StallNo);

			$Exhibitor_HallNo=$fetch_data['Exhibitor_HallNo'];
			$Exhibitor_Region=$fetch_data['Exhibitor_Region'];
			$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
			$Exhibitor_Category=$fetch_data['Exhibitor_StallType'];
			$Exhibitor_Scheme==$fetch_data['Exhibitor_Scheme'];
			$Exhibitor_Premium==$fetch_data['Exhibitor_Premium'];
			$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
			$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];

			$Exhibitor_Address1=$fetch_data['Exhibitor_Address1'];
			$Exhibitor_Address2=$fetch_data['Exhibitor_Address2'];
			$Exhibitor_Address3=$fetch_data['Exhibitor_Address3'];

			$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
			$Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
			$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
			$Exhibitor_State=$fetch_data['Exhibitor_State'];
			$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
			$Exhibitor_IsActive=$fetch_data['Exhibitor_IsActive'];

			$Exhibitor_City=$fetch_data['Exhibitor_City'];
			$Exhibitor_Website=$fetch_data['Exhibitor_Website'];
			$comments = $fetch_data['comments'];
			$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
			$Exhibitor_Premium=$fetch_data['Exhibitor_Premium'];
			$amount_paid=$fetch_data['amountPaid'];
			$amount_unpaid=$fetch_data['amountUnpaid'];
			$vendor=$fetch_data['vendor'];
			$allotted_women=$fetch_data['allotted_women'];
			$specific_area=$fetch_data['specific_area'];
			$exempt_gst=$fetch_data['exempt_gst'];	
			$Exhibitor_Layout=$fetch_data['Exhibitor_Layout'];	
			 
		$ssx = "INSERT INTO exhibitor set Exhibitor_Login='$Exhibitor_Login',Exhibitor_Password='$Exhibitor_Password',Exhibitor_Mobile='$Exhibitor_Mobile',Exhibitor_Code='$Exhibitor_Code',Exhibitor_Gid='$Exhibitor_Gid',billing_bp_no='$billing_bp_no',sale_order_number='$sale_order_number',Exhibitor_Name='$Exhibitor_Name',Exhibitor_Contact_Person='$Exhibitor_Contact_Person',Exhibitor_Designation='$Exhibitor_Designation',Exhibitor_Email='$Exhibitor_Email',Exhibitor_Country_ID='$Exhibitor_Country_ID',Exhibitor_HallNo='$Exhibitor_HallNo',Exhibitor_DivisionNo='$Exhibitor_DivisionNo',Exhibitor_StallNo1='$Exhibitor_StallNo1',Exhibitor_StallNo2='$Exhibitor_StallNo2',Exhibitor_StallNo3='$Exhibitor_StallNo3',Exhibitor_StallNo4='$Exhibitor_StallNo4',Exhibitor_StallNo5='$Exhibitor_StallNo5',Exhibitor_StallNo6='$Exhibitor_StallNo6',Exhibitor_StallNo7='$Exhibitor_StallNo7',Exhibitor_StallNo8='$Exhibitor_StallNo8',Exhibitor_Section='$Exhibitor_Section',Exhibitor_StallType='$Exhibitor_Category',Exhibitor_IsActive=$Exhibitor_IsActive,comments='$comments',Exhibitor_Scheme='$Exhibitor_Scheme',Exhibitor_Premium='$Exhibitor_Premium',Exhibitor_Area='$Exhibitor_Area',Exhibitor_Region='$Exhibitor_Region',amountPaid='$amount_paid',amountUnpaid='$amount_unpaid',vendor='$vendor',allotted_women='$allotted_women',specific_area='$specific_area',exempt_gst='$exempt_gst',Exhibitor_Layout='$Exhibitor_Layout',Catalog_CompanyLogo='',event_name='IIJS',year='2022'";
			$queryData = $conn->query($ssx);
			} 
			*/
			/*
			$sexh="SELECT * FROM manual_iijs2021.iijs_catalog";			
			$qexh = $conn2->query($sexh); 
			while($fetch_catalog = $qexh->fetch_assoc())
			{
				$Exibitor_Name=$fetch_catalog['Exibitor_Name'];
				$exhibitor_code=$fetch_catalog['Exhibitor_Code'];
				$Catalog_Phone=$fetch_catalog['Catalog_Phone'];
				$Catalog_ContactPerson=$fetch_catalog['Catalog_ContactPerson'];
				$Catalog_Fax=$fetch_catalog['Catalog_Fax'];
				$Catalog_Designation=$fetch_catalog['Catalog_Designation'];
				$Catelog_mobile=$fetch_catalog['Catelog_mobile'];
				$Catalog_Address1=$fetch_catalog['Catalog_Address1'];
				$Catalog_Email=$fetch_catalog['Catalog_Email'];
				$Catalog_City=$fetch_catalog['Catalog_City'];
				$Catalog_Email1=$fetch_catalog['Catalog_Email1'];
				$Catalog_Pincode=$fetch_catalog['Catalog_Pincode'];
				$Catalog_Website=$fetch_catalog['Catalog_Website'];
				$Catalog_CountryId=$fetch_catalog['Catalog_CountryId'];
				$Catalog_StallNo=$fetch_catalog['Catalog_StallNo'];
				$Catalog_State=$fetch_catalog['Catalog_State'];
				$Create_Date=$fetch_catalog['Create_Date'];
				$Catalog_Brief = stripslashes($fetch_catalog['Catalog_Brief']);
				$catalog_brief = substr($Catalog_Brief, 0, 100);;
				$Catalog_CompanyLogo=$fetch_catalog['Catalog_CompanyLogo'];
				$CompanyLogo_Approved=$fetch_catalog['CompanyLogo_Approved'];
				$CompanyLogo_Reason=$fetch_catalog['CompanyLogo_Reason'];
				$Catalog_ProductLogo=$fetch_catalog['Catalog_ProductLogo'];
				$ProductLogo_Reason=$fetch_catalog['ProductLogo_Reason'];
				$ProductLogo_Approved=$fetch_catalog['ProductLogo_Approved'];	
				$Info_Reason=$fetch_catalog['Info_Reason'];
				$Info_Approved=$fetch_catalog['Info_Approved'];
				$Application_Complete=$fetch_catalog['Application_Complete'];
				$Info_Recieved=$fetch_catalog['Info_Recieved'];
	
				$sql_insert="insert into iijs_catalog set Exhibitor_Code='$exhibitor_code',Exibitor_Name='$Exibitor_Name',Catalog_Phone='$Catalog_Phone',Catalog_ContactPerson='$Catalog_ContactPerson',Catalog_Fax='$Catalog_Fax',Catalog_Designation='$Catalog_Designation',Catelog_mobile='$Catelog_mobile',Catalog_Address1='$Catalog_Address1',Catalog_Email='$Catalog_Email',	Catalog_City='$Catalog_City',Catalog_Pincode='$Catalog_Pincode',Catalog_Website='$Catalog_Website',Catalog_CountryId='$Catalog_CountryId',Catalog_StallNo='$Catalog_StallNo',Catalog_State='$Catalog_State',brand_names='$brand_names',Catalog_Brief='$catalog_brief',Catalog_ProductLogo='$Catalog_ProductLogo',Catalog_CompanyLogo='$Catalog_CompanyLogo', Info_Recieved='$Info_Recieved',Application_Complete='$Application_Complete',Create_Date='$Create_Date'";
				$execute= $conn ->query($sql_insert);				
			}
			*/
			
?>