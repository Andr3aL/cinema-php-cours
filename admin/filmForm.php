<?php

require_once "../inc/functions.inc.php";



if (!isset($_SESSION['client'])) {
    header('location:' . RACINE_SITE . 'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") {
        header('location:' . RACINE_SITE . 'profil.php');
    }
}

$info = "";
// $idFilm = htmlspecialchars($_GET['id']);
// $filmBdd = showIdFilm($idFilm);

if (isset($_GET['action']) && isset($_GET['id'])) {


    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id'])) {

        $idFilm = htmlspecialchars($_GET['id']); // id qu'on a récupéré dans l'url avec $_GET
        $filmBdd = showIdFilm($idFilm);

        // var_dump($idFilm, $filmBdd);
        // die();

    }

    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id'])) {

        deleteFilm($idFilm);
        header('location:films.php');
    }
}

if (!empty($_POST)) { // on verifie si j'ai cliqué ou non --> est-ce que mes données sont remplies ou vides ?
// POST et pas GET : car plus sécurisé + car dans le html form on a réf POST + ça permlet de rentrer + de données + si on avait pris GET, l'url serait LONGUE et VISIBLE (donc pas sécurisé)
    $verif = true;
    // foreach : c'est pour boucler sur les clés et les valeurs (tab associatif) (c'est mieux), contrairement à for ou while
    foreach ($_POST as $key => $value) { // je prend les valeurs de mon tableau en le parcourant

        if (empty(trim($value))) { // si une de ces valeurs est vide, je passe verif en false
            $verif = false;
        }
    }
    // debug($_POST);
    if ($verif === false) {
        $info = alert("Veuillez renseigner tous les champs", "danger");
    } else {
        // debug($_POST);

        if (!isset($_POST['title']) || strlen(trim($_POST['title'])) < 2 || strlen(trim($_POST['title'])) > 50) {
            // debug($_POST);
            $info .= alert("Le champ title n'est pas valide", "danger");
        }

        if (!isset($_POST['director']) || strlen(trim($_POST['director'])) > 50) {
            $info .= alert("Le champ director n'est pas valide", "danger");
        }









        // $_FILES['image']['full_path'];
        if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
            $info .= alert("Erreur sur l'image", "danger");
        } else {
            $extensions = ['jpg', 'jpeg', 'png', 'gif']; // extensions autorisées
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if (!in_array($extension, $extensions)) {
                $info .= alert("L'extension de l'image n'est pas valide", "danger");
            }
        }







        if (!isset($_POST['categories'])) {
            $info .= alert("Le champ categories n'est pas valide", "danger");
        }

        if (!isset($_POST['actors']) || strlen(trim($_POST['actors'])) < 3) {
            $info .= alert("Le champ actors n'est pas valide", "danger");
        }

        if (!isset($_POST['ageLimit'])) {
            $info .= alert("Le champ ageLimit n'est pas valide", "danger");
        }

        if (!isset($_POST['duration'])) {
            $info .= alert("Le champ duration n'est pas valide", "danger");
        }

        if (!isset($_POST['price']) || !is_numeric($_POST['price'])) {
            $info .= alert("Le champ price n'est pas valide", "danger");
        }

        if (!isset($_POST['synopsis']) || strlen($_POST['synopsis']) < 20) {
            $info .= alert("Le champ synospis n'est pas valide", "danger");
        }

        if (!isset($_POST['date'])) {
            $info .= alert("Le champ date n'est pas valide", "danger");
        }

        if (!isset($_POST['stock'])) {
            $info .= alert("Le champ stock n'est pas valide", "danger");
        }

        debug($info);

        if ($info == "") {
            // debug($_FILES);
            // debug($_FILES['image']);
            // debug($_POST);

            $title = trim(htmlspecialchars($_POST['title']));
            $director = trim(htmlspecialchars($_POST['director']));




            $image = $_FILES['image']['name'];




            // $upload_dir = '../assets/img/';
            // $file_name = basename($_FILES['image']['name']);
            // $upload_path = $upload_dir . $file_name;

            // if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            //     // echo "Fichier uploadé avec succès : " . $upload_path;
            //     $image = $file_name;
            //      // on stocke uniquement le nom du fichier
            // } else {
            //     // echo "Erreur lors du téléchargement.";
            //     $info .= alert("Erreur lors du téléchargement de l'image.", "danger");
            // }


            // $image = trim(htmlspecialchars($_POST['image']));


            // debug($_POST);
            $actors = trim(htmlspecialchars($_POST['actors']));
            $ageLimit = trim(htmlspecialchars($_POST['ageLimit']));
            $duration = trim(htmlspecialchars($_POST['duration']));
            $price = intval(trim(htmlspecialchars($_POST['price'])));
            $synopsis = trim(htmlspecialchars($_POST['synopsis']));
            $date = trim(htmlspecialchars($_POST['date']));
            $stock = intval(trim(htmlspecialchars($_POST['stock'])));
            $category_id = intval(trim(htmlspecialchars($_POST['categories']))); // le name du form est, ici, categories

            // if ($film) {

            //     // $idFilm = $_GET['id_film'];
            //     // updateFilm($idFilm, $name, $description);
            //     // // $info = alert("La catégorie existe déjà", "danger");
            // 
            // } elseif {




            $image = strtolower($image);
            $image = str_replace(" ", "_", $image);


            $filmExist = checkFilm($title);

            if ($filmExist) {
                $info .= alert("Le film existe déjà", "danger");
            } else {

                // On ajoute l'image
                $path = "../assets/img/" . $image;
                move_uploaded_file($_FILES['image']['tmp_name'], $path); // tmp_name : c'est le chemin d'origine

                // On ajoute le film

            }

            $filmBdd = showFilm($title);
            // var_dump($filmBdd);
            // die();

            if ($filmBdd) {

                $idFilm = $_GET['id'];

                // var_dump($_POST);
                // die;
                updateFilm($idFilm, $title, $director, $image, $actors, $ageLimit, $duration, $price, $synopsis, $date, $stock);

                $info = alert("Le film existe déjà et a bien été modifié", "ainfo");

                header('location:'.RACINE_SITE.'films.php');

            } else {
                addFilm($category_id, $title, $director, $image, $actors, $ageLimit, $duration, $price, $synopsis, $date, $stock);

                $info = alert("Le film a bien été ajouté", "success");
            }

            // debug($_POST);
        }
    }
}





