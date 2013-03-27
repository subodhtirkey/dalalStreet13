	/*****************Dalalstreet********/

	var urlphp="../../main/resolver.php";
	var time_for_refresh=15000;
	var regularvariable=0;
var checker=false;
	var mortgagepercent=0.75;
	var email="";
	var pass="";
	var thearrayttr="";
	//email="rubul@haloi.com";pass="rubulhaloi11";
	//email="kumar@delta.com";pass="kumar";
	//email="dipankar@gmail.com";pass="rubulhaloi11";
	//sell pop up box
	//////////////////////////	
	//google.load("visualization", "1", {packages:["corechart"]});

	///////////////////////////////////
	var data = 0;
	var graph=0;

	///////////-----------------------------------------------------
	function graphthis(){
		
		    var xPadding = 30;
		    var yPadding = 30;
		
		    // Returns the max Y value in our data list

		    function getMaxY() {
		        var max = 0;
		        
		        for(var i = 0; i <data.values.length;i++) {
		            if(data.values[i].Y > max) {
		                max = data.values[i].Y;
		            }
		        }
		        
		        max += 10 - max % 10;
		        return max;
		    }
		    
		    // Return the x pixel for a graph point
		    function getXPixel(val) {
		        return ((graph.width() - xPadding) / data.values.length) * val + (xPadding * 1.5);
		    }
		    
		    // Return the y pixel for a graph point
		    function getYPixel(val) {
		        return graph.height() - (((graph.height() - yPadding) / getMaxY()) * val) - yPadding;
		    }
		        graph = $('#graphcani');
		         c = graph[0].getContext('2d');            
		        
		        c.lineWidth = 2;
		        c.strokeStyle = '#333';
		        c.font = 'italic 8pt sans-serif';
		        c.textAlign = "center";
		        
		        // Draw the axises
		        c.beginPath();
		        c.moveTo(xPadding, 0);
		        c.lineTo(xPadding, graph.height() - yPadding);
		        c.lineTo(graph.width(), graph.height() - yPadding);
		        c.stroke();
		        
		        // Draw the X value texts
		        for(var i = 0; i < data.values.length; i ++) {
		            c.fillText(data.values[i].X, getXPixel(i), graph.height() - yPadding + 20);
		        }
		        
		        // Draw the Y value texts
		        c.textAlign = "right"
		        c.textBaseline = "middle";
		        
		        for(var i = 0; i < getMaxY(); i += 10) {
		            c.fillText(i, xPadding - 10, getYPixel(i));
		        }
		        
		        c.strokeStyle = '#ffffff';
		        
		        // Draw the line graph
		        c.beginPath();
		        c.moveTo(getXPixel(0), getYPixel(data.values[0].Y));
		        for(var i = 0; i < data.values.length; i ++) {
		            c.lineTo(getXPixel(i), getYPixel(data.values[i].Y));
		        }
		        c.stroke();
		        
		        // Draw the dots
		        c.fillStyle = '#ffffff';
		        
for(var i = 0; i < data.values.length; i += 1) {  
		            c.beginPath();
		            c.arc(getXPixel(i), getYPixel(data.values[i].Y), 4, 0, Math.PI * 2, true);
		            c.fill();
		        }
	}
	//////////////-----------------------------------------

	$(document).ready(function()
	{
	/////////////////////////////////////
	//////////////////////////////////
	///////////////////////////////////

	      


	      var c=0;
	    
		    

	
		    
	////////////////////////////////////
	//////////////////////////////////
	/////////////////////////////////////
	/*
		function makegraph()
	  {

	    google.setOnLoadCallback(drawChart);
													  					 function drawChart() {
		var data = google.visualization.arrayToDataTable([
		  ['Time', 'Apple', 'Microsoft','IBM','Google','Facebook'],
		  ['1',  200,      70,      90,        120,     60],
		  ['2',  130,     54,      70,        110,    70],
		  ['3',  45,      100,     60,        100,    40],
		  ['4',  50,      100,     200,        150,     100],
		  ['5',  50,      80,      60,        100,    30],
		  ['6',  70,      80,      60,        100,    100],
		]);

		var options = {
		  title: 'Company Performance'
		};

		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	      }

	    }


	  ////////////////////////////////////////////////
	*/


		//Function For Sell Query

		function sellquery()
		{
			$(".sellbutton1").click(function()
				{	$("#sellmessage").html("processing  please wait").show().fadeOut(4000);
					var thesellid=$(this).attr("id");
					var thesellid1=thesellid.substr(10);
					var noofsharesforsell=$("#no_ofshares1").val();
					var pricepershare=$("#price_expected1").val();

if((thesellid1<1) || (noofsharesforsell<1) || (pricepershare<5))
					{
											$("#sellmessage").html("invalid parameters ").show().fadeOut(4000);
					return ;

					}
			if(!((!isNaN(thesellid1)) && (!isNaN(noofsharesforsell)) && (!isNaN(pricepershare))))
					{
					$("#sellmessage").html("invalid parameters ").show().fadeOut(4000);
					return;

					}	
					$("#sellmessage").html("Sell query has been queued ,please be patient.").show().fadeOut(4000);




					$.post(urlphp,{action:"sell", stockid:thesellid1, stocknum:noofsharesforsell, pricepershare:pricepershare },function(returndata){
						//alert(returndata);
						var returndata1=JSON.parse(returndata);
					
						//var code = "<div class='alert alert-success' id='message' style='display:none;'>"+returndata1.response+"</div>";
							
							$("#sellmessage").html(returndata1.response).show().fadeOut(4000);
							$('#sellmodal').modal('hide');

					
					});
					return false;
				});
		}


		/*//Function For Sell Query1

		function sellquery1()
		{
			$(".sellbutton1").click(function()
				{
					var thesellid=$(this).attr("id");
					var thesellid1=thesellid.substr();
					var noofsharesforsell=$("#no_ofshares1").val();
					var pricepershare=$("#price_expected1").val();
					$.post(urlphp,{action:"sell", stockid:thesellid1, stocknum:noofsharesforsell, pricepershare:pricepershare },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						//var code = "<div class='alert alert-success' id='message' style='display:none;'>"+returndata1.response+"</div>";
						
							$("#sellmessage").html(returndata1.response).show().fadeOut(14000);

					
					});
					return false;
				});
		}


	*/
	//Function For Buy Query

		function buyquery()
		{	
			$(".buybutton1").click(function()
				{	
					var thebuyid=$(this).attr("id");
					var thebuyid1=thebuyid.substr(9);
					var noofsharestobuy=$("#no_ofshares").val();
					var pricepershare=$("#price_redeem").val();
					if((thebuyid1<1) || (noofsharestobuy<1) || (pricepershare<5))
					{
											$("#buymessage").html("invalid parameters ").show().fadeOut(4000);
					return ;

					}
			if(!((!isNaN(thebuyid1)) && (!isNaN(noofsharestobuy)) && (!isNaN(pricepershare))))
					{
					$("#buymessage").html("invalid parameters ").show().fadeOut(4000);
					return;

					}	
					$("#buymessage").html("Buy query has been queued , please be patient.").show().fadeOut(4000);
					$.post(urlphp,{action:"buy", stockid:thebuyid1, stocknum:noofsharestobuy, pricepershare:pricepershare },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						
							//$("#buymodal").close();
							$('#buymodal').modal('hide');

					
					});
					return false;
				});
		}
//Function For morquery Query
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
/*function morquery()
	{
	
	$(".mybuton1").click(function()
			{
					
					var themorid=$(this).attr("id");
					var themorid1=themorid.substr(9);

					var noofsharestomortgage=$("#no_ofshares2").val();
				
					$.post(urlphp,{action:"mortgagedeal", stockid:themorid1, stocknum:noofsharestomortgage },function(returndata){
						var returndata1=JSON.parse(returndata);
							$("#mormessage1").html(returndata1.response).show().fadeOut(14000);
					});
					return false;
				});
		}
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	//Function for Redeem Query
	function redeembutton12query()
		{
			$(".redeembutton12").click(function()
				{
					var thebankid=$(this).attr("id");
					var thebankid1=thebankid.substr(9);
					$.post(urlphp,{action:"redeem", code:thebankid1 },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						
							$("#redeemmessage").html(returndata1.response).show().fadeOut(4000);
							return ;
					
					});
					return false;
				});
		}

*/

		///////////////////////////////////////////////////
		///////////////////////////////////////////////////
		//Function For Trade Query

		function tradequery()
		{ $("#trademessage").html("processing  please wait").show().fadeOut(20000);
			$(".tradebutton1").click(function()
				{
					var thetradeid=$(this).attr("id");
					var thetradeid1=thetradeid.substr(11);
					var noofsharestotrade=$("#no_ofshares3").val();

if((thetradeid1<1) || (noofsharestotrade<1))
					{
											$("#trademessage").html("invalid parameters ").show().fadeOut(4000);
					return ;

					}
			if(!((!isNaN(thetradeid1)) && (!isNaN(noofsharestotrade))))
					{
					$("#trademessage").html("invalid parameters ").show().fadeOut(4000);
					return;

					}	
					$("#trademessage").html("Trade query has been queued , please be patient.").show().fadeOut(4000);


				
					$.post(urlphp,{action:"trade", stockid:thetradeid1, stocknum:noofsharestotrade },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						
							$("#trademessage").html(returndata1.response).show().fadeOut(4000);
							$('#trademodal').modal('hide');
					
					});
					return false;
				});
		}


		////////////////////////////////////////////////
		function forquery()
		{$("#trademessage").html("processing please wait").show().fadeOut(20000);
			$("#forumbutton").click(function()
				{
					console.log("fakhfkahkfhk");
					$.post(urlphp,{action:"deal"},function(returndata){
						var returndata1=JSON.parse(returndata);

							console.log(returndata1);
						
							$("#iiiiiii").html(returndata);

					
					});
					return false;
				});
		}







