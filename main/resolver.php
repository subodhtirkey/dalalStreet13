<?php
require_once("dbconfig.php");
require_once("classdefinition.php");
/* resolver 
 * resolves the url and calls the apppropiate function
 * i have divided the entire script in sections
 */
/*LOGIN HANDLER
 */
if((isset($_POST["email"])) && (isset($_POST["password"])))
{
	//check for correct login from the users table
	$p_email=mysql_real_escape_string($_POST["email"]);
	$p_password=mysql_real_escape_string($_POST["password"]);
	$user_load=new thisuser;
	$login_attempt_result=$user_load->attempt_login($p_email,$p_password);
	
	if(is_array($login_attempt_result))
	{
		if($login_attempt_result['result']==false && isset($login_attempt_result['response']))
		{
			/*
			 * this fo debugging
			 */
			var_dump(json_encode($login_attempt_result));
			/*
			 * this fo debugging
			 */
			return json_encode($login_attempt_result);
		}
		else if($login_attempt_result['result']==true)
		{
			/*
			 * this fo debugging
			 */ 
			//var_dump(json_encode($login_attempt_result));
			/*
			 * this fo debugging
			 */
			echo json_encode($login_attempt_result); 
			return;
		}
		else
		{
			/*
			 *log an error into the error log if this else block runs
			 */
			 /*
			 * this fo debugging
			 */
			 var_dump(json_encode($login_attempt_result));
			 /*
			 * this fo debugging
			 */
			return json_encode(array("result"=>"false","response"=>"invalid-parameters"));
			
		}
	}
	else
	{
		/*
		 * log an error into the error log if this else block runs
		 */
		 /*
	      * this fo debugging
	      */
		 var_dump(json_encode($login_attempt_result));
		 /*
			 * this fo debugging
			 */
		return json_encode(array("result"=>"false","response"=>"invalid-parameters"));
	}
	
}


/*
 * THE REGULAR REQUEST
 *
 if($_POST["action"]=="regular")
 {
 	$user_load=new thisuser;
	$login_attempt_result=$user_load->get_regular_details();
 	
 }
/*
 *this section for the share listing
 * currently testing with get
 */
else if($_POST["action"]=="share_listing")
 {
 	$typelisting=0;
 	if(isset($_POST["type"]))
	{
		$typelisting=mysql_real_escape_string($_POST["type"]);
	}
	
	if($typelisting>4 || $typelisting<0)
	$typelisting=0;
	$user_load=new thisuser;
	$sharelist=$user_load->get_share_list($typelisting);
	//testing statement
	var_dump($sharelist);//this is check statement actually the data has to returne
	return ;
	
 }
 
 //any call to verify login has to be explicit and the calls have to be post ;all of them
