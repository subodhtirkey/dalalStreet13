<?php
  //  header('Location:./fbaccess1.php');
include("/var/www/html/13/dalalstreet13/main/facebooklogin/fbaccess1.php");
$user=$facebook->getUser();
if (!$user) 
header('Location: http://www.pragyan.org/13/dalalstreet13/main/facebooklogin/new.php');
?>
<!--I will instruct you and teach you in the way you should go; I will counsel you with my eye upon you (Psalm 32:8)-->
<!doctype html>
<html>
  
  <head>
    <title>Dalal Street 2013</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <link rel="stylesheet" href="theme/bootstrap.min.css">
    <link rel="stylesheet" href="theme/bootstrap-responsive.css"> 
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.6.1.min.js"></script>
    <link rel="stylesheet" href="theme/scroll.css">
    <!--<link rel="stylesheet" href="scroll/nanoscroller.css">--> 
    <script type="text/javascript" src="js/graph.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
     <script type="text/javascript" src="http://www.horsevideolibrary.com/01_new/js/jquery.overlay-0.14.js"></script>
     <script type="text/javascript" src="http://www.horsevideolibrary.com/01_new/js/jquery.expose-0.14.js"></script>

    <!--<script type="text/javascript" src="js/scroll.js"></script>

    <script type="text/javascript" src="scroll/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="scroll/jquery.nanoscroller.min.js"></script>
   
   
   -->
<style>
 #loading-image{
 	 width : 100%;
        height : 100%;
        position : absolute;
        background : #fff;
        z-index : 100;
}	
.load{
       position : absolute;
       left : 50%;
       top : 50%;
}
.clear {
   display : none;
}
</style>
<!-- <style type="text/css">
   #loading-image1 {  
         background-color:;
         width: 55px;
         height: 55px;
         position: fixed;
         top: 350px;
         right: 650px;
     background : #fff;
         z-index: 1;
         -moz-border-radius: 10px;
         -webkit-border-radius: 10px;
         border-radius: 10px; /* future proofing */
         -khtml-border-radius: 10px;
  }
.ajax_loader {background: url("ajax-loader.gif") no-repeat center center transparent;width:100%;height:100%;}
</style> -->


  <script type="text/javascript">

    var mymy=0;
/*$.fn.imageLoad = function(fn){
				var i=1,max=this.length;
				    this.load(function(){
					 if(i == max) 
					     fn();

 					i++;
				});
} */

</script>
  </head>
  
  <body>
<div id="loading-image">
<img class="load" src="ajax-loader.gif" alt="Loading..." /></div>
   
    <title>Dalal Street 13</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <link rel="stylesheet" href="theme/bootstrap.min.css">
    <link rel="stylesheet" href="theme/bootstrap-responsive.css">
    <link rel="stylesheet" href="theme/util.css">
    <link rel="stylesheet" href="theme/canvas.css">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Dalal Street 2013</a>
          <div class="navbar-content">
            <ul class="nav  pull-right">
              <li>
                <a href="logout.php">Logout</a> 
              </li>
              <li>
                <a href="#">Help</a> 
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <ul class="nav nav-list"></ul>
    <div class="row-fluid">
      <div class="pull-left span1 tabbable">

        <ul class="nav nav-tabs nav-stacked">
          <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
          <li class=""><a href="#market" data-toggle="tab">Market</a></li> 
          <li class=""><a href="#trade" data-toggle="tab">Trade</a></li>
          <li class=""><a href="#ranking" data-toggle="tab">Ranking</a></li>
          <li class=""><a href="#bank" data-toggle="tab">Bank</a></li>
          <li class=""><a href="#forum" data-toggle="tab">Forum</a></li>
         </ul>
    </div>
      <div class="span2">
        <div class="well">
          <div class="alert alert-success">
            <b>Companies</b>
          </div>
          <div class="scroll" style="overflow:auto; height:450px;" id="thesharelistdiv11">
          <ul class="nav nav-tabs nav-stacked">
            <li>
             
    		<a href="#c1" role="button" data-toggle="modal">Microsoft</a>

            </li>
            <li>
             <a href="#c2" role="button" data-toggle="modal">Google</a> 
            </li>
            <li>
              <a href="#c3" role="button" data-toggle="modal">IBM</a> 
            </li>
            <li>
              <a href="#c4" role="button" data-toggle="modal">Facebook</a> 
            </li>
            <li>
              <a href="#c5" role="button" data-toggle="modal">Goldman Sachs</a> 
            </li>
            <li>
              <a href="#">Ubisoft</a> 
            </li>
            <li>
              <a href="#">Rockstar Games</a> 
            </li>
            <li>
              <a href="#">Morgan Stanley</a> 
            </li>
            <li>
              <a href="#">Capitol One</a> 
            </li>
            <li>
              <a href="#">Directi</a> 
            </li>
            <li>
              <a href="#">Bank Of Scotland</a> 
            </li>
          </ul>
      
        </div>
        
        </div>
      </div>
