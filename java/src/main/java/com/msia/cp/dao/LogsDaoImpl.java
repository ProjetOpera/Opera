package com.msia.cp.dao;

import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.cfg.Configuration;
import org.hibernate.query.Query;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.util.ArrayList;

/**
 * Created by Cendri on 26/04/2017.
 */
public class LogsDaoImpl implements ILogsDAO {
    private static Logger logger = LoggerFactory.getLogger(TsmDaoImpl.class);

    private SessionFactory sessionFactory = new Configuration().configure("vueglobale.cfg.xml").buildSessionFactory();
    private Session session = null;
    private Transaction transaction = null;

    public ArrayList findAllLogs() {
        ArrayList logsList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            //Appel de la requête présente dans le fichier Requete_VueGloable.hbm.xml
            Query query = session.getNamedQuery("LogsSelect");
            logsList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur findAllLogs. " + e.toString());
        }
        return logsList;
    }

    public void deleteLogs() {
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            Query query = session.getNamedQuery("LogsDeleteAll");
            query.executeUpdate();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur deleteLogs. " + e.toString());
        }
    }
}
