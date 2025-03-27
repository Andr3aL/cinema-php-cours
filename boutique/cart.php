<?php

require_once "../inc/functions.inc.php";


// initPanier();

// if (isset($_POST['action']) && $_POST['action'] == 'add') {
//     // Ajouter un produit au panier
//     $id_film = $_POST['id_film'];
//     $title = $_POST['title'];
//     $price = $_POST['price'];
//     $image = $_POST['image'];
//     $quantity = $_POST['quantity'];
    
//     // Si le produit existe déjà dans le panier, on met à jour la quantité
//     if (isset($_SESSION['panier'][$id_film])) {
//         $_SESSION['panier'][$id_film]['quantity'] += $quantity;
//     } else {
//         // Sinon on l'ajoute
//         $_SESSION['panier'][$id_film] = [
//             'title' => $title,
//             'price' => $price,
//             'image' => $image,
//             'quantity' => $quantity
//         ];
//     }
    
//     // Redirection pour éviter de renvoyer le formulaire en cas de rafraîchissement
//     header('Location: ' . RACINE_SITE . 'boutique/cart.php');
//     exit;
// }

// // Supprimer un produit du panier
// if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
//     $id_film = $_GET['id'];
//     if (isset($_SESSION['panier'][$id_film])) {
//         unset($_SESSION['panier'][$id_film]);
//     }
//     header('Location: ' . RACINE_SITE . 'boutique/cart.php');
//     exit;
// }

// require_once "../inc/header.inc.php";

// // Calculer le total du panier
// $total = 0;
// foreach ($_SESSION['panier'] as $film) {
//     $total += $film['price'] * $film['quantity'];
// }

// Vérifier que le panier est un tableau
if (!isset($_SESSION['panier']) || !is_array($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Traiter l'ajout au panier
if (isset($_POST['id_film'])) {
    $id_film = $_POST['id_film'];
    
    // Récupérer les données du film depuis la base de données pour plus de sécurité
    $filmBdd = showIdFilm($id_film); 
    
    if ($filmBdd) {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        // Si le produit existe déjà dans le panier, on ajoute juste la quantité
        if (isset($_SESSION['panier'][$id_film])) {
            $_SESSION['panier'][$id_film]['quantity'] += $quantity;
        } else {
            // Sinon on l'ajoute avec toutes ses informations
            $_SESSION['panier'][$id_film] = [
                'title' => $filmBdd['title'],
                'price' => $filmBdd['price'],
                'image' => $filmBdd['image'],
                'quantity' => $quantity
            ];
        }
    }
}
debug($_SESSION['panier']);
// Supprimer un produit du panier
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_film = $_GET['id'];
    if (isset($_SESSION['panier'][$id_film])) {
        unset($_SESSION['panier'][$id_film]);
    }
}

// Vider tout le panier
if (isset($_GET['action']) && $_GET['action'] == 'empty') {
    $_SESSION['panier'] = array();
    header('Location: ' . RACINE_SITE . 'boutique/cart.php');
    exit;
}

require_once "../inc/header.inc.php";

?>


<div class="panier d-flex justify-content-center" style="padding-top:8rem;">


        <div class="d-flex flex-column  mt-5 p-5">
            <h2 class="text-center fw-bolder mb-5 text-danger">Mon panier</h2>

            <!-- le paramètre vider=1 pour indiquer qu'il faut vider le panier. -->
            
            <?php if (empty($_SESSION['panier'])): ?>
                <div class="alert alert-info">Votre panier est vide.</div>
            <?php else: ?>
                <a href="<?= RACINE_SITE ?>boutique/cart.php?action=empty" class="btn align-self-end mb-5">Vider le panier</a>

                           

                <table class="fs-4">
                    <tr>
                        <th class="text-center text-danger fw-bolder">Affiche</th>
                        <th class="text-center text-danger fw-bolder">Nom</th>
                        <th class="text-center text-danger fw-bolder">Prix</th>
                        <th class="text-center text-danger fw-bolder">Quantité</th>
                        <th class="text-center text-danger fw-bolder">Sous-total</th>
                        <th class="text-center text-danger fw-bolder">Supprimer</th>
                    </tr>

                    <?php 
                        $total = 0;
                        foreach ($_SESSION['panier'] as $id_film => $film): 
                            $subtotal = $film['price'] * $film['quantity'];
                            $total += $subtotal;
                    ?>
                    
                        <tr>
                            <td class="text-center border-top border-dark-subtle"><a href="<?= RACINE_SITE ?>showFilm.php?action=show&id=<?= $id_film ?>"><img src="<?= RACINE_SITE ?>assets/img/<?= $film['image'] ?>" style="width: 100px;"></a></td>
                            <td class="text-center border-top border-dark-subtle"><?= $film['title'] ?></td>
                            <td class="text-center border-top border-dark-subtle"><?= $film['price'] ?>€</td>
                            <td class="text-center border-top border-dark-subtle d-flex align-items-center justify-content-center" style="padding: 7rem;"><?= $film['quantity'] ?>
                            
                                                                <!-- Afficher la quantité actuelle -->

                            </td>
                            <td class="text-center border-top border-dark-subtle"><?= $subtotal ?>€</td>
                            <td class="text-center border-top border-dark-subtle"><a href="?action=delete&id=<?= $id_film ?>"><i class="bi bi-trash3"></i></a></td>
                        </tr>
                        <?php endforeach; ?>
                                       <tr class="border-top border-dark-subtle">
                        <th class="text-danger p-4 fs-3">Total :<?= $total ?>€</th>
                    </tr>
               </table>
               
                <form action="<?= RACINE_SITE ?>boutique/checkout.php" method="post">
                    <input type="hidden" name="total" value="<?= $total ?>">
                    <button type="submit" class="btn btn-danger mt-5 p-3" id="checkout-button">Payer</button>
              </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="w-50 m-auto d-flex flex-column align-item-center">
        <p class="alert alert-success text-center">Votre achat a bien été effectué !</p>
        <a href="<?= RACINE_SITE ?>profil.php" class="btn btn-primary text-center">Suivre ma commande</a>
    </div>


<?php


require_once "../inc/footer.inc.php";


?>