<!--span6 middlecontaints-->
      <div class="span6" id="middlec">
	
	<marquee behavior='scroll' direction='right' id="update_field" styele='width:100%'></marquee>


       <!--<div class="alert alert-info" id="update_field"></div>-->
        <div class="tabbable">
          <div class="tab-content">


            <!------------------------Central Home-------------------------------------------->
            <div class="tab-pane active" id="home">

        <div class="well" id="centraldiv">   
        <div class="tabbable"> <!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Home</a></li>
            <li><a href="#tab2" data-toggle="tab">Profile</a></li>
            <li><a href="#tab3" data-toggle="tab">Shares</a></li>
            <li><a href="#tab4" data-toggle="tab">Buy/Sell</a></li>
            <li><a href="#tab5" data-toggle="tab">Bank</a></li>
          </ul>
            <div class="tab-content">
                  <div class="tab-pane active" id="tab1">
      
                      <div class="alert alert-success">
                          <b>Home</b>
                      </div>
                          <img src="login.jpg" class="img-rounded" width="99.9%" height="100%">
                  </div>

                  <div class="tab-pane" id="tab2">
                          <div class="alert alert-success">
                              <b>Profile</b>
                          </div>

                          <form class="form-horizontal">
                                    <div class="control-group">
                                          <label class="control-label" for="username">User Name</label>
                                                <div class="controls">
                                                      <input type="text" id="username" placeholder="Username" disabled=true>
                                                </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="cashinhand">Cash In Hand</label>
                                          <div class="controls">
                                                    <input type="text" id="cashinhand" placeholder="Cash In Hand" disabled=true>
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="totsharesvalue">Total Value Of Shares</label>
                                          <div class="controls">
                                                    <input type="text" id="totsharesvalue" placeholder="Total Value Of Shares" disabled=true>
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="networth">Net Worth</label>
                                          <div class="controls">
                                                    <input type="text" id="networth" placeholder="Net Worth" disabled=true>
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="userrank">Rank</label>
                                          <div class="controls">
                                                    <input type="text" id="userrank" placeholder="rank" disabled=true>
                                          </div>
                                    </div>

                                </form>





                  </div>

                  <div class="tab-pane" id="tab3">
                          <div class="alert alert-success">
                              <b>Shares</b>
                          </div>

                  </div>

                  <div class="tab-pane" id="tab4">
                          <div class="alert alert-success">
                              <b>Buy/Sell</b>
                          </div>
                  </div>

                  <div class="tab-pane" id="tab5">
                          <div class="alert alert-success">
                              <b>Bank</b>
                          </div>
                  </div>

          </div>
      </div>






          <!--<div class="alert alert-success">
            <b>Home</b>
          </div>
          <img src="login.jpg" class="img-rounded" width="100%" height="100%">

          --> 
        </div>


      </div>

      <!-----------------------Central Market------------------------------------------------------------------------------------------>
          <div class="tab-pane" id="market">
           <div class="well" id="marketwell">
              </div>

          </div>
        

          <!-----------------------Central Trade------------------------------------------------------------------------------------------>
              <div class="tab-pane" id="trade">
                 <div class="well" id="tradedetail">
              </div>
          </div>


        <!-----------------------Central Ranking------------------------------------------------------------------------------------------>
            <div class="tab-pane" id="ranking">
              <div class="well" id="leaderboard">
              </div>

          </div>

        <!-----------------------Central Bank------------------------------------------------------------------------------------------>
        
          <div class="tab-pane" id="bank">
           <div class="well" id="bankdetail">
              </div>

          </div>

          <!-----------------------Central Forum------------------------------------------------------------------------------------------>
        
          <div class="tab-pane" id="forum">
            <div class="well" id="forum">
                <div class="alert alert-success">
                              <b>Forum</b>
                </div>
		We will be using the  <a href="https://www.facebook.com/pages/Dalal-Street/109866185756914" target="_blank">DALAL STREET Facebook Page</a>for answering queries and doubts
		

                <div class="alert alert-success" id="#iiiiiii">
                  <p id="iiiiiii"></p>
                              
                </div>

              </div>
        
          </div>


        </div><!--closing div class="tabcontent"-->
      </div> <!--closing div class="tabbable"--> 




      
       <!-- <div class="well">
          <div class="alert alert-success">
            <b>Statistics</b>
          </div>
  <div id="chart_div" style="width: 500; height: 300px;">  <canvas id="graphcan" width="400" height="270">   
        </canvas> </div>
        </div> 
        -->
	<div class="well">

		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="fb-like" data-href="https://www.facebook.com/pages/Dalal-Street/109866185756914" data-send="true" data-width="450" data-show-faces="true" data-font="trebuchet ms"></div>




	</div>

     </div>
