package com.msia.cp.tests;

import com.msia.cp.dao.VueGlobaleDaoImpl;
import com.msia.cp.entities.VueGlobaleEntity;

import java.sql.Timestamp;

/**
 * Created by Cendri on 30/03/2017.
 */
public class VueGlobaleTest {

    public static void main(String[] args) {
        VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();
        System.out.println("Taille de la liste vueG : " + vueG.findAllVueGlobale().size());

        VueGlobaleEntity vue = new VueGlobaleEntity();
        vue.setPrevision(0);
        vue.setEnv("TSM");
        Timestamp date = new Timestamp(System.currentTimeMillis());
        vue.setDate(date);
        vue.setSite("Ampère");
        vue.setCustom1("56");
        vue.setCustom2("78");
        vue.setCustom3("256");
        vue.setCustom4("89");

        vueG.createVueGloable(vue);

        System.out.println("Taille de la liste vueG : " + vueG.findAllVueGlobale().size());

    }

}
