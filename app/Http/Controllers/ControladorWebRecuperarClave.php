<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorWebRecuperarClave extends Controller{
      public function index(Request $request){
            $titulo = "Recuperar clave";
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.recuperar-clave", compact("titulo"));
      }
      public function recuperar(Request $request){
            $titulo = "Recuperar clave";
            $correo = $request->input('txtCorreo');
            $clave = rand(1000, 9999);

            $cliente = new Cliente();
            $cliente->obtenerPorCorreo($correo);
            if($cliente->correo != null){
                  $data = "Instrucciones";
                  $mail = new PHPMailer(true);
                  try{
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = env('MAIL_HOST');
                        $mail->SMTPAuth = true;
                        $mail->Username = env('MAIL_USERNAME');
                        $mail->Password = env('MAIL_PASSWORD');
                        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                        $mail->Port = env('MAIL_PORT');

                        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $mail->addAddress($correo);
                        
                        $mail->isHTML(true);
                        $mail->Subject = 'Recuperar clave';
                        $mail->Body = "Los datos de acceso son: 
                        Usuario: $cliente->correo;
                        Clave: $clave;
                        ";
                        $mail->send();
                        //Actualizar en el cliente la nueva clave ya encriptada
                        $claveEncriptada = password_hash($clave, PASSWORD_DEFAULT);
                        $cliente->clave = $claveEncriptada;
                        $cliente->guardar();

                        dd([
                              'correo' => $cliente->correo,
                              'clave_nueva' => $clave,
                              'clave_encriptada' => $cliente->clave
                        ]);

                        $mensaje = "La nueva clave es $clave, y te la hemos enviado a tu correo";
                        return view('web.recuperar-clave', compact('titulo', 'mensaje'));
                  }catch(Exception $e){
                        $mensaje = "No se pudo enviar el correo. ";
                        return view('web.recuperar-clave', compact('titulo', 'mensaje'));
                  }
            }else{
                  $mensaje = "El correo no está registrado.";
                  return view('web.recuperar-clave', compact('titulo', 'mensaje'));
            }

      }
}

?>