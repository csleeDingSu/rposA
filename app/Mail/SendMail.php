<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


//extends Mailable
class SendMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
	
	
	public $data;
	public $mailtype;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type = '1',$data = FALSE)
    {
        $this->mailtype = $type;
		$this->data = $data;
		self::build();
    }
	
	
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
		$data    = $this->data;
		$type    = $this->mailtype;
		$name = 'Dingsu';
		$view = 'emailtest';
		$subject = 'Test Mail';
		$to = 'pre@ac.com';
	
		
		switch ($type)
		{
			case 'resetpass':	
				$view    = 'emails.emailtest';
				$subject = 'Reset your Dingsu password';
				$to      = $data['email'];
				$email   = $data['email'];
			break;
				
			case 'welcomemail':	
				$view    = 'emails.emailtest';
				$subject = 'Welcome to Dingsu';
				$to      = $data['email'];
				$email   = $data['email'];
			break;
				
			case 'sendtoken':
			break;
			case 'passwordupdate':	
			break;	
			case 'loginattempt':	
			break;	
		}
		
		
        return $this->view($view)
                    ->subject($subject)
                    ->with([ 'data' => $this->data   ]);
				
		
		$address = 'ignore@batcave.io';
		$name = 'Dingsu';

		return $this->view($view)
					->to($to)
					->subject($subject);
		
					
    }
	
	public function failed()
    {
        // Called when the job is failing...
        Log::alert('error in reset password queue mail');

    }
	
	private function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

        return $json;
    }


    private function asString($data)
    {
        $json = $this->asJSON($data);
        
        return wordwrap($json, 76, "\n   ");
    }
	
}
