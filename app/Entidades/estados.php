<?php

      namespace App\Entidades\Sistema;

      use DB;
      use Illuminate\Database\Eloquent\Model;

      class Estados extends Model{

      protected $table = 'estados';
      public $timestamps = false;   //Si lo ponemos true, laravel insertará una marca de tiempo en la bbdd, cada vez que insertemos un cliente le pondrá la fecha y hora de la inserción

      protected $fillable = [ 'idestado', 'pendiente(por pago)', 'en preparacion', 'cancelado', 'pendiente(pagado por MP)'];

      protected $hidden = [   ];

      }


?>