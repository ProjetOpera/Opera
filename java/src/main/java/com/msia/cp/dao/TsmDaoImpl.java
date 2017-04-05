package com.msia.cp.dao;

import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.cfg.Configuration;
import org.hibernate.query.Query;

import java.util.ArrayList;

/**
 * Created by Cendri on 03/04/2017.
 */
public class TsmDaoImpl implements ITsmDAO {
    SessionFactory sessionFactory = new Configuration().configure("tsm.cfg.xml").buildSessionFactory();
    Session session = null;
    Transaction transaction = null;

    public ArrayList findAllTsm() {
        ArrayList tsmList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.createQuery("from TSMEntity");
            tsmList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }
        return tsmList;
    }
}