require_once "../inc/header.inc.php";

?>



<main>
    <h2 class="text-center fw-bolder mb-5 text-danger">Ajout de film</h2>

    <?php
    echo $info;
    ?>

    <form action="" method="post" class="back" enctype="multipart/form-data"> 
<!-- multipart/form-data sert à manipuler des fichiers comme des images -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title">Titre de film</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $filmBdd['title'] ?? '' ?>">
            </div>










            <div class="col-md-6 mb-5">
                <label for="image">Photo</label>
                <br>
                <input type="file" name="image" id="image" value="<?= $filmBdd['image'] ?? '' ?>">
            </div>










        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="director">Réalisateur</label>
                <input type="text" class="form-control" id="director" name="director" value="<?= $filmBdd['director'] ?? '' ?>">
            </div>
            <div class="col-md-6">
                <label for="actors">Acteur(s)</label>
                <input type="text" class="form-control" id="actors" name="actors" value="<?= $filmBdd['actors'] ?? '' ?>" placeholder="séparez les noms d'acteurs avec un /">
            </div>
        </div>
        <div class="row">
            <!-- raccouci bs5 select multiple -->
            <div class="mb-3">
                <label for="ageLimit" class="form-label">Àge limite</label>


                <?php// foreach($filmBdd['ageLimit'] as $ageLimit) : ?>
                <select class="form-select form-select-lg" name="ageLimit" id="ageLimit">
                  
                    <option value="10">10</option>
                    <option value="13">13</option>
                    <option value="16">16</option>
                 
                </select>
                <?php// endforeach; ?>



            </div>
        </div>
        <div class="row">
            <label for="categories">Genre du film</label>



            <?php $categories = allCategory();
            foreach ($categories as $categorie) :
                // var_dump($categorie['name']);
            ?>
                <div class="form-check col-sm-12 col-md-4">

                    <input class="form-check-input" type="radio" name="categories" id="<?= $categorie['name'] // ce name là est la colonne "name" de la bdd ?>" value="<?= $categorie['id_categorie'] ?>">

                    <label class="form-check-label" for="<?= $categorie['name'] ?>">
                        <?= ucfirst(html_entity_decode($categorie['name'])) ?>
                    </label>
                </div>

            <?php endforeach; ?>



        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="duration">Durée du film</label>
                <input type="time" class="form-control" id="duration" name="duration" min="01:00" value="<?= $filmBdd['duration'] ?? '' ?>">
            </div>

            <div class="col-md-6 mb-5">

                <label for="date">Date de sortie</label>
                <input type="date" name="date" id="date" class="form-control" value="<?= $filmBdd['date'] ?? '' ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros amount (with dot and two decimal places)" value="<?= $filmBdd['price'] ?? '' ?>">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?= $filmBdd['stock'] ?? '' ?>"> <!--pas de stock négativ donc je rajoute min="0"-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="synopsis">Synopsis</label>
                <textarea type="text" class="form-control" id="synopsis" name="synopsis" rows="10"><?= isset($filmBdd) ? $filmBdd['synopsis'] : '' ?></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger p-3 w-25"><?= isset($filmBdd) ? 'Modifier le film' : ' Ajouter un film' ?></button>
        </div>

    </form>

</main>


<?php


require_once "../inc/footer.inc.php";


?>