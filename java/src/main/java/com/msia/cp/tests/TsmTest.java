package com.msia.cp.tests;

import com.msia.cp.dao.TsmDaoImpl;

/**
 * Created by Cendri on 03/04/2017.
 */
public class TsmTest {

    public static void main(String[] args) {
        TsmDaoImpl tsm = new TsmDaoImpl();

        System.out.println("Taille de la liste vueG : " + tsm.findAllTsm().size());

    }

}
