<x-layout>
<h1>Watchlist</h1>
<h3>Quand je ne sais pas quoi regarder</h3>
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

    if (isset($anime->id)) {
  
    $sql = "INSERT INTO watchlist(user_id, anime_id) 
          VALUES (  '".Auth::user()->id."' ,  '".$anime->id."')";
          header("");

          try {
            $bdd->exec($sql); 
          }
            catch(PDOException $e) {
              echo "Erreur : " . " Vous avez déjà ajouter cet anime dans votre watchlist.";
            }
        };

        if (isset($bdd)) {
//      Affiche la watchlist en fonction de l'utilisateur connecté
        $reponse = $bdd->query("SELECT cover FROM watchlist INNER JOIN animes ON animes.id = watchlist.anime_id WHERE user_id = ".Auth::user()->id." ORDER by watchlist.id DESC ");

        while ($donnees = $reponse->fetch())
          {
            echo  "<img style ='width:320px; margin:30px' src='/covers/".htmlspecialchars($donnees['cover'])."' />";
            echo '<br>';                                                                                   
}
      $reponse->closeCursor();
      } 
        ?>

