{--
    Projet : Episode 1
    
    Salas Ait OUaret.
-}



module Cha6 (challenge6) where
import CPL




{-- 
La premiere Porte qui dit  : Il y a un tigre ici.
Donc -> 
-}


door1 :: Formula
door1 = (Var "t1")






{--
 La deuxieme Porte qui dit :Cette cellule contient une peluche.
Donc ->

-}


door2 :: Formula
door2 = (Var "p2")





{--
 Il y a un tigre dans a cellule 2. 
 Donc ->
-}


door3 :: Formula
door3 = (Var "t2")





{--
il ne peut pas y avoir un tigre et une princesse en même temps
et qu'une seule cellule renfermait une princesse 
et qu'il avait fait mettre un tigre dans chacune des deux autres.
 -}



constraint :: Formula
constraint = (
    And 
        (And 
            (Eqv (Var "p1") (Not (Var "t1"))) 
            (Imp (Var "p1") (And (Var "t2") (Var "t3")))
        ) 
        (And 
            (And 
                (Eqv (Var "p2") (Not (Var "t2"))) 
                (Imp (Var "p2") (And (Var "t1") (Var "t3")))
            ) 
            (And 
                (Eqv (Var "p3") (Not (Var "t3"))) 
                (Imp (Var "p3") (And (Var "t1") (Var "t2")))
            )
        )
    )



{--
 une seule des trois est sincere.
 Donc ->
-}



reglement :: Formula
reglement = (
    And 
        (Imp 
            (door1) 
            (And (Not door2) (Not door3))
        ) 
        (And 
            (Imp 
                (door2) 
                (And (Not door1) (Not door3))
            ) 
            (Imp 
                (door3) 
                (And (Not door1) (Not door2))
            )
        )
    )




    

{--
 epreuves 6 :
-}

challenge6 :: Formula
challenge6 = And (constraint) (reglement)