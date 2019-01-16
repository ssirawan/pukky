<?php


$RICH_URL = 'https://api.line.me/v2/bot/richmenu';
$REPLY_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'sOEyFKdoKFQDFMhGL5xv2pliXwALUNCvZYG0QeHWRFXXmwbdnfv1Zdj6BkCbkK8qPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk6Vs4W/8jXaNYjLZOKTf0wnCnHoAeptCHg7CTZl+Zw4gdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$CHANNEL_SECRET = 'b41da5ab3d233c34e1bffc5a75a63846';
$POST_HEADER = array('Content-Type: application/json ; charset=UTF-8', 'Authorization: Bearer ' . $ACCESS_TOKEN, 'cache-control: no-cache');

$rich_area = array(
		  array('bounds'=> array( 'x'=>'0','y'=>'0','width' => 1254,'height' => 850 ), 'action' = array('type'=> 'postback', 'text' =>'ดูสินค้า')),
		  array('bounds'=> array( 'x'=>'0','y'=>'850','width' => 1258,'height' => 831 ), 'action' = array('type'=> 'postback', 'text' =>'Promotion')),
		  array('bounds'=> array( 'x'=>'1254','y'=>'0','width' => 1246,'height' => 850 ), 'action' = array('type'=> 'postback', 'text' =>'สินค้าที่บันทึกไว้')),
		  array('bounds'=> array( 'x'=>'1258','y'=>'850','width' => 1242,'height' => 835 ), 'action' = array('type'=> 'postback', 'text' =>'เช็คสถานะ'))
		  );
$rich_object = array('size'=> array('width'=>2500,'height'=>1686),'selected'=>true,
			     'name'=>'menu','chatBarText'=>'menu','areas'=>$rich_area);
$rich_obj_req = json_encode($rich_object, JSON_UNESCAPED_UNICODE);

$rich_menu = create_rich_menu($RICH_URL,$POST_HEADER,$rich_obj_req); 
	  
	  
	  
	  
	  
	  
	  
	  
function create_rich_menu($post_url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 	
 curl_close($ch);
 return $result;	
}	


echo $result;  
?>
