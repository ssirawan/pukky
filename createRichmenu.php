<?php

require('TypeMessage.php');

$ACCESS_TOKEN = getTokenData();
$RICH_URL = 'https://api.line.me/v2/bot/richmenu';

$rich_area = array(
		  array('bounds'=> array( 'x'=>'0','y'=>'0','width' => 1254,'height' => 850 ), 'action' => array('type'=> 'postback', 'text' =>'ดูสินค้า','data' => 'action=buy&itemid=123')),
		  array('bounds'=> array( 'x'=>'0','y'=>'850','width' => 1258,'height' => 831 ), 'action' => array('type'=> 'postback', 'text' =>'Promotion','data' => 'action=buy&itemid=123')),
		  array('bounds'=> array( 'x'=>'1254','y'=>'0','width' => 1246,'height' => 850 ), 'action' => array('type'=> 'postback', 'text' =>'สินค้าที่บันทึกไว้','data' => 'action=buy&itemid=123')),
		  array('bounds'=> array( 'x'=>'1258','y'=>'850','width' => 1242,'height' => 835 ), 'action' => array('type'=> 'postback', 'text' =>'เช็คสถานะ','data' => 'action=buy&itemid=123'))
		  );
$rich_object = array('size'=> array('width'=>2500,'height'=>1686),'selected'=> true ,
			     'name'=>'rich_menu','chatBarText'=>'menu','areas'=>  $rich_area );
$rich_obj_req = json_encode($rich_object, JSON_UNESCAPED_UNICODE);


$richmenu_id = create_rich_menu($RICH_URL,$ACCESS_TOKEN,$rich_obj_req); //เหมือนว่าทุกครั้งที่ deploy จะได้ richmenuid ใหม่กลับมา	  
file_put_contents("php://stderr", "POST JSON ===> ".$richmenu_id); //เอาค่า richmenu_id จากโค้ดนี้ ใน log
//richMenuId":"richmenu-1fca312bacb85188fd89e78633ad7286"


function create_rich_menu($post_url, $ACCESS_TOKEN , $post_body)
{

	$curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $post_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $post_body,
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer ".$ACCESS_TOKEN,
        "cache-control: no-cache",
        "content-type: application/json; charset=UTF-8",
      ),
    ));

 
 $result = curl_exec($curl);
 $err = curl_error($curl);
 	
 curl_close($curl);
	
 if ($err) {
        return $err;
    } else {
    	return $result;
    }	
	
?>