//Function for Redeem Query
	function redeemquery()
		{$("#redeemmessage").html("processing please wait").show().fadeOut(20000);
			$(".redeembutton12").click(function()
				{
					var thebankid=$(this).attr("id");
					var thebankid1=thebankid.substr(9);
				
 if(thebankid1<1)
					{
											$("#redeemmessage").html("invalid parameters ").show().fadeOut(4000);
					return ;

					}
			if(!(!isNaN(thebankid1)))
					{
					$("#redeemmessage").html("invalid parameters ").show().fadeOut(4000);
					return;

					}	
					$("#redeemmessage").html("Redeem query has been queued , please be patient .").show().fadeOut(4000);

					$.post(urlphp,{action:"redeem", code:thebankid1 },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						
							$("#redeemmessage").html(returndata1.response).show().fadeOut(4000);
                                                        $('#bankmodal').modal('hide');
							return ;
					
					});
					return false;
				});
		}




		//Function For Mortgage Query

		function mortgagequery()
		{$("#mormessage1").html("processing  please wait").show().fadeOut(20000);
			$(".mybuton1").click(function()
				{	
					var mid=$(this).attr("id");
					var themid1=mid.substr(9);
					var noofshares=$("#no_ofshares2").val();

					if((themid1<1) || (noofshares<1))
					{
											$("#mormessage1").html("invalid parameters ").show().fadeOut(4000);
					return ;

					}
			if(!(!isNaN(themid1)) && (!isNaN(noofshares)))
					{
					$("#mormessage1").html("invalid parameters ").show().fadeOut(4000);
					return;

					}	
					$("#mormessage1").html("Mortgage query has been queued , please be patient.").show().fadeOut(4000);



				
					$.post(urlphp,{action:"mortgagedeal", stockid:themid1, stocknum:noofshares },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						
							$("#mormessage1").html(returndata1.response).show().fadeOut(4000);
                                                         $('#mortgagemodal').modal('hide');
					
					});
					return false;
				});
		}





