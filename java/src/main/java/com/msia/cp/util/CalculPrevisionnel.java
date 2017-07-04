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
                DerniereDateBD = 0;

                //Calcul Custom1 Debut
                String PointXYSuivantCustom1 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom1()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom1 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom1 Fin

                //Calcul Custom2 Debut
                String PointXYSuivantCustom2 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString2 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString2.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom2()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString2.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom2 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom2 Fin

                //Calcul Custom3 Debut
                String PointXYSuivantCustom3 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString3 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString3.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom3()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString3.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom3 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom3 Fin

                //Calcul Custom4 Debut
                String PointXYSuivantCustom4 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString4 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString4.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom4()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString4.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom4 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom4 Fin

                //Calcul Custom5 Debut
                String PointXYSuivantCustom5 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString5 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString5.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom5()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString5.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom5 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom5 Fin

                //Calcul Custom6 Debut
                String PointXYSuivantCustom6 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString6 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString6.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom6()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString6.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom6 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom6 Fin

                //Calcul Custom7 Debut
                String PointXYSuivantCustom7 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString7 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString7.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom7()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString7.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom7 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom7 Fin

                //Calcul Custom8 Debut
                String PointXYSuivantCustom8 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString8 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString8.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom8()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString8.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom8 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom8 Fin

                //Calcul Custom9 Debut
                String PointXYSuivantCustom9 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString9 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString9.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom7()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString9.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom9 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom9 Fin

                //Calcul Custom10 Debut
                total = 0;
                float PointXYSuivantCustom10 = 0;
                HashMap<Integer, PointXY> liste_PointXY10 = new HashMap<Integer, PointXY>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    if (vueG_entity.getEnv().equals("Virtualisation")) {
                        //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                        liste_PointXY10.put(i, new PointXY((int) vueG_entity.getDate().getTime() / 1000, Float.parseFloat(vueG_entity.getCustom10())));

                        DerniereDateBD = vueG_entity.getDate().getTime() / 1000;
                    }
                }

                if (liste_PointXY10.size() < 30) {
                    coef = (float) 1 / liste_PointXY10.size();
                    ponderation = (float) 1 / liste_PointXY10.size();
                } else {
                    coef = (float) 1 / 30;
                    ponderation = (float) 1 / 30;
                }

                for (Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY10.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom10 = liste_PointXY_temp_valeur.Y;

                    if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY10.size() - 29) {
                        PointXY point_temp = liste_PointXY10.get(liste_PointXY_temp_cle.intValue() - 1);
                        total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
                        total_ponderation_inverse = total_ponderation_inverse + (1 - ponderation);
                        ponderation = ponderation + coef;
                    }
                }

                DerniereDateBD = DerniereDateBD + 86400;

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                PointXYSuivantCustom10 = PointXYSuivantCustom10 + total / total_ponderation_inverse;
                //Calcul Custom10 Fin

                //Calcul Custom11 Debut
                total = 0;
                float PointXYSuivantCustom11 = 0;
                HashMap<Integer, PointXY> liste_PointXY11 = new HashMap<Integer, PointXY>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    if (vueG_entity.getEnv().equals("Virtualisation")) {
                        //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                        liste_PointXY11.put(i, new PointXY((int) vueG_entity.getDate().getTime() / 1000, Float.parseFloat(vueG_entity.getCustom11())));

                        DerniereDateBD = vueG_entity.getDate().getTime() / 1000;
                    }
                }

                if (liste_PointXY11.size() < 30) {
                    coef = (float) 1 / liste_PointXY11.size();
                    ponderation = (float) 1 / liste_PointXY11.size();
                } else {
                    coef = (float) 1 / 30;
                    ponderation = (float) 1 / 30;
                }

                for (Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY11.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom11 = liste_PointXY_temp_valeur.Y;

                    if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY11.size() - 29) {
                        PointXY point_temp = liste_PointXY11.get(liste_PointXY_temp_cle.intValue() - 1);
                        total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
                        total_ponderation_inverse = total_ponderation_inverse + (1 - ponderation);
                        ponderation = ponderation + coef;
                    }
                }

                DerniereDateBD = DerniereDateBD + 86400;

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                PointXYSuivantCustom11 = PointXYSuivantCustom11 + total / total_ponderation_inverse;
                //Calcul Custom11 Fin

                //Calcul Custom12 Debut
                String PointXYSuivantCustom12 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString12 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString12.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom12()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString12.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom12 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom12 Fin

                //Calcul Custom13 Debut
                total = 0;
                float PointXYSuivantCustom13 = 0;
                HashMap<Integer, PointXY> liste_PointXY13 = new HashMap<Integer, PointXY>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    if (vueG_entity.getEnv().equals("Virtualisation")) {
                        //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                        liste_PointXY11.put(i, new PointXY((int) vueG_entity.getDate().getTime() / 1000, Float.parseFloat(vueG_entity.getCustom13())));

                        DerniereDateBD = vueG_entity.getDate().getTime() / 1000;
                    }
                }

                if (liste_PointXY13.size() < 30) {
                    coef = (float) 1 / liste_PointXY13.size();
                    ponderation = (float) 1 / liste_PointXY13.size();
                } else {
                    coef = (float) 1 / 30;
                    ponderation = (float) 1 / 30;
                }

                for (Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY13.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom13 = liste_PointXY_temp_valeur.Y;

                    if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY13.size() - 29) {
                        PointXY point_temp = liste_PointXY11.get(liste_PointXY_temp_cle.intValue() - 1);
                        total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
                        total_ponderation_inverse = total_ponderation_inverse + (1 - ponderation);
                        ponderation = ponderation + coef;
                    }
                }

                DerniereDateBD = DerniereDateBD + 86400;

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                PointXYSuivantCustom13 = PointXYSuivantCustom11 + total / total_ponderation_inverse;
                //Calcul Custom13 Fin

                //Calcul Custom14 Debut
                String PointXYSuivantCustom14 = "Erreur";
                HashMap<Integer, PointXYString> liste_PointXYString14 = new HashMap<Integer, PointXYString>();

                for (int i = 0; i < liste_vueG.size(); i++) {
                    VueGlobaleEntity vueG_entity = (VueGlobaleEntity) liste_vueG.get(i);
                    //liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
                    liste_PointXYString14.put(i, new PointXYString((int) vueG_entity.getDate().getTime() / 1000, vueG_entity.getCustom14()));
                }

                for (Entry<Integer, PointXYString> liste_PointXY_temp : liste_PointXYString14.entrySet()) {
                    Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
                    PointXYString liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
                    PointXYSuivantDate = liste_PointXY_temp_valeur.X;
                    PointXYSuivantCustom14 = liste_PointXY_temp_valeur.Y;
                }

                PointXYSuivantDate = PointXYSuivantDate + 86400;
                //Calcul Custom12 Fin

                //Instentiation vue
                Timestamp date = new Timestamp(DerniereDateBD * 1000);
                vue.setDate(date);
                vue.setCustom1(String.valueOf(PointXYSuivantCustom1));
                vue.setCustom2(String.valueOf(PointXYSuivantCustom2));
                vue.setCustom3(String.valueOf(PointXYSuivantCustom3));
                vue.setCustom4(String.valueOf(PointXYSuivantCustom4));
                vue.setCustom5(String.valueOf(PointXYSuivantCustom5));
                vue.setCustom6(String.valueOf(PointXYSuivantCustom6));
                vue.setCustom7(String.valueOf(PointXYSuivantCustom7));
                vue.setCustom8(String.valueOf(PointXYSuivantCustom8));
                vue.setCustom9(String.valueOf(PointXYSuivantCustom9));
                vue.setCustom10(String.valueOf(PointXYSuivantCustom10));
                vue.setCustom11(String.valueOf(PointXYSuivantCustom11));
                vue.setCustom12(String.valueOf(PointXYSuivantCustom12));
                vue.setCustom13(String.valueOf(PointXYSuivantCustom13));
                vue.setCustom14(String.valueOf(PointXYSuivantCustom14));
            }

            //Create vue (Enregistrement des resultats)
            vueG.createVueGloable(vue);
        }
        catch(Exception e){
            logger.error("Erreur PointXY_suivant. " + e.toString());
        }
	}
}