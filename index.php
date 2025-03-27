<?php

require_once "inc/functions.inc.php";

// if (isset($_GET['action']) && isset($_GET['id'])) {


//     if (!empty($_GET['action']) && $_GET['action'] == "show" && !empty($_GET['id'])) {

//         // $idFilm = htmlspecialchars($_GET['id']); // id qu'on a récupéré dans l'url avec $_GET
//         // $filmBdd = showIdFilm($idFilm);
//         $allFilms = allFilms();
//         // var_dump($idFilm, $filmBdd);
//         // die();

//     }
// }

// $allFilms = allFilms();

$totalFilms = countFilms();

$filmsToShow = all6Films();

if (!empty($_GET['action']) && $_GET['action'] == "showall") {
    $filmsToShow = allFilms();
}



debug($_POST);
require_once "inc/header.inc.php";

// debug($_SESSION['client']);
// debug($_SESSION['panier']);
?>


<div class="films">
    <h2 id="messagePlusNbFilms" class="fw-bolder fs-1 mx-5 text-center mt-5"> Message : ; Nombre de films : <?= $totalFilms ?> </h2> <!-- Affiche le message et le nombre de films-->
<?php foreach($filmsToShow as $film) : ?>
    
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                
                <div class="card">
                    <img src="<?=RACINE_SITE?>assets/img/<?= $film['image'] ?>" alt="image du film"> <!-- Affiche l'image du film -->
                    <div class="card-body">
                        <h3><?= html_entity_decode($film['title']) ?></h3> <!-- Affiche le titre du film -->
                        <h4><?= html_entity_decode($film['director']) ?></h4> <!-- Affiche le réalisateur du film -->
                        <p><span class="fw-bolder">Résumé:</span><?= html_entity_decode(substr(ucfirst($film['synopsis']), 0, 500)) . "..." ?></p> <!-- Affiche un résumé du film -->
                        <a href="showFilm.php?action=show&id=<?= $film['id_film'] ?>" class="btn">Voir plus</a> <!-- Lien pour voir plus de détails -->
                    </div>
                </div>
                
            </div>
        </div>
<?php endforeach; ?>
        <div class="col-12 text-center">
            <a href="index.php?action=showall" class="btn p-4 fs-3">Voir plus de films</a> <!-- Lien pour voir plus de films -->
        </div>
   </div>







<?php

require_once "inc/footer.inc.php";

?>