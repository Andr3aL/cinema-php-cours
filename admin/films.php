<?php

require_once "../inc/functions.inc.php";




if (!isset($_SESSION['client'])) {
    header('location:'.RACINE_SITE.'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") {
        header('location:'.RACINE_SITE.'profil.php');
    }
}

$info = "";




require_once "../inc/header.inc.php";

?>




<div class="d-flex flex-column m-auto mt-5">
    
    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>

    <?= $info ?>

    <a href="gestion_film.php" class="btn align-self-end"> Ajouter un film</a>
    <table class="table table-dark table-bordered mt-5 " >
            <thea>
                    <tr >
                    <!-- th*7 -->
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Affiche</th>
                        <th>Réalisateur</th>
                        <th>Acteurs</th>
                        <th>Àge limite</th>
                        <th>Genre</th>
                        <th>Durée</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Synopsis</th>
                        <th>Date de sortie</th>
                        <th>Supprimer</th>
                        <th> Modifier</th>
                    </tr>
            </thea>
            <tbody>

            <?php

                


                $films = allFilms();
                foreach ($films as $film) {

               $actors = explode("/", $film['actors']);
          

            ?>
              
                        <tr>

                            <!-- Je récupére les valeus de mon tabelau $film dans des td -->
                            <td><?= $film['id_film'] ?></td>
                            <td><?= ucfirst($film['title']) ?></td>
                            <td><img src="<?=RACINE_SITE?>assets/img/<?= $film['image'] ?>" alt="affiche du film" class="img-fluid"></td>
                            <td><?= html_entity_decode($film['director']) ?></td>
                            <td> 
                                <ul>

                                <?php
                                    foreach ($actors as $actor) {
                                ?>

                                        <li><?= $actor ?></li>

                                <?php 
                                    }
                                ?>
        
                                </ul>
                            </td>
                            <td><?= html_entity_decode($film['ageLimit']) ?></td>
                            <td><?= html_entity_decode($film['category_id']) ?></td>
                            <td><?= html_entity_decode($film['duration']) ?></td>
                            <td><?= html_entity_decode($film['price']) ?>€</td>
                            <td><?= html_entity_decode($film['stock']) ?></td>
                            <td><?= html_entity_decode(substr(ucfirst($film['synopsis']), 0, 100)) . "..." ?></td>
                            <td><?= html_entity_decode($film['date']) ?></td>
                            <td class="text-center"><a href="films.php?action=delete&id=<?= $film['id_film'] ?>" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer ce film ?'))"><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href="filmForm.php?action=update&id=<?= $film['id_film'] ?>"><i class="bi bi-pen-fill"></i></a></td>
                           
                        </tr>


                    <?php
               
            }

                ?>


            </tbody>
            

    </table>


</div>




<?php


require_once "../inc/footer.inc.php";


?>