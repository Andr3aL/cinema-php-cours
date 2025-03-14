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

if (!empty($_POST)) {

    $verif = true;
    foreach($_POST as $key=> $value) { // je prend les valeurs de mon tableau en le parcourant

        if(empty(trim($value))) { // si une de ces valeurs est vide, je passe verif en false
            $verif = false;
        }
    }
// debug($_POST);
    if ($verif === false) {
        $info = alert("Veuillez renseigner tous les champs", "danger");
debug($_POST);

    } else {

        if (!isset($_POST['title']) || strlen(trim($_POST['title'])) < 2 || strlen(trim($_POST['title'])) > 50) {
            // debug($_POST);
            $info .= alert("Le champ title n'est pas valide", "danger");
        }

        if (!isset($_POST['director']) || strlen(trim($_POST['director'])) > 50) {
            $info .= alert("Le champ director n'est pas valide", "danger");
        }

        if (!isset($_POST['image'])) {
            $info .= alert("Le champ image n'est pas valide", "danger");
        }

        if (!isset($_POST['actors']) || strlen(trim($_POST['actors'])) < 3 || strlen(trim($_POST['actors'])) > 50) {
            $info .= alert("Le champ actors n'est pas valide", "danger");
        }
        if (!isset($_POST['ageLimit'])) {
            $info .= alert("Le champ ageLimit n'est pas valide", "danger");
        }

        if (!isset($_POST['duration'])) {
            $info .= alert("Le champ duration n'est pas valide", "danger");
        }

        if (!isset($_POST['price']) || !preg_match("/[0-9]/", $_POST['price'])) {
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
        elseif($info = "") {
            $title = trim(htmlspecialchars($_POST['title']));
            $director = trim(htmlspecialchars($_POST['director']));
            $image = trim(htmlspecialchars($_POST['image']));
            $actors = trim(htmlspecialchars($_POST['actors']));
            $ageLimit = trim(htmlspecialchars($_POST['ageLimit']));
            $duration = trim(htmlspecialchars($_POST['duration']));
            $price = trim(htmlspecialchars($_POST['price']));
            $synopsis = trim(htmlspecialchars($_POST['synopsis']));
            $date = trim(htmlspecialchars($_POST['date']));
            $stock = trim(htmlspecialchars($_POST['stock']));

            // if ($film) {

            //     // $idFilm = $_GET['id_film'];
            //     // updateFilm($idFilm, $name, $description);
            //     // // $info = alert("La catégorie existe déjà", "danger");
            // 
            // } elseif {
                addFilm($title, $director, $image, $actors, $ageLimit, $duration, $price, $synopsis, $date, $stock);
                
                $info = alert("Le film a bien été ajouté", "success");
// debug($_POST);
            }
        }
    }



require_once "../inc/header.inc.php";

?>



<main>
    <h2 class="text-center fw-bolder mb-5 text-danger"></h2>

        <form action="" method="post" class="back" enctype="multipart/form-data">
        <!-- il faut isérer une image pour chaque film, pour le traitement des images et des fichiers en PHP on utilise la surperglobal $_FILES -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title">Titre de film</label>
                <input type="text" name="title" id="title" class="form-control" value="">

            </div>
            <div class="col-md-6 mb-5">
                <label for="image">Photo</label>
                <br>
                <input type="file" name="image" id="image">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="director">Réalisateur</label>
                <input type="text" class="form-control" id="director" name="director" value="">
            </div>
            <div class="col-md-6">
                <label for="actors">Acteur(s)</label>
                <input type="text" class="form-control" id="actors" name="actors" value="" placeholder="séparez les noms d'acteurs avec un /">
            </div>
        </div>
        <div class="row">
            <!-- raccouci bs5 select multiple -->
            <div class="mb-3">
                <label for="ageLimit" class="form-label">Àge limite</label>
                <select multiple class="form-select form-select-lg" name="ageLimit" id="ageLimit">
                    <option value="10">10</option>                  
                    <option value="13">13</option>
                    <option value="16">16</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label for="categories">Genre du film</label>

         
                <div class="form-check col-sm-12 col-md-4">


                    <input class="form-check-input" type="radio" name="categories" id="" value=""  checked>

                    <label class="form-check-label" for=""></label>
                </div>

           

        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="duration">Durée du film</label>
                <input type="time" class="form-control" id="duration" name="duration"  min="01:00" value="">
            </div>

            <div class="col-md-6 mb-5">

                <label for="date">Date de sortie</label>
                <input type="date" name="date" id="date" class="form-control" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros amount (with dot and two decimal places)" value="">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value=""> <!--pas de stock négativ donc je rajoute min="0"-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="synopsis">Synopsis</label>
                <textarea type="text" class="form-control" id="synopsis" name="synopsis" rows="10"></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger p-3 w-25">Ajouter un film</button>
        </div>

    </form>

</main>


<?php


require_once "../inc/footer.inc.php";


?>