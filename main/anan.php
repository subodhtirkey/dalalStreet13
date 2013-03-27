<?php

public function deal()
{
//THISIS PERCENTAGE ABOVE
$PERCENTAGE_ABOVE=325;
$PERCENTAGE_BELOW=325;
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
while($oneid=mysql_fetch_array($getallthestockidsinthebuy))//loop for each stockid in buy
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
		/*********
		return json_encode(array("result"=>false,
								"response"=>"the buy retrived stockid has no presence in stocks"));
		 *///
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
		while($getthepparticularrow=mysql_fetch_array($get_the_stock_all))///for each id found in the stocktable
			{
			$pricebid=$getthepparticularrow[3];
			if($pricebid>$UPPERLIMIT)///only uppperlimit required for buy
				{
///////////////////////////////
				$debugarray[$debugarraycount++]="price overshoots upper";
///////////////////////////////
///////////////////////////////////////////
				/******
				return array("result"=>false,
				"response"=>"price overshoots uppervalue");
				 * ******/
///////////////////////////////////////////
				continue;
				}
			else
				{
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
			}//looping through the buy array
		}//buy array complete
	else//runs if the buy 
		{
///////////////////////////////
		$debugarray[$debugarraycount++]="retrived id not in buy";
///////////////////////////////
///////////////////////////////////////////
		/*
		return array("result"=>false,
					"response"=>"the buy retrived stockid has no presence in buy");
		 * */
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
			else
				{
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
	continue;///goes to the next id
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
	if($formthebuyquotationarray[$takecounter1]["pricerendered"]<$formthesellquotationarray[$takecounter2]["priceexpected"])
	{
///////////////////////////////
	$debugarray[$debugarraycount++]="buy price lesser tthan sell";
///////////////////////////////
	$takecounter1++;
	//note this
	//$takecounter2++;
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
	$debugarray[$debugarraycount++]="maximum shares that can be brought by the user fetched == ";
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
	$theselluserid=$formthesellquotationarray[$takecounter1]["userid"];
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
	$debugarray[$debugarraycount++]="the final amount in the seller account is calculated not updated till now";
	}
///////////////////////////
	$thecurrentnumberofshareswithseller=0;
	$thesellersharesofthiskindcurrently=mysql_query("SELECT `num` FROM `stocks_details` WHERE `userid`='{$theselluserid}' AND `stockid`='{$thebuyuserid}'");
	//buy user id and sell user id is thesame
return mysql_error();
	if(mysql_num_rows($thesellersharesofthiskindcurrently)==0)
	{
	//no such shares with the seller before
	}
	else
	{
	$thecurrentnumberofshareswithseller_fetch=mysql_fetch_array($thesellersharesofthiskindcurrently);
	$thecurrentnumberofshareswithseller=$thecurrentnumberofshareswithseller_fetch[0];
	}
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
?>