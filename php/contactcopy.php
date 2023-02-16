<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Connexion à la base de données
$host = "localhost:3306";
$dbname = "sjxq5813_portfolio";
$user = "sjxq5813_ludwig";
$mdp = "ludwig971";
try {
    $db = new PDO("mysql:host={$host};dbname={$dbname}", $user, $mdp);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo '<pre>';
    // var_dump($db);
    // echo '</pre>';
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if (isset($_POST['envoyer'])) {
    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';
    $nom = htmlspecialchars($_POST['nom'] ?? '');
    $prenom = htmlspecialchars($_POST['prenom'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    $PDOStatement = $db->prepare('INSERT INTO `contacts` (`nom`, `prenom`, `email`, `message`) VALUES (:nom, :prenom, :email, :message)');
    $PDOStatement->bindParam(':nom', $nom);
    $PDOStatement->bindParam(':prenom', $prenom);
    $PDOStatement->bindParam(':email', $email);
    $PDOStatement->bindParam(':message', $message);

    if ($PDOStatement->execute()) {
        header("Location: ../index.php?send=success");
        exit();
    }
}

header("Location: ../index.php?send=error");
exit();
