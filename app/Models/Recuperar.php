<?php

//session_start();
class Recuperar
{
	public $_data,
			$_db;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function cambiopass($passOriginal, $pass){
				// //estos dos se envian a base
				$salt = Hash::salt(32);
				$encriptPass = Hash::make($pass, $salt);
				$idUser = Session::get(Config::get("session/session_name"));

				$user = $this->_db->get("usuarios", array('id','=',$idUser));
				
				if ($user->count()) {
					$this->_data = $user->first();	

					if(User::checkPass($passOriginal, $this->_data->pass))
					{

						$where = array("nombre"=>"id", "valor"=>$idUser);
					    $fields = array(
					  	 "salt"=>$salt,
						 "pass"=>$encriptPass
						);

						if(!$this->_db->update("usuarios", $where, $fields)){
							//return $this->sendMail($this->_data->correo,$pass);
							//no se pudo realizar el cambio
							return -1;
						}
						else{
							//se hizo el cambio
							return 1;
						}
					}
					else
					{
						return 0;
						//la contraseña original no es valida
					}
				}
				return -2;
				/*
				1 Cambios exitosos
				-1 No se pudo reaizaar el cambio (error de update)
				0 la contraseña original no es valida
				-2 no se encontró el usuario loggeado en base
				*/
	}

	public function check($username = null)
	{		
		//$user = DB::getInstance()->get("usuarios", array('documento','=',$username));
		$user = $this->_db->get("usuarios", array('documento','=',$username));
		if ($user->count()) {
			$this->_data = $user->first();	
				$nuevoPass = $this->getPass(10);
				// //estos dos se envian a base
				$salt = Hash::salt(32);
				$encriptPass = Hash::make($nuevoPass, $salt);

				$where = array("nombre"=>"id", "valor"=>$this->_data->id);
			    $fields = array(
			  	 "salt"=>$salt,
				 "pass"=>$encriptPass
				);

				if(!$this->_db->update("usuarios", $where, $fields)){
					return false;
				}
				else{

					$correo = $this->_db->get("correos", array('id','=','1'));
					if (!$correo->count())
					return false;
					$info = $correo->first();
					if($this->sendMail($this->_data->correo,$nuevoPass, $info))
					{
						return $this->_data->correo;
					}else{
						return false;
					}
				}
		}
		return false;
	}

	private function getPass($len){
    $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_*)(.:,;?¿!$#&+";
    $su = strlen($an) - 1;
    $pass = "";
    for ($i=0; $i <$len ; $i++) { 
    	$pass = $pass.substr($an, rand(0, $su), 1);
    }
    return $pass;
	}

	private function sendMail($correo,$pass, $info = array())
	{				
		if (file_exists("../vendor/PHPMailer/PHPMailerAutoload.php"))
		{
			require "../vendor/PHPMailer/PHPMailerAutoload.php";

			$mail = new PHPMailer;

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $info->host;  // Specify main and backup SMTP servers
			$mail->SMTPAuth =  $info->smtp;                               // Enable SMTP authentication
			$mail->Username =  $info->correo;                 // SMTP username
			$mail->Password =  $info->pass;                           // SMTP password
			$mail->SMTPSecure =  $info->secure;                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port =  $info->port;                                    // TCP port to connect to

			$mail->From = 'no_responder@cta.org.co';
			$mail->FromName = 'Centro de ciencia y tecnología de antioquia - CTA';
			$mail->addAddress($correo, $this->_data->primerNombre." ".$this->_data->primerApellido);     // Add a recipient

			$mail->isHTML(true);  

			$correo = file_get_contents('../app/views/mail/mail.html', dirname(__FILE__));                                  // Set email format to HTML
			$correo = str_replace("**nombre**", $this->_data->primerNombre." ".$this->_data->primerApellido, $correo);
			$correo = str_replace("**pass**", $pass , $correo);
			$mail->Subject = 'Recuperación de contraseña';

			$mail->Body    = $correo;
			$mail->AltBody = 'Este es el mensaje para navegadores viejos';

			$mail->CharSet = 'UTF-8';


			if(!$mail->send()) {
			    // echo 'Message could not be sent.';
			    // echo 'Mailer Error: ' . $mail->ErrorInfo;
			    return false;
			} else {
			    // echo 'Message has been sent';
			    return true;
			}

		}
		#enviar correo phpMailer
		//return true;
	}

	private function clean()
	{
		$this->_data = null;
	}


}