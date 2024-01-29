<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $email=$_POST['mail'];
    $mdp=$_POST['mdp'];

    $sql = "SELECT * FROM utilisateur;";
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  if($email == $result["Mail"] && $mdp == $result["mdp"]){
    $_SESSION['id_user'] = $result['id_user'];
    $_SESSION['Nom'] = $result['Nom'];
    $_SESSION['Prenom'] = $result['Prenom'];
    $_SESSION['Mail'] = $result['Mail'];
    $_SESSION['Role'] = $result['Role'];

    
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
