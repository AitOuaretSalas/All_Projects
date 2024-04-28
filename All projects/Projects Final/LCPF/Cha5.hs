{--
    Projet : Episode 1
    
    Salas Ait OUaret.
-}


module Cha5 (challenge5) where
import CPL

{-- 
La premiere Porte qui dit  : Choisis bien ta cellule c a a de l importance !
Donc -> 
-}


door1 :: Formula
door1 = Or 
        (And (Var "p1") (Var "t2")) 
        (And (Var "t1") (Var "p2"))



{--
 La deuxieme Porte qui dit : Tu ferais mieux de choisir l autre
cellule !

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
        (Eqv 
            (Var "p1") (Not (Var "t1"))
        ) 
        (Eqv 
            (Var "p2") (Not (Var "t2"))
        )
    )

{--
La cellule 2 dit la verite quand il y a une princesse dans autre cellule et ment quand c'est un tigre. 
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
 epreuves 5 :
-}


challenge5 :: Formula
challenge5 = And (constraint) (reglement)