<?php
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