//Function For Sell Delete Query

		function selldeletequery()
		{$("#s_delete_message").html("processing  please wait").show().fadeOut(20000);
			$(".s_delete").click(function()
				{
					var thesellid=$(this).attr("id");
					var thesellid1=thesellid.substr(5);
					var cd=2;
							$("#s_delete_message").html("The delete query has been queued :" ).show().fadeOut(4000);

					
					$.post(urlphp,{action:"withdraw", code:cd, tableid:thesellid1 },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						

					
					});
					return false;
				});
		}



//Function For Buy Delete Query

		function buydeletequery()
		{$("#trademessage").html("processing  please wait").show().fadeOut(20000);
			$(".b_delete").click(function()
				{
					var thesellid=$(this).attr("id");
					var thesellid1=thesellid.substr(5);
					var cd=1;
					
							$("#b_delete_message").html("The delete query has been queued :").show().fadeOut(4000);
					$.post(urlphp,{action:"withdraw", code:cd, tableid:thesellid1 },function(returndata){
						var returndata1=JSON.parse(returndata);
					
						

					
					});
					return false;
				});
		}






	//////////////////////////////////////////////////////////
	function formthelist()
	{	
	var thestringis= "<ul class='nav nav-tabs nav-stacked'>";
	var i =1;
	var thenameofshare=0,oid,oname,oinmarket,oinex,oinme,thevaluething,thedivname,thispart,thisisforid;
	while(thenameofshare=regularvariable.graph[i])
		{
		oid=thenameofshare.details.id;
		oname=thenameofshare.details.name;
		oinmarket=thenameofshare.details.stocksinmarket;
		oinex=thenameofshare.details.stocksinexchange;
		oinme=thenameofshare.details.stockswithme;
		thevaluething=thenameofshare.values;
		thisisforid="clickhere"+oid;
		thispart=" <li><a href='#c1' role='button' data-toggle='modal' id="+thisisforid+" class='clickheretoget'>"+oname+"</a> </li>";
		thestringis+=thispart;
		i++;
		thenameofshare=false;
		}
	thestringis+="</ul>";
		$("#thesharelistdiv11").html(thestringis);

	
	}



			/*******************Function To Udate Home***************************************/
			function updatehome()
			{

				$("#username").val(regularvariable.currentuserdetails.name);
				$("#cashinhand").val(regularvariable.currentuserdetails.cash);
				$("#totsharesvalue").val(regularvariable.currentuserdetails.sharevalue);
				$("#networth").val(regularvariable.currentuserdetails.total);
				$("#userrank").val(regularvariable.currentuserdetails.rank);
			}



			/*******************Function To Udate Shares***************************************/

		
			function updatemyshares()
			{

					var thearray="<div class='alert alert-success'><b>Market</b></div><table class='table table-striped table-hover table-bordered'><thead><th>Share</th><th>Rate</th><th>In Mrkt</th><th>In Exch.</th><th>Shares With Me</th><th>Buy</th><th>Sell</th><th>Mortgage</th><th>Trade</th></thead><tbody>";
				
					var i;
					var buybutton, tradebutton;
					//console.log(regularvariable.sharedetails.length);
					for( i=0;i<regularvariable.sharedetails.length;i++)
					{
						if(!(regularvariable.sharedetails[i].shareswithme>0))continue;
						var b_theidis="b_ides"+regularvariable.sharedetails[i].stockid;
						var t_theidis="t_ides"+regularvariable.sharedetails[i].stockid;
						var s_theidis="s_ides"+regularvariable.sharedetails[i].stockid;
						var m_theidis="m_ides"+regularvariable.sharedetails[i].stockid;
						if(regularvariable.sharedetails[i].sharesinmarket>0)
							{
								buybutton="<button class='btn btn-primary buy1' type='button' id='"+b_theidis+"' href='#buymodal' data-toggle='modal'>Buy Bid</button>";
							}
							else
							{
								buybutton="<button class='btn btn-primary disabled buy1' type='button' id='"+b_theidis+"'>Buy Bid</button>";
							}	
						
						if(regularvariable.sharedetails[i].sharesinexchange>0)
						{
							tradebutton="<button class='btn btn-primary trade1' type='button' id='"+t_theidis+"' href='#trademodal' data-toggle='modal'>buy from exg</button>";
						}
						else
						{
							tradebutton="<button class='btn btn-primary disabled trade1' type='button' id='"+t_theidis+"'>buy from exg</button>";
						}	
						
						if(regularvariable.sharedetails[i].shareswithme>0)
							{
							sellbutton="<button class='btn btn-primary sell1' type='button' id='"+s_theidis+"' href='#sellmodal' data-toggle='modal'>Sell bid</button>";
							}
							else
							{
							sellbutton="<button class='btn btn-primary disabled sell1' type='button' id='"+s_theidis+"'>Sell bid</button>";
							}
					


						if(regularvariable.sharedetails[i].shareswithme>0)
							{
							mortgagebutton="<button class='btn btn-primary mortgage1' type='button' id='"+m_theidis+"' href='#mortgagemodal' data-toggle='modal'>Mortgage</button>";
							}
							else
							{
							mortgagebutton="<button class='btn btn-primary disabled mortgage1' type='button' id='"+m_theidis+"'>Mortgage</button>";
							}	
							 thearray+="<tr><td>"+regularvariable.sharedetails[i].stockname+"</td><td>"+regularvariable.sharedetails[i].currentprice.toString()+"</td><td>"+regularvariable.sharedetails[i].sharesinmarket+"</td><td>"+regularvariable.sharedetails[i].sharesinexchange+"</td><td>"+regularvariable.sharedetails[i].shareswithme+"</td><td>"+buybutton+"</td><td>"+sellbutton+"</td><td>"+mortgagebutton+"</td><td>"+tradebutton+"</td></tr>";
						

					}
				
					thearray+="</tbody></table>";
					$("#tab3").html(thearray);

			}
		
			   

	

			/*******************Function To Update Buy/Sell***************************************/
				function buysell()
			{

					var thearray="<div class='alert alert-success'><b>Shares For Selling</b></div><table class='table table-striped table-hover table-bordered'><thead><th>Sharename</th><th> Current Price</th><th>Number</th><th>Price Expected For Selling</th><th>Stocks In Market</th><th>Stocks In Exchange</th><th>Delete Quotation</th></thead><tbody>";
				
					var i;
					var b_deletequotation;
					var button_deletequotation;
					//console.log(regularvariable.sharedetails.length);
					for( i=0;i<regularvariable.sell.length;i++)
					{
						b_deletequotation="q_sell_"+regularvariable.sell[i].sellid;
						button_deletequotation="<button class='btn btn-primary sdel' type='button' id='"+b_deletequotation+"'href='#deletemodal1' data-toggle='modal'>Delete</button>";
					
						{
						
							 thearray+="<tr><td>"+regularvariable.sell[i].stockname+"</td><td>"+regularvariable.sell[i].currentprice.toString()+"</td><td>"+regularvariable.sell[i].num.toString()+"</td><td>"+regularvariable.sell[i].priceexpected+"</td><td>"+regularvariable.sell[i].stocksinmarket+"</td><td>"+regularvariable.sell[i].stocksinexchange+"</td><td>"+button_deletequotation+"</td></tr>";						
						}

					}
					thearray+="</tbody></table>";
				 	thearray+="<div class='alert alert-success'><b>Shares For Buying</b></div><table class='table table-striped table-hover table-bordered'><thead><th>Sharename</th><th> Current Price</th><th>Number</th><th>Price Rendered</th><th>Stocks In Market</th><th>Stocks In Exchange</th><th>Delete Quotation</th></thead><tbody>";
				
					for( i=0;i<regularvariable.buy.length;i++)
					{
						b_deletequotation="q_buy_"+regularvariable.buy[i].buyid;
						button_deletequotation="<button class='btn btn-primary bdel' type='button' id='"+b_deletequotation+"' href='#deletemodal0' data-toggle='modal'>Delete</button>";

						{
							//var num1=regularvariable.sharedetails[i].shareswithme.toString();
							 thearray+="<tr><td>"+regularvariable.buy[i].stockname+"</td><td>"+regularvariable.buy[i].currentprice.toString()+"</td><td>"+regularvariable.buy[i].num.toString()+"</td><td>"+regularvariable.buy[i].pricerendered+"</td><td>"+regularvariable.buy[i].stocksinmarket+"</td><td>"+regularvariable.buy[i].stocksinexchange+"</td><td>"+button_deletequotation+"</td></tr>";						}

					}
					thearray+="</tbody></table>";
					$("#tab4").html(thearray);		
			}

	
			/*******************Function To Update Bank***************************************/

		
			function updatebank()
			{

					var thearray="<div class='alert alert-success '><b>Bank</b></div><table class='table table-striped table-hover table-bordered'><thead><th>Sharename</th><th>Current Price</th><th>Shares Number</th><th>Price Mortgaged</th><th>Stocks In Market</th><th>Stocks In Exchange</th><th>Redeem</th</thead><tbody>";
				
					var i;
					var re_id;
					//console.log(regularvariable.sharedetails.length);
					for( i=0;i<regularvariable.bank.length;i++)
					{
							var re_id="b_redeem"+regularvariable.bank[i].bankid;
							var button_redeem="<button class='btn btn-primary bankb12' type='button' id='"+re_id+"' href='#bankmodal' data-toggle='modal'>Redeem</button>";
										
							//var num1=regularvariable.sharedetails[i].shareswithme.toString();
							 thearray+="<tr><td>"+regularvariable.bank[i].stockname+"</td><td>"+regularvariable.bank[i].currentprice+"</td><td>"+regularvariable.bank[i].num+"</td><td>"+regularvariable.bank[i].pricemortgaged+"</td><td>"+regularvariable.bank[i].stocksinmarket+"</td><td>"+regularvariable.bank[i].stocksinexchange+"</td><td>"+button_redeem+"</td></tr>";						

					}
					thearray+="</tbody></table>";
				 	
					$("#tab5").html(thearray);
					$("#bankdetail").html(thearray);		
			}




			/*******************Function To Update LeaderBoard***************************************/

		
			function updateleaderboard()
			{

					var thearray="<div class='alert alert-success'><b>LeaderBoard</b></div><table class='table table-striped table-hover table-bordered'><thead><th>Rank</th><th>Name</th><th>market Value</th></thead><tbody>";
				
					var i;
					var count;
					//console.log(regularvariable.sharedetails.length);
					for( i=0,count=1;i<regularvariable.ranklist.length;i++,count++)
					{
					
						{
						
							 thearray+="<tr><td>"+count+"</td><td>"+regularvariable.ranklist[i].name+"</td><td>"+regularvariable.ranklist[i].marketvalue.toString()+"</td></tr>";				
						}

					

					}
					thearray+="</tbody></table>";
				 	
					$("#leaderboard").html(thearray);		
			}


			/*******************Function To Udate Market***************************************/

		
			function updatemarket()
			{

					var thearray="<div class='alert alert-success'><b>Market</b></div><table class='table table-striped table-hover table-bordered'><thead><th>Share</th><th>Rate</th><th>In Mrkt</th><th>In Exch.</th><th>Shares With Me</th><th>Buy</th><th>Sell</th><th>Mortgage</th><th>Trade</th></thead><tbody>";
			
					var i;
					var buybutton, tradebutton;
					//console.log(regularvariable.sharedetails.length);
					for( i=0;i<regularvariable.sharedetails.length;i++)
					{
						var b_theidis="b_ids"+regularvariable.sharedetails[i].stockid;
						var t_theidis="t_ids"+regularvariable.sharedetails[i].stockid;
						var s_theidis="s_ids"+regularvariable.sharedetails[i].stockid;
						var m_theidis="m_ids"+regularvariable.sharedetails[i].stockid;
						if(regularvariable.sharedetails[i].sharesinmarket>0)
							{
								buybutton="<button class='btn btn-primary buy11' type='button' id='"+b_theidis+"'href='#buymodal' data-toggle='modal' >Buy Bid</button>";
							}
							else
							{
								buybutton="<button class='btn btn-primary disabled' type='button' id='"+b_theidis+"'>Buy Bid</button>";
							}	
						
						if(regularvariable.sharedetails[i].sharesinexchange>0)
						{
							tradebutton="<button class='btn btn-primary trade11' type='button' id='"+t_theidis+"'href='#trademodal' data-toggle='modal'>buy from xcg</button>";
						}
						else
						{
							tradebutton="<button class='btn btn-primary disabled ' type='button' id='"+t_theidis+"'>buy from xcg</button>";
						}	
						
						if(regularvariable.sharedetails[i].shareswithme>0)
							{
							sellbutton="<button class='btn btn-primary sell11' type='button' id='"+s_theidis+"'href='#sellmodal' data-toggle='modal'>Sell bid</button>";
							}
							else
							{
							sellbutton="<button class='btn btn-primary disabled' type='button' id='"+s_theidis+"'>Sell bid</button>";
							}



						if(regularvariable.sharedetails[i].shareswithme>0)
							{
							mortgagebutton="<button class='btn btn-primary mor12' data-toggle='modal' type='button' id='"+m_theidis+"' 	href='#mortgagemodal'>Mortgage</button>";
							}
							else
							{
							mortgagebutton="<button class='btn btn-primary disabled' type='button' id='"+m_theidis+"'>Mortgage</button>";
							}	
							 thearray+="<tr><td>"+regularvariable.sharedetails[i].stockname+"</td><td>"+regularvariable.sharedetails[i].currentprice.toString()+"</td><td>"+regularvariable.sharedetails[i].sharesinmarket+"</td><td>"+regularvariable.sharedetails[i].sharesinexchange+"</td><td>"+regularvariable.sharedetails[i].shareswithme+"</td><td>"+buybutton+"</td><td>"+sellbutton+"</td><td>"+mortgagebutton+"</td><td>"+tradebutton+"</td></tr>";
						

					}
					thearray+="</tbody></table>";
					$("#marketwell").html(thearray);		
			}



	/*******************Function To Udate Trade***************************************/

		
			function updatetrade()
			{

					var thearray="<div class='alert alert-success'><b>Trade</b></div><table class='table table-striped table-hover table-bordered'><thead><th>Sharename</th><th>Current Price</th><th>Shares In Market</th><th>Shares In Exchange</th><th>Shares With Me</th><th>Trade</th></thead><tbody>";
			
					var i;
					var  tradebutton;
					//console.log(regularvariable.sharedetails.length);
					for( i=0;i<regularvariable.sharedetails.length;i++)
					{
						var t_theidis="tt_ids"+regularvariable.sharedetails[i].stockid;
					
						
						if(regularvariable.sharedetails[i].sharesinexchange>0)
						{
							tradebutton="<button class='btn btn-primary trade111' type='button' id='"+t_theidis+"' href='#trademodal' data-toggle='modal'>Trade</button>";
							 thearray+="<tr><td>"+regularvariable.sharedetails[i].stockname+"</td><td>"+regularvariable.sharedetails[i].currentprice.toString()+"</td><td>"+regularvariable.sharedetails[i].sharesinmarket+"</td><td>"+regularvariable.sharedetails[i].sharesinexchange+"</td><td>"+regularvariable.sharedetails[i].shareswithme+"</td><td>"+tradebutton+"</td></tr>";
						
						}
					
						

					}
					thearray+="</tbody></table>";
					$("#tradedetail").html(thearray);		
			}



			/*******************Function To Update Notification***************************************/

		
			function updatenotification()
			{

					var thearray="<table class='table table-striped table-hover table-bordered'><thead><th>Recent Notifications</th></head><tbody>";
				
					var i;
					//console.log(regularvariable.sharedetails.length);
					for( i=0;i<regularvariable.notifications.length;i++)
					{
					
						{
						
							 thearray+="<tr><td>"+regularvariable.notifications[i].notification+"</td></tr>";				
						}

					

					}
					thearray+="</tbody></table>";
				 	
					$("#recent_notifications").html(thearray);		
			}

	/*******************Function To Update update***************************************/

	function update_update()
			{
					var ttr=0;
					var theaui="";
					for(ttr=0;ttr<regularvariable.newsfeed.length;ttr++)
					theaui+=regularvariable.newsfeed[ttr];
					 thearrayttr="<div class='alert alert-info' style='width:100%;' id='loaderdiv'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+theaui+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>";			

					//thearrayttr="<marquee behavior='scroll' direction='right'>"+theaui+"</marquee>";
				
					var i;
						//console.log(thearrayttr)				;
				 	
					$("#update_field").html(thearrayttr);		
			}



			/*******************Function To for login***************************************/
