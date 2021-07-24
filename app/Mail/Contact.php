<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;
    
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
    	$this->data = $data;
    	$this->data['title'] = 'wasla.net تواصل جديد عل موقع وصلة';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		return $this->view('content.email')
			->subject($this->data['title'])
			->with('data',$this->data);
    }
}
