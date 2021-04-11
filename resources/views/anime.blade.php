<x-layout>
  <x-slot name="title">
    {{ $anime->title }}
  </x-slot>

  <article class="anime">
    <header class="anime--header">
      <div>
        <img alt="" src="/covers/{{ $anime->cover }}" />
      </div>
      <h1>{{ $anime->title }}</h1>
    </header>

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
    // Dans ce cas, la function ROUND permet d'obtenir la moyenne en retournant le résultat 1 chiffre après la virgule
        $reponse = $bdd->query("SELECT ROUND(AVG(rating), 1) as note FROM review WHERE anime_id = '".$anime->id."' ");
        while ($donnees = $reponse->fetch())
        {
          echo '<div><strong> La moyenne générale de l\'anime est de <div class="cta">' .  $donnees['note'] . '</div></div>' ;
          echo '<br>';
        }
        $reponse->closeCursor();
  ?>


    <p>{{ $anime->description }}</p>
    <br>
    
    <div>
      <div class="actions">
        <div>
          <a class="cta" href="/anime/{{ $anime->id }}/new_review">Écrire une critique</a>
        </div>
        <form action="/anime/{{ $anime->id }}/add_to_watch_list" method="POST">
        @csrf  
          <button  type="submit" class="cta">Ajouter à ma watchlist</button>
        </form>
      </div>
    </div>
  </article>
</x-layout>
