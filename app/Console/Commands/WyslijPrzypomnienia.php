<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\PrzypomnienieEmail;

class WyslijPrzypomnienia extends Command
{
    protected $signature = 'przypomnienia:wykonaj';
    protected $description = 'Wysyła przypomnienia dla użytkowników o nadchodzących wydarzeniach';

    public function handle()
    {
        
            $startDate = Carbon::now()->addDays(3)->startOfDay()->format('Y-m-d H:i:s');

            // Ustawienie $endDate na dzisiejszą datę z dodanymi 3 dni i godziną 23:59:59
            $endDate = Carbon::now()->addDays(3)->endOfDay()->format('Y-m-d H:i:s');
            
            $wydarzenia = DB::table('event_details')
                ->where('date_start', '>=', $startDate)
                ->where('date_start', '<=', $endDate)
                ->get();

        foreach ($wydarzenia as $wydarzenie) {
            // Pobierz użytkowników, którzy zapisali się na to wydarzenie
            $uczestnicy = DB::table('event_participants')
                ->where('event_details_id', '=', $wydarzenie->id)
                ->whereNull('deleted_at')
                ->pluck('participants_id');

                $adresyEmail = DB::table('participants')
                ->whereIn('id', $uczestnicy)
                ->pluck('email');

              
                foreach ($adresyEmail as $email) {
                    $uczestnik = DB::table('participants')
                    ->where('email', $email)
                    ->first();
                  
                    if ($uczestnik) {
                    // Wysyłanie powiadomienia do każdego uczestnika
                    $this->sendPrzypomnienieEmail($email, $wydarzenie->title, Carbon::parse($wydarzenie->date_start)->format('d-m-Y'), Carbon::parse($wydarzenie->date_start)->format('H:i'),$wydarzenie->speaker_first_name,$wydarzenie->speaker_last_name, $uczestnik->first_name);
            }
            else {
                $this->error("Nie znaleziono uczestnika o adresie email");
            }
        }
    }

        $this->info('Przypomnienia wysłane pomyślnie.');
        
    }

    private function sendPrzypomnienieEmail($email, $nazwaWydarzenia, $dataWydarzenia, $godzinaWydarzenia ,$firstName,$lastName, $u_first_name)
    {
        // Tutaj możesz użyć Mailera do wysyłania emaili
        Mail::to($email)->send(new PrzypomnienieEmail($nazwaWydarzenia, $dataWydarzenia, $godzinaWydarzenia,$firstName,$lastName, $u_first_name));
    }
}
