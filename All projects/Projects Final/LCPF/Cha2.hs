{--
    Projet : Episode 1
    
    Salas Ait Ouaret.
    Zouhir Ait Saada.
    Adel Oulmou.
-}

module Cha2 (challenge2) where
import CPL

{-- 
La premiere Porte qui dit  : Une au moins de deux cellules contient une peluche.
Donc -> 
-}


door1 :: Formula
door1 = Or 
        (Var "p1") 
        (Or 
            (Var "p2") 
            (And (Var "p1") (Var "p2"))
        )



{--
 La deuxieme Porte qui dit : Il y a un tigre dans lautre cellule.
Donc -> 
-}


door2 :: Formula
door2 = (Var "t1")



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
les deux portes disent toutes les deux la verite, ou mentent !!!!!
 Donc -> 

-}



reglement :: Formula
reglement = (
    Or 
        (And door1 door2) 
        (And (Not door1) (Not door2))
    )



{--
 epreuves 2 :
 -}



challenge2 :: Formula
challenge2 = And (constraint) (reglement)