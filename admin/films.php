<?php

require_once "../inc/functions.inc.php";




if (!isset($_SESSION['client'])) {
    header('location:'.RACINE_SITE.'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") {
        header('location:'.RACINE_SITE.'profil.php');
    }
}





require_once "../inc/header.inc.php";

?>




<div class="d-flex flex-column m-auto mt-5">
    
    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>
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

              
                        <tr>

                            <!-- Je récupére les valeus de mon tabelau $film dans des td -->
                            <td></td>
                            <td> </td>
                            <td> <img src="" alt="affiche du film" class="img-fluid"></td>
                            <td> </td>
                            <td> 
                                <ul>
                                
                                    <li></li>
                          
                               
                                </ul>
                            </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> €</td>
                            <td> </td>
                            <td> ...</td>
                            <td> </td>
                            <td class="text-center"><a href=""><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href=""><i class="bi bi-pen-fill"></i></a></td>
                           
                        </tr>


                    <?php
               


                ?>


            </tbody>
            

    </table>


</div>




<?php


require_once "../inc/footer.inc.php";


?>