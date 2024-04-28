{--
    Projet : Episode 1
    
    Salas Ait OUaret.
    Zouhir Ait Saada.
    Adel Oulmou.
-}




module CPL (
    Formula (..),
    World,
    genAllWorlds, testGenAllWorlds,
    sat, testSat,
    findWorlds, testFindWorlds,
    testAll
) where


 
{- pour representer des formules logiques. -}


data Formula = T | F | Var [Char]
    | Not   (Formula)
    | And   (Formula) (Formula)
    | Or    (Formula) (Formula)
    | Imp   (Formula) (Formula)
    | Eqv   (Formula) (Formula)
    deriving (Eq)

instance Show Formula where
    show T = "Vrai"
    show F = "Faux"
    show (Var s) = s
    show (Not f) = "~" ++ show f
    show (And f1 f2) = "(" ++ show f1 ++ " ∧ " ++ show f2 ++ ")"
    show (Or f1 f2) = "(" ++ show f1 ++ " ∨ " ++ show f2 ++ ")"
    show (Imp f1 f2) = "(" ++ show f1 ++ " ⇒ " ++ show f2 ++ ")"
    show (Eqv f1 f2) = "(" ++ show f1 ++ " ⇔ " ++ show f2 ++ ")"







{-pour representer le type des mondes possibles. -}


type World = [[Char]]


genAllWorlds :: [[Char]] -> [World]
genAllWorlds [] = [[]]
genAllWorlds (x:xs) = [x:ps | ps <- (genAllWorlds xs)] ++ (genAllWorlds xs)

testGenAllWorlds :: [Bool] -- Fonction de test
testGenAllWorlds = [
        genAllWorlds ["p1"] == [["p1"],[]],
        genAllWorlds ["p1", "t2"] == [["p1","t2"],["p1"],["t2"],[]] 
    ]






{- pour un monde possible w et une formule phi passes en arguments, verifie la corespondance. -}



sat :: World -> Formula -> Bool
sat _ T = True
sat _ F = False
sat w (Var s) = s `elem` w
sat w (Not phi) = not (sat w phi)
sat w (And phi psi) = (sat w phi) && (sat w psi)
sat w (Or phi psi)  = (sat w phi) || (sat w psi)
sat w (Imp phi psi) = (not (sat w phi)) || (sat w psi)
sat w (Eqv phi psi) = (sat w (Imp phi psi)) && (sat w (Imp psi phi))

testSat :: [Bool] -- Fonction de test
testSat = [
        sat ["p1", "t2"] T == True,
        sat ["p1", "p2", "t2"] (And (Var "p1") (Var "p2")) == True,
        sat ["p1", "p2"] (And (Var "p1") (Var "p2")) == True,
        sat ["p1", "t2"] (And (Eqv (Var "p1") (Not (Var "t1"))) (Eqv (Var "p2") (Not (Var "t2")))) == True
    ]










{- pour une phi renvoie la liste de tous mondes possibles qui satisfont phi. -}


-- Extrait les variables d'une formule

extractVars :: Formula -> [[Char]] 
extractVars T = []
extractVars F = []
extractVars (Var v) = [v]
extractVars (Not f) = extractVars f
extractVars (And f1 f2) = extractVars f1 ++ extractVars f2
extractVars (Or f1 f2) = extractVars f1 ++ extractVars f2
extractVars (Imp f1 f2) = extractVars f1 ++ extractVars f2
extractVars (Eqv f1 f2) = extractVars f1 ++ extractVars f2


-- Supprime les doublons d'une liste de variables.

supDoublons :: [[Char]] -> [[Char]] 
supDoublons [] = []
supDoublons (x:xs)   
    | x `elem` xs = supDoublons xs
    | otherwise = x : supDoublons xs



-- Trie l'ensemble des mondes possibles selon la formule.

findFromWorlds :: [World] -> Formula -> [World] 
findFromWorlds [] _ = []
findFromWorlds (x:xs) f
    | (sat x f) == True = x : findFromWorlds xs f
    | otherwise = (findFromWorlds xs f)




findWorlds :: Formula -> [World] -- Fonction principale.
findWorlds f = (findFromWorlds (genAllWorlds (supDoublons(extractVars f))) f)




testFindWorlds :: [Bool]
testFindWorlds = [
    findWorlds (And (Var "p1") (Var "t2")) == [["p1","t2"]] ]








{- retourne vrai si tous les resultats du test sont vrai sinon faux . -}


test :: [Bool] -> Bool
test(tab)
    | head tab == last tab && head tab == True = True
    | head tab == False = False
    | otherwise = test (tail tab)








{- "Success!" 
si tous les tests de toutes les fonctions sont vrais, sinon "Fail!". -}




testAll :: [Char]
testAll 
    | test(testGenAllWorlds) && test(testSat) && test(testFindWorlds) = "Success"
    | otherwise = "Fail!"
