package com.msia.cp.tests;

import com.msia.cp.dao.VueGlobaleDaoImpl;
import com.msia.cp.entities.VueGlobaleEntity;
import com.msia.cp.util.EnregistrementBdd;

import java.sql.Timestamp;

/**
 * Created by Cendri on 30/03/2017.
 */
public class VueGlobaleTest {

    public static void main(String[] args) {
        VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();

        System.out.println("Taille de la liste vueG avant : " + vueG.findAllVueGlobale().size());
        //vueG.deleteAllVueGlobale();

        EnregistrementBdd.tsmVersVueGlobale();
        System.out.println("Taille de la liste vueG après : " + vueG.findAllVueGlobale().size());


        /*VueGlobaleEntity vue = new VueGlobaleEntity();
        vue.setPrevision(0);
        vue.setEnv("VEEAM");
        Timestamp date = new Timestamp(System.currentTimeMillis());
        vue.setDate(date);
        vue.setSite("Ampère");
        vue.setCustom1("56");
        vue.setCustom2("78");
        vue.setCustom3("256");
        vue.setCustom4("89");

        vueG.createVueGloable(vue);*/

        System.out.println("Taille de la liste vueG : " + vueG.findAllVueGlobale().size());
        System.out.println("Ampère : " + vueG.findAllBySite("Ampère").size());
        System.out.println("Franklin : " + vueG.findAllBySite("Franklin").size());

        System.out.println("Environnement Veeam : " + vueG.findAllByEnv("VEEAM").size());
        System.out.println("Environnement TSM : " + vueG.findAllByEnv("TSM").size());

        System.out.println("Environnement TSM + site Ampère: " + vueG.findAllBySiteAndEnv("AMPERE", "TSM").size());

        for (Object o : vueG.findAllBySiteAndEnv("AMPERE", "TSM")) {
            System.out.println("  " + o.toString());
        }

    }

}
