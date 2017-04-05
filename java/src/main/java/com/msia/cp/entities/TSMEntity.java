package com.msia.cp.entities;

import javax.persistence.*;
import java.sql.Timestamp;

/**
 * Created by Cendri on 03/04/2017.
 */
@Entity
@Table(name = "cp_tsm", schema = "inv_datacenter", catalog = "")
public class TSMEntity {
    private String site;
    private int scratchtape;
    private int dbpctutil;
    private int libpctutil;
    private int stockscratchtape;
    private Timestamp date;

    @Basic
    @Column(name = "tsmsite")
    public String getSite() {
        return site;
    }

    public void setSite(String site) {
        this.site = site;
    }

    @Basic
    @Column(name = "tsmscratchtape")
    public int getScratchtape() {
        return scratchtape;
    }

    public void setScratchtape(int scratchtape) {
        this.scratchtape = scratchtape;
    }

    @Basic
    @Column(name = "tsmdbpctutil_percent")
    public int getDbpctutil() {
        return dbpctutil;
    }

    public void setDbpctutil(int dbpctutil) {
        this.dbpctutil = dbpctutil;
    }

    @Basic
    @Column(name = "libpctutil_percent")
    public int getLibpctutil() {
        return libpctutil;
    }

    public void setLibpctutil(int libpctutil) {
        this.libpctutil = libpctutil;
    }

    @Basic
    @Column(name = "stockscratchtape")
    public int getStockscratchtape() {
        return stockscratchtape;
    }

    public void setStockscratchtape(int stockscratchtape) {
        this.stockscratchtape = stockscratchtape;
    }

    @Id // Pour les besoin d'hibernate, n'est pas considéré comme Id dans la table, à voir si cela pose problème
    @Column(name = "date_releve")
    public Timestamp getDate() {
        return date;
    }

    public void setDate(Timestamp date) {
        this.date = date;
    }
}
