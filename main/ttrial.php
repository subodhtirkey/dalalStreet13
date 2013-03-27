                       
<?php

class thisuser
{
private $username,
$iflogged,
$userid;
public function __construct()
{
$username=NULL;
$iflogged=NULL;
$userid=NULL;
}
public function db_connection()
{
  mysql_connect("localhost","dalal","dalal@01#");
mysql_select_db("pragyan13_dalal");
////error_log(mysql_error());
}
public function attempt_login($p_email,$p_password)
{
$this->db_connection();
$loginresource=mysql_query("SELECT * FROM `users` WHERE `email`='{$p_email}' AND `password`='{$p_password}'");
////error_log(mysql_error());
$loggeduserdetails=mysql_fetch_array($loginresource);
if($loggeduserdetails)
{
$loginuserid=$loggeduserdetails[0];
$loginuser_verified=$loggeduserdetails[4];
$loginuser_disabled=$loggeduserdetails[5];
if(!$loginuser_verified)
{
return array("result"=>false,"response"=>"email id not yet verified");
}
if($loginuser_disabled)
{
return array("result"=>false,"response"=>"your account has been disabled");
}
session_start();
$_SESSION['userid']=$loginuserid;
$this->iflogged=1;
$this->username=$loggeduserdetails['username'];
$this->userid=$loggeduserdetails['userid'];
$thecurrentsessionid=session_id();
$existingsessionidintable=$loggeduserdetails[7];
if($existingsessionidintable!=$thecurrentsessionid)
{
$updatesessionidintheusers=mysql_query("UPDATE `users` SET `sessionid`='{$thecurrentsessionid}' WHERE `userid`='{$this->userid}'");
if(!mysql_affected_rows())
{
session_destroy();
$_SESSION["PHPSESSID"]="";
return array("result"=>false,"response"=>"invalid data entered please try again");
}
}
return array("result"=>true,"userid"=>$this->userid);
}
else
{
return array("result"=>false,"response"=>"invalid username password combination");
}
}
public function verify_login()
{
$this->db_connection();
require_once("facebooklogin/fbaccess1.php");
//session_start();
//$access_token=$_SESSION["KICKME"];
//$thefbiid=$iid;
//error_log("6576878688783456789043567890458970546879");
//error_log($access_token);
$sql_1=mysql_query("SELECT `userid` FROM `users1` WHERE `facebook_id`='{$iid}'");
//error_log(("SELECT `userid` FROM `users1` WHERE `facebook_id`='{$thefbiid}'"));
if(!mysql_num_rows($sql_1))
	{
	return false;
	}
else
	{
	$getone=mysql_fetch_array($sql_1);
	$theuseridmain_1=$getone[0];
	$sql_2=mysql_query("SELECT * FROM `users` WHERE `userid`='{$theuseridmain_1}'");
	//error_log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@");
	//error_log(mysql_error());
	if(!mysql_num_rows($sql_2))
		{
		return false;
		}
	else 	{
		$getsql_3=mysql_fetch_array($sql_2);
		$this->username=$getsql_3[1];
		$this->userid=$getsql_3[0];
		$this->iflogged=1;
		//error_log(json_encode($getsql_3));
		return true;
		}	
	}

/*
//just compare the session id with the one existing in the db and if not the revoke the session
$this->db_connection();
session_start();
$passeduserid=mysql_real_escape_string($_SESSION['userid']);
$loginresource=mysql_query("SELECT * FROM `users` WHERE `userid`='{$passeduserid}'");
$loggeduserdetails=mysql_fetch_array($loginresource);
if($loggeduserdetails)
{
$loginusersessionid=$loggeduserdetails[7];
$thecurrentsessionid=session_id();
if($thecurrentsessionid==$loginusersessionid)
{
$this->username=$loggeduserdetails[1];
$this->userid=$loggeduserdetails[0];
$this->iflogged=1;
return true;
}
                else
{
$this->userid="";
$this->username="";
$this->iflogged=0;
session_destroy();
$_SESSION["PHPSESSID"]="";
$_SESSION['userid']="";
return false;
*/
}
public function get_share_list($code)
{
$this->db_connection();
//spaghetti code
if(!$this->verify_login())
{
return array("result"=>false,"response"=>"you have been logged out please login to continue");
//custom message needed
}
if($code==0)//for general listing
{
$forreturn=array();
$counter=0;
$get_complete_share_details_query=mysql_query("SELECT `stockname`,`stockid`,`currentprice`,`stocksinexchange`,`stocksinmarket` FROM `stocks`");
while($result=mysql_fetch_array($get_complete_share_details_query))
{
$getthenumberofusershares_query=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$result[1]}'");
$getthenumberofusershares_fetch=mysql_fetch_array($getthenumberofusershares_query);
if(mysql_num_rows($getthenumberofusershares_query)==0)
$numberofshareswithme=0;
else
{
$numberofshareswithme=$getthenumberofusershares_fetch[0];
}
$forreturn[$counter]=array("stockid"=>$result[1],"stockname"=>$result[0],"currentprice"=>$result[2],"stocksinexchange"=>$result[3],"stocksinmarket"=>$result[4],"stockswithme"=>$numberofshareswithme);
$counter++;
}
return json_encode($forreturn);
}
if($code==1)//for user specific listing
{
$forreturn=array();
$counter=0;
$get_all_the_shareids_query=mysql_query("SELECT `stockid`,`num` FROM `stocks_details` WHERE `userid`='{$this->userid}'");
while($thesharesfetch=mysql_fetch_array($get_all_the_shareids_query))
{
$get_complete_share_details_query=mysql_query("SELECT `stockname`,`currentprice`,`stocksinexchange`,`stocksinmarket` FROM `stocks` WHERE `stockid`='{$thesharesfetch[0]}'");
while($result=mysql_fetch_array($get_complete_share_details_query))
{
$forreturn[$counter]=array("stockid"=>$thesharesfetch[0],"stockname"=>$result[0],"currentprice"=>$result[1],"stocksinexchange"=>$result[2],"stocksinmarket"=>$result[3],"stockswithme"=>$thesharesfetch[1]);
$counter++;
}
}
return json_encode($forreturn);
}
if($code==2)//for mortgaged share listing
{
$forreturn=array();
$counter=0;
$get_all_the_mortgaged_shareids_query=mysql_query("SELECT `stockid`,`num` FROM `bank` WHERE `userid`='{$this->userid}'");
while($thesharesfetch=mysql_fetch_array($get_all_the_mortgaged_shareids_query))
{
//this calculates how many shares user has 
$get_all_the_shareids_his_query=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$thesharesfetch[0]}'");
$thehissharesfetch=mysql_fetch_array($get_all_the_shareids_his_query);
$onetotalshares=0;
if(mysql_num_rows($get_all_the_shareids_his_query))
{
$onetotalshares=$thehissharesfetch[0];
}
$get_complete_share_details_query=mysql_query("SELECT `stockname`,`currentprice`,`stocksinexchange`,`stocksinmarket` FROM `stocks` WHERE `stockid`='{$thesharesfetch[0]}'");
while($result=mysql_fetch_array($get_complete_share_details_query))
{
$forreturn[$counter]=array("stockid"=>$thesharesfetch[0],"stockname"=>$result[0],"currentprice"=>$result[1],"stocksinexchange"=>$result[2],"stocksinmarket"=>$result[3],"stockswithme"=>$onetotalshares,"stocksmortgaged"=>$thesharesfetch[1]);
$counter++;
}
}
return json_encode($forreturn);
}
if($code==3)//for buying
{
$forreturn=array();
$counter=0;
$get_all_the_desired_shareids_query=mysql_query("SELECT `stockid`,`num`,`pricerendered` FROM `buy` WHERE `userid`='{$this->userid}'");
while($thesharesfetch=mysql_fetch_array($get_all_the_desired_shareids_query))
{
//this calculates how many shares user has 
$get_all_the_shareids_his_query=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$thesharesfetch[0]}'");
$thehissharesfetch=mysql_fetch_array($get_all_the_shareids_his_query);
$onetotalshares=0;
if(mysql_num_rows($get_all_the_shareids_his_query))
{
$onetotalshares=$thehissharesfetch[0];
}
$get_complete_share_details_query=mysql_query("SELECT `stockname`,`currentprice`,`stocksinexchange`,`stocksinmarket` FROM `stocks` WHERE `stockid`='{$thesharesfetch[0]}'");
while($result=mysql_fetch_array($get_complete_share_details_query))
{
$forreturn[$counter]=array("stockid"=>$thesharesfetch[0],"stockname"=>$result[0],"currentprice"=>$result[1],"stocksinexchange"=>$result[2],"stocksinmarket"=>$result[3],"stockswithme"=>$onetotalshares,"stocksdesired"=>$thesharesfetch[1],"pricerendered"=>$thesharesfetch[2]);
$counter++;
}
}
return json_encode($forreturn);
}
if($code==4)//for selling
{
$forreturn=array();
$counter=0;
$get_all_the_selling_shareids_query=mysql_query("SELECT `stockid`,`num`,`priceexpected` FROM `sell` WHERE `userid`='{$this->userid}'");
while($thesharesfetch=mysql_fetch_array($get_all_the_selling_shareids_query))
{
//this calculates how many shares user has 
$get_all_the_shareids_his_query=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$thesharesfetch[0]}'");
$thehissharesfetch=mysql_fetch_array($get_all_the_shareids_his_query);
$onetotalshares=0;
if(mysql_num_rows($get_all_the_shareids_his_query))
{
$onetotalshares=$thehissharesfetch[0];
}
$get_complete_share_details_query=mysql_query("SELECT `stockname`,`currentprice`,`stocksinexchange`,`stocksinmarket` FROM `stocks` WHERE `stockid`='{$thesharesfetch[0]}'");
while($result=mysql_fetch_array($get_complete_share_details_query))
{
$forreturn[$counter]=array("stockid"=>$thesharesfetch[0],"stockname"=>$result[0],"currentprice"=>$result[1],"stocksinexchange"=>$result[2],"stocksinmarket"=>$result[3],"stockswithme"=>$onetotalshares,"stocksforselling"=>$thesharesfetch[1],"priceexpected"=>$thesharesfetch[2]);
$counter++;
}
}
return json_encode($forreturn);
}

}
/*
 * ONE SHOW GRAPH FUNCTION NEEDED
 */ 
 
 public function show_graph($stock_id)
{
}
public function bid_for_sale($stock_id,$stock_num,$price_per_share)
{
/*
*i need to verify if the user has already put some of his stocks of the kind up for sale if yes i update after checking that the number of shares does not cross the number of shares owned by him
*/ 
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return array("result"=>false,
"response"=>"you have been logged out please login to continue");
//custom message needed
}
$getthenameofftheshare=mysql_query("SELECT `stockname` FROM `stocks` WHERE `stockid`='{$stock_id}'");
$getthenameofftheshare_fetch=mysql_fetch_array($getthenameofftheshare);
$stockname=$getthenameofftheshare_fetch[0];
$totalsharesforsaleuptonow=0;//to get the total number of shares of the company for sale upto now
$check_if_update_necessary=mysql_query("SELECT `num`,`priceexpected` FROM `sell` WHERE `userid`='{$this->userid}' AND `stockid`='{$stock_id}'");
if($check_if_update_necessary==false)
{
//this means the user has not put up any shares of this kind for sale earlier
}
else
{
while($sharesforsale=mysql_fetch_array($check_if_update_necessary))
{
$totalsharesforsaleuptonow+=$sharesforsale[0];
}
}
$verify_bid_query=mysql_query("SELECT `stockid`,`num` FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$stock_id}'");//total number of the shares of the company with the user 
$verify_bid_fetch=mysql_fetch_array($verify_bid_query);
if($verify_bid_fetch[1]-$totalsharesforsaleuptonow<$stock_num)
{

$thenotification="SELL QUERY FAILED ::insufficient shares : you are trying to bid for $stock_num $stockname shares ,while you have only $verify_bid_fetch[1] shares and $totalsharesforsaleuptonow shares are up for selling already";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

$response="insufficient_shares";
return json_encode(array("result"=>false,
"stockid"=>$stock_id,
"stockname"=>$stockname,
"sharesowned"=>$verify_bid_fetch[1],
"sharesupforsalealready"=>$totalsharesforsaleuptonow,
"response"=>$response));
//the message can be changed here to reflect on the front end
}
else
{
$currenttimestamp=time();
$push_the_sell_bid_into_sell_table=mysql_query("INSERT INTO `sell`(`userid`,`stockid`,`priceexpected`,`num`,`timestamp`) VALUES('{$this->userid}','{$stock_id}','{$price_per_share}','{$stock_num}','{$currenttimestamp}') ");
//push the entire thing into notifications
$thenotification="QUERY SUCCESSFUL : $stock_num number of $stockname share have been PUT up for sale at Rs. $price_per_share";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,4)");
if(mysql_affected_rows()==1)
{
$response="request successfull";
return json_encode(array("result"=>true,
"stockid"=>$stock_id,
"stockname"=>$stockname,
"stocksputupforsalenow"=>$stock_num,
"rateofshares"=>$price_per_share,
"sharesowned"=>$verify_bid_fetch[1],
"sharesupforsalealready"=>$totalsharesforsaleuptonow,
"response"=>$response,
"timestamp"=>$currenttimestamp));
//i need a success json message to be returned 
}
}
}
/*
 * this is for buying bidding
 */
 public function bid_for_buying($stock_id,$stock_num,$price_per_share)
{
/*
*i need to verify if the user has sufficient cash with him at the point he is bidding for this particular type of shares
*/ 
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return array("result"=>false,"response"=>"you have been logged out please login to continue");
//custom message needed
}
$availablecash=0;
$get_the_cash=mysql_query("SELECT `cash` FROM `users` WHERE `userid`='{$this->userid}'");
if(!mysql_num_rows($get_the_cash))
{
//the user cash could not be retrived
return json_encode(array("result"=>false,"response"=>"electronic exchange could not take place"));
}
else {
$fetch_the_cash=mysql_fetch_array($get_the_cash);
$availablecash=$fetch_the_cash['cash'];
}
$getthenameofftheshare=mysql_query("SELECT `stockname`,`stocksinmarket` FROM `stocks` WHERE `stockid`='{$stock_id}'");
$getthenameofftheshare_fetch=mysql_fetch_array($getthenameofftheshare);
$stockname=$getthenameofftheshare_fetch[0];
$totalstocksinmarket=$getthenameofftheshare_fetch[1];
if($stock_num>$totalstocksinmarket)
{
$thenotification="BUY QUERY FAILED ::insufficient shares : you are trying to bid for $stock_num of $stockname shares ,while there are only $totalstocksinmarket shares in market";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");



//confirm that the shares bid is greater than the number of shares in market right now
//this loop takes action for the complemantary case
return json_encode(array("result"=>false,
"response"=>"stocks bid for cannot be greater than the stocks in market",
"cashinaccount"=>$availablecash,
"stockidbidfor"=>$stock_id,
"stockname"=>$stockname,
"numberofstocks"=>$stock_num,
"stocksinmarket"=>$totalstocksinmarket,
"pricepershare"=>$price_per_share,
"totalprice"=>$totalpricebidfor,
));
//the message can be changed here to reflect on the front end
}
$totalpricebidfor=$stock_num*$price_per_share;
if($totalpricebidfor>$availablecash)
{

$thenotification="BUY QUERY FAILED ::insufficient funds : you are trying to bid for $totalpricebidfor rupees $stockname shares ,while your cash $availablecash";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");


//confirm if the total shares-total shares for sale upto now is greater than or equal the number of stocks requested now
//this loop takes action for the complemantary case
return json_encode(array("result"=>false,
"response"=>"insufficient funds",
"cashinaccount"=>$availablecash,
"stockidbidfor"=>$stock_id,
"stockname"=>$stockname,
"numberofstocks"=>$stock_num,
"pricepershare"=>$price_per_share,
"totalprice"=>$totalpricebidfor,
));
//the message can be changed here to reflect on the front end
}
else
{
$currenttimestamp=time();
$push_the_buy_bid_into_buy_table=mysql_query("INSERT INTO `buy`(`userid`,`stockid`,`pricerendered`,`num`,`timestamp`) VALUES('{$this->userid}','{$stock_id}','{$price_per_share}','{$stock_num}','{$currenttimestamp}') ");
$thenotification="BUY QUERY SUCCESSFUL :$stock_num number of $stockname share have been BID FOR BUYING at Rs. $price_per_share";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,3)");
if(mysql_affected_rows()==1)
{
//i need a success json message to be returned
   $response="request successfull";
return json_encode(array("result"=>true,
"stockid"=>$stock_id,
"stockname"=>$stockname,
"stocksbidforbuying"=>$stock_num,
"rateofshares"=>$price_per_share,
"response"=>$response,
"cashinaccount"=>$availablecash,
"timestamp"=>$currenttimestamp));
}
}
}
public function deal()
{
//THISIS PERCENTAGE ABOVE
$PERCENTAGE_ABOVE=25;
$PERCENTAGE_BELOW=25;
$this->db_connection();
/*
if(!$this->verify_login())//verifies if the user is still logged in
{
return array("result"=>false,
"response"=>"you have been logged out please login to continue");
//custom message needed
}
*/
///////////////////////////
$debugarray=array();
$debugarraycount=0;
///////////////////////////
//for each type of stoccks run a query and try to match 
// find the lowest bidding price and highiest price bidded;
//from the bid price find if the user has enough cash to buy the shares
//from the shares for sale find if the user still has the number and type of shares to sell;
//sell only the number of shares minimum of the two stocks for selling and shares up for buying
//note if the selling price is too low
//or if the buying price is too high`
//skip to the next thing
//and note that after selling some shares i have to  alter the entire thing from the sell and the buy table also
//and also from the user shares
//this function needs to run the most number of times
//like with every regular request and every sell buy request
//select distinct stokid ;get all the stockids
//for eah stockid run a query
$getallthestockidsinthebuy=mysql_query("SELECT DISTINCT  `stockid` FROM  `buy` ");
if(mysql_num_rows($getallthestockidsinthebuy)==0)
{
return json_encode(array("deal_result"=>true,"response"=>"no quotations in buy"));
//that the query returned zero means that no buy quotation exists in
}
//control upto here means that the entire that some or other stocks do have buy quotations
while($oneid=mysql_fetch_array($getallthestockidsinthebuy))
{
///////////////////////////////
$debugarray[$debugarraycount++]="distinct ids found in buy";
///////////////////////////////
$thebuystockidis=$oneid[0];//thestockid
$formthebuyquotationarray=array();
$formthesellquotationarray=array();
$buyquotationcounter=0;
$sellquotationcounter=0;
$getthecurrentpriceothestocki=mysql_query("SELECT `currentprice` FROM `stocks` WHERE `stockid`='{$thebuystockidis}'");
if(!mysql_num_rows($getthecurrentpriceothestocki))
{
///////////////////////////////////////////
/*
return array("result"=>false,
"response"=>"the buy retrived stockid has no presence in stocks");
*/
/////////////////////////////////////////// 
continue;
//this is for the case that the stockd retrived from the buy table has no presence in the stocks table
//will not happen but still
}
///////////////////////////////
$debugarray[$debugarraycount++]="currentprice retrived";
///////////////////////////////
$getthecurrentpriceothestock=mysql_fetch_array($getthecurrentpriceothestocki);
$thecurrentpriceis=$getthecurrentpriceothestock[0];
$UPPERLIMIT=$thecurrentpriceis*(1+($PERCENTAGE_ABOVE/100));
$LOWERLIMIT=$thecurrentpriceis*(1-($PERCENTAGE_BELOW/100));
///////////////////////////////
$debugarray[$debugarraycount++]="upper lower bound set";
///////////////////////////////
$get_the_stock_all=mysql_query("SELECT  * FROM `buy` WHERE `stockid`='{$thebuystockidis}'");
if(mysql_num_rows($get_the_stock_all))
{
///////////////////////////////
$debugarray[$debugarraycount++]="id found in buy";
///////////////////////////////
while($getthepparticularrow=mysql_fetch_array($get_the_stock_all))
{
$pricebid=$getthepparticularrow[3];
if($pricebid>$UPPERLIMIT)///only uppperlimit required for buy
{
///////////////////////////////
$debugarray[$debugarraycount++]="price overshoots upper";
///////////////////////////////
///////////////////////////////////////////
/*
return array("result"=>false,
"response"=>"price overshoots uppervalue");
*/
///////////////////////////////////////////
continue;
}
else {
$formthebuyquotationarray[$buyquotationcounter++]=array("theid"=>$getthepparticularrow[0],
 "userid"=>$getthepparticularrow[1],
 "stockid"=>$getthepparticularrow[2],
 "pricerendered"=>$getthepparticularrow[3],
 "num"=>$getthepparticularrow[4],
 "timestamp"=>$getthepparticularrow[5]
 );
///////////////////////////////
$debugarray[$debugarraycount++]="buyarray with counter $buyquotationcounter found";
///////////////////////////////
   }
///////////////////////////////
$debugarray[$debugarraycount++]="buy array anotherloop";
///////////////////////////////
}
}
else {
///////////////////////////////
$debugarray[$debugarraycount++]="retrived id not in buy";
///////////////////////////////
///////////////////////////////////////////
/*
return array("result"=>false,
"response"=>"the buy retrived stockid has no presence in buy");
*/
///////////////////////////////////////////
continue;
}
 
$get_the_stock_all_sell=mysql_query("SELECT  * FROM `sell` WHERE `stockid`='{$thebuystockidis}'");
if(mysql_num_rows($get_the_stock_all_sell))
{
///////////////////////////////
$debugarray[$debugarraycount++]="id found in sell";
///////////////////////////////
while($getthepparticularrow=mysql_fetch_array($get_the_stock_all_sell))
{
$pricebid=$getthepparticularrow[3];
if($pricebid<$LOWERLIMIT)///only lowerlimit required for buy
{
///////////////////////////////
$debugarray[$debugarraycount++]="price undershoots lower";
///////////////////////////////
///////////////////////////////////////////
/*
return array("result"=>false,
"response"=>"price undershoots lowervalue");
*/
///////////////////////////////////////////
continue;
}
else {
$formthesellquotationarray[$sellquotationcounter++]=array("theid"=>$getthepparticularrow[0],
 "userid"=>$getthepparticularrow[1],
 "stockid"=>$getthepparticularrow[2],
 "priceexpected"=>$getthepparticularrow[3],
 "num"=>$getthepparticularrow[4],
 "timestamp"=>$getthepparticularrow[5]
 );
///////////////////////////////
$debugarray[$debugarraycount++]="sellarray with counter $sellquotationcounter found";
///////////////////////////////
}
///////////////////////////////
$debugarray[$debugarraycount++]="sell array anotherloop";
///////////////////////////////
}
}
else
{
///////////////////////////////
$debugarray[$debugarraycount++]="retrived id not in sell";
///////////////////////////////
///////////////////////////////////////////
/*
return array("result"=>false,
"response"=>"the buy retrived stockid has no presence in sell");
*/
///////////////////////////////////////////
continue;
    }
// the arrays are formed upto here
//now sort each of the arrays according to there price
$ii=0;
$jj=0;
///////////////////////////////
$debugarray[$debugarraycount++]="counters set for sorting";
///////////////////////////////
for($ii=0;$ii<$buyquotationcounter;$ii++)
{
for($jj=0;$jj<$buyquotationcounter;$jj++)
{
if($formthebuyquotationarray[$ii]["pricerendered"]>$formthebuyquotationarray[$jj]["pricerendered"])
{
///////////////////////////////
$debugarray[$debugarraycount++]="buy swapped";
///////////////////////////////
$ttemp=$formthebuyquotationarray[$ii];
$formthebuyquotationarray[$ii]=$formthebuyquotationarray[$jj];
$formthebuyquotationarray[$jj]=$ttemp;
}
}
}
for($ii=0;$ii<$sellquotationcounter;$ii++)
{
for($jj=0;$jj<$sellquotationcounter;$jj++)
{
if($formthesellquotationarray[$ii]["priceexpected"]<$formthesellquotationarray[$jj]["priceexpected"])
{
///////////////////////////////
$debugarray[$debugarraycount++]="sell swapped";
///////////////////////////////
$ttemp=$formthesellquotationarray[$ii];
$formthesellquotationarray[$ii]=$formthesellquotationarray[$jj];
$formthesellquotationarray[$jj]=$ttemp;
}
}
}
///////////////////////////////
$debugarray[$debugarraycount++]="sorting over";
///////////////////////////////
$takecounter1=0;
$takecounter2=0;
while($takecounter1<$buyquotationcounter && $takecounter2<$sellquotationcounter)
{
///////////////////////////////
$debugarray[$debugarraycount++]="inside trade";
///////////////////////////////
////////////////////////
/////return array($formthebuyquotationarray[$takecounter1],$formthesellquotationarray[$takecounter2]);
////////////////////////
if($formthebuyquotationarray[$takecounter1]["pricerendered"]<$formthesellquotationarray[$takecounter1]["priceexpected"])
{
///////////////////////////////
$debugarray[$debugarraycount++]="buy price lesser tthan sell";
///////////////////////////////
$takecounter1++;
$takecounter2++;
continue;
}
///////////////////////////////
$debugarray[$debugarraycount++]="price requirement set";
///////////////////////////////
if($formthebuyquotationarray[$takecounter1]["userid"]==$formthesellquotationarray[$takecounter1]["userid"])
{
///////////////////////////////
$debugarray[$debugarraycount++]="userids match";
///////////////////////////////
$takecounter1++;
$takecounter2++;
continue;
}
///////////////////////////////
$debugarray[$debugarraycount++]="userids okay";
///////////////////////////////
$thebuyuserid=$formthebuyquotationarray[$takecounter1]["userid"];
//get the cash with the user
$theusercashis=mysql_query("SELECT `cash`,`disabled` FROM `users` WHERE `userid`='{$thebuyuserid}'");
if(mysql_num_rows($theusercashis)==0)
{
$takecounter1++;
continue;
}
$theusercashis_fetch=mysql_fetch_array($theusercashis);
$disableduser=$theusercashis_fetch[1];
if($disableduser)
{
///////////////////////////////
$debugarray[$debugarraycount++]="buyer disabled";
///////////////////////////////
$takecounter1++;
continue;
}
//error_log("iamin deal");
$theusercashis=$theusercashis_fetch[0];//this is the buyers cash
///////////////////////////////
if($theusercashis)
{
$debugarray[$debugarraycount++]="buyercash fetched";
}
///////////////////////////////
$maxsharescurrently_canbebrought=($theusercashis)/($formthebuyquotationarray[$takecounter1]["pricerendered"]);
$maxsharescurrently_canbebrought=(int)$maxsharescurrently_canbebrought;
//this is the maximum number of shares that can be brought by the buyer
///////////////////////////////
if($maxsharescurrently_canbebrought)
{
$debugarray[$debugarraycount++]="maximum shares that can be brought by the user fetched";
}
///////////////////////////////
if($maxsharescurrently_canbebrought<1)
{
///////////////////////////
$debugarray[$debugarraycount++]="no such share can be brought";
///////////////////////////
$takecounter1++;
continue;
};
//return "kick";
//if the maximum shares in account is less than the buy quotation change it to the maximum shares in account
if($maxsharescurrently_canbebrought>$formthebuyquotationarray[$takecounter1]["num"])
{
$maxsharescurrently_canbebrought=$formthebuyquotationarray[$takecounter1]["num"];
///////////////////////////
$debugarray[$debugarraycount++]="max shares that can be brought is reset to the asked value";
///////////////////////////
}
//make the check with the buy user
@$theselluserid=$formthesellquotationarray[$takecounter1]["userid"];
$theusersharesis=mysql_query("SELECT `disabled` FROM `users` WHERE `userid`='{$theselluserid}'");
if(mysql_num_rows($theusersharesis)==0)
{
///////////////////////////
$debugarray[$debugarraycount++]="seller could not be found";
///////////////////////////
$takecounter2++;
continue;
}
$theusercashis_fetch=mysql_fetch_array($theusersharesis);
$disableduser=$theusercashis_fetch[0];
if($disableduser)
{
///////////////////////////
$debugarray[$debugarraycount++]="seller disabled";
///////////////////////////
$takecounter2++;
continue;
}
$theusersharesis_q=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$theselluserid}' AND `stockid`='{$thebuystockidis}'");
//seller initial number of shares
if(mysql_num_rows($theusersharesis_q)==0)
{
///////////////////////////
$debugarray[$debugarraycount++]="no the seller does not have the stockid entry";
///////////////////////////
$takecounter2++;
continue;
}
///////////////////////////
$fetch_thesharesavailableare=mysql_fetch_array($theusersharesis_q);
if($fetch_thesharesavailableare)
{
$debugarray[$debugarraycount++]="shares from the seller fetched";
}
///////////////////////////
$thesharesavailableare=$fetch_thesharesavailableare[0];
//these are initial number of shares with the seller
if($thesharesavailableare<1)
{
///////////////////////////
$debugarray[$debugarraycount++]="seller has less than one share available in his table";
///////////////////////////
$takecounter2++;
continue;
}
if($thesharesavailableare>$formthesellquotationarray[$takecounter2]["num"])
{
///////////////////////////
$debugarray[$debugarraycount++]="available shares in seller table are greater than the shares in this quotation so the number of shares from seller is set as the quotation shares";
///////////////////////////
$thesharesavailableare=$formthesellquotationarray[$takecounter2]["num"];//this is the number of maximum shares that can be sold
}
//by now it has been checked that the seller and buyer have greater than the minimum cash and prices
$final_agreement=0;
if($maxsharescurrently_canbebrought<$thesharesavailableare)
$final_agreement=$maxsharescurrently_canbebrought;
else $final_agreement=$thesharesavailableare;
//reach a final agreement between the number of shares to be traded
///////////////////////////
$debugarray[$debugarraycount++]="seller gives $thesharesavailableare --buyer wants $maxsharescurrently_canbebrought so the final agreement is $final_agreement";
///////////////////////////
$thebuyer_loses=$final_agreement*$formthebuyquotationarray[$takecounter1]["pricerendered"];
///////////////////////////
$debugarray[$debugarraycount++]="buyer loses $thebuyer_loses";
///////////////////////////
$thebuyerfinalcash=$theusercashis-$thebuyer_loses;
///////////////////////////
$debugarray[$debugarraycount++]="buyer initial cash was $theusercashis he loses $thebuyer_loses final cash is $thebuyerfinalcash";
///////////////////////////
$initialsharesinquotation_buy=$formthebuyquotationarray[$takecounter2]["num"];
//sell                                  //$maxsharescurrently_canbebrought 
$buy_finalsharesinquotation=$formthebuyquotationarray[$takecounter2]["num"]-$final_agreement;
///////////////////////////
$debugarray[$debugarraycount++]="buy quotation had initially $initialsharesinquotation_buy traded shares are $final_agreement final shares are $buy_finalsharesinquotation ";
///////////////////////////
//get the buyer final shares of this type
$thebuyersharesofthiskindcurrently=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$thebuyuserid}' AND `stockid`='{$thebuystockidis}'");
///////////////////////////
if($thebuyersharesofthiskindcurrently)
$debugarray[$debugarraycount++]="buyer initially had some shares of stockid $thebuystockidis";
///////////////////////////
$thecurrentnumberofshareswithbuyer=0;
if(mysql_num_rows($thebuyersharesofthiskindcurrently)==0)
{
//buyer had no stocks of this kind before
}
else
{
$thecurrentnumberofshareswithbuyer_fetch=mysql_fetch_array($thebuyersharesofthiskindcurrently);
$thecurrentnumberofshareswithbuyer=$thecurrentnumberofshareswithbuyer_fetch[0];
//buyer had initially this many stocks of this kind already
}
///////////////////////////
$debugarray[$debugarraycount++]="buyer stocks prior to this this transaction calculated $thecurrentnumberofshareswithbuyer";
///////////////////////////
$buy_finalsharesinwithuser=$thecurrentnumberofshareswithbuyer+$final_agreement;
///////////////////////////
if($buy_finalsharesinwithuser && $thecurrentnumberofshareswithbuyer&& $final_agreement)
$debugarray[$debugarraycount++]="final shares in the buyers account calculated";
///////////////////////////
$theseller_gains=$final_agreement*$formthesellquotationarray[$takecounter1]["priceexpected"];
///this is how much the seller gains from this trade
///////////////////////////
$debugarray[$debugarraycount++]="$theseller_gains this is how much the seller gains from this trade";
///////////////////////////
//get the seller initial cash
$thesellercashcurrently=mysql_query("SELECT `cash` FROM `users` WHERE `userid`='{$theselluserid}'");
$thesellercashcurrently_fetch=mysql_fetch_array($thesellercashcurrently);
$thesellercashcurrently_number=$thesellercashcurrently_fetch[0];//this is the seller initial cash
$thefinalcashwiththeseller=$thesellercashcurrently_number+$theseller_gains;;
///////////////////////////
if($thefinalcashwiththeseller&&$thesellercashcurrently_number&&$theseller_gains)
{
$debugarray[$debugarraycount++]="the final amount in the seller account is calculated not updated";
}
///////////////////////////
$thecurrentnumberofshareswithseller=0;
//error_log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
$thesellersharesofthiskindcurrently=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$theselluserid}' AND `stockid`='{$thebuystockidis}'");//buy user id and sell user id is thesame
//error_log(("SELECT `num` FROM `stocks_details` WHERE `userid`='{$theselluserid}' AND `stockid`='{$thebuystockidis}'"));
if(!mysql_num_rows($thesellersharesofthiskindcurrently))
{
//error_log(mysql_num_rows($thesellersharesofthiskindcurrently));
//no such shares with the seller before
}
else
{
$thecurrentnumberofshareswithseller_fetch=mysql_fetch_array($thesellersharesofthiskindcurrently);
$thecurrentnumberofshareswithseller=$thecurrentnumberofshareswithseller_fetch[0];
}
////error_log("$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$");
////error_log($thecurrentnumberofshareswithseller);
$initialsharesinquotation_sell=$formthesellquotationarray[$takecounter2]["num"];
$sell_finalsharesinquotation=$initialsharesinquotation_sell-$final_agreement;
//the final number of shares in the seller quotation
$sell_finalsharesinwithuser=$thecurrentnumberofshareswithseller-$final_agreement;
//the final number of shares with the seller calculated not updated
//THIS IS THE QUERY SECTION
//THIS IS THE QUERY SECTION
//THIS IS THE QUERY SECTION
//THIS IS THE QUERY SECTION
$buyerfinalcash=mysql_query("UPDATE `users` SET `cash`='{$thebuyerfinalcash}'  WHERE `userid`='{$thebuyuserid}'");
if(mysql_affected_rows())
{
///////////////////////////
$debugarray[$debugarraycount++]="new cash $thebuyerfinalcash is updated for the buyer";
///////////////////////////
//new cash could not be updated into the buyer
}
$sellerfinalcash=mysql_query("UPDATE `users` SET `cash`='{$thefinalcashwiththeseller}'  WHERE `userid`='{$theselluserid}'");
if(mysql_affected_rows())
{
///////////////////////////
$debugarray[$debugarraycount++]="new cash $thefinalcashwiththeseller is updated for the seller";
///////////////////////////
}
else
{
//new cash could not be updated into the seller
}
$buy_finalsharesinquotation=$formthebuyquotationarray[$takecounter2]["num"]-$final_agreement;
if(!$buy_finalsharesinquotation)
{
//remove the buy quotation
$thebuyquotationid=$formthebuyquotationarray[$takecounter1]["theid"];
$removethebuyquotation=mysql_query("DELETE FROM `buy` WHERE `theid`='{$thebuyquotationid}'");
if(!mysql_affected_rows())
{
//the quotation id could not be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be deleted from buy";
///////////////////////////
}
                    else
                    {
///////////////////////////
$debugarray[$debugarraycount++]="entry deleted from buy";
///////////////////////////
}
}
else
{
$thebuyquotationid=$formthebuyquotationarray[$takecounter1]["theid"];
$updatethebuyquotation=mysql_query("UPDATE `buy` SET `num`='{$buy_finalsharesinquotation}' WHERE `theid`='{$thebuyquotationid}'");
if(!mysql_affected_rows())
{
//the quotation id could not be updated
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be updated from buy";
///////////////////////////
}
else
                    {
                    //quotation id updated
///////////////////////////
$debugarray[$debugarraycount++]="entry updated from buy";
///////////////////////////
}
}
//NOTE THAT THE FINAL SHARES WITH THE BUYER HAS TO BE NON ZERO
//the finalshares with the seller quotation
if(!$sell_finalsharesinquotation)
{
//remove the buy quotation
$thesellquotationid=$formthesellquotationarray[$takecounter2]["theid"];
$removethebuyquotation=mysql_query("DELETE FROM `sell` WHERE `theid`='{$thesellquotationid}'");
if(!mysql_affected_rows())
{
//the quotation id could not be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be removed form sell";
///////////////////////////
}
else
{
//the quotation id be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry removed form sell";
///////////////////////////
}
}
else
{
$thesellquotationid=$formthesellquotationarray[$takecounter2]["theid"];
$updatethesellquotation=mysql_query("UPDATE `sell` SET `num`='{$sell_finalsharesinquotation}' WHERE `theid`='{$thesellquotationid}'");
if(!mysql_affected_rows())
{
//the quotation id could not be updated
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be updated form sell";
///////////////////////////
}
else
{
//the quotation id be has been updated
///////////////////////////
$debugarray[$debugarraycount++]="entry removed form sell";
///////////////////////////
}
}
//updatetheusersallashares
//set the final shares with the seller
if(!$sell_finalsharesinwithuser)
{
//remove the stock entry from stock details
$updatesellershares=mysql_query("DELETE FROM `stocks_details` WHERE `userid`='{$theselluserid}' AND `stockid`='{$thebuystockidis}'");
if(!mysql_affected_rows())
{
//the quotation id could not be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be removed form stocks details";
///////////////////////////
}
else
{
//the quotation id be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry removed form stocks details";
///////////////////////////
}
}
else
{
$updatesellershares=mysql_query("UPDATE `stocks_details` SET `num`='{$sell_finalsharesinwithuser}' WHERE `userid`='{$theselluserid}' AND `stockid`='{$thebuystockidis}'");
if(!mysql_affected_rows())
{
//the quotation id could not be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be updated form stocks details";
///////////////////////////
}
else
{
//the quotation id be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry updated form stocks details";
///////////////////////////
}
}
//set the final shares with the buyer
if(!$thecurrentnumberofshareswithbuyer)
{
$updatethebuyertotalshares=mysql_query("INSERT INTO `stocks_details`(`userid`,`stockid`,`num`) VALUES('{$thebuyuserid}','{$thebuystockidis}','{$buy_finalsharesinwithuser}')");
//the quotation id could not be removed
///////////////////////////
///////////////////////////
if(!mysql_affected_rows())
{
//the quotation id could not be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be inserted form stocks details";
///////////////////////////
}
else
{
//the quotation id be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry inserted form stocks details";
///////////////////////////
}
}
else
{
$updatethebuyertotalshares=mysql_query("UPDATE `stocks_details` SET `num`='{$buy_finalsharesinwithuser}' WHERE `userid`='{$thebuyuserid}' AND `stockid`='{$thebuystockidis}'");
if(!mysql_affected_rows())
{
//the quotation id could not be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry could not be updated form stocks details";
///////////////////////////
}
else
{
//the quotation id be removed
///////////////////////////
$debugarray[$debugarraycount++]="entry updated form stocks details";
///////////////////////////
}
}
////////////////////////////
////////////////////////////
//this is for updating logs and notifications
$nameofthestock=mysql_query("SELECT * FROM `stocks` WHERE `stockid`='{$thebuystockidis}'");
if(mysql_num_rows($nameofthestock))
{
//the stockname could not be retrived
}
$nameofthestock_fetch=mysql_fetch_array($nameofthestock);
//this section sets the new price
//////////////////////////////////////////
$thestockid=$nameofthestock_fetch[0];
$currentpriceofthestock=$nameofthestock_fetch[2];
$dayhigh=$nameofthestock_fetch[3];
$daylow=$nameofthestock_fetch[4];
$alltimehigh=$nameofthestock_fetch[5];
$alltimelow=$nameofthestock_fetch[6];
$stocksinexchange=$nameofthestock_fetch[7];
$stocksinmarket=$nameofthestock_fetch[8];
$stocksactuallytraded=$final_agreement;
$soldatprice=$formthesellquotationarray[$takecounter1]["priceexpected"];
if($soldatprice>$dayhigh)$dayhigh=$soldatprice;
if($soldatprice<$daylow)$daylow=$soldatprice;
if($soldatprice>$alltimehigh)$alltimehigh=$soldatprice;
if($soldatprice<$alltimelow)$alltimelow=$soldatprice;
$inmarketprice=($stocksinmarket-$final_agreement)*$currentpriceofthestock;
$nowdealprice=$final_agreement*$soldatprice;
$currentnew=($inmarketprice+$nowdealprice)/$stocksinmarket;
$themainquery="UPDATE `stocks` SET `currentprice`='{$currentnew}',`dayhigh`='{$dayhigh}',`daylow`='{$daylow}',`alltimehigh`='{$alltimehigh}',`alltimelow`='{$alltimelow}' WHERE `stockid`='{$thestockid}'";
$themainquery_q=mysql_query($themainquery);
if(mysql_affected_rows())
{
$debugarray[$debugarraycount++]="new price set";
}
$thenewtime=time();
$graph_q=mysql_query("INSERT INTO `graph` (`stockid`,`price`,`timestamp`) VALUES('{$thestockid}','{$currentnew}','{$thenewtime}')");
if(mysql_affected_rows())
{
$debugarray[$debugarraycount++]="new graphpoint set";
}
///////////////////////////////////////
$nameofthestock_actual=$nameofthestock_fetch[1];
$buyrate=$formthebuyquotationarray[$takecounter1]["pricerendered"];
$sellrate=$formthesellquotationarray[$takecounter1]["priceexpected"];
$notificationforbuyer="$final_agreement number of $nameofthestock_actual have been brought for $thebuyer_loses at $buyrate pershare";
$notificationforseller="$final_agreement number of $nameofthestock_actual have been sold for $theseller_gains at $sellrate pershare";
$lognotification="$final_agreement number of $nameofthestock_actual  (stockid,$thebuystockidis) have been sold for $theseller_gains at $sellrate versus brought for $thebuyer_loses at $buyrate (seller,buyer)($theselluserid,$thebuyuserid)";
$currenttimestamp=time();
$insertintobuyernotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$thebuyuserid}','{$currenttimestamp}','{$notificationforbuyer}',0,5)");
if(mysql_affected_rows())
{
//log 
}
$insertintosellernotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$theselluserid}','{$currenttimestamp}','{$notificationforseller}',0,5)");
if(mysql_affected_rows())
{
//log 
}
$insertintolog=mysql_query("INSERT INTO `notifications`(`action`,`from`,`to`,`stockid`,`num`,notification`) VALUES (1,'{$theselluserid}','{$thebuyuserid}','{$thebuystockidis}',$lognotification)");
if(mysql_affected_rows())
{
//log 
}
$takecounter1++;
$takecounter2++;
}
  }
