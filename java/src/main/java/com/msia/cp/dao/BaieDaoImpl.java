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
public class BaieDaoImpl implements IBaieDAO{
    SessionFactory sessionFactory = new Configuration().configure("baie.cfg.xml").buildSessionFactory();
    Session session = null;
    Transaction transaction = null;

    public ArrayList findAllBaie() {
        ArrayList baieList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.createQuery("from BaieEntity");
            baieList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }
        return baieList;
    }
}

