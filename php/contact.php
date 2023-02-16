<?php
    $nom = htmlspecialchars($_POST['nom']);    //variable nom
    $prenom = htmlspecialchars($_POST['prenom']);    //variable prenom
    $email = htmlspecialchars($_POST['email']);    //variable mail
    $message = htmlspecialchars($_POST['message']);  
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';//variable message

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.el-dev.fr';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'contact@el-dev.fr';                     //SMTP username
        $mail->Password   = 'Q0cPwcBdXN0d';
        // PHPMailer::ENCRYPTION_SMTPS                               //SMTP password
        $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('contact@el-dev.fr', 'el-dev');
        $mail->addAddress($_POST['mail']);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Envoie de la demande';
        $mail->Body    = 'Votre messgae à bien été envoyé. Je vous rendrais dans les plus <b>bref delais!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

if($mail){
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
       (!empty($_POST['nom']) ? $nom : $error .= 'erreur nom <br>');
       (!empty($_POST['prenom']) ? $prenom : $error .= 'erreur prenom <br>');
       (!empty($_POST['email']) ? $email : $error .= 'erreur email <br>');
       (!empty($_POST['message']) ? $message : $error .= 'erreur message <br>');

       
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
    }
        //else{
        // echo "Erreur il y a un probleme"
        // }