return json_encode(array("deal_result"=>true));
}
/*
 *enquiry  for mortgage
 * for explicit mortgage enquiry and 
 * for prompting the user about mortgage rates right at the moment he decides to mortgage
 */
 public function mortgage_inquiry($stock_id,$stock_num)
 {
 //i have to keep track that the stocks to be put up for mortgage have to be present in the user account and should not be up for selling
 //in the event of the shares being in the selling tray i have to notify the user to take them off and then mortgage
 $this->db_connection();
 if(!$this->verify_login())//verifies if the user is still logged in
{
return array("result"=>false,
"response"=>"you have been logged out please login to continue 1");
//custom message needed
}
//this section for calculation of mortgage rates
$get_the_stock_details=mysql_query("SELECT `currentprice`,`dayhigh`,`daylow`,`alltimehigh`,`alltimelow`,`stocksinexchange`,`stocksinmarket`,`stockname` FROM `stocks` WHERE `stockid`='{$stock_id}' ");
if(!mysql_num_rows($get_the_stock_details))
{

$thenotification="MORTGAGE QUERY FAILED ::no such stock :";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

//log an error for the stockid cannot be found or queried
return json_encode(array("result"=>false,
"response"=>"no such stock exists 1"));//CUSTOM MESSAGE
}
$totalpriceofshares_f=mysql_fetch_array($get_the_stock_details);
$totalpriceofshares=$totalpriceofshares_f[0]*$stock_num;
$thepricepershare=$totalpriceofshares_f[0];



$fetch_the_stock_details=mysql_fetch_array($get_the_stock_details);
$stocknameis=$fetch_the_stock_details[7];
$userstocks=0;
$get_the_user_details=mysql_query("SELECT `num` FROM `stocks_details` WHERE `stockid`='{$stock_id}' AND `userid`='{$this->userid}'");
if(!(mysql_num_rows($get_the_user_details)))
{

$thenotification="MORTGAGE QUERY FAILED ::you have no such stock :";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");
return json_encode(array("result"=>false,
"response"=>"no such stock exists with the user"));//CUSTOM MESSAGE	
}
else {
	$thething=mysql_fetch_array($get_the_user_details);
	$userstocks=$thething[0];
	if(!($userstocks>0))
	{
		return json_encode(array("result"=>false,
"response"=>"no such stock exists with the user"));//CUSTOM MESSAGE
	}
	
	$sharestheuserowns=$userstocks;
}


if($userstocks<$stock_num)
{

$thenotification="MORTGAGE QUERY FAILED ::insufficient shares : you are trying to MORTGAGE $stock_num of $stocknameis shares ,but you have only $userstocks shares";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

		return json_encode(array("result"=>false,
"response"=>"insufficient shares"));//CUSTOM MESSAGE
}	


///////////////
////-------------------------------------
/*
$get_the_user_details=mysql_query("SELECT `num` FROM `stocks_details` WHERE `stockid`='{$stock_id}' AND `userid`='{$this->userid}'");
//check here if the user indeed has that many shares
$sharestheuserowns=0;
$gethowmanystocksforsale=mysql_query("SELECT `num` FROM `sell` WHERE `stockid`='{$stock_id}' AND `userid`='{$this->userid}'");
$numberofsharesforselling=0;
if(mysql_num_rows($gethowmanystocksforsale))
{
while($gethowmanystocksforsale_fetch=mysql_fetch_array($gethowmanystocksforsale))
{
$numberofsharesforselling+=$gethowmanystocksforsale_fetch[0];
//there can be multiple selling queries in the same table
}
}
if(!mysql_num_rows($get_the_user_details))
{
///log an error for the user does not have these shares
return json_encode(array("result"=>false,
"response"=>"the user does not have this kind of shares 1"));//CUSTOM MESSAGE
}
else
{
$fetch_the_user_details=mysql_fetch_array($get_the_user_details);
$sharestheuserowns=$fetch_the_user_details[0];
}
if(($sharestheuserowns-$numberofsharesforselling)<$stock_num)
{
///log an error for the user does not have the required number of shares
return json_encode(array("result"=>false,
"response"=>"the user does not have that many shares 1",
"shareswiththeuser"=>$sharestheuserowns,
"sharesupforselling"=>$numberofsharesforselling,
"sharesrequestedformortgage"=>$stock_num
)
  );//CUSTOM MESSAGE
}
*/
//----------------------------------
////////////////////////////////////////////
//the mortgage price formula has not been planned but should be a function of the user and his marketvalue etc and dept also 
//here needs to be a complex formula for the mortgage rate 
$thepricepershare=$thepricepershare*0.70;
$totalpriceofshares=$thepricepershare*$stock_num;
return json_encode(array("result"=>true,
"response"=>"request successful",
"stockid"=>$stock_id,
"pricepershare"=>$thepricepershare,
"numberofshares"=>$stock_num,
"totalpriceofshares"=>$totalpriceofshares,
"availableshareswiththeuser"=>$userstocks,
"stockname"=>$stocknameis
)
);
 }

