{--
    Projet : Épisode 1
    
    Salas Ait OUaret.
-}

module Cha1 (challenge1) where
import CPL

{-- 
La première Porte qui dit  : "Il y a une peluche dans cette cellule et un tigre dans l’autre.
Donc -> 
-}


door1 :: Formula
door1 = And (Var "p1") (Var "t2")


{--
 La deuxieme Porte qui dit : "Il y a une peluche dans une cellule et il y a un tigre dans une cellule.
Donc -> 
-}


door2 :: Formula
door2 = Or 
        (And (Var "p1") (Var "t2")) 
        (And (Var "t1") (Var "p2"))


{--
une Princesse et un Tigre en meme temps Interdit et Imposible 
Donc -> 
-}


constraint :: Formula
constraint = (
    And 
        (Eqv (Var "p1") (Not (Var "t1"))) 
        (Eqv (Var "p2") (Not (Var "t2")))
    )



{--
 Pour la premiere epreuve, le roi a colle un affiche sur la porte de chaque cellule :  Une des
affiches dit la verite , promit le roi, et autre ment.
 Donc -> 
-}
reglement :: Formula
reglement = (
    Or 
        (And (Not door1) door2) 
        (And door1 (Not door2))
    )

{--
 epreuves 1 :
 -}

challenge1 :: Formula
challenge1 = And (constraint) (reglement)