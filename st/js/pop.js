/**
 * 
 */

var NEW_ORDER_INTERVAL = 180000;
$(function(){ 
   checkMsg();
   setInterval(checkMsg, NEW_ORDER_INTERVAL);
});

	   
var nums;

/*
 * 检查信息
 */
function checkMsg()
{
    try
    {
		
	  $.getJSON('/index.php/Home/Ajax/popMsg',{name:"liu",num:0,stauts:0},function(json){												
		if(json.success==1){
			//alert(json.name);
			nums=json.num;
			Message.show();
			}				
	  });
    }
    catch (e) { }
  }





/*
 * 气泡式提示信息
 */

var Message = Object();

Message.bottom  = 0;
Message.count   = 0;
Message.elem    = "popMsg";
Message.mvTimer = null;

Message.show = function()
{
  try
  {
    document.getElementById(Message.elem).style.visibility = "visible"
    document.getElementById(Message.elem).style.display = "block"
     $("#ppnumber").html(nums);
    Message.bottom  = 0 - parseInt(document.getElementById(Message.elem).offsetHeight);
    Message.mvTimer = window.setInterval("Message.move()", 10);

    document.getElementById(Message.elem).style.bottom = Message.bottom + "px";
  }
  catch (e)
  {
    alert(e);
  }
}

Message.move = function()
{
  try
  {
    if (Message.bottom == 0)
    {
      window.clearInterval(Message.mvTimer)
      Message.mvTimer = window.setInterval("Message.close()", 120000)
    }

    Message.bottom ++ ;
    document.getElementById(Message.elem).style.bottom = Message.bottom + "px";
  }
  catch (e)
  {
    alert(e);
  }
}

Message.close = function()
{
  document.getElementById(Message.elem).style.visibility = 'hidden';
  document.getElementById(Message.elem).style.display = 'none';
  if (Message.mvTimer) window.clearInterval(Message.mvTimer)
}