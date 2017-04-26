package com.msia.cp;

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
            VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();
            logger.info("Suppression des données de la table Vue_Globale : début. " +
                    "Nombre de données dans la base : " + vueG.findAllVueGlobale().size());
            vueG.deleteAllVueGlobale();
            logger.info("Suppression des données de la table Vue_Globale : fin. " +
                    "Nombre de données restantes dans la base : " + vueG.findAllVueGlobale().size());

            logger.info("Lancement de l'enregistrement TSM vers Vue Globale");
            EnregistrementBdd.tsmVersVueGlobale();
            logger.info("Fin de l'enregistrement TSM vers Vue Globale");

            logger.info("Phase de calcul : début");
            CalculPrevisionnel CalculPrevisionnel = new com.msia.cp.util.CalculPrevisionnel();

            for(int i = 1; i <= 90; i++)
            {
                CalculPrevisionnel.PointXY_suivant("TSM", "AMPERE");
            }
            logger.info("Phase de calcul : fin");
        } catch (Exception e) {
            logger.error("erreur lors de l'enregistrement en base ou de la phase de calcul. " + e.toString());
        }
    }
}