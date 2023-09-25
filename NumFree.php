<?php

#BY {@Sero_bots - @pvpppp}
#ممنوع تغير الحقوق او بيع الملف !!

error_reporting(0);
ob_start();
header("Content-Type: application/json; charset=UTF-8");
ob_start();
date_default_timezone_set('Asia/Baghdad');
$API_KEY = "6618295778:AAEhrjtwyhKYQsxv_-NHwr1Hhegqs6yxvtA" ;
define('API_KEY',$API_KEY);
define("IDBot", explode(":", $API_KEY)[0]);

echo file_get_contents("https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
           function bot($method, $datas=[]){
$Saied_Botate = "https://api.telegram.org/bot".API_KEY."/".$method;
$saied_botate = null;
if(!empty($datas)){
$boundary = uniqid();
$saied_botate = buildMultipartData($datas,$boundary);
$Saied = ['http'=>[
'header'=>"Content-Type: multipart/form-data; boundary=$boundary\r\n",
'method'=>'POST',
'content'=>$saied_botate,
],];
} 
if($saied_botate !== null){
$saied = stream_context_create($Saied);
$saied_result = file_get_contents($Saied_Botate, false, $saied);
}else{
$saied_result = file_get_contents($Saied_Botate);
}
if($saied_result === false){
return "Error: ".error_get_last()['message'];
}else{
return json_decode($saied_result);
}
}

function buildMultipartData($data,$boundary){
$SaiedData = '';
foreach($data as $key => $value){
if($value instanceof CURLFile){
$fileContents = file_get_contents($value->getFilename());
$fileName = basename($value->getFilename());
$fileMimeType = $value->getMimeType();
$SaiedData .= "--" . $boundary . "\r\n";
$SaiedData .= 'Content-Disposition: form-data; name="' . $key . '"; filename="' . $fileName . '"' . "\r\n";
$SaiedData .= 'Content-Type: ' . $fileMimeType . "\r\n\r\n";
$SaiedData .= $fileContents . "\r\n";
}else{
$SaiedData .= "--" . $boundary . "\r\n";
$SaiedData .= 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n\r\n";
$SaiedData .= $value . "\r\n";
}
}
$SaiedData .= "--" . $boundary . "--\r\n";
return $SaiedData;
}


$update = json_decode(file_get_contents('php://input'));

$usrbot = bot("getme")->result->username;
$emoji = 
"➡️
🎟️
↪️
🔘
🏠
" ;
$emoji = explode ("\n", $emoji) ;
$b = $emoji[rand(0,4)];
$NamesBACK = "رجوع $b" ;

define("USR_BOT",$usrbot); #يابه لحد يلعب بهاذه

if($update->callback_query ){
$data = $update->callback_query->data;
$chat_id = $update->callback_query->message->chat->id;
$title = $update->callback_query->message->chat->title;
$message_id = $update->callback_query->message->message_id;
$name = $update->callback_query->message->chat->first_name;
$user = $update->callback_query->message->chat->username;
$from_id = $update->callback_query->from->id;
    }

   
if($update->message){
	$message = $update->message;
$message_id = $update->message->message_id;
$username = $message->from->username;
$chat_id = $message->chat->id;
$title = $message->chat->title;
$text = $message->text;
$user = $message->from->username;
$name = $message->from->first_name;
$from_id = $message->from->id;
}

if($text == "/start"){
    bot("sendmessage",[
        'chat_id' => $chat_id,
        'text' => "
        - مرحبا بك في بوت ارقام الافضل علي تلكرام
        - يمكنك صنع رقم وهمي من *خلال البوت* مجانا
        - البوت يمتلك اكثر من *+10000* رقم مجاني
        ",
        'parse_mode' => 'markdown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
            
            [['text'=>"- سحب رقم وهمي -",'callback_data'=>"GETNUM" ]],
              
              
             ]
           ])
    ]);
}

