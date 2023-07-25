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
                    // Wysyłanie powiadomienia do każdego uczestnika
                    $this->sendPrzypomnienieEmail($email, $wydarzenie->title, $wydarzenie->date_start);
            }
        }

        $this->info('Przypomnienia wysłane pomyślnie.');
        
    }

    private function sendPrzypomnienieEmail($email, $nazwaWydarzenia, $dataWydarzenia)
    {
        // Tutaj możesz użyć Mailera do wysyłania emaili
        Mail::to($email)->send(new PrzypomnienieEmail($nazwaWydarzenia, $dataWydarzenia));
    }
}