/* function login()    
                      {
                      var loginpost="email="+email+"&password="+pass;
                      $.ajax({type:'POST',
                          url:urlphp,
                          data:loginpost,
                          success:function(returndata)
                                  {
                                    
                                    
  //                                  alert(returndata);
                                    return;
                                  }
                          });
                      
                    }
/*

	/**********************Function To Call sell  popup Box*********/
	function sellpopup()
		{				  
					$(".sell1").click(
					function()
					{

					var sellb = ($(this).attr("id"));
					var sellb1=sellb.substr(6);
					var i;
					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		if(regularvariable.sharedetails[i].stockid==sellb1)
							{
							$("#sharename1").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice1").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket1").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange1").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme1").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh1").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow1").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh1").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow1").val(regularvariable.sharedetails[i].alltimelow);
							$("#no_ofshares1").val(regularvariable.sharedetails[i].shareswithme);
							$(".sellbutton1").attr("id","sellbutton"+sellb1);
							}
					}

					});
		}



	/**********************Function To Call sell  popup Box1*********/
	function sellpopup1()
		{				  
					$(".sell11").click(
					function()
					{

					var sellb = ($(this).attr("id"));
					var sellb1=sellb.substr(5);
					console.log(sellb1);
					var i;
					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		if(regularvariable.sharedetails[i].stockid==sellb1)
							{
							$("#sharename1").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice1").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket1").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange1").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme1").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh1").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow1").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh1").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow1").val(regularvariable.sharedetails[i].alltimelow);
							$("#no_ofshares1").val(regularvariable.sharedetails[i].shareswithme);
							$(".sellbutton1").attr("id","sellbutton"+sellb1);
							}
					}

					});
		}



	/**********************Function To Call buypop box*******/
	function buypopup()
		{				  
					$(".buy1").click(
					function()
					{

					var buyb = ($(this).attr("id"));
					var buyb1=buyb.substr(6);
					var i;
					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		if(regularvariable.sharedetails[i].stockid==buyb1)
							{
							$("#sharename").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow").val(regularvariable.sharedetails[i].alltimelow);
							$("#no_ofshares").val(regularvariable.sharedetails[i].shareswithme);
							$(".buybutton1").attr("id","buybutton"+buyb1);

							}
					}

					});
		}



	/**********************Function To Call buypop1 box*******/
	function buypopup1()
		{				  
					$(".buy11").click(
					function()
					{

					var buyb = ($(this).attr("id"));
					var buyb1=buyb.substr(5);
					var i;
					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		if(regularvariable.sharedetails[i].stockid==buyb1)
							{
							$("#sharename").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow").val(regularvariable.sharedetails[i].alltimelow);
							$("#no_ofshares").val(regularvariable.sharedetails[i].shareswithme);
							$(".buybutton1").attr("id","buybutton"+buyb1);

							}
					}

					});
		}



	/**********************Function To Call morgagepop box*******/
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%	
/*	function morgpopup()
		{				  
					$(".mortgage1").click(
					function()
					{


					var morb = ($(this).attr("id"));
					var morb1=morb.substr(6);
					var i;
					var cp,n,mortgagepercent=0.75,result;

					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		
					
						if(regularvariable.sharedetails[i].stockid==morb1)
							{
						
							$("#sharename2").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice2").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket2").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange2").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme2").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh2").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow2").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh2").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow2").val(regularvariable.sharedetails[i].alltimelow);
						
							$(".mybuton1").attr("id","morbutton"+morb1);
							cp=regularvariable.sharedetails[i].currentprice;
					

							 $('#no_ofshares2').keyup(function(event) {
								n=this.value;
								result=cp*n;
								$('#price_id2').val(result);
					
	    														}); 


						
						

							}
					}

					});
		}
*///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	/**********************Function To Call tradepop box*******/
	function tradepopup()
		{				  
					$(".trade1").click(
					function()
					{

					var tradeb = ($(this).attr("id"));
					var tradeb1=tradeb.substr(6);
					console.log(tradeb1);
					var i;
						//				var cp,n,mortgagepercent=0.75,result;
					
					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		
					
						if(regularvariable.sharedetails[i].stockid==tradeb1)
							{
						
							$("#sharename3").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice3").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket3").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange3").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme3").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh3").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow3").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh3").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow3").val(regularvariable.sharedetails[i].alltimelow);
							$(".tradebutton1").attr("id","tradebutton"+tradeb1);


							cp=regularvariable.sharedetails[i].currentprice;
					

							 $('#no_ofshares3').keyup(function(event) {
								n=this.value;
								result=cp*n;
								$('#price_redeem3').val(result);
					
	    														}); 
						
							}
					}

					});
		}


	/**********************Function To Call tradepop box1*******/
	function tradepopup1()
		{				  
					$(".trade11").click(
					function()
					{

					var tradeb = ($(this).attr("id"));
					var tradeb1=tradeb.substr(5);
					console.log(tradeb1);
					var i;
						//				var cp,n,mortgagepercent=0.75,result;

					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		
					
						if(regularvariable.sharedetails[i].stockid==tradeb1)
							{
						
							$("#sharename3").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice3").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket3").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange3").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme3").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh3").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow3").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh3").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow3").val(regularvariable.sharedetails[i].alltimelow);
							$(".tradebutton1").attr("id","tradebutton"+tradeb1);


							cp=regularvariable.sharedetails[i].currentprice;
					

							 $('#no_ofshares3').keyup(function(event) {
								n=this.value;
								result=cp*n;
								$('#price_redeem3').val(result);
					
	    														}); 
						
							}
					}

					});
		}



		/**********************Function To Call tradepop box11*******/
	function tradepopup11()
		{				  
					$(".trade111").click(
					function()
					{

					var tradeb = ($(this).attr("id"));
					var tradeb1=tradeb.substr(6);
					console.log(tradeb1);
					var i;
						//				var cp,n,mortgagepercent=0.75,result;

					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		
					
						if(regularvariable.sharedetails[i].stockid==tradeb1)
							{
						
							$("#sharename3").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice3").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket3").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange3").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme3").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh3").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow3").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh3").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow3").val(regularvariable.sharedetails[i].alltimelow);
							$(".tradebutton1").attr("id","tradebutton"+tradeb1);


							cp=regularvariable.sharedetails[i].currentprice;
					

							 $('#no_ofshares3').keyup(function(event) {
								n=this.value;
								result=cp*n;
								$('#price_redeem3').val(result);
					
	    														}); 
						
							}
					}

					});
		}

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	/**********************Function To Call BAnk  popup Box*********/
/*	function bankpopup()
		{				  
					$(".bankb12").click(
					function()
					{

					var bankb = ($(this).attr("id"));
					var bankb1=bankb.substr(8);
					var i;
					for(i=0;i<regularvariable.bank.length;i++)
					{		if(regularvariable.bank[i].bankid==bankb1)
							{
							$("#sharename5").val(regularvariable.bank[i].stockname);
							$("#currentprice5").val(regularvariable.bank[i].currentprice);
							$("#sharesinmarket5").val(regularvariable.bank[i].stocksinmarket);
							$("#sharesinexchange5").val(regularvariable.bank[i].stocksinexchange);
							$("#shareswithme5").val(regularvariable.bank[i].num);
							$("#pricemortgaged5").val(regularvariable.bank[i].pricemortgaged);
							$("#time5").val(regularvariable.bank[i].currentprice*regularvariable.bank[i].num*0.75);
							$("#sharesmortgaged6").val(regularvariable.bank[i].num);

						
							$(".redeembutton12").attr("id","redbutton"+bankb1);
							}
					}

					});
		}


*///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	

	/**********************Function To Call sell  mortgagepopup1 Box*********/
	function mortgagepopup1()
		{				  
					$(".mortgage1").click(
					function()
					{

					var morb = ($(this).attr("id"));
					var morb1=morb.substr(6);
					console.log(morb1);
					var i;
					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		if(regularvariable.sharedetails[i].stockid==morb1)
							{
							$("#sharename2").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice2").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket2").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange2").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme2").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh2").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow2").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh2").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow2").val(regularvariable.sharedetails[i].alltimelow);


							$(".mybuton1").attr("id","morbutton"+morb1);
							cp=regularvariable.sharedetails[i].currentprice;
					

							 $('#no_ofshares2').keyup(function(event) {
								n=this.value;
								result=cp*n*0.75;
								$('#price_id2').val(result);
					
	    														}); 


							}
					}

					});
		}




