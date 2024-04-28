package Model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
import Control.ChefService;
import Control.Employe;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;


/**
 *
 * @author KHALED
 */
public class EmployeEntity {

    /**
     * @param args the command line arguments
     */
    Connexion conn = new Connexion();

    public void addEmploye(Employe e) {

        conn.seConnecter();
        Statement stmt;
        ResultSet rs;

        stmt = conn.getStmt();
// STEP 2: perform operations on the database:

        // Insertion
        // stmt.execute("INSERT INTO  users (  nom ,  prenom ,  adresse ,  diplome ,  login ,  password ,  situationfamiliale ) VALUES ('bedjou','samir','ighil','ingenieur','samir','samir','marié')");
        try {
            // Selection et parcours
            stmt.execute("INSERT INTO  employe(  nom ,  prenom ,  age , adresse, typeEmploye ) VALUES ('" + e.getNom() + "','" + e.getPrenom()+ "','" + e.getAge()+ "','" + e.getAdresse()+"','Employé Simple')");

            JOptionPane.showMessageDialog(null, "Employé ajoutée avec succès", "Message de succès",
                    JOptionPane.INFORMATION_MESSAGE);
        } catch (SQLException ex) {
            //Logger.getLogger(this.class.getName()).log(Level.SEVERE, null, ex);

            JOptionPane.showMessageDialog(null, "Erreur de Connexion", "Message d'erreur",
                    JOptionPane.ERROR_MESSAGE);
            System.err.println(ex);
        }

        // Suppression
        // stmt.execute("DELETE FROM users WHERE idusers=4");
        // Mise a jour
// STEP 3: close the connexion to the database:
        conn.close();

    }

    public void addChefService(ChefService c) {

        conn.seConnecter();

        Statement stmt;
        ResultSet rs;

        stmt = conn.getStmt();
// STEP 2: perform operations on the database:

        // Insertion
        // stmt.execute("INSERT INTO  users (  nom ,  prenom ,  adresse ,  diplome ,  login ,  password ,  situationfamiliale ) VALUES ('bedjou','samir','ighil','ingenieur','samir','samir','marié')");
        try {
            // Selection et parcours
            stmt.execute("INSERT INTO  employe (  nom ,  prenom ,  age , adresse, service, typeEmploye ) VALUES ('" + c.getNom() + "','" + c.getPrenom() + "','" + c.getAge() + "','" + c.getAdresse() + "','" + c.getService()+"','Chef Service')");

            JOptionPane.showMessageDialog(null, "Chef service ajouté avec succès", "Message de succès",
                    JOptionPane.INFORMATION_MESSAGE);
        } catch (SQLException ex) {
            //Logger.getLogger(testUser.class.getName()).log(Level.SEVERE, null, ex);
            System.err.println(ex);
            JOptionPane.showMessageDialog(null, "Erreur de Connexion", "Message d'erreur",
                    JOptionPane.ERROR_MESSAGE);
            System.err.println(ex);
        }

        // Suppression
        // stmt.execute("DELETE FROM users WHERE idusers=4");
        // Mise a jour
// STEP 3: close the connexion to the database:
        conn.close();
    }

}