else if($_POST["action"]=="check")
{

	$user_load=new thisuser;
	$login_check=$user_load->verify_login();
	/*
	&&&&&&&&&&&&&&&&&&&&7777
	var_dump($login_check);//this is check statement actually the data has to returned
	*/
	if($login_check==false)
	{
		var_dump($login_check);
	}
	else if($login_check==true)
	{
		var_dump($login_check);
	}
	
	return ;
}
else if($_POST["action"]=="regular")
{
	$user_load=new thisuser;
	$regular_details=$user_load->get_regular_details();
	echo $regular_details;//this is check statement actually the data has to returned
	return ;
}
else if($_POST["action"]=="mortgageinquire")
{
	$mortgageshareid=mysql_real_escape_string($_POST["stockid"]);
	$mortgagesharenum=mysql_real_escape_string($_POST["stocknum"]);
	//just checking the values at the controller
	if($mortgagesharenum<0 || $mortgagesharenum<0)
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return;
	}
	if(!((is_numeric($mortgageshareid)) && is_numeric($mortgagesharenum)))
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	$user_load=new thisuser;
	$mortgageenquire=$user_load->mortgage_inquiry($mortgageshareid,$mortgagesharenum);
	echo $mortgageenquire;//this is check statement actually the data has to returned
	return ;
}
else if($_POST["action"]=="mortgagedeal")
{
  //	$mortgageshareid=mysql_real_escape_string($_POST["stockid"]);
  //	$mortgagesharenum=mysql_real_escape_string($_POST["stocknum"]);
  //	if($mortgageshareid<=0 || $mortgagesharenum<=0)
  //	{
  //		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
  //		return;
  //	}
  //	if(!((is_numeric($mortgageshareid)) && is_numeric($mortgagesharenum)))
  //	{
  //		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
  //		return ;
  //	}
  //	$user_load=new thisuser;
  //	$mortgagedeal=$user_load->mortgage_deal($mortgageshareid,$mortgagesharenum);
	//$mortgagedeal=$user_load->iamaa($mortgageshareid,$mortgagesharenum);
;//this is check statement actually the data has to returned
	return ;
}
else if($_POST["action"]=="sell")
{
	$sellshareid=mysql_real_escape_string($_POST["stockid"]);
	$sellsharenum=mysql_real_escape_string($_POST["stocknum"]);
	$sellshareprice=mysql_real_escape_string($_POST["pricepershare"]);
	if($sellshareid<=0 || $sellsharenum<=0 || $sellshareprice<=0)
	{
		
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	if(!((is_numeric($sellshareid)) && is_numeric($sellsharenum) && is_numeric($sellshareprice)))
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	$user_load=new thisuser;
	$sellputup=$user_load->bid_for_sale($sellshareid,$sellsharenum,$sellshareprice);
	echo $sellputup;//this is check statement actually the data has to returned
	return ;
}
else if($_POST["action"]=="buy")
{
	$buyshareid=mysql_real_escape_string($_POST["stockid"]);
	$buysharenum=mysql_real_escape_string($_POST["stocknum"]);
	$buyshareprice=mysql_real_escape_string($_POST["pricepershare"]);
	if($buyshareid<=0 || $buysharenum<=0 || $buyshareprice<=0)
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	if(!((is_numeric($buyshareid)) && is_numeric($buysharenum) && is_numeric($buyshareprice)))
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	$user_load=new thisuser;
	$buyputup=$user_load->bid_for_buying($buyshareid,$buysharenum,$buyshareprice);
	echo  $buyputup;//this is check statement actually the data has to returned
	return ;
}
else if($_POST["action"]=="redeem")
{
  /*	
	$redeemcode=mysql_real_escape_string($_POST["code"]);
	if($redeemcode<=0)
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	if(!((is_numeric($redeemcode))))
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	$user_load=new thisuser;
	$redeemputup=$user_load->redeem_shares($redeemcode);
	echo $redeemputup;//this is check statement actually the data has to returned
  */
	return ;
}
else if($_POST["action"]=="withdraw")
{
	
	$code=mysql_real_escape_string($_POST["code"]);
	$tableid=mysql_real_escape_string($_POST["tableid"]);
	if($tableid<=0 || $code<=0)
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	if(!((is_numeric($tableid)) && is_numeric($code)))
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	$user_load=new thisuser;
	
	$withdrawn=$user_load->cancelquotation($code,$tableid);
	echo $withdrawn;//this is check statement actually the data has to returned
	return ;
}

else if($_POST["action"]=="trade")
{
	$stockid=mysql_real_escape_string($_POST["stockid"]);
	$stocknum=mysql_real_escape_string($_POST["stocknum"]);
	if($stockid<=0 || $stocknum<=0)
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	if(!((is_numeric($stockid)) && is_numeric($stocknum)))
	{
		echo json_encode(array("result"=>false,"response"=>"INVALID PARAMETERS"));
		return ;
	}
	$user_load=new thisuser;
	
	$exchanged=$user_load->tradewithexchange($stockid,$stocknum);
	echo $exchanged;//this is check statement actually the data has to returned
	return ;
}
else if($_POST["action"]=="deal")
{
	$user_load=new thisuser;
	
	$dealt=$user_load->deal();
	var_dump($dealt);//this is check statement actually the data has to returned
	return ;
}
else
{
{
		var_dump("INVALID PARAMETERS");
		return ;
	}	
}
?>
