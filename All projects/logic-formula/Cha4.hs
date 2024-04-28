{--
    Projet : Episode 1
    
    Salas Ait OUaret.
-}



module Cha4 (challenge4) where
import CPL

{-- 
La premiere Porte qui dit  : Choisis n importe quelle cellule, ca na pas d importance !
Donc -> 
-}


door1 :: Formula
door1 = Or 
        (And (Var "p1") (Var "p2")) 
        (And (Var "t1") (Var "t2"))




{--
 La deuxieme Porte qui dit : Il y a une peluche dans l autre cellule.
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
La cellule 1 dit la verite quand il y a une princesse dans cette cellule et ment quand c'est un tigre.
Pour la cellule 2 c'est exactement le contraire. 
Donc ->
-}


reglement :: Formula
reglement = (
    And 
        (And 
            (Imp (Var "p1") door1) 
            (Imp (Var "t1") (Not door1))
        ) 
        (And 
            (Imp (Var "t2") door2) 
            (Imp (Var "p2") (Not door2))
        )
    )



{--
 epreuves 4 :
 -}



challenge4 :: Formula
challenge4 = And (constraint) (reglement)