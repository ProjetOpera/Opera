package com.msia.cp;

import com.msia.cp.dao.LogsDaoImpl;
import com.msia.cp.dao.VueGlobaleDaoImpl;
import com.msia.cp.util.CalculPrevisionnel;
import com.msia.cp.util.EnregistrementBdd;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Created by A618735 on 16/03/2017.
 */
public class Main {

    private static Logger logger = LoggerFactory.getLogger(Main.class);

    public static void main(String[] args) {

        try {
            LogsDaoImpl logs = new LogsDaoImpl();
            logger.info("Suppression des données de la table cp_logs : début. " +
                    "Nombre de données dans la base : " + logs.findAllLogs().size());
            logs.deleteLogs();
            logger.info("Suppression des données de la table cp_logs : fin. " +
                    "Nombre de données restantes dans la base : " + logs.findAllLogs().size());
        }catch (Exception e) {
            logger.error("Erreur initialisation des logs. " + e.toString());
        }
        try {
            VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();
            logger.info("Suppression des données de la table Vue_Globale : début. " +
                    "Nombre de données dans la base : " + vueG.findAllVueGlobale().size());
            vueG.deleteAllVueGlobale();
            logger.info("Suppression des données de la table Vue_Globale : fin. " +
                    "Nombre de données restantes dans la base : " + vueG.findAllVueGlobale().size());

            logger.info("Lancement de l'enregistrement TSM vers Vue Globale");
            EnregistrementBdd.tsmVersVueGlobale();
            logger.info("Fin de l'enregistrement TSM vers Vue Globale");

            logger.info("Lancement de l'enregistrement Virtualisation vers Vue Globale");
            EnregistrementBdd.virtualVersVueGlobale();
            logger.info("Fin de l'enregistrement Virtualisation vers Vue Globale");

            logger.info("Phase de calcul : début");
            CalculPrevisionnel CalculPrevisionnel = new com.msia.cp.util.CalculPrevisionnel();

            for(int i = 1; i <= 90; i++)
            {
                CalculPrevisionnel.PointXY_suivant("TSM", "AMPERE");
                CalculPrevisionnel.PointXY_suivant("TSM", "FRANKLIN");
                CalculPrevisionnel.PointXY_suivant("Virtualisation", "AMP");
                CalculPrevisionnel.PointXY_suivant("Virtualisation", "FKL");
            }
            logger.info("Phase de calcul : fin");
        } catch (Exception e) {
            logger.error("Erreur enregistrement en base ou calcul. " + e.toString());
        }
    }
}