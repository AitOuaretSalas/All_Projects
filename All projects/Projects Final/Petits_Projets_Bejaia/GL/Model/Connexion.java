

package Model;

 
/*
 * Connexion.java
 *
 * Created on 18 février 2004, 15:35
 */
 
/**
 *
 * @author  c-top
 */
import java.sql.*;
import java.util.logging.Level;
import java.util.logging.Logger;
 
public class Connexion {
 
    private Connection con;
    private Statement stmt;
 
    /** Creates a new instance of Connexion */
    public Connexion() {
        String username = "root";
        String password = "";
        
        
        String url = "jdbc:mysql://localhost:3306/gestionpersonnel";
 
        try{
            Class.forName("com.mysql.jdbc.Driver");
        }catch(java.lang.ClassNotFoundException e) {
            System.err.print("ClassNotFoundException: ");
            System.err.println(e.getMessage());
        }
        try{
            con = DriverManager.getConnection(url, username, password);
            System.out.println("OK connexion réussie...");
            stmt = con.createStatement();
 
        }
 
        catch(SQLException ex){
            System.out.println(ex.getMessage());
        }
    }
 
    public Statement getStmt() {
        return stmt;
    }
 
    public Connection getCon() {
        return con;
    }
     
 public void seConnecter() {
        try{
            Connexion connect = new Connexion();
            stmt = connect.getStmt();
            con = connect.getCon();
//             rqt = new Requete(con, stmt);
            //mise_a_jour();
        }
        catch(Exception ex){
            System.out.println(ex.getMessage());
        }
    }
 public void close(){
        try {
            con.close();
        } catch (SQLException ex) {
            Logger.getLogger(Connexion.class.getName()).log(Level.SEVERE, null, ex);
        }
 }
}