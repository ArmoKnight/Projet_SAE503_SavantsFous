<?php 
	require "../config.php";
	require "../common.php";
?>


<?php include "templates/header.php"; ?>

<ul>
	<li><a href="create.php"><strong>Create</strong></a> - add a user</li>
	<li><a href="read.php"><strong>Read</strong></a> - find a user</li>
	<li><a href="update.php"><strong>Update</strong></a> - edit a user</li>
	<li><a href="show_user.php"><strong>Afficher les utilisateurs</strong></a></li>
	<li><a href="show_class.php"><strong>Afficher les classe</strong></a></li>
	<li><a href="show_cours.php"><strong>Afficher les cours</strong></a></li>
	<li><a href="logout.php"><strong>Deconnexion</strong></a></li>
</ul>

<?php include "templates/footer.php"; ?>