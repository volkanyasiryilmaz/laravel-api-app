<?php

namespace App\Mail;

use App\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var License
     */
    private $license;
    private $new_password;

    /**
     * Create a new message instance.
     * @return void
     */
    public function __construct(License $license, $new_password)
    {
        //
        $this->license = $license;
        $this->new_password = $new_password;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forgot_password')->with(
            [
                'license' => $this->license,
                'new_password' => $this->new_password,
            ])->subject('Şifre Yenileme');
    }
}