<!--span6 middlecontaints ending -->

      <div class="span3">
          <div class="well" >
            <div class='alert alert-success'><b>Notification</b></div>
            <div class="scroll" style="overflow:auto; height:450px;" id="recent_notifications">
            
          </div>
         
        </div>
      </div>
    </div>
    <div class="row-fluid">

<div class="span6">
	        <div class="pull-left">

<!--------------  ---------------->


		</div>
      </div>

      <div class="span6">
        <div class="alert pull-right alert-info">
          <b>Created By:</b>Delta Force Web Team (NIT Trichy)
          <br>
          <b>Powered By:</b>Pragyan CSG</div>
      </div>
    </div>
 



<!------
----------------------------------
<div id="redeemmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Buy</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                    <div class="control-group">
                                          <label class="control-label" for="sharename">Share Name</label>
                                                <div class="controls">
                                                      <input type="text" id="sharename" placeholder="sharename" disabled="true">
                                                </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="currentprice">Current Price</label>
                                          <div class="controls">
                                                    <input type="text" id="currentprice" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinmarket">Shares In Market</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinmarket" placeholder="Shares In Market" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinexchange">Shares In Exchange</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinexchange" placeholder="sharesinexchange" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="shareswithme">Shares With Me</label>
                                          <div class="controls">
                                                    <input type="text" id="shareswithme" placeholder="Shares With Me" disabled="true">
                                          </div>
                                    </div>
                                      <div class="control-group">
                                        <label class="control-label" for="dayhigh">Day high</label>
                                          <div class="controls">
                                                    <input type="text" id="dayhigh" placeholder="Day High" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="daylow">Day low</label>
                                          <div class="controls">
                                                    <input type="text" id="daylow" placeholder="daylow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimehigh">All time High</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimehigh" placeholder="alltimehigh" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimelow">All Time Low</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimelow" placeholder="alltimelow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="no_ofshares">No. Of Shares</label>
                                          <div class="controls">
                                                    <input type="text" id="no_ofshares" placeholder="No. Of Shares">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="price_redeem">Price Redeem</label>
                                          <div class="controls">
                                                    <input type="text" id="price_redeem" placeholder="Price Redeem">

                                          </div>

                                           <button type="submit" class="btn btn-primary buybutton1" align="right" id="buybutton1">Buy</button>
                                           <p>&nbsp;</p>
                                          <div class="alert alert-info" id="buymessage" style="display:none;"></div>
                                           
                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>
