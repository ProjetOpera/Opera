package com.msia.cp.tests;

import com.msia.cp.dao.VirtualDaoImpl;

/**
 * Created by A618735 on 07/04/2017.
 */
public class VirtualTest {
    public static void main(String[] args) {
            VirtualDaoImpl virtual = new VirtualDaoImpl();
            System.out.println("Taille de la liste de virtualisation : " +virtual.findAllVirtual().size());

            for (Object o : virtual.findAllVirtual())
                System.out.println("  " + o.toString());
    }
}