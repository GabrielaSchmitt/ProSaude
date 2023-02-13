<? php 

$error = '';
$name = '';
$surname = '';
$email = '';
$phone = '';
$subject = '';
$message = '';

    function clean_text($string){
      $string = trim($string);
      $string = stripslashes($string);
      $string = htmlspecialchars($string);
      return $string;
    }

  if(isset($_POST["submit"])){
    if (empty($_POST["name"])){
      $error .= '<p><label class="text-danger">Porfavor, digite seu nome.</label></p>';
    }else {
    $name = clean_text($_POST["name"]);
    if(!preg_match("/^[a-zA-Z ]*$/",$name)){
      $error .= '<p><label class="text-danger">Apenas letras e espaços permitidos.</label></p>';
    }
  }
  if (empty($_POST["surname"])){
    $error .= '<p><label class="text-danger">Porfavor, digite seu sobrenome.</label></p>';
  }else {
  $surname = clean_text($_POST["surname"]);
  if(!preg_match("/^[a-zA-Z ]*$/",$surname)){
    $error .= '<p><label class="text-danger">Apenas letras e espaços permitidos.</label></p>';
  }
  }
  if (empty($_POST["email"])){
    $error .= '<p><label class="text-danger">Porfavor, digite seu e-mail.</label></p>';
  } else {
    $email = clean_text($_POST["email"]);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error .= '<p><label class="text-danger">Formato de e-mail inválido.</label></p>';
    }
  }
  if (empty($_POST["phone"])){
    $error .= '<p><label class="text-danger">Porfavor, digite seu número.</label></p>';
  }else {
  $phone = clean_text($_POST["phone"]);
  }
  if (empty($_POST["subject"])){
    $error .= '<p><label class="text-danger">Porfavor, digite o assunto.</label></p>';
  } else {
    $subject = clean_text($_POST["subject"]);
  }
  if (empty($_POST["message"])){
    $error .= '<p><label class="text-danger">Porfavor, digite o texto.</label></p>';
  }else {
    $message = clean_text($_POST["message"]);
    $content = "From: $name $surname \nEmail: $email \nPhone: $phone \nMessage: $message";
  }
  if($error != ''){
    require 'class/class.phpmailer.php';
    $mail = new phpmailer;
    $mail->isSMTP();
    $mail->Host = 'smtpout.secureserver.net'; 
    $mail->Port = '587'; //80
    $mail->SMTPAuth = true;
    $mail->Username = '';
    $mail->Password = '';
    $mail->SMTPSecure = '';
    $mail->From = $_POST["$email"];
    $mail->Fromname = $_POST["$name"];
    $mail->AddAddress('gabrielacristinaschmitt@gmail.com', 'Name');
    $mail->AddCC($_POST["$email"]), $_POST[$name]);
    $mail->WordWrap = 50;
    $mail->isHtml(true);
    $mail->Subject = $_POST["$subject"];
    $mail->Body = $_POST["$content];
    if($mail->Send()){
      $error = '<label class="text-success">Obrigado por contatar-nos! Responderemos assim que possível</label>';
    }else{
      $error = '<label class="text-danger">Erro no envio. Tente contatar-nos por nossas redes, ou presencialmente. Obrigado pela compreensão.</label>';
    }
    $name = '';
    $surname = '';
    $email = '';
    $phone = '';
    $subject = '';
    $message = '';
  }
}
?>