package com.msia.cp.dao;

import com.msia.cp.entities.VueGlobaleEntity;
import org.hibernate.*;
import org.hibernate.cfg.Configuration;
import org.hibernate.query.Query;

import java.util.ArrayList;

/**
 * Created by Cendri on 30/03/2017.
 */

public class VueGlobaleDaoImpl implements IVueGlobaleDAO {
    SessionFactory sessionFactory = new Configuration().configure("vueglobale.cfg.xml").buildSessionFactory();
    Session session = null;
    Transaction transaction = null;

    public ArrayList findAllVueGlobale() {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.createQuery("from VueGlobaleEntity");
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }
        return vueGlobaleList;
    }

    public void createVueGloable(VueGlobaleEntity vue) {
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            session.saveOrUpdate(vue);

            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }

    }
}