----------------------------------
----->
<!--Buy Modal-->
<div id="buymodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Buy</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                    <div class="control-group">
                                          <label class="control-label" for="sharename">Share Name</label>
                                                <div class="controls">
                                                      <input type="text" id="sharename" placeholder="sharename" disabled="true">
                                                </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="currentprice">Current Price</label>
                                          <div class="controls">
                                                    <input type="text" id="currentprice" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinmarket">Shares In Market</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinmarket" placeholder="Shares In Market" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinexchange">Shares In Exchange</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinexchange" placeholder="sharesinexchange" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="shareswithme">Shares With Me</label>
                                          <div class="controls">
                                                    <input type="text" id="shareswithme" placeholder="Shares With Me" disabled="true">
                                          </div>
                                    </div>
                                      <div class="control-group">
                                        <label class="control-label" for="dayhigh">Day high</label>
                                          <div class="controls">
                                                    <input type="text" id="dayhigh" placeholder="Day High" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="daylow">Day low</label>
                                          <div class="controls">
                                                    <input type="text" id="daylow" placeholder="daylow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimehigh">All time High</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimehigh" placeholder="alltimehigh" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimelow">All Time Low</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimelow" placeholder="alltimelow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="no_ofshares">No. Of Shares</label>
                                          <div class="controls">
                                                    <input type="text" id="no_ofshares" placeholder="No. Of Shares">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="price_redeem">Price Redeem</label>
                                          <div class="controls">
                                                    <input type="text" id="price_redeem" placeholder="Price Redeem">

                                          </div>

                                           <button type="submit" class="btn btn-primary buybutton1" align="right" id="">Buy</button>
                                           <p>&nbsp;</p>
                                          <div class='alert alert-info' id='buymessage' style='display:none;'></div>
                                           
                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
   
  </div>
</div>



<!--Trade Modal-->
<div id="trademodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"></h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                    <div class="control-group">
                                          <label class="control-label" for="sharename3">Share Name</label>
                                                <div class="controls">
                                                      <input type="text" id="sharename3" placeholder="sharename" disabled="true">
                                                </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="currentprice3">Current Price</label>
                                          <div class="controls">
                                                    <input type="text" id="currentprice3" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinmarket3">Shares In Market</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinmarket3" placeholder="Shares In Market" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinexchange3">Shares In Exchange</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinexchange3" placeholder="sharesinexchange" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="shareswithme3">Shares With Me</label>
                                          <div class="controls">
                                                    <input type="text" id="shareswithme3" placeholder="Shares With Me" disabled="true">
                                          </div>
                                    </div>
                                      <div class="control-group">
                                        <label class="control-label" for="dayhigh3">Day high</label>
                                          <div class="controls">
                                                    <input type="text" id="dayhigh3" placeholder="Day High" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="daylow3">Day low</label>
                                          <div class="controls">
                                                    <input type="text" id="daylow3" placeholder="daylow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimehigh3">All time High</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimehigh3" placeholder="alltimehigh" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimelow3">All Time Low</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimelow3" placeholder="alltimelow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="no_ofshares3">No. Of Shares</label>
                                          <div class="controls">
                                                    <input type="text" id="no_ofshares3" placeholder="No. Of Shares">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="price_redeem3">Total Cost</label>
                                          <div class="controls">
                                                    <input type="text" id="price_redeem3" placeholder="Total Price" disabled="true">

                                          </div>

                                           <button type="submit" class="btn btn-primary tradebutton1" align="right" id="">Trade</button>
                                            <p>&nbsp;</p>
                                          <div class='alert alert-info' id='trademessage' style='display:none;'></div>
                                          
                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>




