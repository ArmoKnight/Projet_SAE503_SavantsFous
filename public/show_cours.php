<?php

/**
 * Delete a user
 */

require "../config.php";
require "../common.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  $_SESSION["Cours"] = $_POST["submit"];

  header("Location: show_presence_cours.php");

}
try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM Cours JOIN Classe ON Cours.id_classe = Classe.id_class;";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM utilisateur JOIN Classe ON utilisateur.Classe_ID = Classe.id_class ;";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $student = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Delete users</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Matière</th>
        <th>Salle</th>
        <th>Classe</th>
        <th>Heure de début</th>
        <th>Heure de Fin</th>
        <th>Date</th>
        <th>Afficher</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["id_cours"]); ?></td>
        <td><?php echo escape($row["Matiere"]); ?></td>
        <td><?php echo escape($row["Salle"]); ?></td>
        <td><?php echo escape($row["Nom_Classe"]); ?></td>
        <td><?php echo escape($row["heure_debut"]); ?></td>
        <td><?php echo escape($row["heure_fin"]); ?></td>
        <td><?php echo escape($row["Date"]); ?></td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["id_cours"]); ?>">Afficher</button></td>
      </tr>
      <!--
      <br>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Classe</th>
            <th>Mail</th>
            <th>Rôle</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($student as $row) : ?>
          <tr>
            <td><?php echo escape($row["id_user"]); ?></td>
            <td><?php echo escape($row["Nom"]); ?></td>
            <td><?php echo escape($row["Prenom"]); ?></td>
            <td><?php echo escape($row["Nom_Classe"]); ?></td>
            <td><?php echo escape($row["Mail"]); ?></td>
            <td><?php echo escape($row["Role"]); ?></td>
            <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete</button></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>-->
      <?php endforeach; ?>
        
        </tbody>
  </table>

</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>