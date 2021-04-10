<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CustomerInquiry;
use App\Models\Property;
class inquirySender extends Mailable
{
    use Queueable, SerializesModels;

    public $ci;
    public $prop;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CustomerInquiry $ci)
    {
        $this->ci = $ci;
        $this->prop = Property::where('prop_code',$ci->project_name)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.newInq');
    }
}
