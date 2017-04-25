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
 * Created by Cendri on 03/04/2017.
 */
public class TsmDaoImpl implements ITsmDAO {
    private static Logger logger = LoggerFactory.getLogger(TsmDaoImpl.class);

    private SessionFactory sessionFactory = new Configuration().configure("inv_datacenter.cfg.xml").buildSessionFactory();
    private Session session = null;
    private Transaction transaction = null;

    public ArrayList findAllTsm() {
        ArrayList tsmList = new ArrayList();
        try {
            session = sessionFactory.openSession();
            transaction = session.beginTransaction();
            //Appel de la requête présente dans le fichier Requete_InvDatacenter.hbm.xml
            Query query = session.getNamedQuery("TSMSelect");
            tsmList =  (ArrayList) query.list();
            transaction.commit();
            session.close();
        } catch (HibernateException e) {
            logger.error("Erreur lors de l'éxécution de la méthode findAllTsm /n" + e.toString());
        }
        return tsmList;
    }
}
