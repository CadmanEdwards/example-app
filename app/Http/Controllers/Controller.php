<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	
	public function ImapMailFetch()
	{
		$client = \Webklex\IMAP\Facades\Client::account('default');
		// return [$client];

		$client->connect();
		$folder = $client->getFolderByName('INBOX');
		$messages = $folder->messages()->unseen()->get();


		$email_data = [];
		foreach($messages as $message){	
			if($message->hasAttachments()){
				foreach ($message->getAttachments() as $attachment) {
					$status = $attachment->save($path = public_path () . "/email_attachments/", $filename = null);
					dump($status);
                }
		}
			
			//Move the current Message to 'INBOX.read'
			// if($message->move('INBOX.read') == true){
			// 	echo 'Message has ben moved';
			// }else{
			// 	echo 'Message could not be moved';
			// }
		}
	}

}
