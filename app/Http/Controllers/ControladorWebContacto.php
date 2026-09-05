<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorWebContacto extends Controller{
      public function index(){
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();


            return view("web.contacto", compact('aSucursales'));
      }
      public function enviar(Request $request){
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $nombre = $request->input('txtNombre');
            $correo = $request->input('txtCorreo');
            $telefono = $request->input('txtTelefono');
            $comentarios = $request->input('txtComentarios');

            //Este if lo agrega el profe
            if($nombre != "" && $correo != "" && $telefono != "" && $comentarios != ""){

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
                        return view("web.contacto-gracias", compact('aSucursales'));
                        //return redirect('/contacto-gracias');
                  }catch(Exception $e){
                        $msg['ESTADO'] = 'danger';
                        $msg['MSG'] = "Error al enviar el mensaje: " . $e->getMessage();
                        return view("web.contacto", compact('msg', 'aSucursales'));
                        /*$msg = ['ESTADO' => 'danger', 'MSG' => 'ERROR: No se pudo enviar el mensaje. Ingresar nuevamente. '];
                        return redirect('/contacto')->with('msg', $msg);*/

                  }
            }else{
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = "Complete todos los datos";
                  return view('web.contacto', compact('aSucursales', 'msg'));
            }
      }
      public function contactoGracias(){

      }
}


?>