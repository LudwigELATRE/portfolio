<?php


    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['message'])){
        if(isset($message)){
            $info = "Ce message vous a été envoyé via la page contact du site el-dev.fr
            Nom : " .$nom "
            Prenom : " .$prenom "
            Email : " .$email "
            Message : " .$message;
            $retour = mail(ludwig.elatre@outlook.com, $nom, $prenom, $message, "FROM:contact@el-dev.fr\r\nReplay-to" .$email );
            if($retour){
                echo "<p>L'email a bien été envoyé.</p>"
            }else{
                echo "<p>L'email n'a pas été envoyé.</p>"
            }
        }
    }
    
    /*PHPMailer */
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;
    
    // require '/home/cpanelusername/PHPMailerTest/PHPMailer/src/Exception.php';
    // require '/home/cpanelusername/PHPMailerTest/PHPMailer/src/PHPMailer.php';
    // require '/home/cpanelusername/PHPMailerTest/PHPMailer/src/SMTP.php';
    
    // // Instantiation and passing [ICODE]true[/ICODE] enables exceptions
    // $mail = new PHPMailer(true);
    
    // try {
    //  //Server settings
    //  $mail->SMTPDebug = 2; // Enable verbose debug output
    //  $mail->isSMTP(); // Set mailer to use SMTP
    //  $mail->Host = 'smtp1.example.com;smtp2.example.com'; // Specify main and backup SMTP servers
    //  $mail->SMTPAuth = true; // Enable SMTP authentication
    //  $mail->Username = 'user@example.com'; // SMTP username
    //  $mail->Password = 'jrnU-TeVV-dSg@'; // SMTP password
    //  $mail->SMTPSecure = 'tls'; // Enable TLS encryption, [ICODE]ssl[/ICODE] also accepted
    //  $mail->Port = 587; // TCP port to connect to
    
    // //Recipients
    //  $mail->setFrom('from@example.com', 'Mailer');
    //  $mail->addAddress('recipient1@example.net', 'Joe User'); // Add a recipient
    //  $mail->addAddress('recipient2@example.com'); // Name is optional
    //  $mail->addReplyTo('info@example.com', 'Information');
    //  $mail->addCC('cc@example.com');
    //  $mail->addBCC('bcc@example.com');
    
    // // Attachments
    //  $mail->addAttachment('/home/cpanelusername/attachment.txt'); // Add attachments
    //  $mail->addAttachment('/home/cpanelusername/image.jpg', 'new.jpg'); // Optional name
    
    // // Content
    //  $mail->isHTML(true); // Set email format to HTML
    //  $mail->Subject = 'Here is the subject';
    //  $mail->Body = 'This is the HTML message body <b>in bold!</b>';
    //  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    // $mail->send();
    //  echo 'Message envoyé';
    
    // } catch (Exception $e) {
    //  echo "Le message ne peut être envoyé. Mailer Error: {$mail->ErrorInfo}";
    // }

/*Envoie des element du formulaire dans la base de donnée Mysql */
    //Affichage des erreurs
    error_reporting(E_ALL);
    ini_set('display_error', TRUE);
    ini_set('display_startup_errors',  TRUE);
    echo '<pre>';
var_dump($_POST);
echo '</pre>';
    /* on se connecte à la base de données*/
    $host = "localhost:8889"; $dbname = "portfolio"; $user = "root"; $mdp = "root";
    try{
        $db=new PDO("mysql:host={$host};dbname={$dbname}", $user, $mdp);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // foreach ($db->query('SELECT * FROM contact') as $row){
        //     print_r($row);
        // }
    }catch(PDOException $e){
        die("une erreur a été trouvée : " .$e->getMessage());
    }

    //----------------------------------------------------------------------------------
    if(isset($_POST['envoyer'])){
        /*Si la variable $_Post['truc'] exist, alors $truc=$_POST['truc'] sinon elle vaut NULL */
        extract($_POST);
        $error = "";
       (!empty($_POST['nom']) ? $nom = htmlspecialchars($_POST['nom']) : $error .= 'erreur nom <br>');
       (!empty($_POST['prenom']) ? $prenom = htmlspecialchars($_POST['prenom']) : $error .= 'erreur prenom <br>');
       (!empty($_POST['email']) ? $email = htmlspecialchars($_POST['email']) : $error .= 'erreur email <br>');
       (!empty($_POST['message']) ? $message = htmlspecialchars($_POST['message']) : $error .= 'erreur message <br>');

       
            $PDOStatement=$db->prepare('INSERT INTO `contact`(`id`,`nom`, `prenom`, `message`, `mail`) VALUES (:id,:nom,:prenom,:message,:mail)');



        /*l'insertion se fait avec les parametres <binParam></binParam>*/

        //On renvoie l'utilisateur vers la page de remerciement
        // $PDOStatement->bindParam(':nom', $nom);
        // $PDOStatement->bindParam(':prenom', $prenom);
        // $PDOStatement->bindParam(':mail', $email);
        // $PDOStatement->bindParam(':message', $message);
        $PDOStatement->execute([
            'id'    => null,
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $email,
            'message' => $message
        ]); 

        header("Location:../index.php?send=success");
        exit();

    }else{
        header("Location:../index.php?send=error");
        exit(); 
    }


    // if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['message'])){
    //     if(isset($message)){
    //         $info = "Ce message vous a été envoyé via la page contact du site el-dev.fr
    //         Nom : " .$nom "
    //         Prenom : " .$prenom "
    //         Email : " .$email "
    //         Message : " .$message;
    //         $retour = mail(ludwig.elatre@outlook.com, $nom, $prenom, $message, "FROM:contact@exemple.fr\r\nReplay-to" .$email );
    //         if($retour){
    //             echo "<p>L'email a bien été envoyé.</p>"
    //         }
    //     }
    // }