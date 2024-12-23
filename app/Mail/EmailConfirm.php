<?php

namespace App\Mail;

use App\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConfirm extends Mailable
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
    public function __construct(License $license)
    {
        //
        $this->license = $license;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        $url = url("/api/email_confirm?email={$this->license->email}&code={$this->license->confirm_code}");
        return $this->markdown('emails.email_confirm')->with(
            [
                'url'     => $url,
                'license' => $this->license,
            ])->subject('E-Posta Adresi Doğrulama');
    }
}
