package com.msia.cp.dao;

import com.msia.cp.entities.VueGlobaleEntity;
import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.cfg.Configuration;
import org.hibernate.Query;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.util.ArrayList;

/**
 * Created by Cendri on 30/03/2017.
 */

public class VueGlobaleDaoImpl implements IVueGlobaleDAO {
    private static Logger logger = LoggerFactory.getLogger(VueGlobaleDaoImpl.class);

    private SessionFactory sessionFactory = new Configuration().configure("vueglobale.cfg.xml").buildSessionFactory();
    private Session session = null;
    private Transaction transaction = null;

    public ArrayList findAllVueGlobale() {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            //Appel de la requête présente dans le fichier Requete_VueGloable.hbm.xml
            Query query = session.getNamedQuery("VueGSelect");
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur findAllVueGlobale. " + e.toString());
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
            logger.error("Erreur createVueGlobale. " + e.toString());
        }

    }

    public void deleteAllVueGlobale() {
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.getNamedQuery("VueGDeleteAll");
            query.executeUpdate();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur deleteAllVueGlobale. " + e.toString());
        }

    }

    public ArrayList findAllBySite(String site) {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.getNamedQuery("VGFindAllBySite");
            query.setParameter("site", site);
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur findAllBySite. " + e.toString());
        }
        return vueGlobaleList;
    }

    public ArrayList findAllByEnv(String env) {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.getNamedQuery("VGFindAllByEnv");
            query.setParameter("env", env);
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur findAllByEnv. " + e.toString());
        }
        return vueGlobaleList;
    }

    public ArrayList findAllBySiteAndEnv(String site, String env) {
        ArrayList vueGlobaleList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.getNamedQuery("VGFindAllBySiteAndEnv");
            query.setParameter("site", site);
            query.setParameter("env", env);
            vueGlobaleList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur findAllBySiteAndEnv. " + e.toString());
        }
        return vueGlobaleList;
    }
}
