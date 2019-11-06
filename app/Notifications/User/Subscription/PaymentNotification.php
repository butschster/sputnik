<?php

namespace App\Notifications\User\Subscription;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Laravel\Cashier\Payment;

class PaymentNotification extends \Laravel\Cashier\Notifications\ConfirmPayment
{

}
