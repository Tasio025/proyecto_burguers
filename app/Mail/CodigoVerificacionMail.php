<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodigoVerificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    // Propiedades públicas: Laravel las pasa solas a la vista
    public $codigo;
    public $minutos;

    // Recibe el código y cuántos minutos dura, así el texto no queda fijo
    public function __construct($codigo, $minutos = 10)
    {
        $this->codigo = $codigo;   // guarda el código para la vista
        $this->minutos = $minutos; // guarda la validez para la vista
    }

    public function build()
    {
        return $this->subject('Tu código de verificación - Burguers SRL') // asunto
                    ->view('emails.codigo-verificacion');                 // vista a usar
    }
}

?>