public function mortgage_deal($stock_id,$stock_num)
{
$this->db_connection();
$inquiry_results=$this->mortgage_inquiry($stock_id, $stock_num);
$inquiry_result=(array)json_decode($inquiry_results);
if(!$inquiry_result["result"])
{
//this is the case when the inquiry function is not passing the control through yet the user has pushed the request from the console this needs logging
return json_encode(array("result"=>false,"response"=>$inquiry_result["response"]));//CUSTOM MESSAGE
}
else 
{
//the inquiry was successful so now the actual mortgage has to be carried out
//clean that many shares from the stocks_details
$priceofeachshare=$inquiry_result["pricepershare"];
$currenttimestamp=time();
$updatednumberofshares=$inquiry_result["availableshareswiththeuser"]-$inquiry_result["numberofshares"];
if($updatednumberofshares>0)
$update_stocks_details=mysql_query("UPDATE `stocks_details` SET `num`='{$updatednumberofshares}' WHERE `userid`='{$this->userid}' AND `stockid`='{$stock_id}'");
else if(!$updatednumberofshares)
$update_stocks_details=mysql_query("DELETE FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$stock_id}'");
if(!mysql_affected_rows())
{
//this is a bug or an exception log the error
return json_encode(array("result"=>false,
"response"=>"electronic exchange could not take place at 1"));//CUSTOM MESSAGE
}
$push_into_bank=mysql_query("INSERT INTO `bank`(`userid`,`stockid`,`num`,`price`,`since`) VALUES ('{$this->userid}','{$stock_id}','{$stock_num}','{$priceofeachshare}','{$currenttimestamp}')");
if(mysql_affected_rows()!=1)
{
//this is a bug or an exception log the error
return json_encode(array("result"=>false,
"response"=>"electronic exchange could not take place at 2"));//CUSTOM MESSAGE
}
$gettheuserscash=mysql_query("SELECT `cash` FROM `users` WHERE `userid`='{$this->userid}'");
if(!mysql_num_rows($gettheuserscash))
{
//this is a bug or an exception log the error
return json_encode(array("result"=>false,
"response"=>"electronic exchange could not take place at 3"));//CUSTOM MESSAGE
}
$fetchtheuserscash=mysql_fetch_array($gettheuserscash);
$thecurrentcash=$fetchtheuserscash[0];
$newcash=$thecurrentcash+$inquiry_result["totalpriceofshares"];
$updatetheuserscash=mysql_query("UPDATE `users` SET `cash`='{$newcash}' WHERE `userid`='{$this->userid}'");
if(mysql_affected_rows()!=1)
{
//this is a bug or an exception log the error
return json_encode(array("result"=>false,
 "response"=>"electronic exchange could not take place at 4"));//CUSTOM MESSAGE
}
//update the notification for the user;
$thestockname=$inquiry_result["stockname"];
$rateofmortgage=$inquiry_result["pricepershare"];
$totalpriceofshares=$inquiry_result["totalpriceofshares"];
$thenotification="MORTGAGE SUCCESSFUL:$stock_num number of $thestockname share have been MORTGAGED for cash amount Rs. $totalpriceofshares at $rateofmortgage per share";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,1)");
$theresponse="request successful";
if(mysql_affected_rows()!=1)
{
$theresponse=mysql_error();
}
return json_encode(array("result"=>true,"response"=>$theresponse,"timestamp"=>$currenttimestamp));
//this thing has to be entered in the log also
//no response implies the query was successful
}
}
 
