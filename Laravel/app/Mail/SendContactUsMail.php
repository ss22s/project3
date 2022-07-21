<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email,$item,$content)
    {
        //
        $this->name = $name;
        $this->email = $email;
        $this->item = $item;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.ContactUsMail')
        ->subject('[自動送信] メッセージ内容の確認')
        ->with(['name' => $this->name, 'email' => $this->email, 
                'item' => $this->item, 'content' => $this->content]);
    }
}
