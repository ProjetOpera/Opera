package com.msia.cp.util;

import com.msia.cp.dao.VueGlobaleDaoImpl;
import com.msia.cp.entities.VueGlobaleEntity;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map.Entry;

public class CalculPrevisionnel {
	private static Logger logger = LoggerFactory.getLogger(CalculPrevisionnel.class);

	//Cette fonction renvoie le prochain point previsionnel de l'environnement Environnement_util pour le site Site_util
    //Elle doit donc etre appelé 30 fois pour avoir les previsions des 30 prochains jours par exemple
	public void PointXY_suivant(String Environnement_util, String Site_util) {
	    try {
            //Variables
            float coef = 0;
            float ponderation = 0;
            float total = 0;
            float total_ponderation_inverse = 0;
            int PointXYSuivantDate = 0;
            long DerniereDateBD = 0;
            VueGlobaleDaoImpl vueG = new VueGlobaleDaoImpl();
            ArrayList liste_vueG = new ArrayList();
            liste_vueG = vueG.findAllBySiteAndEnv(Site_util, Environnement_util);

            //Instentiation vue
            VueGlobaleEntity vue = new VueGlobaleEntity();
            vue.setPrevision(1);
            vue.setEnv(Environnement_util);
            vue.setSite(Site_util);

            //Calcul TSM Debut (4 Customs)
            if (Environnement_util == "TSM") {
                //Calcul Custom1 Debut
                total = 0;
                float PointXYSuivantCustom1 = 0;
                HashMap<Integer, PointXY> liste_PointXY = new HashMap<Integer, PointXY>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXY.put(i, new PointXY((int) vueG_entity.getDate().getTime() / 1000, Float.parseFloat(vueG_entity.getCustom1())));
                }

                if (liste_PointXY.size() < 30) {
                    coef = (float) 1 / liste_PointXY.size();
                    ponderation = (float) 1 / liste_PointXY.size();
                } else {
                    coef = (float) 1 / 30;
                    ponderation = (float) 1 / 30;
                }

                for (Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom1 = liste_PointXY_temp_valeur.Y;

                    if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY.size() - 29) {
                        PointXY point_temp = liste_PointXY.get(liste_PointXY_temp_cle.intValue() - 1);
                        total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
                        total_ponderation_inverse = total_ponderation_inverse + (1 - ponderation);
                        ponderation = ponderation + coef;
                    }
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                PointXYSuivantCustom1 = PointXYSuivantCustom1 + total / total_ponderation_inverse;
                //Calcul Custom1 Fin

                //Calcul Custom2 Debut
                total = 0;
                float PointXYSuivantCustom2 = 0;
                HashMap<Integer, PointXY> liste_PointXY2 = new HashMap<Integer, PointXY>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXY2.put(i, new PointXY((int) vueG_entity.getDate().getTime() / 1000, Float.parseFloat(vueG_entity.getCustom2())));
                }

                if (liste_PointXY2.size() < 30) {
                    coef = (float) 1 / liste_PointXY2.size();
                    ponderation = (float) 1 / liste_PointXY2.size();
                } else {
                    coef = (float) 1 / 30;
                    ponderation = (float) 1 / 30;
                }

                for (Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY2.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom2 = liste_PointXY_temp_valeur.Y;

                    if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY2.size() - 29) {
                        PointXY point_temp = liste_PointXY2.get(liste_PointXY_temp_cle.intValue() - 1);
                        total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
                        total_ponderation_inverse = total_ponderation_inverse + (1 - ponderation);
                        ponderation = ponderation + coef;
                    }
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                PointXYSuivantCustom2 = PointXYSuivantCustom2 + total / total_ponderation_inverse;
                //Calcul Custom2 Fin

                //Calcul Custom3 Debut
                total = 0;
                float PointXYSuivantCustom3 = 0;
                HashMap<Integer, PointXY> liste_PointXY3 = new HashMap<Integer, PointXY>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXY3.put(i, new PointXY((int) vueG_entity.getDate().getTime() / 1000, Float.parseFloat(vueG_entity.getCustom3())));
                }

                if (liste_PointXY3.size() < 30) {
                    coef = (float) 1 / liste_PointXY3.size();
                    ponderation = (float) 1 / liste_PointXY3.size();
                } else {
                    coef = (float) 1 / 30;
                    ponderation = (float) 1 / 30;
                }

                for (Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY3.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom3 = liste_PointXY_temp_valeur.Y;

                    if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY3.size() - 29) {
                        PointXY point_temp = liste_PointXY3.get(liste_PointXY_temp_cle.intValue() - 1);
                        total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
                        total_ponderation_inverse = total_ponderation_inverse + (1 - ponderation);
                        ponderation = ponderation + coef;
                    }
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                PointXYSuivantCustom3 = PointXYSuivantCustom3 + total / total_ponderation_inverse;
                //Calcul Custom3 Fin

                //Calcul Custom4 Debut
                total = 0;
                float PointXYSuivantCustom4 = 0;
                HashMap<Integer, PointXY> liste_PointXY4 = new HashMap<Integer, PointXY>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXY4.put(i, new PointXY((int) vueG_entity.getDate().getTime() / 1000, Float.parseFloat(vueG_entity.getCustom4())));
                    DerniereDateBD = vueG_entity.getDate().getTime() / 1000;
                }

                if (liste_PointXY4.size() < 30) {
                    coef = (float) 1 / liste_PointXY4.size();
                    ponderation = (float) 1 / liste_PointXY4.size();
                } else {
                    coef = (float) 1 / 30;
                    ponderation = (float) 1 / 30;
                }

                for (Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY4.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom4 = liste_PointXY_temp_valeur.Y;

                    if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY4.size() - 29) {
                        PointXY point_temp = liste_PointXY4.get(liste_PointXY_temp_cle.intValue() - 1);
                        total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
                        total_ponderation_inverse = total_ponderation_inverse + (1 - ponderation);
                        ponderation = ponderation + coef;
                    }
                }

                DerniereDateBD = DerniereDateBD + 86400;
                PointXYSuivantCustom4 = PointXYSuivantCustom4 + total / total_ponderation_inverse;
                //Calcul Custom4 Fin

                //Instentiation vue
                Timestamp date = new Timestamp(DerniereDateBD * 1000);
                vue.setDate(date);
                vue.setCustom1(String.valueOf(PointXYSuivantCustom1));
                vue.setCustom2(String.valueOf(PointXYSuivantCustom2));
                vue.setCustom3(String.valueOf(PointXYSuivantCustom3));
                vue.setCustom4(String.valueOf(PointXYSuivantCustom4));
            }
            //Calcul TSM Fin

            //Calcul Virtualisation Debut (11 Customs)
            if (Environnement_util == "Virtualisation") {

            }

            //Create vue (Enregistrement des resultats)
            vueG.createVueGloable(vue);
        }
        catch(Exception e){
            logger.error("Erreur PointXY_suivant. " + e.toString());
        }
	}
}