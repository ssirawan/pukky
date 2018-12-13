<?php
$db = pg_connect("host = ec2-107-21-125-209.compute-1.amazonaws.com port=5432 dbname=dc3tivj0r52gsf user=mpwiqbtiiesnzo password=78194c7e081845f6138d252da9e93ee66a5107de8e5d307a0f2a63be2c05d055");
echo $db;

/*
pg_query($db,"CREATE TABLE Rec (Reply varchar(40) NOT NULL)");
pg_query($db,"INSERT INTO Rec VALUES ('asdfghjkl')");
$aaa = pg_query($db,"SELECT COUNT(*) FROM Rec ");
$bbb = pg_fetch_row($aaa);
echo "result = $bbb[0] <br>";
*/

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'KAqNx0+niWFXmr6kBFMM/m2P600prLBti2wl7YDpdvb4lV+OSVRegqRJxuHqhq9UuyxnEBPRfI+W6LjLKzctQU+cJwCLJAFKZ0e8+iwqJJAnnmS1VvxWlYefUlLfJV/ZunwddeU7cLK2/O/EJMeDYgdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
if ( sizeof($request_array['events']) > 0 )
{
 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];
  if ( $event['type'] == 'message' ) 
  {
   $userid = $event['source']['userId'];
   
   $findtable = pg_query($db,"SELECT COUNT(*) FROM $userid");
   if( pg_fetch_result($findtable) == 0)
   {
	   pg_query($db,"CREATE TABLE $userid (Reply varchar(100) NOT NULL)");
   }
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
   	if($text=='showid')
   	{
	   $reply_message = $userid;
   	}
    	elseif($text == 'Total')
    	{
	$qq = pg_query($db,"SELECT COUNT(*) FROM $userid ");
	$yyy = pg_fetch_row($qq);
	$reply_message = "มีข้อมูลในระบบทั้งหมด ".$yyy[0]." ข้อมูล";
    	}
    	else
    	{
	$add = pg_query($db,"INSERT INTO $userid VALUES ('$text')");
	$reply_message = "ระบบได้ทำการเพิ่ม '".$text."' เข้าสู่ฐานข้อมูลแล้ว"."\n"."กรุณาพิมพ์ 'Total' เพื่อตรวจสอบจำนวนข้อมูลในระบบ";}
   	}
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}
echo "OK";
echo "$userid <br>";



function send_reply_message($url, $post_header, $post_body)
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
?>