/**********************Function To Call sell  mortgagepopup1 Box*********/
	function mortgagepopup11()
		{				  
					$(".mor12").click(
					function()
					{

					var morb = ($(this).attr("id"));
					var morb1=morb.substr(5);
					//console.log(morb1);
					var i;
					for(i=0;i<regularvariable.sharedetails.length;i++)
					{		if(regularvariable.sharedetails[i].stockid==morb1)
							{
							$("#sharename2").val(regularvariable.sharedetails[i].stockname);
							$("#currentprice2").val(regularvariable.sharedetails[i].currentprice);
							$("#sharesinmarket2").val(regularvariable.sharedetails[i].sharesinmarket);
							$("#sharesinexchange2").val(regularvariable.sharedetails[i].sharesinexchange);
							$("#shareswithme2").val(regularvariable.sharedetails[i].shareswithme);
							$("#dayhigh2").val(regularvariable.sharedetails[i].dayhigh);
							$("#daylow2").val(regularvariable.sharedetails[i].daylow);
							$("#alltimehigh2").val(regularvariable.sharedetails[i].alltimehigh);
							$("#alltimelow2").val(regularvariable.sharedetails[i].alltimelow);


							$(".mybuton1").attr("id","morbutton"+morb1);
							cp=regularvariable.sharedetails[i].currentprice;
					

							 $('#no_ofshares2').keyup(function(event) {
								n=this.value;
								result=cp*n*0.75;
								$('#price_id2').val(result);
					
	    														}); 


							}
					}

					});
		}



