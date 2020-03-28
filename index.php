<?php

/*
 * Farsroid TelegramBot (v1.2)
 * Coded By https://kihanb.ir | @kihanb | @kihanb_ir
 */

error_reporting(0);
//-----------------------------------------
$admin = 615724046; // your userid
$channel = "kihanb_ir"; // your channel id
$token = ''; // your api token [Buy : https://one-api.ir]
define('API_KEY',''); // your bot token
//-----------------------------------------
function Bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//-----------------------------------------
function SendMessage($chat_id,$text,$mode,$reply = null,$keyboard = null){
	Bot('SendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$mode,
	'reply_to_message_id'=>$reply,
	'reply_markup'=>$keyboard
	]);
}
function EditMessage($chat_id,$message_id,$text,$keyboard){
	Bot('editMessagetext',[
    'chat_id'=>$chat_id,
	'message_id'=>$message_id,
    'text'=>$text,
    'reply_markup'=>$keyboard
	]);
	}
function SendDocument($chatid,$document,$caption = null){
	Bot('SendDocument',[
	'chat_id'=>$chatid,
	'document'=>$document,
	'caption'=>$caption
	]);
}
function ForwardMessage($chatid,$from_chat,$message_id){
	bot('ForwardMessage',[
	'chat_id'=>$chatid,
	'from_chat_id'=>$from_chat,
	'message_id'=>$message_id
	]);
	
}
function Download($link, $path){
    $file = fopen($link, 'r') or die("Can't Open Url !");
    file_put_contents($path, $file);
    fclose($file);
    return is_file($path);
  }
function GetChat($chatid){
	$get =  Bot('GetChat',['chat_id'=>$chatid]);
	return $get;
}
function GetMe(){
	$get =  Bot('GetMe',[]);
	return $get;
} $botid =getMe() -> result -> username;



//-----------------------------------------
$update = json_decode(file_get_contents('php://input'));
if(isset($update->message)){
    $message = $update->message; 
    $chat_id = $message->chat->id;
    $text = $message->text;
    $message_id = $message->message_id;
    $textmessage = $message->text;
    $from_id = $message->from->id;
    $tc = $message->chat->type;
    $first_name = $message->from->first_name;
    $last_name = $message->from->last_name;
    $username = $message->from->username;
    $caption = $message->caption;
    $reply = $message->reply_to_message->forward_from->id;
    $reply_id = $message->reply_to_message->from->id;
    $data = $message->data;
}
if(isset($update->callback_query)){
    $data = $update->callback_query->data;
    $data_id = $update->callback_query->id;
    $chatid = $update->callback_query->message->chat->id;
    $fromid = $update->callback_query->from->id;
    $tccall = $update->callback_query->chat->type;
    $messageid = $update->callback_query->message->message_id;
}

if(isset($chat_id)){
    $chat = $chat_id;
}elseif(isset($chatid)){
    $chat = $chatid;
}
$stats = file_get_contents("data/$chat/stats.txt");
//-----------------------------------------
function getChatMember($channel, $id = ""){
    $forchannel = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@$channel&user_id=".$id));
    $tch = $forchannel->result->status;

     if($tch == 'member' or $tch == 'creator' or $tch == 'administrator'){
         return true;
     }else{
         return false;
     }
}
if(getChatMember($channel, $chat) == false){
	bot('SendMessage',[
        'chat_id'=>$chat,
        'text'=>"📣کاربر گرامی
جهت استفاده از خدمات این ربات، ابتدا در کانال ما عضو شوید:
        
@$channel

@$channel

سپس دستور /start را مجددا ارسال نمایید!",
        	 ]);
}elseif($textmessage == "/start" or $textmessage == "🔙"){
    if (!file_exists("data/$chat_id/stats.txt")) {
		mkdir("data/$chat_id");
		$myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");
        fwrite($myfile2, "$chat_id\n");
        fclose($myfile2);
	}
	
	file_put_contents("data/$chat_id/stats.txt","none");
	bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"🎲به ربات فارسروید خوش آمدید!

🎯با این ربات به منبعی عظیم از برنامه و بازی های اندرویدی دست خواهید یافت و در عرض چند ثانیه برنامه یا بازی موردنظر خود را دریافت خواهید کرد!

coded by @kihanb

@$botid",
'reply_to_message_id'=>$message_id,
 'parse_mode'=>"HTML",
    'reply_markup'=>json_encode([
           'keyboard'=>[
    [['text'=>"🔎جستجو برنامه و بازی"]],
	[['text'=>"🏆جدیدترین بازی ها"],['text'=>"🏆جدیدترین برنامه ها️"]],
           ],
		"resize_keyboard"=>true,
	 ])
	 ]);
}elseif($textmessage == "🏆جدیدترین برنامه ها️"){
    
    bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"درحال دریافت اطلاعات لطفا کمی صبر کنید...",
  'reply_to_message_id'=>$message_id,
 'parse_mode'=>"MarkDown",
 'reply_markup'=>json_encode([
                    'keyboard'=>[
	[['text'=>"🔙"]],
	],
		"resize_keyboard"=>true,
	 ])
 ]);
 
