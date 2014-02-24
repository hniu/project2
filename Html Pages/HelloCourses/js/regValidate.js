function validateForm()
{
	var x = document.forms["myForm"]["email"].value;
	var y = document.forms["myForm"]["username"].value;
	var z = document.forms["myForm"]["password"].value;
	var w = document.forms["myForm"]["re-password"].value;
	if((x==null||x=="")||(y==null||y=="")||(z==null||z=="")||(w==null||w=="")){
		alert("All the information must be filled out!");
		return false;
	}
}

function check(input) {
    if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('The two passwords must match.');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
   }
}