<x-layout>
<h1>Top</h1>
<h3>Le meilleur de l'animation</h3>
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

    if (isset($bdd)) {
        // Liste la moyenne de chaque anime, de la + élevée à la - élevée
        $reponse = $bdd->query("SELECT ROUND(AVG(rating), 1) as note, title, cover FROM review INNER JOIN animes WHERE review.anime_id = animes.id GROUP BY anime_id ORDER by note DESC ");
          while ($donnees = $reponse->fetch())
      {
        echo '<div style="margin: 30px"; class="cta"><strong>'  . htmlspecialchars($donnees['title']) . " => ".  htmlspecialchars($donnees['note']) . "  </strong></div> <img style ='width:320px; margin: 30px' src='/covers/".htmlspecialchars($donnees['cover'])."' />";
        echo '<br>';                                                                                    
      }
      $reponse->closeCursor();
        } 
?>


                                                                                         















