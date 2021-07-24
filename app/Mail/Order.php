<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
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
    	$this->data['title'] = 'wasla.net طلب خدمة جديد عل موقع وصلة';
    	$this->data['not_contact'] = true;
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
