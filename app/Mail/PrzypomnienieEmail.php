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
    public $godzinaWydarzenia;
    public $Imie;
    public $Nazwisko;
    public $uNazwisko;

    public function __construct($nazwaWydarzenia, $dataWydarzenia,$godzinaWydarzenia ,$firstName,$lastName,$u_first_name)
    {
        $this->nazwaWydarzenia = $nazwaWydarzenia;
        $this->dataWydarzenia = $dataWydarzenia;
        $this->godzinaWydarzenia = $godzinaWydarzenia;
        $this->Imie = $firstName;
        $this->Nazwisko = $lastName;
        $this->uNazwisko = $u_first_name;
    }

    public function build()
    {
        return $this->view('emails.przypomnienie') // Tutaj używasz nazwy szablonu emaila
            ->subject('Przypomnienie o nadchodzącym wydarzeniu');
    }
}
?>