package com.msia.cp.tests;

import com.msia.cp.dao.VirtualDaoImpl;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Created by A618735 on 07/04/2017.
 */
public class VirtualTest {

    private static Logger logger = LoggerFactory.getLogger(VirtualTest.class);

    public static void main(String[] args) {

        logger.info("test");
        VirtualDaoImpl virtual = new VirtualDaoImpl();
        System.out.println("Taille de la liste de virtualisation : " + virtual.findAllVirtual().size());

        for (Object o : virtual.findAllVirtual())
            System.out.println("  " + o.toString());
    }
}