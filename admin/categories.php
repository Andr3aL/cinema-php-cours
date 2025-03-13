<?php

require_once "../inc/functions.inc.php";

$info = "";



if (!isset($_SESSION['client'])) {
    header('location:' . RACINE_SITE . 'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") {
        header('location:' . RACINE_SITE . 'profil.php');
    }
}

if (!empty($_POST)) {

    $verif = true;
    foreach ($_POST as $key => $value) { // je prend les valeurs de mon tableau en le parcourant

        if (empty(trim($value))) { // si une de ces valeurs est vide, je passe verif en false
            $verif = false;
        }
    }

    if ($verif === false) {

        $info = alert("Veuillez renseigner tous les champs", "danger");
    } else {

        if (!isset($_POST['name']) || strlen($_POST['name']) < 3 || preg_match("/[0-9]/", $_POST['name'])) {

            $info = alert("Le champ nom de la catégorie n'est pas valide", "danger");
        }

        if (!isset($_POST['description']) || strlen($_POST['description']) < 20) {

            $info .= alert("Le champ description de la catégorie n'est pas valide", "danger"); // la concaténation des alert() permet de les afficher tous en même temps quand les 2 sont conditions sont d'erreurs sont remplies

        } elseif ($info == "") {
            // stockage des données à insérer dans des variables
            $name = trim(htmlspecialchars($_POST['name']));
            $description = trim(htmlspecialchars($_POST['description']));
            $categoryBdd = showCategory($name);

            if ($categoryBdd) {

                $idCategory = $_GET['id_categorie'];
                updateCategory($idCategory, $name, $description);
                // $info = alert("La catégorie existe déjà", "danger");
            } else {
                addCategory($name, $description);
            }
        }
    }
}













$categories = allCategory();
// debug($categories);

if (isset($_GET['action']) && isset($_GET['id_categorie'])) { // on vérifie si y'a déjà une action

    $idCategory = htmlspecialchars($_GET['id_categorie']);

    // $nameCategory = $_POST['name'];
    // $descCategory = $_POST['description'];
    // $selectCategory = selectCategory($idCategory, $nameCategory, $descCategory);

    $categoryBdd = showIdCategory($idCategory);

    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id_categorie'])) { // $_GET['id'] ici, c'est l'id qui passe par l'url


        $idCategory = htmlspecialchars($_GET['id_categorie']);
        $showCategory = showIdCategory($idCategory);


    }

    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id'])) {


        deleteCategory($idCategory);
    }

    header('location:categories.php'); // redirection pour rester sur le même fichier (header ici est une fonction déjà définie dans php)
}








require_once "../inc/header.inc.php";



?>

<div class="row mt-5" style="padding-top: 8rem;">
    <div class="col-sm-12 col-md-6 mt-5">
        <h2 class="text-center fw-bolder mb-5 text-danger">Gestion des catégories</h2>

        <!-- $info ici sert à afficher les messages d'erreur -->

        <?= $info ?>


        <form action="" method="post" class="back">

            <div class="row">
                <div class="col-md-8 mb-5">
                    <label for="name" class="text-white">Nom de la catégorie</label>

                    <?php
                    // if (empty($_GET['id'])) {
                    ?>
                        <!-- <input type="text" id="name" name="name" class="form-control" value=""> -->
                    <?php
                    // } else {
                    ?>
                        <input type="text" id="name" name="name" class="form-control" value="<?= $showCategory['name'] ?? '' ?>">
                    <?php
                    // }
                    ?>
                    <!-- <input type="text" id="name" name="name" class="form-control" value=""> -->


                </div>
                <div class="col-md-12 mb-5">
                    <label for="description" class="text-white">Description</label>

                    <?php
                    // if (empty($_GET['id'])) {
                    ?>
                        <!-- <textarea id="description" name="description" class="form-control" rows="10"></textarea> -->
                    <?php
                    // } else {
                    ?>
                        <textarea id="description" name="description" class="form-control" rows="10"><?= $showCategory['description'] ?? '' ?></textarea>
                    <?php
                    // }
                    ?>
                    <!-- <textarea id="description" name="description" class="form-control" rows="10">

                    </textarea> -->
                </div>

            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-danger p-3"></button>
            </div>
        </form>
    </div>

    <div class="col-sm-12 col-md-6 d-flex flex-column mt-5 pe-3">

        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des catégories</h2>



        <table class="table table-dark table-bordered mt-5 ">
            <thead>
                <tr>
                    <!-- th*7 -->
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Supprimer</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // $selectCategory = selectCategory($id, $name, $description);

                foreach ($categories as $categorie) {

                ?>


                    <tr>
                        <td><?= $categorie['id_categorie'] ?></td>
                        <td><?= ucfirst($categorie['name']) ?></td>
                        <td><?= substr(ucfirst($categorie['description']), 0, 100) . "..." ?></td>

                        <td class="text-center"><a href="categories.php?action=delete&id=<?= $categorie['id_categorie'] ?>"><i class="bi bi-trash3-fill"></i></a></td>
                        <td class="text-center"><a href="categories.php?action=update&id=<?= $categorie['id_categorie'] ?>"><i class="bi bi-pen-fill"></i></a></td>

                    </tr>


                <?php

                }
                // debug($selectCategory);
                ?>


            </tbody>

        </table>

    </div>



    <?php


    require_once "../inc/footer.inc.php";


    ?>