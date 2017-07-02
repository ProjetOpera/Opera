package com.msia.cp.util;

import com.msia.cp.dao.TsmDaoImpl;
import com.msia.cp.dao.VirtualDaoImpl;
import com.msia.cp.dao.VueGlobaleDaoImpl;
import com.msia.cp.entities.TSMEntity;
import com.msia.cp.entities.VirtualEntity;
import com.msia.cp.entities.VueGlobaleEntity;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.sql.Timestamp;
import java.util.ArrayList;

/**
 * Created by Cendri on 05/04/2017.
 */
public class EnregistrementBdd {
    private static Logger logger = LoggerFactory.getLogger(EnregistrementBdd.class);

    public static void tsmVersVueGlobale() {

        try {
            TsmDaoImpl tsm = new TsmDaoImpl();
            VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();
            ArrayList tsmList = tsm.findAllTsm();
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
        } catch (Exception e) {
            logger.error("Erreur tsmVersVueGlobale. " + e.toString());
        }
    }

    public static void virtualVersVueGlobale() {

        try {
            VirtualDaoImpl virtu = new VirtualDaoImpl();
            VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();
            ArrayList virtuList = virtu.findAllVirtual();
            // VirtualEntity{vcenter='VSPPRDIF001VM', dataCenter='SNP1',
            // cluster='VSPGEOAFO', nbrHosts=6, nbrVMs=65, nbrVMsOn=64, vMsOnHosts=11, vCpUpCpu=1,
            // totalMemoryPhyGb=1536, usedMemoryGb=445, totalCpuMhz=335880, usedCpuMhz=19463, totalDiskspaceGb=19239,
            // usedDiskspaceGb=14988, dateReleve=2017-04-07 04:00:01.0}
            //
            // Données obligatoire pour VG :
            // Prevision, Env, date, Site
            // + Customs

            for (int i = 0; i < virtuList.size(); i++) {
                // Récupération des données de tsmList et transformation en objet TSMEntity pour traitement
                VirtualEntity virtualEntity = (VirtualEntity) virtuList.get(i);

                // Création d'un objet VueGlobaleEntity pour procéder à l'enregistrement en base.
                VueGlobaleEntity vue = new VueGlobaleEntity();
                vue.setPrevision(0);
                vue.setEnv("Virtualisation");
                vue.setDate(virtualEntity.getDateReleve());
                vue.setSite(virtualEntity.getCluster().substring(3,6));

                //vcenter
                vue.setCustom1(virtualEntity.getVcenter());
                //Datacenter
                vue.setCustom2(virtualEntity.getDataCenter());
                //cluster
                vue.setCustom3(virtualEntity.getCluster());
                //nbrHost
                vue.setCustom4(Integer.toString(virtualEntity.getNbrHosts()));
                //nbrVMs
                vue.setCustom5(Integer.toString(virtualEntity.getNbrVMs()));
                //nbrVMsOn
                vue.setCustom6(Integer.toString(virtualEntity.getNbrVMsOn()));
                //vMsOnHosts
                vue.setCustom7(Integer.toString(virtualEntity.getvMsOnHosts()));
                //vCpUpCPu1
                vue.setCustom8(Integer.toString(virtualEntity.getvCpUpCpu()));
                //totalMemoryPhyGB
                vue.setCustom9(Integer.toString(virtualEntity.getTotalMemoryPhyGb()));
                //usedMemoryGb
                vue.setCustom10(Integer.toString(virtualEntity.getUsedMemoryGb()));
                //totalCpuMhz
                vue.setCustom11(Integer.toString(virtualEntity.getTotalCpuMhz()));
                //usedCpuMhz
                vue.setCustom12(Integer.toString(virtualEntity.getUsedCpuMhz()));
                //totalDiskspaceGb
                vue.setCustom13(Integer.toString(virtualEntity.getTotalDiskspaceGb()));
                //usedDiskspaceGb
                vue.setCustom14(Integer.toString(virtualEntity.getUsedDiskspaceGb()));

                vueG.createVueGloable(vue);
            }
        } catch (Exception e) {
            logger.error("Erreur tsmVersVueGlobale. " + e.toString());
        }
    }
}
