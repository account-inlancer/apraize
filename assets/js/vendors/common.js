function numberOnlyAllowed(evt){
	var charCode=(evt.which?evt.which:evt.keyCode);

	if(charCode>=48 && charCode<=57 || charCode == 8 || charCode == 32 ||charCode == 37 ||charCode == 38  ||charCode == 38  || charCode == 46 || charCode == 9)

	{	
		return true;
	}

	else
	{
		return false;

	}
	
}