/*
 * REGULAR FUNCTION
 * 
 */ 

public function get_regular_details()
{
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return json_encode(array("result"=>false,"response"=>"you have been logged out please login to continue"));
//custom message needed
}
$this->deal();
$thecurrentuserarray=array();
$getallprices_query=mysql_query("SELECT * FROM `stocks` ORDER BY `stockname`");
$sharedetailarray=array();
$sharedetailarray_counter=0;
while($getallprices_array=mysql_fetch_array($getallprices_query))
{
//shares owned of the kind
$getuserstocks_query=mysql_query("SELECT * FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$getallprices_array[0]}'");
$getuserstocks_array=mysql_fetch_array($getuserstocks_query);
$numbergetuserstocks_query=mysql_num_rows($getuserstocks_query);
$userthiskindofshares=0;
if($numbergetuserstocks_query)
$userthiskindofshares=$getuserstocks_array[2];
//shares mortgaged of the kind
$getuserbanks_query=mysql_query("SELECT * FROM `bank` WHERE `userid`='{$this->userid}' AND `stockid`='{$getallprices_array[0]}'");
$getuserbanks_array=mysql_fetch_array($getuserbanks_query);
$numbergetuserbanks_query=mysql_num_rows($getuserbanks_query);
$userthiskindofshares_bank=0;
$userthiskindofshares_bank_price=0;
if($numbergetuserbanks_query)
{
$userthiskindofshares_bank=$getuserbanks_array[2];
$userthiskindofshares_bank_price=$getuserbanks_array[3];
}
//shares up for selling
//corrected
$getusersell_query=mysql_query("SELECT * FROM `sell` WHERE `userid`='{$this->userid}' AND `stockid`='{$getallprices_array[0]}'");
$totalthisindofsharesforselling=0;
while($getusersell_array=mysql_fetch_array($getusersell_query))
{
$totalthisindofsharesforselling+=$getusersell_array[4];
}
//shares up for buying
//corrected
$getuserbuy_query=mysql_query("SELECT * FROM `buy` WHERE `userid`='{$this->userid}' AND `stockid`='{$getallprices_array[0]}'");
$totalthisindofsharesforbuying=0;
while($getuserbuy_array=mysql_fetch_array($getuserbuy_query))
{
$totalthisindofsharesforbuying+=$getuserbuy_array[4];
}
$sharedetailarray[$sharedetailarray_counter]=array(
"stockid"=>$getallprices_array[0],
"stockname"=>$getallprices_array[1],
"currentprice"=>$getallprices_array[2],
"dayhigh"=>$getallprices_array[3],
"daylow"=>$getallprices_array[4],
"alltimehigh"=>$getallprices_array[5],
"alltimelow"=>$getallprices_array[6],
"sharesinexchange"=>$getallprices_array[7],
"sharesinmarket"=>$getallprices_array[8],
"shareswithme"=>$userthiskindofshares,
"sharesmortgaged"=>$userthiskindofshares_bank,
"rateofmortgage"=>$userthiskindofshares_bank_price,
"sharesforselling"=>$totalthisindofsharesforselling,
"sharesforbuying"=>$totalthisindofsharesforbuying,
 
);
//this array forms the share charts
$sharedetailarray_counter++;
}
$currentuserdetails=0;
//get the current ranking
//get the total stock value for all users
$allusertotals=array();
$counter=0;
$stockvalue1_query=mysql_query("SELECT `userid`,`cash`,`username` FROM `users` WHERE `disabled`=0 AND `verified`=1");
while($byuser=mysql_fetch_array($stockvalue1_query))
{

$allusertotals[$counter]['name']=$byuser[2];
$allusertotals[$counter]['userid']=$byuser[0];

$allusertotals[$counter]['marketvalue']=0;;
$stockvalue2_query=mysql_query("SELECT `stockid`,`num` FROM `stocks_details` WHERE `userid`='{$byuser[0]}'");//get the shares of each user by userid
while($bystock=mysql_fetch_array($stockvalue2_query))
{
//loops for each shareid with the user
$stockmarketprice_query=mysql_query("SELECT `currentprice` FROM `stocks` WHERE `stockid`='{$bystock[0]}'");
$stockmarketprice_fetch=mysql_fetch_array($stockmarketprice_query);
$allusertotals[$counter]['marketvalue']+=$stockmarketprice_fetch[0]*$bystock[1];
}
$beforetotal=$allusertotals[$counter]['marketvalue'];
//upto here shall find the total market value of shares of the user
$allusertotals[$counter]['marketvalue']+=$byuser[1];//this shall add the cash runs once for every user
//market value is the total value after addition of cash
$counter=$counter+1;
if($this->userid==$byuser[0])
{
$currentuserdetails=array("id"=>$this->userid,"name"=>$this->username,"cash"=>$allusertotals[$counter-1]['marketvalue']-$beforetotal,"sharevalue"=>$beforetotal,"total"=>$allusertotals[$counter-1]['marketvalue']);
}
}
//sort according to $allusertotals[$counter]['marketvalue'] and swap between $allusertotals[$counter]
for($i=0;$i<$counter;$i++)
{
for($j=0;$j<$counter;$j++)
{
if($allusertotals[$i]['marketvalue']>$allusertotals[$j]['marketvalue'])
{
$temp=$allusertotals[$i];
$allusertotals[$i]=$allusertotals[$j];
$allusertotals[$j]=$temp;
}
}
}
for($i=0;$i<$counter;$i++)
{
if($allusertotals[$i]['userid']==$this->userid)
{
 $currentuserdetails["rank"]=$i+1;
 break;
}
}
//this sort has to be improved
/*
* the mark database has to be scanned and all the marks that have passed in time have to be notified
* also the marks have to be checked against the prices of items of the stocks to verify if the current price of the marked share has gone beyond the set marks
* 
*/
 
 
//get the newsfeed
$feedarray=array();
$feedcounter=0;
$getthefeed=mysql_query("SELECT * FROM `newsfeed` ORDER BY `feedid` DESC LIMIT 0,10");

