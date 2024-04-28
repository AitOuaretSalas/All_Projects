{--
    Projet : Episode 1
    
    Salas Ait Ouaret.
    Zouhir Ait Saada.
    Adel Oulmou.
-}


module Cha3 (challenge3) where
import CPL


{-- 
La premiere Porte qui dit  : Il y a un tigre dans cette cellule ou il y a une peluche dans autre.
Donc -> 
-}


door1 :: Formula
door1 = Or (Var "t1") (Var "p2")




{--
 La deuxieme Porte qui dit : Il y a une peluche dans autre cellule.
Donc -> 
-}


door2 :: Formula
door2 = (Var "p1")




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
 epreuves 3 :
 -}



challenge3 :: Formula
challenge3 = And (constraint) (reglement)