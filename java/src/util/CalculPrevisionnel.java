package util;

import java.util.HashMap;
import java.util.Map.Entry;

public class CalculPrevisionnel {
	public PointXY PointXY_suivant(HashMap<Integer, PointXY> liste_PointXY) {
		float coef = 0;
		float ponderation = 0;		
		float total = 0;
		float total_ponderation_inverse = 0;
		float PointXYSuivantX = 0;
		float PointXYSuivantY = 0;
		
		if (liste_PointXY.size() < 30)
		{
			coef = (float) 1/liste_PointXY.size();
			ponderation = (float) 1/liste_PointXY.size();
		}
		else
		{
			coef = (float) 1/30;
			ponderation = (float) 1/30;
		}
		
		for(Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY.entrySet()) {
			Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
			PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
			PointXYSuivantX = liste_PointXY_temp_valeur.X;
			PointXYSuivantY = liste_PointXY_temp_valeur.Y;
			
			if (liste_PointXY_temp_cle > 1 && liste_PointXY_temp_cle > liste_PointXY.size()-29)
			{
				PointXY point_temp = liste_PointXY.get(liste_PointXY_temp_cle.intValue()-1);
				total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y) * ponderation;
				total_ponderation_inverse = total_ponderation_inverse + (1-ponderation);
				ponderation = ponderation + coef;
			}
		}

		PointXYSuivantX = PointXYSuivantX+86400;
		PointXYSuivantY = PointXYSuivantY+total/total_ponderation_inverse;
		
		PointXY PointXYSuivant = new PointXY(PointXYSuivantX, PointXYSuivantY);
		
		return PointXYSuivant;
	}
}