package entities;

import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Table;
import java.sql.Timestamp;

/**
 * Created by A618735 on 16/03/2017.
 */
@Entity
@Table(name = "cp_tsm", schema = "inv_datacenter", catalog = "")
public class CpTsmEntity {
    private String tsmsite;
    private int tsmscratchtape;
    private int tsmdbpctutilPercent;
    private int libpctutilPercent;
    private int stockscratchtape;
    private Timestamp dateReleve;

    @Basic
    @Column(name = "tsmsite")
    public String getTsmsite() {
        return tsmsite;
    }

    public void setTsmsite(String tsmsite) {
        this.tsmsite = tsmsite;
    }

    @Basic
    @Column(name = "tsmscratchtape")
    public int getTsmscratchtape() {
        return tsmscratchtape;
    }

    public void setTsmscratchtape(int tsmscratchtape) {
        this.tsmscratchtape = tsmscratchtape;
    }

    @Basic
    @Column(name = "tsmdbpctutil_percent")
    public int getTsmdbpctutilPercent() {
        return tsmdbpctutilPercent;
    }

    public void setTsmdbpctutilPercent(int tsmdbpctutilPercent) {
        this.tsmdbpctutilPercent = tsmdbpctutilPercent;
    }

    @Basic
    @Column(name = "libpctutil_percent")
    public int getLibpctutilPercent() {
        return libpctutilPercent;
    }

    public void setLibpctutilPercent(int libpctutilPercent) {
        this.libpctutilPercent = libpctutilPercent;
    }

    @Basic
    @Column(name = "stockscratchtape")
    public int getStockscratchtape() {
        return stockscratchtape;
    }

    public void setStockscratchtape(int stockscratchtape) {
        this.stockscratchtape = stockscratchtape;
    }

    @Basic
    @Column(name = "date_releve")
    public Timestamp getDateReleve() {
        return dateReleve;
    }

    public void setDateReleve(Timestamp dateReleve) {
        this.dateReleve = dateReleve;
    }

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;

        CpTsmEntity that = (CpTsmEntity) o;

        if (tsmscratchtape != that.tsmscratchtape) return false;
        if (tsmdbpctutilPercent != that.tsmdbpctutilPercent) return false;
        if (libpctutilPercent != that.libpctutilPercent) return false;
        if (stockscratchtape != that.stockscratchtape) return false;
        if (tsmsite != null ? !tsmsite.equals(that.tsmsite) : that.tsmsite != null) return false;
        if (dateReleve != null ? !dateReleve.equals(that.dateReleve) : that.dateReleve != null) return false;

        return true;
    }

    @Override
    public int hashCode() {
        int result = tsmsite != null ? tsmsite.hashCode() : 0;
        result = 31 * result + tsmscratchtape;
        result = 31 * result + tsmdbpctutilPercent;
        result = 31 * result + libpctutilPercent;
        result = 31 * result + stockscratchtape;
        result = 31 * result + (dateReleve != null ? dateReleve.hashCode() : 0);
        return result;
    }
}
