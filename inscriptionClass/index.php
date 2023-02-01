<?php

	class Verifier {
		public static function syntaxeEmail($email) {
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return true;
			} else {
				return false;
			}
		}

		public static function doubleEmail($email) {
			try {
				$bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', 'root');
				$requete = $bdd->prepare('SELECT COUNT(*) AS nombre FROM utilisateurs WHERE email = ? ');
				$requete->execute([$email]);

				while($resultat = $requete->fetch()) {
					if($resultat["nombre"] > 0) {
						return true;
					} else {
						return false;
					}
				}
			} catch (Exception $e) {
				die('Error :'. $e->getMessage());
			}
			
		}
	}

	class Securite {
		public static function chiffrer($password) {
			return password_hash($password, PASSWORD_DEFAULT);
		}
	}

	

	if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['pseudo'])) {
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);
		$pseudo = htmlspecialchars($_POST['pseudo']);

		if(!Verifier::syntaxeEmail($email)) {
			header('location: index.php?error=true&message=Veuillez vérifier votre adresse mail');
			exit();
		}

		if(Verifier::doubleEmail($email)) {
			header('location: index.php?error=true&message=Votre adresse mail est déjà utilisé');
			exit();
		}
		$password = Securite::chiffrer($password);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/default.css">
	<title>Mon Site PHP</title>
</head>
<body>

	<section class="container">
		
		<form method="post" action="index.php">

			<p>Incription</p>

			<?php if(isset($_GET['success'])) {
				echo '<p class="alert success">Inscription réalisée avec succès.</p>';
			}
			else if(isset($_GET['error']) && !empty($_GET['message'])) {
				echo '<p class="alert error">'.htmlspecialchars($_GET['message']).'</p>';
			} ?>

			<input type="text" name="pseudo" id="pseudo" placeholder="Pseudo"><br>
			<input type="email" name="email" id="email" placeholder="Email"><br>
			<input type="password" name="password" id="password" placeholder="Mot de passe"><br>
			<input type="submit" value="Inscription">
		
		</form>

		<div class="drop drop-1"></div>
		<div class="drop drop-2"></div>
		<div class="drop drop-3"></div>
		<div class="drop drop-4"></div>
		<div class="drop drop-5"></div>
	</section>

</body>
</html>