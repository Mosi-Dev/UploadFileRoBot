<?php

     /*
     @TGsoldierSources
     @oYSoF
     */

     define('BOT_TOKEN','TOKEN');
     $update = json_decode(file_get_contents('php://input'));
     $chat_id = $update->message->chat->id;
     $msg_id = $update->message->message_id;
     $msg_text = $update->message->text;
     $user_id = $update->message->from->id;
     $name = $update->message->from->first_name;
     $photo = $update->message->photo;
     $audio = $update->message->audio;
     $document = $update->message->document;
     $sticker = $update->message->sticker;
     $video = $update->message->video;
     $voice = $update->message->voice;
     if ($photo != null) {$count = count($photo)-1; $file_id = $photo[$count]->file_id;}
     elseif ($audio != null) {$file_id = $audio->file_id;}
     elseif ($document != null) {$file_id = $document->file_id;}
     elseif ($sticker != null) {$file_id = $sticker->file_id;}
     elseif ($video != null) {$file_id = $video->file_id;}
     elseif ($voice != null) {$file_id = $voice->file_id;}
     if ($file_id != null || $msg_text == '/start') {file_get_contents('https://api.telegram.org/bot'.BOT_TOKEN.'/sendChatAction?chat_id='.$chat_id.'&action=typing');}
     $get_url = json_decode(file_get_contents('https://api.pwrtelegram.xyz/bot'.BOT_TOKEN.'/getFile?file_id='.$file_id));
     $url = $get_url->result->file_path;
     $error = $get_url->error_code;
     $file_link = 'https://storage.pwrtelegram.xyz/'.$url;
     function bot($method,$fields)
     {$url = 'https://api.telegram.org/bot'.BOT_TOKEN.'/'.$method;
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_POST, count($fields));
     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $answer = curl_exec($ch);
     curl_close($ch);}
     function sendMessage($chat_id,$text,$message_id)
     {$fields = array('chat_id'=>$chat_id,'text'=>$text,'parse_mode'=>'html','reply_to_message_id'=>$message_id,'disable_web_page_preview'=>'true');
     bot('sendMessage',$fields);}
     if ($msg_text == '/start') {sendMessage($chat_id,"سلام 😉✋🏻\n\n💠با این ربات شما میتونید فایل های تلگرامی خودتون رو تا حجم 1.5 گیگابایت بدون کم شدن ترافیک آپلود کنید ! \n\n✅کافیه فایلهای خودتون رو به ربات بفرستید یا فوروارد کنید تا لینک دانلود مستقیم آن را دریافت کنید .");}
     elseif ($url == null && $file_id != null || $error != null && $file_id != null)
          {sendMessage($chat_id,"❗️خطا❗️\n\n🔻لطفا لحظاتی دیگر دوباره امتحان کنید🔻",$msg_id);}
     elseif ($file_id != null && $error == null)
          {$message = "لینک : ".$file_link;
          sendMessage($chat_id,$message,$msg_id);}
?>
