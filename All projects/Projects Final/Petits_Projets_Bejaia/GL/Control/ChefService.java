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
public class ChefService extends Employe{
    


    
    private String service;
    
    public ChefService() {
        super();
        service="inconnu";
    }

    public ChefService(String n, String p, int a, String adr,String ser) {
        super(n, p, a, adr);
        service=ser;
    }

    

    public String getService() {
        return service;
    }

    public void setService(String service) {
        this.service = service;
    }
    public void description(){
        super.description();
        System.out.println("et il gère le service"+service);
    }
    
}
