<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
session_start();

if (empty($_SESSION['csrf'])) {
	if (function_exists('random_bytes')) {
		$_SESSION['csrf'] = bin2hex(random_bytes(32));
	} else if (function_exists('mcrypt_create_iv')) {
		$_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	} else {
		$_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
	}
}
function escape($html) {
  return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}


if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $email=$_POST['mail'];
    $mdp=$_POST['mdp'];

    $sql = "SELECT * FROM utilisateur WHERE Mail = '$email';";

    
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);

    $result = $statement->fetchAll();

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  if($email == $result["0"]["Mail"] && $mdp == $result["0"]["mdp"]){
    $_SESSION['id_user'] = $result["0"]['id_user'];
    $_SESSION['Nom'] = $result["0"]['Nom'];
    $_SESSION['Prenom'] = $result["0"]['Prenom'];
    $_SESSION['Mail'] = $result["0"]['Mail'];
    $_SESSION['Role'] = $result["0"]['Role'];

    echo $_SESSION['id_user'];
    echo $_SESSION['Nom'];
    echo $_SESSION['Prenom'];
    echo $_SESSION['Mail'];
    echo $_SESSION['Role'];

    header("Location: index.php");
  }
}
?>
<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
<?php endif; ?>

<h2>Add a user</h2>


<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="mail">Email</label>
  <input type="text" name="mail" id="mail">
  <label for="mdp">Mot de passe</label>
  <input type="text" name="mdp" id="mdp">
  <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
