package tests;

import java.util.HashMap;

import util.PointXY;

public class Test {
	public static void main(String[] args) {
		util.CalculPrevisionnel CalculPrevisionnel = new util.CalculPrevisionnel();
		HashMap<Integer, PointXY> liste_PointXY = new HashMap<Integer, PointXY>();
		
		//Instantiation du hashmap pour test
		//liste_PointXY.put(id_SQL, new PointXY(datetimestamp, valeur));
		liste_PointXY.put(1, new PointXY(1489532400, 200));
		liste_PointXY.put(2, new PointXY(1489618800, 180));
		liste_PointXY.put(3, new PointXY(1489705200, 185));
		liste_PointXY.put(4, new PointXY(1489791600, 175));
		liste_PointXY.put(5, new PointXY(1489878000, 172));
		
		for(int i = 1; i <= 30; i++)
		{
			PointXY PointXYSuivant = CalculPrevisionnel.PointXY_suivant(liste_PointXY);
			liste_PointXY.put(liste_PointXY.size()+1, PointXYSuivant);
			System.out.println("Point suivant : " + PointXYSuivant.X + "|" + PointXYSuivant.Y);
		}
	}
}
