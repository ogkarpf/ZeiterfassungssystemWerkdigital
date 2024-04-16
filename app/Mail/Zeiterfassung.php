<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\User;
use App\Models\WorkTime;

class Zeiterfassung extends Mailable
{
    private $name;
    private $content;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private $userid)
    {
        $user = User::find($userid);
        $this->name = $user->name; 

        $this->content = $this->getWorkTimeData();
    }

    private function getWorkTimeData()
{
    $workTimes = WorkTime::where('user_id', $this->userid)
                         ->whereDate('start_time', now()->format('Y-m-d'))
                         ->orderBy('start_time')
                         ->get();

    $groupedWorkTimes = $workTimes->groupBy(function ($workTime) {
        return $workTime->start_time->format('d.m.Y');
    });

    $totalWorkHours = [];
    foreach ($groupedWorkTimes as $date => $dayWorkTimes) {
        $totalWorkHours[$date] = $dayWorkTimes->sum(function ($workTime) {
            return $workTime->start_time->diffInHours($workTime->end_time);
        });
    }

    $resultString = '';
    foreach ($groupedWorkTimes as $date => $dayWorkTimes) {
        $resultString .= $date . "<br>";
        foreach ($dayWorkTimes as $workTime) {
            $resultString .= $workTime->start_time->format('H:i') . ' - ' . $workTime->end_time->format('H:i') . "<br>";
        }
        $resultString .= "Gesamt " . number_format($totalWorkHours[$date], 2) . " Stunden <br>";
    }

    return $resultString;
}


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Zeiterfassung',
            from: new Address('zeiterfassung@gmail.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.zeiterfassung',
            with: ['name' => $this->name,
            'content' => $this->content]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
