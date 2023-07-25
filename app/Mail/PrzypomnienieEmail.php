<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class PrzypomnienieEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $nazwaWydarzenia;
    public $dataWydarzenia;

    public function __construct($nazwaWydarzenia, $dataWydarzenia)
    {
        $this->nazwaWydarzenia = $nazwaWydarzenia;
        $this->dataWydarzenia = $dataWydarzenia;
    }

    public function build()
    {
        return $this->view('emails.przypomnienie') // Tutaj używasz nazwy szablonu emaila
            ->subject('Przypomnienie o nadchodzącym wydarzeniu');
    }
}
?>