<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorWebContacto extends Controller{
      public function index(){

            return view("web.contacto");
      }
      public function enviar(Request $request){
            $nombre = $request->input('txtNombre');
            $correo = $request->input('txtCorreo');
            $telefono = $request->input('txtTelefono');
            $comentarios = $request->input('txtComentarios');

            $mail = new PHPMailer(true);
            try{
                  $mail->isSMTP();
                  $mail->Host = env('MAIL_HOST');
                  $mail->SMTPAuth = true;
                  $mail->Username = env('MAIL_USERNAME');
                  $mail->Password = env('MAIL_PASSWORD');
                  $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                  $mail->Port = env('MAIL_PORT');

                  $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                  $mail->addAddress(env('MAIL_TO_ADDRESS'));

                  $mail->isHTML(true);
                  $mail->Subject = 'Gracias por contactarte! ' . $nombre;
                  $mail->Body = "
                  <h3>Nueva consulta de contacto</h3>
                  <p>Nombre: $nombre</p>
                  <p>Correo: $correo<p>
                  <p>Telefono: $telefono<p>
                  <p>Comentarios: $comentarios<p>
                  ";

                  $mail->send();
                  return redirect('/contacto-gracias');
            }catch(Exception $e){
                  $msg = ['ESTADO' => 'danger', 'MSG' => 'ERROR: No se pudo enviar el mensaje. Ingresar nuevamente. '];
                  return redirect('/contacto')->with('msg', $msg);

            }
      }
}


?>