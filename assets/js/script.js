// Fonction pour l'affichage du mot de passe
function myFunction() {
    let x = document.querySelector("#confirmMdp");
    let y = document.querySelector("#mdp");
    // var z = document.getElementsByClassName("mdp");
    if (x.type === "password" || y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}

// function hommeOuFemme() {
//     let x = document.querySelector('#imageProfil');
//     if ()
// }


