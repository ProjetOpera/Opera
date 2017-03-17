package util;

import java.util.HashMap;
import java.util.Map.Entry;

public class CalculPrevisionnel {
	HashMap<Integer, PointXY> liste_PointXY = new HashMap<Integer, PointXY>();
	{
		liste_PointXY.put(1, new PointXY(1, 3));
		liste_PointXY.put(2, new PointXY(2, 2));
		liste_PointXY.put(3, new PointXY(3, 1));
		liste_PointXY.put(4, new PointXY(4, 3));
		liste_PointXY.put(5, new PointXY(5, 5));
		
		float coef = (float) 1/5;
		float ponderation = (float) 1/5;
		float total = 0;
		float result = 0;
		
		//Difference entre n et n-1 pondéré par la date, plus la date approche plus la valeur est representatrice
		//http://forums.futura-sciences.com/mathematiques-superieur/249530-predire-prochain-point-dune-courbe.html
		for(Entry<Integer, PointXY> liste_PointXY_temp : liste_PointXY.entrySet()) {
			Integer liste_PointXY_temp_cle = liste_PointXY_temp.getKey();
			PointXY liste_PointXY_temp_valeur = liste_PointXY_temp.getValue();
			
			if (liste_PointXY_temp_valeur.X > 1)
			{
				PointXY point_temp = liste_PointXY.get(liste_PointXY_temp_cle.intValue()-1);
				total = total + (liste_PointXY_temp_valeur.Y - point_temp.Y);
				ponderation = ponderation + coef;
			}
		}
		
		result = total/4;
		
		System.out.println("Pas d'avancement courbe : " + result);
	}
}