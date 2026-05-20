<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
  use Queueable, SerializesModels;

  public $booking;
  public $page;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($booking, $page)
  {
    $this->booking = $booking;
    $this->page = $page;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $from = config('mail.from.address', 'info@groupemso.com');
    Carbon::setLocale('fr');
    setlocale(LC_TIME, 'French');
    return $this->from($from)
                ->subject("Votre participation est bien enregistrée")
                ->view('mail.confirmMail', ["booking" => $this->booking, "page" => $this->page]);
  }
}
