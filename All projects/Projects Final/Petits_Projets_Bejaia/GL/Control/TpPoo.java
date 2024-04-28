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
public class TpPoo {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Employe e = new Employe();
        
        Employe a = new Employe ("Mira","Abderrahmane",50,"Béjaia");
        Employe b = new Employe ("Abane","Ramdane",55,"Tizi Ouzou" );
        a.comparerAge(b);
        
          System.out.println(a.getAge());
          a.setAge(-100);
          System.out.println(a.getAge());
        
//        System.out.println(e.age);
//        e.age= -100;
//        System.out.println(e.age);
//        
//        System.out.println(a.age);
//        a.age= -100;
//        System.out.println(a.age);

        
        
        ChefService c = new ChefService("Hamadi","Karim",55,"Alger","Personnel");
        c.description();
    }
    
}
