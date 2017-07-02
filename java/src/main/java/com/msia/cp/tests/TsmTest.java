package com.msia.cp.tests;

import com.msia.cp.dao.TsmDaoImpl;
import com.msia.cp.entities.TSMEntity;
import com.msia.cp.util.EnregistrementBdd;

/**
 * Created by Cendri on 03/04/2017.
 */
public class TsmTest {


    public static void main(String[] args) {
        TsmDaoImpl tsm = new TsmDaoImpl();
        System.out.println("Taille de la liste tsm : " + tsm.findAllTsm().size());

        for (Object o : tsm.findAllTsm())
            System.out.println("  " + o.toString());

        EnregistrementBdd.tsmVersVueGlobale();


    }
}