while($getthefeed_fetch=mysql_fetch_array($getthefeed))
{
$feedarray[$feedcounter]=$getthefeed_fetch[1];
$feedcounter++;
}
 
//get the notifications
$narray=array();
$ncounter=0;
$getthen=mysql_query("SELECT * FROM `notifications` WHERE `userid`='{$this->userid}' AND `seen`=0 ORDER BY `notid` DESC LIMIT 0,10");
while($getthe_n=mysql_fetch_array($getthen))
{
$narray[$ncounter]["notification"]=$getthe_n[3];
$narray[$ncounter]["timestamp"]=$getthe_n[2];
$ncounter++;
}
//make the buy and the sell array;;
 
//this is for the buy array
$thebuyarray=array();
$thebuyarray_q=mysql_query("SELECT * FROM `buy` WHERE `userid`='{$this->userid}'");
if(mysql_num_rows($thebuyarray_q))
{
$counterb=0;
while($onerow=mysql_fetch_array($thebuyarray_q))
{
$thestockid=$onerow[2];
$getthestockname=mysql_query("SELECT `stockname`,`currentprice`,`stocksinmarket`,`stocksinexchange` FROM `stocks` WHERE `stockid`='{$thestockid}'");
if(mysql_num_rows($getthestockname)==0)
{
continue;
}
$thestocknameis_f=mysql_fetch_array($getthestockname);
$thestocknameis=$thestocknameis_f[0];
$thecurrentprice=$thestocknameis_f[1];
$stock_m=$thestocknameis_f[2];
$stock_e=$thestocknameis_f[3];
$thebuyarray[$counterb]=array("buyid"=>$onerow[0],"stockid"=>$onerow[2],"pricerendered"=>$onerow[3],"num"=>$onerow[4],"timestamp"=>$onerow[5],"currentprice"=>$thecurrentprice,"stockname"=>$thestocknameis,"stocksinmarket"=>$stock_m,"stocksinexchange"=>$stock_e);
$counterb++;
}
}
 
