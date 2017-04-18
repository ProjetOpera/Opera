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
    private SessionFactory sessionFactory = new Configuration().configure("vueglobale.cfg.xml").buildSessionFactory();
    private Session session = null;
    private Transaction transaction = null;

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

    public ArrayList findAllBySite(String site) {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.createQuery("from VueGlobaleEntity as v where v.site = :site");
            query.setParameter("site", site);
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }
        return vueGlobaleList;
    }

    public ArrayList findAllByEnv(String env) {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.createQuery("from VueGlobaleEntity as v where v.env = :env");
            query.setParameter("env", env);
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }
        return vueGlobaleList;
    }

    public ArrayList findAllBySiteAndEnv(String site, String env) {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            // VueGlobaleEntity{prevision=0, env='TSM', date=2017-02-13 00:00:00.0,
            // site='AMPERE', id=248, custom1='146', custom2='26', custom3='97', custom4='75'
            // select disctint date mais afficher toutes les valeurs...
            // select v2.* from vueglobale as v2 where v2.id_reference in (select max(v.id_reference) from vueglobale as v where v.Site = 'AMPERE' and v.Environnement = 'TSM' group by v.Date_Releve)
            Query query = session.createQuery("from VueGlobaleEntity as v2 where v2.id in (select max(v.id) from VueGlobaleEntity as v where v.site = :site and v.env = :env group by v.date) order by v2.date");
            query.setParameter("site", site);
            query.setParameter("env", env);
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            e.printStackTrace();
        }
        return vueGlobaleList;
    }
}
