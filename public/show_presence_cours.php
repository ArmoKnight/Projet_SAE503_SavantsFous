<?php

/**
 * Delete a user
 */

require "../config.php";
require "../common.php";

$success = null;
//$presence = array();
$C=$_SESSION["Cours"];

try {

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT Presence FROM Cours";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $R = $statement->fetchAll();
  //print_r($R);
  //echo $R[0]["Presence"];
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}

$str=$R[0]["Presence"];

if(!empty($str)){
   $arrayOfStrings = explode(",",$str);
   $arrayOfIntegers = array_map('intval', $arrayOfStrings);
 }
print_r($arrayOfIntegers);

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();


  $str1=$R[0]["Presence"];

 if(!empty($str1)){
    $arrayOfStrings = explode(",",$str1);
    $arrayOfIntegers = array_map('intval', $arrayOfStrings);
  }
  print_r($arrayOfIntegers);

  if (!in_array($_POST["submit"], $arrayOfIntegers)) {
    try {

      $connection = new PDO($dsn, $username, $password, $options);
      
      $presence = $_POST["submit"];
      //echo $presence;
  
      $sql = "UPDATE Cours SET Presence = CONCAT(Presence,$presence,',') WHERE id_cours = $C;";
    
      $statement = $connection->prepare($sql);
      $statement->execute();
    
      $result = $statement->fetchAll();
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  
  }

  
/*

  if (!in_array($_POST["submit"], $presence)) {
    $presence[] = $_POST["submit"];
  }

*/
}

try {

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM utilisateur JOIN Classe ON utilisateur.Classe_ID = Classe.id_class;";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}

try {

  $connection = new PDO($dsn, $username, $password, $options);
  $C=$_SESSION["Cours"];

  $sql = "SELECT * FROM Cours JOIN Classe ON Cours.id_classe = Classe.id_class JOIN utilisateur ON Cours.id_prof = utilisateur.id_user WHERE $C=id_cours;";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $Cours = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<table>
    <thead>
      <tr>
        <th>Classe</th>
        <th>Salle</th>
        <th>Professeur</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($Cours as $row) : ?>
      <tr>
        <td><?php echo escape($row["Nom_Classe"]); ?></td>
        <td><?php echo escape($row["Salle"]); ?></td>
        <td><?php echo escape($row["Nom"])," ",escape($row["Prenom"]); ?></td>
    <?php endforeach; ?>
    </tbody>
  </table>
        
<h2>Eleves</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Classe</th>
        <th>Mail</th>
        <th>Présence</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["id_user"]); ?></td>
        <td><?php echo escape($row["Nom"]); ?></td>
        <td><?php echo escape($row["Prenom"]); ?></td>
        <td><?php echo escape($row["Nom_Classe"]); ?></td>
        <td><?php echo escape($row["Mail"]); ?></td>
        <?php if (in_array($row["id_user"], $arrayOfIntegers)){ ?>
        <td>Présent</td>
        <?php }else{?>
          <td>Absent</td>
        <?php } ?>
        <?php if ($_SESSION['Role']=="Etudiant" && $_SESSION['id_user']==$row["id_user"]){ ?>
        <td><button type="submit" name="submit" value="<?php echo escape($row["id_user"]); ?>">Présent</button></td>
        <?php }?>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>