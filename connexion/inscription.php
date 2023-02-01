<?php
	if(!empty($_POST['password']) && !empty($_POST['email'])) {
		$email = htmlspecialchars($_POST['email']);
    	$password = htmlspecialchars($_POST['password']);
		$verificationInscription = false;
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header('location: inscription.php?error=1&message=Votre adresse email est invalide.');
			exit();
		}

		try {
			$bdd = new PDO('mysql:host=localhost;dbname=netflix;charset=utf8', 'root', 'root');
			$requete = $bdd->prepare('SELECT COUNT(*) as numberEmail FROM user WHERE email = ?');
			$requete->execute([$email]);

			while($resultat = $requete->fetch()) {
				if(!$resultat['numberEmail'] > 0) {
					$inscription = $bdd->prepare('INSERT INTO `user` (`email`, `password`, `secret`) VALUES (?, ?, ?)');
					$inscription->execute([ $email, password_hash($password, PASSWORD_DEFAULT), rand()]);
				} else {
					$verificationInscription = true;
				}
			}
		} catch(Exception $e) {
  			echo "Error: " . $e->getMessage();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Netflix</title>
	<link rel="stylesheet" type="text/css" href="design/default.css">
	<link rel="icon" type="image/pngn" href="img/favicon.png">
</head>
<body>

	<?php include('src/header.php'); ?>
	
	<section>
		<div id="login-body">
			<h1>S'inscrire</h1>

			<form method="post" action="inscription.php">
				<input type="email" name="email" placeholder="Votre adresse email" required />
				<input type="password" name="password" placeholder="Mot de passe" required />
				<input type="password" name="password_two" placeholder="Retapez votre mot de passe" required />
				<button type="submit">S'inscrire</button>
				<?= $verificationInscription ? '<p>Vous êtes déjà inscrits</p>' : '' ?>
			</form>

			<p class="grey">Déjà sur Netflix ? <a href="index.php">Connectez-vous</a>.</p>
		</div>
	</section>

	<?php include('src/footer.php'); ?>
</body>
</html>