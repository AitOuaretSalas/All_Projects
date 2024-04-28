/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Control;

/**
 *
 * @author KHALED
 */
public class Employe {

    protected String nom;
    protected String prenom;
    protected int age;
    protected String adresse;
     //static int nbreInstances = 0;

    public Employe(String n, String p, int a, String adr) {
        this.nom = n;
        this.prenom = p;

        if (a >= 0) {
            this.age = a;
        } else {
            this.age = a * (-1);
        }

        this.adresse = adr;
        
        //nbreInstances=nbreInstances+1;
    }

    public Employe() {
        this.nom = "inconnu";
        this.prenom = "inconnu";
        this.age = 0;
        this.adresse = "nulle part";
        
        //nbreInstances=nbreInstances+1;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int a) {
        if (a >= 0) {
            this.age = a;
        } else {
            this.age = a * (-1);
        }

    }

    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }

    public void description() {
        System.out.println("l'employé s'appelle " + this.nom + " " + this.prenom + " et il a " + this.age + " ans et il habite à " + this.adresse);
    }

    public void comparerAge(Employe x) {
        if (x.age > this.age) {
            System.out.println(x.nom + " " + x.prenom + " est plus âgé que " + this.nom + " " + this.prenom);
        } else {
            if (x.age < this.age) {
                System.out.println(x.nom + " " + x.prenom + " est plus jeune que " + this.nom + " " + this.prenom);
            } else {
                System.out.println(x.nom + " " + x.prenom + " a le même âge que " + this.nom + " " + this.prenom);
            }
        }
    }

}
