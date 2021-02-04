<?php
if(isset($_POST['submit'])){
$dossier = 'images/';
$fichier = basename($_FILES['file']['name']);
$newName = $_POST['userFisrtname'].date('m_d_y_H_i_s');
$taille_maxi = 100000;
$taille = filesize($_FILES['file']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
$extension = strrchr($_FILES['file']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     if(move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $newName. $extension)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {  
        //affichage du profile
        echo '<h1>Profile</h1>';
        echo '<h1>Bonjour '.$_POST['civilite'].' '. $_POST['userFisrtname'].' '.$_POST['userLastname'].' vous êtes né '.$_POST['date'].'</h1>';
        echo '<img src="'.$dossier . $newName.$extension.'" style="width:600px;">';

     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else
{
     echo $erreur;
}
    
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form class="mt-5" method="POST" action="upload.php" enctype="multipart/form-data">
        <legend class="col-form-label col-sm-2 pt-0">Civilité :</legend>
            <div class="col-sm-10">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="civilite"value=" Mr" checked>
                <label class="form-check-label" for="gridRadios1">
                    Mr
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="civilite" value="Mme">
                <label class="form-check-label" for="gridRadios2">
                    Mme
                </label>
                </div>
            <div class="form-group">
                <label for="userFisrtname">Nom :</label>
                <input type="text" class="form-control" name="userFisrtname" placeholder="Enter votre Nom">
            </div>
            <div class="form-group">
                <label for="userLastname">Prenom :</label>
                <input type="text" class="form-control"name="userLastname" placeholder="Enter votre Prenom">
            </div>
            <div class="form-group">
                <label for="date" class="col-2 col-form-label">Date :</label>
                <input class="form-control" type="date" name="date">
            </div>
            <!-- On limite le fichier à 100Ko -->
            <input type="hidden" name="MAX_FILE_SIZE" value="100000">
            Fichier : <input type="file" name="file">
            <input class="mt-3" type="submit" name="submit" value="Envoyer le fichier">
        </form>
        </div>
</body>
</html>
<?php   
}
?>