package com.msia.cp.tests;

import com.msia.cp.dao.BaieDaoImpl;
import com.msia.cp.dao.TsmDaoImpl;
import com.msia.cp.util.EnregistrementBdd;

/**
 * Created by A618735 on 07/04/2017.
 */
public class BaieTest {
    public static void main(String[] args) {
        BaieDaoImpl baie = new BaieDaoImpl();
        System.out.println("Taille de la liste baie : " + baie.findAllBaie().size());

        for (Object o : baie.findAllBaie())
            System.out.println("  " + o.toString());
    }
}