//thisisforselling
$thesellarray=array();
$thesellarray_q=mysql_query("SELECT * FROM `sell` WHERE `userid`='{$this->userid}'");
if(mysql_num_rows($thesellarray_q))
{
$counterb=0;
while($onerow=mysql_fetch_array($thesellarray_q))
{
$thestockid=$onerow[2];
$getthestockname=mysql_query("SELECT `stockname`,`currentprice`,`stocksinmarket`,`stocksinexchange` FROM `stocks` WHERE `stockid`='{$thestockid}'");
if(mysql_num_rows($getthestockname)==0)
{
continue;
}
$thestocknameis_f=mysql_fetch_array($getthestockname);
$thestocknameis=$thestocknameis_f[0];
$thecurrentprice=$thestocknameis_f[1];
$stock_m=$thestocknameis_f[2];
$stock_e=$thestocknameis_f[3];
$thesellarray[$counterb]=array("sellid"=>$onerow[0],"stockid"=>$onerow[2],"priceexpected"=>$onerow[3],"num"=>$onerow[4],"timestamp"=>$onerow[5],"currentprice"=>$thecurrentprice,"stockname"=>$thestocknameis,"stocksinmarket"=>$stock_m,"stocksinexchange"=>$stock_e);
$counterb++;
}
}
 
 
///for the graphs
$getalltheids=mysql_query("SELECT DISTINCT `stockid` FROM `stocks`");
$graphpoints=array();
if(mysql_num_rows($getalltheids))
{
$c_gr=0;
while($orow=mysql_fetch_array($getalltheids))
{
$theid=$orow[0];//thisisthestockid
$getalldetails=mysql_query("SELECT *  FROM `stocks` WHERE `stockid`='{$theid}'");
$thedetails=mysql_fetch_array($getalldetails);
$stockname=$thedetails[1];
$stocksinexchange=$thedetails[7];
$stocksinmarket=$thedetails[8];
$stockswithme=0;
$thepriceofeachshare=$thedetails[2];
$qgetalldetails=mysql_query("SELECT *  FROM `stocks_details` WHERE `stockid`='{$theid}' AND `userid`='{$this->userid}'");
if(mysql_num_rows($qgetalldetails))
{
$qgetalldetails1=mysql_fetch_array($qgetalldetails);
$stockswithme=$qgetalldetails1[2];
}
$grpharr=array(array("Time",$stockname));
$myvar=array();
$myvari=array();
//$I_getthegraphpoints=mysql_query("SELECT MAX(`graphid`) FROM `graph` WHERE `stockid`='{$theid}'");
//$J_getthegraphpoints=mysql_fetch_array($I_getthegraphpoints);
//$num_getthegraphpoints=$J_getthegraphpoints[0];
//$num_getthegraphpoints_l=$num_getthegraphpoints-11;
$getthegraphpoints=mysql_query("SELECT * FROM `graph` WHERE `stockid`='{$theid}' ORDER BY `graphid` DESC LIMIT 0,10");
////error_log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
////error_log(mysql_error());
////error_log(("SELECT * FROM `graph` WHERE `stockid`='{$theid}' LIMIT '{$num_getthegraphpoints_l}','{$num_getthegraphpoints}'"));
//error_log(mysql_num_rows($getthegraphpoints));

if(mysql_num_rows($getthegraphpoints))
{
$c_2=0;
while($grph=mysql_fetch_array($getthegraphpoints) )
{
$myvari[$c_2]=(int)$grph[2];
$c_2++;
}
}
$iiuy=0;
for($iiuy=0;$iiuy<$c_2;$iiuy++)
{
$myvar[$iiuy]=array("X"=>($iiuy),"Y"=>$myvari[$c_2-1-$iiuy]);
}


$grpharr=array(array("Time",$stockname),$myvar);
$graphpoints[$theid]=array("details"=>array("id"=>$theid,
"name"=>$stockname,
"stocksinexchange"=>$stocksinexchange,
"stocksinmarket"=>$stocksinmarket,
"stockswithme"=>$stockswithme,
"currentprice"=>$thepriceofeachshare,
),
"values"=>array("values"=>$myvar)
 );
}
}
//get the bankdetails
$thebankarray=array();
$thebankarray_q=mysql_query("SELECT * FROM `bank` WHERE `userid`='{$this->userid}'");
if(mysql_num_rows($thebankarray_q))
{
$counterb=0;
while($onerow=mysql_fetch_array($thebankarray_q))
{
$thestockid=$onerow[2];
$getthestockname=mysql_query("SELECT `stockname`,`currentprice`,`stocksinmarket`,`stocksinexchange` FROM `stocks` WHERE `stockid`='{$thestockid}'");
if(mysql_num_rows($getthestockname)==0)
{
continue;
}
$thestocknameis_f=mysql_fetch_array($getthestockname);
$thestocknameis=$thestocknameis_f[0];
$thecurrentprice=$thestocknameis_f[1];
$stock_m=$thestocknameis_f[2];
$stock_e=$thestocknameis_f[3];
$thebankarray[$counterb]=array("bankid"=>$onerow[0],"stockid"=>$onerow[2],"pricemortgaged"=>$onerow[4],"num"=>$onerow[3],"timestamp"=>$onerow[5],"currentprice"=>$thecurrentprice,"stockname"=>$thestocknameis,"stocksinmarket"=>$stock_m,"stocksinexchange"=>$stock_e);
$counterb++;
}
}
 
 
 