/**********************Function To Call sell  bankpopup1 Box*********/
	function bankpopup1()
		{				  
					$(".bankb12").click(
					function()
					{

					var bankb = ($(this).attr("id"));
					var bankb1=bankb.substr(8);
					var i;
					for(i=0;i<regularvariable.bank.length;i++)
					{		if(regularvariable.bank[i].bankid==bankb1)
							{
							$("#sharename5").val(regularvariable.bank[i].stockname);
							$("#currentprice5").val(regularvariable.bank[i].currentprice);
							$("#sharesinmarket5").val(regularvariable.bank[i].stocksinmarket);
							$("#sharesinexchange5").val(regularvariable.bank[i].stocksinexchange);
							$("#shareswithme5").val(regularvariable.bank[i].num);
							$("#pricemortgaged5").val(regularvariable.bank[i].pricemortgaged);
							$("#time5").val(regularvariable.bank[i].currentprice*regularvariable.bank[i].num*0.75);
							$("#sharesmortgaged6").val(regularvariable.bank[i].num);

						
							$(".redeembutton12").attr("id","redbutton"+bankb1);
							}
					}

					});
		}



		/**********************Function To Call sell  deletepopup1 Box*********/
	function selldeletepopup()
		{				  
					$(".sdel").click(
					function()
					{

					var bankb = ($(this).attr("id"));
					var bankb1=bankb.substr(7);
					var i;
					for(i=0;i<regularvariable.sell.length;i++)
					{		if(regularvariable.sell[i].sellid==bankb1)
							{
							
							$(".s_delete").attr("id","s_yes"+bankb1);
							}
					}

					});
		}