<!--sell Modal-->
<div id="sellmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Sell</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                    <div class="control-group">
                                          <label class="control-label" for="sharename1">Share Name</label>
                                                <div class="controls">
                                                      <input type="text" id="sharename1" placeholder="sharename" disabled="true">
                                                </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="currentprice1">Current Price</label>
                                          <div class="controls">
                                                    <input type="text" id="currentprice1" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinmarket1">Shares In Market</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinmarket1" placeholder="Shares In Market" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinexchange1">Shares In Exchange</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinexchange1" placeholder="sharesinexchange" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="shareswithme1">Shares With Me</label>
                                          <div class="controls">
                                                    <input type="text" id="shareswithme1" placeholder="Shares With Me" disabled="true">
                                          </div>
                                    </div>
                                      <div class="control-group">
                                        <label class="control-label" for="dayhigh1">Day high</label>
                                          <div class="controls">
                                                    <input type="text" id="dayhigh1" placeholder="Day High" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="daylow1">Day low</label>
                                          <div class="controls">
                                                    <input type="text" id="daylow1" placeholder="daylow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimehigh1">All time High</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimehigh1" placeholder="alltimehigh" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimelow1">All Time Low</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimelow1" placeholder="alltimelow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="no_ofshares1">No. Of Shares</label>
                                          <div class="controls">
                                                    <input type="text" id="no_ofshares1" placeholder="No. Of Shares">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="price_expected1">Price Expected</label>
                                          <div class="controls">
                                                    <input type="text" id="price_expected1" placeholder="Price Expected">

                                          </div>
                                          
                                           <button type="submit" class="btn btn-primary sellbutton1" align="right"id="">Sell</button>
                                           <p>&nbsp;</p>
                                          <div class='alert alert-info' id='sellmessage' style='display:none;'></div>
                                           

                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>


<!--Mortgage Modal-->
<div id="mortgagemodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Mortgage</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                    <div class="control-group">
                                          <label class="control-label" for="sharename2">Share Name</label>
                                                <div class="controls">
                                                      <input type="text" id="sharename2" placeholder="sharename" disabled="true">
                                                </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="currentprice2">Current Price</label>
                                          <div class="controls">
                                                    <input type="text" id="currentprice2" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinmarket2">Shares In Market</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinmarket2" placeholder="Shares In Market" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinexchange2">Shares In Exchange</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinexchange2" placeholder="sharesinexchange" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="shareswithme2">Shares With Me</label>
                                          <div class="controls">
                                                    <input type="text" id="shareswithme2" placeholder="Shares With Me" disabled="true">
                                          </div>
                                    </div>
                                      <div class="control-group">
                                        <label class="control-label" for="dayhigh2">Day high</label>
                                          <div class="controls">
                                                    <input type="text" id="dayhigh2" placeholder="Day High" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="daylow2">Day low</label>
                                          <div class="controls">
                                                    <input type="text" id="daylow2" placeholder="daylow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimehigh2">All time High</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimehigh2" placeholder="alltimehigh" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="alltimelow2">All Time Low</label>
                                          <div class="controls">
                                                    <input type="text" id="alltimelow2" placeholder="alltimelow" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="no_ofshares2">No. Of Shares</label>
                                          <div class="controls">
                                                    <input type="text" id="no_ofshares2" placeholder="No. Of Shares">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="price_id2">Price</label>
                                          <div class="controls">
                                                    <input type="text" id="price_id2" placeholder="0" disabled="true">

                                          </div>

                                           <button type="submit" class="btn btn-primary mybuton1" align="right" id="">Mortgage</button>
                                          <p>&nbsp;</p>
                                          <div class='alert alert-info' id='mormessage1' style='display:none;'></div>
                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>


<!--Bank Modal-->
<div id="bankmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Bank</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                    <div class="control-group">
                                          <label class="control-label" for="sharename5">Share Name</label>
                                                <div class="controls">
                                                      <input type="text" id="sharename5" placeholder="sharename" disabled="true">
                                                </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="currentprice5">Current Price</label>
                                          <div class="controls">
                                                    <input type="text" id="currentprice5" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>
         <div class="control-group">
                                        <label class="control-label" for="sharesmortgaged6">Shares Mortgaged</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesmortgaged6" placeholder="sharesmortgaged" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="pricemortgaged5">Price Mortgaged</label>
                                          <div class="controls">
                                                    <input type="text" id="pricemortgaged5" placeholder="Shares In Market" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinmarket5">Shares In Market</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinmarket5" placeholder="Shares In Market" disabled="true">
                                          </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="sharesinexchange5">Shares In Exchange</label>
                                          <div class="controls">
                                                    <input type="text" id="sharesinexchange5" placeholder="sharesinexchange" disabled="true">
                                          </div>
                                    </div>

                                    
                                     

                                    
                                   <div class="control-group">
                                        <label class="control-label" for="time5">Price for redemption</label>
                                          <div class="controls">
                                                    <input type="text" id="time5" placeholder="Price for redemption" disabled="true" >

                                          </div>
                                          
                                           <button type="submit" class="btn btn-primary redeembutton12" align="right"id="">Redeem</button>
                                           <p>&nbsp;</p>
                                          <div class='alert alert-info' id='redeemmessage' style='display:none;'></div>
                                           

                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>






   <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="bootstrap.min.js"></script>
     <script type="text/javascript">
    
    </script>
