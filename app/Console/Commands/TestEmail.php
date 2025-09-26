<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email : The email address to send test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');

        try {
            Mail::raw('This is a test email to verify your SMTP configuration with Brevo.', function (Message $message) use ($email) {
                $message->to($email)
                    ->subject('Test Email from BukuCerita - SMTP Configuration Test');
            });

            $this->info("Test email sent successfully to {$email}!");

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send test email: '.$e->getMessage());

            return 1;
        }
    }
}
