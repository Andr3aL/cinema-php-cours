<?php

require_once "inc/functions.inc.php";

// debug($_GET);
debug($_SESSION['client']); // pour savoir avec quel compte on est connecté (dans la page profil car on parle du compte avec lequel on est connecté)
debug($_SESSION['panier']);

if (!isset($_SESSION['client'])) {
    header('location:authentication.php');
}

require_once "inc/header.inc.php";
?>


<div class="mx-auto p-2 row flex-column align-items-center">
    <h2 class="text-center mb-5">Bonjour <?= $_SESSION['client']['firstName'] ?></h2>
    <div class="cardFilm">
        <div class="image">

        


<!-- Première façon d'afficher l'image en fonction du sexe -->

    <!-- <?php 
    //if ($_SESSION['client']['civility'] == 'h') {
    ?>
        <img id="imageProfil" src="<?=RACINE_SITE?>assets/img/avatar_h.png" alt="Image avatar de l'utilisateur">

    <?php
    //} else {
    ?>
        <img src="<?=RACINE_SITE?>assets/img/avatar_f.png" alt="Image avatar de l'utilisateur">

    <?php
    //}
    ?> -->

<!-- Deuxième façon d'afficher l'image en fonction du sexe -->

    <img src="assets/img/<?= $_SESSION['client']['civility'] == 'f' ? 'avatar_f.png' : 'avatar_h.png' ;?>" alt="Image avatar de l'utilisateur">




            <div class="details">
                <div class="center ">

                    <table class="table">
                        <tr>
                            <th scope="row" class="fw-bold">Nom </th>
                            <td><?= $_SESSION['client']['lastName'] ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Prenom </th>
                            <td><?= $_SESSION['client']['firstName'] ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Pseudo </th>
                            <td colspan="2"><?= $_SESSION['client']['pseudo'] ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">email </th>
                            <td colspan="2"><?= $_SESSION['client']['email'] ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Tel </th>
                            <td colspan="2"><?= $_SESSION['client']['phone'] ?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Adresse </th>
                            <td colspan="2"><?= $_SESSION['client']['address'] ?>  <?= $_SESSION['client']['zip'] ?> <?= $_SESSION['client']['city'] ?> <?= $_SESSION['client']['country'] ?></td>

                        </tr>

                    </table>
                    <a href="" class="btn mt-5">Modifier vos informations</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

require_once "inc/footer.inc.php";

?>