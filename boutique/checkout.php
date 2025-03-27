<?php
require_once "../inc/functions.inc.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['client'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ' . RACINE_SITE . 'authentication.php');
    exit;
}

// Vérifier si le panier existe et n'est pas vide
if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    // Rediriger vers la page du panier si le panier est vide
    header('Location: ' . RACINE_SITE . 'boutique/cart.php');
    exit;
}

// Calculer le total
$total = 0;
foreach ($_SESSION['panier'] as $id_film => $film) {
    $total += $film['price'] * $film['quantity'];
}




// Variable pour suivre l'état du paiement
$payment_success = false;

// Traitement du paiement - uniquement si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    // Ici, vous pourriez intégrer un vrai système de paiement
    // Pour cet exemple, nous simulerons un paiement réussi
    
    // Stockage de la commande dans la base de données (à implémenter si nécessaire)
    // saveOrder($_SESSION['client']['id_user'], $_SESSION['panier'], $total);
    
    // On indique que le paiement a réussi
    $payment_success = true;
    
    // Vider le panier après paiement réussi
    $_SESSION['panier'] = array();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    
    // Traiter la commande
    processOrder(
        $_SESSION['client']['id_user'],
        $_SESSION['panier'],
        $total
    );
    
    // Vider le panier après paiement réussi
    $_SESSION['panier'] = array();
    
    // Afficher message de succès
    $payment_success = true;
}





// // Traitement du paiement
// if (isset($_POST['total'])) {
//     // Ici, vous pourriez intégrer un vrai système de paiement
//     // Pour cet exemple, nous allons simplement simuler un paiement réussi
    
//     // Stockage de la commande dans la base de données (à implémenter si nécessaire)
//     // saveOrder($_SESSION['client']['id_user'], $_SESSION['panier'], $total);
    
//     // Message de succès
//     $success = true;
    
//     // Vider le panier après paiement réussi
//     $_SESSION['panier'] = array();
// } else {
//     $success = false;
// }

require_once "../inc/header.inc.php";
?>

<div class="container" style="padding-top:8rem;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($payment_success): ?>
                <!-- Affichage du message de succès -->
                <div class="alert alert-success text-center">
                    <h2>Votre achat a bien été effectué !</h2>
                    <p>Merci pour votre commande. Votre paiement de <?= $total ?>€ a été accepté.</p>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= RACINE_SITE ?>profil.php" class="btn btn-primary">Suivre ma commande</a>
                    <a href="<?= RACINE_SITE ?>index.php" class="btn btn-secondary">Continuer mes achats</a>
                </div>
            <?php else: ?>
                <!-- Affichage du formulaire de paiement -->
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="text-center mb-0">Finalisation de la commande</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-4">Résumé de votre commande</h4>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Film</th>
                                    <th>Quantité</th>
                                    <th>Prix</th>
                                    <th>Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['panier'] as $id_film => $film): ?>
                                    <tr>
                                        <td><?= $film['title'] ?></td>
                                        <td><?= $film['quantity'] ?></td>
                                        <td><?= $film['price'] ?>€</td>
                                        <td><?= $film['price'] * $film['quantity'] ?>€</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th><?= $total ?>€</th>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <form action="" method="post" class="mt-4">
                            <input type="hidden" name="total" value="<?= $total ?>">
                            
                            <div class="mb-3">
                                <label for="card-number" class="form-label">Numéro de carte</label>
                                <input type="text" class="form-control" id="card-number" placeholder="1234 5678 9012 3456" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiry" class="form-label">Date d'expiration</label>
                                    <input type="text" class="form-control" id="expiry" placeholder="MM/AA" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom sur la carte</label>
                                <input type="text" class="form-control" id="name" placeholder="John Doe" required>
                            </div>
                            
                            <div class="text-center mt-4">
                                <!-- Important: ajout de name="confirm_payment" -->
                                <button type="submit" name="confirm_payment" class="btn btn-danger btn-lg">Confirmer le paiement</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php
require_once "../inc/footer.inc.php";
?>