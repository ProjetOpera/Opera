package util;

import java.util.HashMap;

public class CalculPrevisionnel {
	HashMap<Integer, PointXY> liste_PointXY = new HashMap<Integer, PointXY>();
	{
		liste_PointXY.put(1, new PointXY(1, 2));
		liste_PointXY.put(2, new PointXY(2, 4));
		liste_PointXY.put(3, new PointXY(3, 6));
	}
}