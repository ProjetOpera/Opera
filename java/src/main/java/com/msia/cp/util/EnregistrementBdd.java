package com.msia.cp.util;

import com.msia.cp.dao.TsmDaoImpl;
import com.msia.cp.dao.VueGlobaleDaoImpl;
import com.msia.cp.entities.TSMEntity;
import com.msia.cp.entities.VueGlobaleEntity;

import java.sql.Timestamp;
import java.util.ArrayList;

/**
 * Created by Cendri on 05/04/2017.
 */
public class EnregistrementBdd {

    public static void tsmVersVueGlobale() {

        TsmDaoImpl tsm = new TsmDaoImpl();
        VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();
        ArrayList tsmList = new ArrayList();

        tsmList = tsm.findAllTsm();
        // TSMEntity{site='TSMAMPERE', scratchtape=146, dbpctutil=26, libpctutil=97,
        // stockscratchtape=75, date=2017-02-13 18:00:07.0}
        // Données obligatoire pour VG :
        // Prevision, Env, date, Site
        // + Customs

        for (int i = 0; i < tsmList.size(); i++) {
            // Récupération des données de tsmList et transformation en objet TSMEntity pour traitement
            TSMEntity tsmEntity = (TSMEntity) tsmList.get(i);

            // Création d'un objet VueGlobaleEntity pour procéder à l'enregistrement en base.
            VueGlobaleEntity vue = new VueGlobaleEntity();
            vue.setPrevision(0);
            vue.setEnv(tsmEntity.getSite().substring(0, 3));
            vue.setDate(tsmEntity.getDate());
            vue.setSite(tsmEntity.getSite().substring(3));
            //Scratchtape
            vue.setCustom1(Integer.toString(tsmEntity.getScratchtape()));
            //Dbpctutil
            vue.setCustom2(Integer.toString(tsmEntity.getDbpctutil()));
            //Libpctutil
            vue.setCustom3(Integer.toString(tsmEntity.getLibpctutil()));
            //Stockscratchtape
            vue.setCustom4(Integer.toString(tsmEntity.getStockscratchtape()));

            vueG.createVueGloable(vue);
        }
    }
}