/**********************Function To Call sell  deletepopup1 Box*********/
	function buydeletepopup()
		{				  
					$(".bdel").click(
					function()
					{

					var bankb = ($(this).attr("id"));
					var bankb1=bankb.substr(6);
					var i;
					for(i=0;i<regularvariable.buy.length;i++)
					{		if(regularvariable.buy[i].buyid==bankb1)
							{
							
							$(".b_delete").attr("id","b_yes"+bankb1);
							}
					}

					});
		}








		/*******************Setting regularfunction***************************************/

		var me=setInterval(function regularfunction()		
									{//login();
												var regularpost='action=regular';
												$.ajax({type:'POST',
													  url:urlphp,
													  data:regularpost,
													  success:function(returndata)
													  				{//login();
													  					//alert(returndata);	
					checker=true;								  					regularvariable=JSON.parse(returndata);
													  					//$("#centraldiv").html(returndata);
													  					//alert(returndata);
													  					
													  					updatehome();
													  					updatemyshares();
													  					buysell();
													  					updatebank();
													  					updateleaderboard();
													  					updatemarket();
													  					updatetrade();
													  					updatenotification();
													  					update_update();
													  					sellpopup();
													  					buypopup();
													  					tradepopup();
													  					sellpopup1();
													  					buypopup1();
													  					tradepopup1();
													  					tradepopup11();

													  					mortgagepopup1();
													  					mortgagepopup11();

													  					bankpopup1();

													  					selldeletepopup();
													  					
													  					buydeletepopup();

	
	formthelist();
	
	$(".clickheretoget").click(function()
							{
							var i9_id=$(this).attr("id");
							var i9_id1=parseInt(i9_id.substr(9));						
							var myCanvas = document.getElementById("graphcani");
							//myCanvas.width=67;
							data=regularvariable.graph[i9_id1].values;


							graphthis();
							myCanvas.width=300;
							var i=i9_id1;
							console.log(regularvariable.graph[i].details,name);
							$("#oi_sni").val(regularvariable.graph[i].details.name);
							$("#oi_cpi").val(regularvariable.graph[i].details.currentprice);
							$("#oi_sei").val(regularvariable.graph[i].details.stocksinexchange);
							$("#oi_smi").val(regularvariable.graph[i].details.stocksinmarket);
							$("#oi_swi").val(regularvariable.graph[i].details.stockswithme);
							if(regularvariable.graph[i].details.stocksinexchange==0)$(".ol_t").attr("disabled","disabled");
							if(regularvariable.graph[i].details.stocksinexchange>0)$(".ol_t").attr("disabled",false)

							if(regularvariable.graph[i].details.stockswithme==0)$(".ol_s").attr("disabled","disabled");
							if(regularvariable.graph[i].details.stockswithme>0)$(".ol_s").attr("disabled",false);
							$(".ol_s").attr("id","abc_s"+i);
							$(".ol_b").attr("id","abc_b"+i);
							$(".ol_t").attr("id","abc_t"+i);
							$(".oec").click(function(){$("#closeonemodal").click();});
							$(".ol_s").click(function(){$("#closeonemodal").click();});
							$(".ol_b").click(function(){$("#closeonemodal").click();});
							$(".ol_t").click(function(){$("#closeonemodal").click();});

							}
					  );

											  
													  					return;
													  				}
										  				});
											
										}
										,time_for_refresh);
	
	
		//calling functions
	
		//regularfunction(); 
	var anotherme=setInterval(function uuupdategraph(){graphthis();},900);
	sellquery();
	buyquery();
	tradequery();
	mortgagequery();
	redeemquery();
	selldeletequery();
	buydeletequery();

	forquery();

	});

