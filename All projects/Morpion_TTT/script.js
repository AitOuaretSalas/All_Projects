$(document).ready(function(){ 
var pions = document.getElementById("jeu").children; // nos boutons
var joueurs = [
    {
    id:'Axeluus',
    icon: '<img class="icon_poisson" src="images/AT.jpg" alt="fish">'
    },  {
        id:'cherifuus',
        icon: '<img class="icon_chien" src="images/salasuus.jpeg" alt="chien">'
        } ,{
            id:'Aylanuus',
            icon: '<img class="icon_chi" src="images/aylanuus.jpg" alt="cat">'
            }
  
];
var wins = [
    [0,1,2],
    [1,2,3],
    [8,9,10],
    [4,5,6],
    [5,6,7],
    [9,10,11],
    [12,13,14],
    [13,14,15],
    [0,4,8],
    [4,8,12],
    [1,5,9],
    [5,9,13],
    [6,10,14],
    [7,11,15],
    [3,7,11],
    [2,1,0],
    [3,2,1],
    [10,9,8],
    [6,5,4],
    [7,6,5],
    [11,10,9],
    [14,13,12],
    [15,14,13],
    [8,4,0],
    [12,8,4],
    [9,5,1],
    [13,9,5],
    [14,10,6],
    [15,11,7],
    [11,7,3],
    [1,6,11],
    [5,10,15],
    [0,5,10],
    [4,9,14],
    [11,6,1],
    [15,10,5],
    [10,5,0],
    [14,9,4],
    [6,9,12],
    [12,9,6],
    [3,6,9],
    [6,9,3]
]
var currentTurn = 1; // le tour du joueur
var jeuEstFini = false; // si le jeux est finit
var afficheur = document.querySelector("#jeuStatus"); // permet un nouvelle affichage


function estValide(button){
return button.innerHTML.length == 0; // retourne si il y a quelque chose dans les cases.
}

function setSymbol(btn, symbole){
console.log('Setting symbole');
console.log(btn);
btn.innerHTML = symbole; //mettre le symbole de l'utillisateur.
}

function rechercherVainqueur(pions, joueurs, currentTurn){  //retourne true si une solution vainqueur est trouvé

for(win of wins) {
    var success = true;
    for(cell of win) {
        success = success && (pions[cell].innerHTML == joueurs[currentTurn].icon);
    }
    if(success){
        return true;
    }
} 
}

function tableauEstPlein(pions){ // vérifie si le tableau est plein
for(var i = 0, len = pions.length; i < len; i++){
    if(pions[i].innerHTML.length == 0)
        return false;
}
return true;
}


function userClick() {
if(jeuEstFini) // retourne false si le jeux est finit.
return;

if (!estValide(this)){
    afficheur.innerHTML ="domage!!!! déja pris :) -> il faux choisir un autre emplacement  !";
} else{
    setSymbol(this, joueurs[currentTurn].icon);

    jeuEstFini = rechercherVainqueur(pions, joueurs, currentTurn);

    //Le jeu est finit (Quelqu'un a gagné)
    if(jeuEstFini){
        afficheur.innerHTML = " Bravooooooo ;) Joueur " + joueurs[currentTurn].id + " -> tu a gagné !!!!!!";
        return;
    }
    //Le jeu est finit (Match nul)
    if(tableauEstPlein(pions)){
        afficheur.innerHTML = "Match  null !!!!! vous etes tres fort !!!!";
        return;
    }
    //Le jeu n'est pas encore fini
    currentTurn++;//1//2
    currentTurn = currentTurn % 3;//1//0
    afficheur.innerHTML = "Joueur " + joueurs[currentTurn].id + " à ton tour !"; // affiche le tour du joueur en question.
}
}

function main() { // fonction principale
afficheur.innerHTML = "saluut on peut jouer :). <br/> Joueur " + joueurs[currentTurn].id + " c'est ton tour."; // envoyer ce message pour l'afficher

for(var i = 0, len = pions.length; i < len; i++){
    pions[i].addEventListener("click", userClick);
}
}

main();

});