$mus = json_decode(file_get_contents("https://one-api.ir/farsroid/?token=$token&action=app"), true);
	for($i=1;$i<6;$i++){
$pic = $mus['result'][$i]['pic'];
$link = $mus['result'][$i]['link'];
$title = $mus['result'][$i]['title'];
$link =STR_REPLACE("https://www.farsroid.com/","da_",$link);
bot('sendphoto',[
   'chat_id'=>$chat_id,
   'photo'=>$pic,
   'caption'=>"$title
   
@$botid",
 'reply_markup'=>json_encode([
            'inline_keyboard'=>[[['text'=>"توضیحات + دانلود",'callback_data'=>"$link"]],]
        ])
   ]);
}
}elseif($textmessage == "🏆جدیدترین بازی ها"){
    
        bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"درحال دریافت اطلاعات لطفا کمی صبر کنید...",
  'reply_to_message_id'=>$message_id,
 'parse_mode'=>"MarkDown",
 'reply_markup'=>json_encode([
                    'keyboard'=>[
	[['text'=>"🔙"]],
	],
		"resize_keyboard"=>true,
	 ])
 ]);
 
$mus = json_decode(file_get_contents("https://one-api.ir/farsroid/?token=$token&action=game"), true);
	for($i=1;$i<6;$i++){
$pic = $mus['result'][$i]['pic'];
$link = $mus['result'][$i]['link'];
$title = $mus['result'][$i]['title'];
$link =STR_REPLACE("https://www.farsroid.com/","da_",$link);
bot('sendphoto',[
   'chat_id'=>$chat_id,
   'photo'=>$pic,
   'caption'=>"$title
   
@$botid",
 'reply_markup'=>json_encode([
            'inline_keyboard'=>[[['text'=>"توضیحات + دانلود",'callback_data'=>"$link"]],]
        ])
   ]);
}
}elseif(strpos($data,'da_') !== false){

$text2 = str_replace("da_",'https://www.farsroid.com/',$data);
$mus = json_decode(file_get_contents("https://one-api.ir/farsroid/?token=$token&action=download&link=$text2"), true);
$title = $mus['result']['title'];
$pic = $mus['result']['pic'];
$description = $mus['result']['description'];

bot('sendphoto',[
   'chat_id'=>$chatid,
   'photo'=>$pic,
   'caption'=>"📥$title
   
@RimonRobot",
   ]);
bot('sendMessage',[
 'chat_id'=>$chatid,
 'text'=>"💎توضیحات: $description

@RimonRobot",
 'parse_mode'=>"HTML",
	 ]);
$links ="";
	for($i=1;$i<4;$i++){
$title = $mus['result']["link$i"]['title'];
$link = $mus['result']["link$i"]['link'];
if(!empty($title))
$links .="\n <a href=\"$link\">$title</a>";
}
$info = $mus['result']['info'];


	bot('sendMessage',[
 'chat_id'=>$chatid,
 'text'=>"📥جعبه دریافت:
$links

$info

@RimonRobot",
 'parse_mode'=>"HTML",
	 ]);

  
}elseif($textmessage == "🔎جستجو برنامه و بازی"){
file_put_contents("data/$from_id/stats.txt","searchapp");

bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"🔎جهت جستجو لطفا نام برنامه یا بازی موردنظر خود را با فاصله ارسال نمایید:",
  'reply_to_message_id'=>$message_id,
 'parse_mode'=>"HTML",
      'reply_markup'=>json_encode([
           'keyboard'=>[
    [['text'=>"🔙"]],
           ],
		"resize_keyboard"=>true,
	 ])
 ]);
}
elseif($stats == "searchapp"){
        
   	        bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"درحال دریافت اطلاعات لطفا کمی صبر کنید...",
  'reply_to_message_id'=>$message_id,
 'parse_mode'=>"MarkDown",
 'reply_markup'=>json_encode([
                    'keyboard'=>[
	[['text'=>"🔙"]],
	],
		"resize_keyboard"=>true,
	 ])
 ]);
    $text2=urlencode($message->text);
$mus = json_decode(file_get_contents("https://one-api.ir/farsroid/?token=$token&action=search&q=$text2"), true);
for($i=1;$i<6;$i++){
$pic = $mus['result'][$i]['pic'];
$link = $mus['result'][$i]['link'];
$title = $mus['result'][$i]['title'];
$link =STR_REPLACE("https://www.farsroid.com/","da_",$link);
bot('sendphoto',[
   'chat_id'=>$chat_id,
   'photo'=>$pic,
   'caption'=>"$title
   
@$botid",
 'reply_markup'=>json_encode([
            'inline_keyboard'=>[[['text'=>"توضیحات + دانلود",'callback_data'=>"$link"]],]
        ])
   ]);
}

}

?>