<!------------------------Companies List  ------------------------------------------------------------------------>
<!--Microsoft-->
<div id="c1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:600px;height:550px;">
  <div class="modal-header"> 
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Statistics</h3>
  </div>
  
<div class="row-fluid"> 
 <div class='span5'>
   <div id="chart_div" style="width: 500; height: 300px;">  <canvas id="graphcani" width="400" height="300"></canvas></div>
</div>
<div class='span7' style="position:absolute; left:320px;">
<div class="control-group">
  <label class="control-label" for="oi_cp">Sharename</label>
                                          <div class="controls">
                                                    <input type="text" id="oi_sni" placeholder="Sharename" disabled="true">
                                          </div>
                                    </div>

<div class="control-group">
                                        <label class="control-label" for="oi_cp">Current Price</label>
                                          <div class="controls">
                                                    <input type="text" id="oi_cpi" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>
<div class="control-group">
                                        <label class="control-label" for="oi_se">Shares in Exchange</label>
                                          <div class="controls">
                                                    <input type="text" id="oi_sei" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>
<div class="control-group">
                                        <label class="control-label" for="oi_sm">Shares in Market</label>
                                          <div class="controls">
                                                    <input type="text" id="oi_smi" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>             
<div class="control-group">
                                        <label class="control-label" for="oi_sw">Shares With Me</label>
                                          <div class="controls">
                                                    <input type="text" id="oi_swi" placeholder="Current Price" disabled="true">
                                          </div>
                                    </div>

<button class='btn btn-primary b12 ol_s sell11 oec' type='button' href='#sellmodal' data-toggle='modal'>Sell</button>
<button class='btn btn-primary b12 ol_t trade11 oec' type='button' href='#trademodal' data-toggle='modal' >Trade</button>
<button class='btn btn-primary b12 ol_b buy11 oec' type='button' href='#buymodal' data-toggle='modal' >Buy</button>
 <button class="btn btn-primary" data-dismiss="modal" id="closeonemodal">Close</button>
  </div>
</div>

  
  

</div>



<!--Delete Modal for shares for selling-->
<div id="deletemodal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                                                       
                                    <div class="control-group">
                                        <p>Are you sure that you want to delete ?</p>
                                          
                                           <button type="submit" class="btn btn-primary s_delete" align="right" id="">YES</button>
                                          <p>&nbsp;</p>
                                          <div class='alert alert-info' id='s_delete_message' style='display:none;'></div>
                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>



<!--Delete Modal for shares for buying-->
<div id="deletemodal0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
                                                                       
                                    <div class="control-group">
                                        <p>Are you sure that you want to delete ?</p>
                                          
                                           <button type="submit" class="btn btn-primary b_delete" align="right" id="">YES</button>
                                          <p>&nbsp;</p>
                                          <div class='alert alert-info' id='b_delete_message' style='display:none;'></div>
                                    </div>

                                </form>
  
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>




 
  </body>
 <script type="text/javascript" src="ajaxfile.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        //this condition checks for all DOM elements loaded
   setTimeout(function(){//this function checks for all img with class BEACON loaded
      console.log("image loaded");
      $("#loading-image").animate({"opacity" : "0"},750);
      document.getElementById("loading-image").classList.add("clear");
   },50000);
});
     
    </script>
 </html>
