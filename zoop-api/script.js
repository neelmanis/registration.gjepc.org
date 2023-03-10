
//Onclick functionlality of Verify button
var verify_btn = document.getElementById("verify_btn");
verify_btn.onclick = function()
{
    //Get values from the form
    var pan_no = document.getElementById("pan_no").value;

    if(pan_no == "") //Check if all fields are filled or not
    {
        alert("Please enter all the fields!");
    }
    else{
        verifyPan(pan_no);  // Call to verification function
    }

}
//------------------------End of button click event function------------------------


//Function to verify PAN Number
function verifyPan(pan_no){

    //Create new connection
    var panAPI = new XMLHttpRequest();
    panAPI.open('POST','https://gjepc.org/zoop-api/API/verify_pan_script.php',true);
    panAPI.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    // On result of API call
    panAPI.onload = function(){
        console.log(JSON.parse(this.responseText));
        var result = JSON.parse(this.responseText);
       // console.log(result.pan_result);
       
        if(result.pan_result.indexOf("Invalid PAN")!= -1)
        {   //if Invalid pan
            console.log("invalid pan");
            notify("invalid");
        } else {
			//check if result is found
            
            //verify if name matches
            
            //break by td to fetch name from the ressult
            var name_received = result.pan_result.split("<td>")[2].replace("</td>","");
            console.log(name_received);

            if(name_received == name.toUpperCase())
            { //if entered name and received name are same then its VALID PAN
                console.log("verified");
                notify("valid");
            } else { // if name does not match , its INVALID PAN
                console.log("Incorrect name");
                notify("invalid");
            }
        }
    }

    //Set post values
    values = "pan_numbers="+pan_no;
    //Cal the API
    panAPI.send(values);
}
//------------------------End of verifyPAN function------------------------

//Function to set alert type class and message box value based on the result
function notify(value){

    if(value == "valid")
    {
        document.getElementById('result').className = "alert alert-success";
        document.getElementById('result').innerText = "Valid PAN";
    }
    else if (value == "invalid")
    {   document.getElementById('result').className = "alert alert-danger";
        document.getElementById('result').innerText = "Invlid Valid PAN";
    }
    else{
        document.getElementById('result').innerText = "Unknown error";
    }
}
//------------------------End of notify function------------------------