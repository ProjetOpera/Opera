package com.msia.cp.dao;

import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.cfg.Configuration;
import org.hibernate.query.Query;

import java.util.ArrayList;

/**
 * Created by A618735 on 07/04/2017.
 */
public class VirtualDaoImpl implements IVirtualDAO{
    private SessionFactory sessionFactory = new Configuration().configure("inv_datacenter.cfg.xml").buildSessionFactory();
    private Session session = null;
    private Transaction transaction = null;

    public ArrayList findAllVirtual() {
        ArrayList virtualList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            //Appel de la requête présente dans le fichier Requete_InvDatacenter.hbm.xml
            Query query = session.getNamedQuery("VirtualSelect");
            virtualList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }
        return virtualList;
    }
}

