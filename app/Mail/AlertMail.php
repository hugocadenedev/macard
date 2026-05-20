<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertMail extends Mailable
{
  use Queueable, SerializesModels;

  public $booking;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($booking)
  {
    $this->booking = $booking;
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
                ->subject("Nouvelle réservation !")
                ->view('mail.alertMail', ["booking" => $this->booking]);
  }
}