///////////////////////
$thetotalreturnarray=array("bank"=>$thebankarray,"graph"=>$graphpoints,"sell"=>$thesellarray,"buy"=>$thebuyarray,"currentuserdetails"=>$currentuserdetails,"sharedetails"=>$sharedetailarray,"ranklist"=>$allusertotals,"notifications"=>$narray,"newsfeed"=>$feedarray);
return json_encode($thetotalreturnarray);
}

public function tradewithexchange($stockid,$stocknum)
{
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return json_encode(array("result"=>false,
"response"=>"you have been logged out please login to continue"
));
//custom message needed
}
$getthecashoftheuser=mysql_query("SELECT `cash`,`disabled` FROM `users` WHERE `userid`='{$this->userid}'");
$getthecashoftheuser_fetch=mysql_fetch_array($getthecashoftheuser);
$disabled=$getthecashoftheuser_fetch[1];
if($disabled)
{
return json_encode(array("result"=>false,
"response"=>"user is disabled"
)
 );
}
$cashwiththeuser=$getthecashoftheuser_fetch[0];
$currentmarketprice=mysql_query("SELECT `stocksinexchange`,`currentprice`,`stockname`,`stocksinmarket` FROM `stocks` WHERE `stockid`='{$stockid}'");
if(mysql_num_rows($currentmarketprice)==0)
{

$thenotification="TRADE FAILED ::insufficient shares : no such shares";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");


return json_encode(array("result"=>false,
"response"=>"no such stock exists"));
}
$currentprice_fetch=mysql_fetch_array($currentmarketprice);
$available_stocks=$currentprice_fetch[0];
$namestock=$currentprice_fetch[2];
$currentprice=$currentprice_fetch[1];
$stocksinmarket_now=$currentprice_fetch[3];
$stocksinmarket_final=$stocksinmarket_now+$stocknum;
if($stocknum>$available_stocks)
{

$thenotification="TRADE FAILED ::insufficient shares : you are tryiing to buy $stocknum of $namestock shares but exchange has only $available_stocks shares";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

return json_encode(array("result"=>false,
"response"=>"insufficient number of stocks in market",
"stocksinmarket"=>$available_stocks,
"stocksaskedfor"=>$stocknum)
);
}
$totalpriceofstocks=$stocknum*$currentprice;
if($cashwiththeuser<$totalpriceofstocks)
{

$thenotification="TRADE FAILED ::insufficient cash : you are tryiing to buy  $namestock of worth $totalpriceofshares but your current cash $cashwiththeuser";
return json_encode(array("result"=>false,
"response"=>"insufficient funds",
"pricepershare"=>$currentprice_fetch,
"totalprice"=>$totalpriceofstocks,
"cashavailable"=>$cashwiththeuser
)
);
}
//trade the shares
$finalcashwithuser=$cashwiththeuser-$totalpriceofstocks;
$finalstocksinexchange=$available_stocks-$stocknum;
$availablestocksofsamekindwithuser=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$stockid}'");
$initialshares=0;
if(mysql_num_rows($availablestocksofsamekindwithuser)==0)
{
$initialshares=0;
$querytoinsertnewstock=mysql_query("INSERT INTO `stocks_details` (`userid`,`stockid`,`num`)VALUES('{$this->userid}','$stockid','{$stocknum}')");
if(mysql_affected_rows()==0)
{
////////////////////////
return "one";
////////////////////////
}
}
else
{
$availablestocksofsamekindwithuser_fetch=mysql_fetch_array($availablestocksofsamekindwithuser);
$initialshares=$availablestocksofsamekindwithuser_fetch[0];
$totalshareaftertrade=$initialshares+$stocknum;
$insertfinalnumberofshares=mysql_query("UPDATE `stocks_details` SET `num`='{$totalshareaftertrade}' WHERE `userid`='{$this->userid}' AND `stockid`='{$stockid}'");
if(mysql_affected_rows()==0)
{
////////////////////////
return "two";
////////////////////////
}
}
$updatefinalcash=mysql_query("UPDATE `users` SET  `cash`='{$finalcashwithuser}' WHERE `userid`='{$this->userid}'");
if(mysql_affected_rows()==0)
{
////////////////////////
return "three";
////////////////////////
}
$updatefinalexchangestocks=mysql_query("UPDATE `stocks` SET `stocksinexchange`='{$finalstocksinexchange}',`stocksinmarket`='{$stocksinmarket_final}' WHERE `stockid`='{$stockid}'");
if(mysql_affected_rows()==0)
{
////////////////////////
return "four";
////////////////////////
}
$getthenameofftheshare=mysql_query("SELECT `stockname` FROM `stocks` WHERE `stockid`='{$stockid}'");
$getthenameofftheshare_get=mysql_fetch_array($getthenameofftheshare);
$stockname=$getthenameofftheshare_get[0];
$thenotification="TRADE SUCCESSFUL::$stocknum number of $stockname share have been TRADED with EXCHANGE for $totalpriceofstocks at Rs. $currentprice PER SHARE : total CASH in account $finalcashwithuser";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,8)");
$response="request successful";
return json_encode(array("result"=>true,
"stocksinmarket"=>$stocksinmarket_final,
"response"=>$response,
"stockstraded"=>$stocknum,
"stockprice"=>$currentprice,
"totalpriceofstocks"=>$totalpriceofstocks,
"availablecashwituser"=>$finalcashwithuser
)
);
}
public function cancel_quotation($stockid,$stocknum,$priceper,$timestamp,$code)
{
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return json_encode(array("result"=>false,
"response"=>"you have been logged out please login to continue"
));
//custom message needed
}
if($code==1)///from buy
{
$remove_quotation=mysql_query("DELETE FROM `buy` WHERE `userid`='{$this->userid}' AND `stockid`='{$stockid}' AND `num`='{$stocknum}' AND `pricerendered`='{$priceper}' AND `timestamp`='{$timestamp}'");
if(mysql_affected_rows())
{
//log it
}
$getthenameofftheshare=mysql_query("SELECT `stockname` FROM `stocks` WHERE `stockid`='{$stockid}'");
$getthenameofftheshare_get=mysql_fetch_array($getthenameofftheshare);
$stockname=$getthenameofftheshare_get[0];
$thenotification="QUOTATION to BUY $stocknum NUMBER of $stockname shares SET has been CANCELLED ";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,9)");
if(mysql_affected_rows())
{
//take an action
}
return json_encode(array("result"=>true
));
}
else if($code==2)///from buy
{
$remove_quotation=mysql_query("DELETE FROM `sell` WHERE `userid`='{$this->userid}' AND `stockid`='{$stockid}' AND `num`='{$stocknum}' AND `priceexpected`='{$priceper}' AND `timestamp`='{$timestamp}'");
if(mysql_affected_rows())
{
//log it
}
$getthenameofftheshare=mysql_query("SELECT `stockname` FROM `stocks` WHERE `stockid`='{$stockid}'");
$getthenameofftheshare_get=mysql_fetch_array($getthenameofftheshare);
$stockname=$getthenameofftheshare_get[0];
$thenotification="QUOTATION to SELL $stocknum NUMBER of $stockname shares SET has been CANCELLED ";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,10)");
if(mysql_affected_rows())
{
//take an action
}
return json_encode(array("result"=>true
));
}
else
{
return json_encode(array("result"=>false,
"response"=>"invalid parameters"
));
}
}
public function cancelquotation($code,$id)
{
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return json_encode(array("result"=>false,
"response"=>"you have been logged out please login to continue"
));
//custom message needed
}
if($code==1)
{
//from the buy
$remfrombuy=mysql_query("DELETE FROM `buy` WHERE `theid`='{$id}' AND `userid`='{$this->userid}'");
//return json_encode(array("response"=>("DELETE FROM `buy` WHERE `theid`='{$id}' AND `userid`=>'{$this->userid}'")));
//return json_encode(array("response"=>mysql_error()));
if(!mysql_affected_rows())
{
return json_encode(array("result"=>false,"response"=>"Invalid Request"));
}
else
return json_encode(array("result"=>true,"response"=>"Request successful"));

	
}
else if($code==2)
{
//from the sell
$remfrombuy=mysql_query("DELETE FROM `sell` WHERE `theid`='{$id}' AND `userid`='{$this->userid}'");
//return json_encode(array("response"=>("DELETE FROM `sell` WHERE `theid`='{$id}' AND `userid`=>'{$this->userid}'")));
//return json_encode(array(("DELETE FROM `sell` WHERE `theid`='{$id}' AND `userid`=>'{$this->userid}'")));
//return json_encode(array("response"=>mysql_error()));
if(!mysql_affected_rows())
{
return json_encode(array("result"=>false,"response"=>"Invalid Request"));
}
else
return json_encode(array("result"=>true,"response"=>"Request successful"));
}

}
public function redeemshares($stockid,$stocknum,$theid)
{
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return json_encode(array("result"=>false,
"response"=>"you have been logged out please login to continue"
));
//custom message needed
}
$gettheshareprice=mysql_query("SELECT * FROM `bank` WHERE `userid`='{$this->userid}' AND `stockid`='{$stockid}'  AND `bankid`='{$theid}'");
if(!mysql_num_rows($gettheshareprice))
{
return json_encode(array("result"=>false,
"response"=>"no such share to be redeemed"
));
}
$gettheshareprice_fetch=mysql_fetch_array($gettheshareprice);
$gettheshareprice_get=$gettheshareprice_fetch[3];
$shares_mortgaged=$gettheshareprice_fetch[2];
$getthetotalprice=$gettheshareprice_get*$stocknum;
$getthecashwithuser=mysql_query("SELECT `cash` FROM `users` WHERE `userid`='{$this->userid}'");
if(!mysql_num_rows($getthecashwithuser))
{
return json_encode(array("result"=>false,
"response"=>"no such user exists invalid parameters"
));
}
$getthecashwithuser_fetch=mysql_fetch_array($getthecashwithuser);
$getthecashwithuser_get=$getthecashwithuser_fetch[0];
if($getthecashwithuser_get<$getthetotalprice)
{
return json_encode(array("result"=>false,
"response"=>"insufficient funds",
"shareprice"=>$gettheshareprice,
"numberofshares"=>$stocknum,
"totalprice"=>$getthetotalprice,
"cashwiththeuser"=>$getthecashwithuser_get
));
}
$finalcashinaccount=$getthecashwithuser_get-$getthetotalprice;
$setthefinalcash=mysql_query("UPDATE `users` SET `cash`='{$finalcashinaccount}' WHERE `userid`='{$this->userid}'");
if(mysql_affected_rows())
{
///take an action
}
if($stocknum==$shares_mortgaged)
{
$removefrombank=mysql_query("DELETE FROM `bank` WHERE  `userid`='{$this->userid}' AND `stockid`='{$stockid}' AND `num`='{$stocknum}' AND `bankid`='{$theid}'");
if(mysql_affected_rows())
{
///take an action
}
}
else {
$finalsharesinmortgage=$shares_mortgaged-$stocknum;
$update_mortgagetable=mysql_query("UPDATE `bank` SET `num`='{$finalsharesinmortgage}' WHERE  `userid`='{$this->userid}' AND `stockid`='{$stockid}' AND `num`='{$shares_mortgaged}' AND `bankid`='{$theid}'");
if(!mysql_affected_rows())
{
return "there is an error";
}
}
$getthatkindofshareswithuser=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='{$stockid}'");
if(mysql_num_rows($getthatkindofshareswithuser)==0)
{
$setthefinalshares=mysql_query("INSERT INTO `stocks_details` (`userid`,`stockid`,`num`) VALUES('{$this->userid}',$stockid,'{$stocknum}')");
if(mysql_affected_rows())
{
///take an action
}
}
        else
{
$finalsharenumbers_fetch=mysql_fetch_array($getthatkindofshareswithuser);
$initialshares=$finalsharenumbers_fetch[0];
$finalshares=$initialshares+$stocknum;
$finalshareupdate=mysql_query("UPDATE `stocks_details` SET `num`='{$finalshares}' WHERE `userid`='{$this->userid}' AND `stockid`='{$stockid}'");
if(mysql_affected_rows())
{
///take an action
}
}
/////////////////////////
$getthenameofftheshare=mysql_query("SELECT `stockname` FROM `stocks` WHERE `stockid`='{$stockid}'");
$getthenameofftheshare_get=mysql_fetch_array($getthenameofftheshare);
$stockname=$getthenameofftheshare_get[0];
$thenotification="$stocknum number of $stockname share have been REDEEMED for $getthetotalprice at Rs. $gettheshareprice_get PER SHARE : total CASH in account $finalcashinaccount";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,8)");
return json_encode(array("result"=>true,
"cashinaccount"=>$finalcashinaccount
));
}
public function redeem_shares($code)
{
$THEPERCENTAGE=70;
$this->db_connection();
if(!$this->verify_login())//verifies if the user is still logged in
{
return json_encode(array("result"=>false,
"response"=>"you have been logged out please login to continue"
));
//custom message needed
}
//check if the code is of the user only
$getthedetailsofthemortgage=mysql_query("SELECT * FROM `bank` WHERE `bankid`='{$code}' AND `userid`='{$this->userid}'");
if(!mysql_num_rows($getthedetailsofthemortgage))
{
$thenotification="REDEEM QUERY FAILED ::no such stock :";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

return json_encode(array(
"result"=>false,
"response"=>"no such mortgage"));
//code passed not available in the table
}
$thedetails=mysql_fetch_array($getthedetailsofthemortgage);
$thestockid=$thedetails[2];
$thenum=$thedetails[3];
$theprice=$thedetails[4];
//check the current price of the stock
$getthenameandprice=mysql_query("SELECT * FROM `stocks` WHERE `stockid`='{$thestockid}'");
if(!mysql_num_rows($getthenameandprice))
{
$thenotification="REDEEM QUERY FAILED ::no such stock :";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

return json_encode(array(
"result"=>false,
"response"=>"no such stock exists"));
//code passed not available in the table
}
$getstockdet=mysql_fetch_array($getthenameandprice);
$thename=$getstockdet[1];
$therate=$getstockdet[2];
$totalvale_to_be_redeemed=($therate*$thenum*$THEPERCENTAGE)/100;
////error_log($totalvale_to_be_redeemed);
$thecashwiththeuser=mysql_query("SELECT * FROM `users` WHERE `userid`='{$this->userid}'");
if(!mysql_num_rows($thecashwiththeuser))
{
$thenotification="REDEEM QUERY FAILED ::no such stock :";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

return json_encode(array(
"result"=>false,
"response"=>"no such stock exists"));
//code passed not available in the table
}
$currentcash_f=mysql_fetch_array($thecashwiththeuser);
$currentcash=$currentcash_f[6];
if($currentcash<$totalvale_to_be_redeemed)
{
$thenotification="REDEEM QUERY FAILED ::you have bid for redemption value $totalvale_to_be_redeemed but your current cash is $currentcash";
$currenttimestamp=time();
$insertanewnotification=mysql_query("INSERT INTO `notifications`(`userid`,`timestamp`,`notification`,`seen`,`type`) VALUES ('{$this->userid}','{$currenttimestamp}','{$thenotification}',0,89)");

return json_encode(array(
"result"=>false,
"response"=>"insufficient funds"));
}
$finalcash=$currentcash-$totalvale_to_be_redeemed;
$updatefinalcash=mysql_query("UPDATE `users` SET `cash`='{$finalcash}' WHERE `userid`='{$this->userid}'");
if(!(mysql_affected_rows()>0))
{
return json_encode(array(
"result"=>false,
"response"=>"electronic exchange could not take place"));
}
$removebank=mysql_query("DELETE FROM `bank` WHERE `bankid`='{$code}'");
if(!(mysql_affected_rows()>0))
{
return json_encode(array(
"result"=>false,
"response"=>"electronic exchange could not take place"));
}
$getallusershares=mysql_query("SELECT * FROM `stocks_details` WHERE `userid`='{$this->userid}' AND `stockid`='$thestockid'");
if(mysql_num_rows($getallusershares))
{
$initialshares_f=mysql_fetch_array($getallusershares);
$initialshares=$initialshares_f[2];
$newshares=$initialshares+$thenum;
$updateshares=mysql_query("UPDATE `stocks_details` SET `num`='{$newshares}' WHERE `userid`='{$this->userid}' AND `stockid`='$thestockid'");
if(!(mysql_affected_rows()>0))
{
return json_encode(array(
"result"=>false,
"response"=>"electronic exchange could not take place"));
}
}
else {
$updateshares=mysql_query("INSERT INTO `stocks_details` (`userid`,`stockid`,`num`) VALUES('{$this->userid}','{$thestockid}','{$thenum}')");

if(!(mysql_affected_rows()>0))
{
return json_encode(array(
"result"=>false,
"response"=>"electronic exchange could not take place"));
}
}
$time=time();
$not="REDEEM SUCCESSFUL:$thenum NUMBER of $thename shares have been redeemed : CASH DEBITED -$totalvale_to_be_redeemed :CURRENT CASH :$finalcash";
$notification=mysql_query("INSERT INTO `notifications` (`userid`,`timestamp`,`notification`,`seen`,`type`) VALUE ('{$this->userid}','{$time}','{$not}',0,2)");
$action="redemption";
$lo=mysql_query("INSERT INTO `log` (`action`,`from`,`to`,`stockid`,`num`,`price`) VALUE ('{$action}','{$this->userid}',0,'{$thestockid}','{$thenum}','{$totalvale_to_be_redeemed}')");
$response="request successful";
return json_encode(array(
"result"=>true,
"response"=>$response,
"finalcash"=>$finalcash,
"shareredeemed"=>$thename,
"num"=>$thenum,
"cashdebited"=>$totalvale_to_be_redeemed
)
);
}
};

?>
