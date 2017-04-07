package com.msia.cp.tests;

import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.HashMap;

import com.msia.cp.dao.VueGlobaleDaoImpl;
import com.msia.cp.entities.VueGlobaleEntity;
import com.msia.cp.util.PointXY;

public class Test {
	public static void main(String[] args) {
		com.msia.cp.util.CalculPrevisionnel CalculPrevisionnel = new com.msia.cp.util.CalculPrevisionnel();

		for(int i = 1; i <= 5; i++)
		{
			CalculPrevisionnel.PointXY_suivant("TSM", "AMPERE");
		}
	}
}