if($data == "GETNUM"){
$keyk = [];
    $message = file_get_contents("https://receive-smss.com/#google_vignette");
preg_match_all('/<a style="text-decoration: none;" href="\/sms\/(.*?)"\s+aria-label="(.*?)"/', $message, $matches);


for($i=0;$i<10;$i++){
	$sms_url = "https://receive-smss.com/sms/" . $matches[1][$i];
    $sms_url = explode("sms/",$sms_url)[1];
    $sms_url = str_replace("/",null,$sms_url);
    $keyk["inline_keyboard"][]=[["text"=>"+$sms_url","callback_data"=>"entrqm:$sms_url"]];
}
$keyk["inline_keyboard"][]=[["text"=>"التالي ->","callback_data"=>"next:10"]];

bot('editmessagetext',[
        'chat_id' => $chat_id,
        "message_id" => $message_id,
        'text' => "
        - اختر احد الارقام الموجوده ادناه
        ",
        'parse_mode' => 'markdown',
        'reply_markup'=>json_encode($keyk)
    ]);
}

$set = explode(":",$data);

if($set[0] == "entrqm"){
    bot('editmessagetext',[
        'chat_id' => $chat_id,
        "message_id" => $message_id,
        'text' => "
        - الرقم : +$set[1]
        - سيتم ارسال لك كل رسالات الرقم تحت ادناه

        ",
        'parse_mode' => 'markdown',
   
    ]);
    $message = file_get_contents("https://receive-smss.com/sms/$set[1]/");
    preg_match_all('/<div class="col-md-3 sender"><label>Sender<\/label><br>(.*?)<\/div>\s+<div class="col-md-6 msg"><label>Message<\/label><br><span>(.*?)<\/span><\/div>\s+<div class="col-md-3 time"><label>Time<\/label><br>(.*?)<\/div>/', $message, $matches);
    foreach ($matches[1] as $key => $value) {
        $sender = $value;
        $msg = $matches[2][$key];
        $time = $matches[3][$key];
        bot('sendmessage',[
            'chat_id' => $chat_id,
            'text' => "
            - الرقم : *+$set[1]*
            - الرساله رقم $key

            - تفاصيل الرساله :
            - المرسل : *$sender*
            - وقت الارسال : $time
            - الرساله :
            ".strip_tags($msg)."
            ",
            'parse_mode' => 'markdown',
       
        ]);
    }
    bot('sendmessage',[
        'chat_id' => $chat_id,
        'text' => "
        - تم ارسال كل رسائل الرقم : +$set[1]
        ",
        'parse_mode' => 'markdown',
   
    ]);
    bot("sendmessage",[
        'chat_id' => $chat_id,
        'text' => "
        - مرحبا بك في بوت ارقام الافضل علي تلكرام
        - يمكنك صنع رقم وهمي من *خلال البوت* مجانا
        - البوت يمتلك اكثر من *+10000* رقم مجاني
        ",
        'parse_mode' => 'markdown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
            
            [['text'=>"- سحب رقم وهمي -",'callback_data'=>"GETNUM" ]],
              
              
             ]
           ])
    ]);
}


if($set[0] == "next"){
    $keyk = [];
    $message = file_get_contents("https://receive-smss.com/#google_vignette");
preg_match_all('/<a style="text-decoration: none;" href="\/sms\/(.*?)"\s+aria-label="(.*?)"/', $message, $matches);

$r = 20;
for($i=0;$i<$r;$i++){
	$sms_url = "https://receive-smss.com/sms/" . $matches[1][$i];
    $sms_url = explode("sms/",$sms_url)[1];
    $sms_url = str_replace("/",null,$sms_url);
    $keyk["inline_keyboard"][]=[["text"=>"+$sms_url","callback_data"=>"entrqm:$sms_url"]];
}
$keyk["inline_keyboard"][]=[["text"=>"رجوع","callback_data"=>"GETNUM"]];

bot('editmessagetext',[
        'chat_id' => $chat_id,
        "message_id" => $message_id,
        'text' => "
        - اختر احد الارقام الموجوده ادناه
        - يتم تحديث هذه الارقام كل يوم
        ",
        'parse_mode' => 'markdown',
        'reply_markup'=>json_encode($keyk)
    ]);
}
