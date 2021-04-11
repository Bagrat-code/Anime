<x-layout>
  <x-slot name="title">
    Nouvelle critique de {{ $anime->title }}
  </x-slot>

  <h1>Nouvelle Critique de {{ $anime->title }}</h1>

  <form method="post"> 
  {{-- Le @csrf permet de se protéger d'une faille de sécurité dans l'authentification. Cela évite qu'une personne puisse accéder à notre compte. Il a également réglé le soucis Page Expired--}}
  @csrf  
  
  <label for="critique">Partage ton avis</label>
 <textarea class="cta" name="critique" id="critique" rows="7" cols="45" required></textarea>

<label for="critique">Donne une note entre 0 et 10</label>
 <input class= "cta " type="number" id="note" name="note"
       min="0" max="10" required>
 <button class="cta" type="submit"> Partager</button>
 
</form>
</x-layout>

<?php

try
{
    $bdd = new PDO("mysql:host=localhost;dbname=animes", "root", ""); 
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->exec('SET NAMES utf8');
}
    catch(PDOException $e){
      echo "Erreur : " . $e->getMessage();
    }
    
    if (isset($_POST['critique'])) {
$critique =  addslashes($_POST['critique']);

if (isset($_POST['note'])) {
  $note =  addslashes($_POST['note']);

    
$sql = "INSERT INTO review(rating, comment, user_id, anime_id) 
          VALUES ( '".$note."', '".$critique."',  '".Auth::user()->id."' ,  '".$anime->id."')";
          header("");

          try {
            $bdd->exec($sql); 
          }
            catch(PDOException $e) {
              echo "Erreur : " . " Vous avez déjà posté une critique pour cet anime";
            }
}
    }

  if (isset($bdd)) {
// Affiche le commentaire et la note sur la page de l'anime appropriée
  $reponse = $bdd->query ('SELECT comment, rating FROM review WHERE anime_id = "'.$anime->id.'" ORDER BY ID DESC');

    while ($donnees = $reponse->fetch())
{
	echo '<div class="cta"><strong>' . htmlspecialchars($donnees['comment']) .  ' Note: ' . htmlspecialchars($donnees['rating']) . ' / 10 ' . '</strong>  </div>';
  echo '<br>';
  echo '<br>'; 
}

$reponse->closeCursor();
  }

    ?>


