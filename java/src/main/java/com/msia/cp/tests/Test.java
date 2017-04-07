package com.msia.cp.tests;

public class Test {
	public static void main(String[] args) {
		com.msia.cp.util.CalculPrevisionnel CalculPrevisionnel = new com.msia.cp.util.CalculPrevisionnel();

		for(int i = 1; i <= 10; i++)
		{
			CalculPrevisionnel.PointXY_suivant("TSM", "AMPERE");
		}
	}
}