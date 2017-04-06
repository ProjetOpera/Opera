package com.msia.cp.entities;

import javax.persistence.*;
import java.sql.Timestamp;

/**
 * Created by Cendri on 30/03/2017.
 */
@Entity
@Table(name = "vueglobale", schema = "capacityplanning", catalog = "")
public class VueGlobaleEntity {
    private int prevision; // Boolean ? True/False ou 1/0 ? Int pour le moment
    private String env;
    private Timestamp date; // A vérifier
    private String site;
    private int id;
    // Custom
    private String custom1;
    private String custom2;
    private String custom3;
    private String custom4;
    private String custom5;
    private String custom6;
    private String custom7;
    private String custom8;
    private String custom9;
    private String custom10;
    private String custom11;
    private String custom12;
    private String custom13;
    private String custom14;

    @Basic
    @Column(name = "Prevision")
    public int getPrevision() {
        return prevision;
    }

    public void setPrevision(int prevision) {
        this.prevision = prevision;
    }

    @Basic
    @Column(name ="Environnement")
    public String getEnv() {
        return env;
    }

    public void setEnv(String env) {
        this.env = env;
    }

    @Basic
    @Column(name ="Date_Releve")
    public Timestamp getDate() {
        return date;
    }

    public void setDate(Timestamp date) {
        this.date = date;
    }

    @Basic
    @Column(name = "Site")
    public String getSite() {
        return site;
    }

    public void setSite(String site) {
        this.site = site;
    }

    @Id
    @Column(name = "id_Reference")
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    @Basic
    @Column(name = "Custom1")
    public String getCustom1() {
        return custom1;
    }

    public void setCustom1(String custom1) {
        this.custom1 = custom1;
    }

    @Basic
    @Column(name = "Custom2")
    public String getCustom2() {
        return custom2;
    }

    public void setCustom2(String custom2) {
        this.custom2 = custom2;
    }

    @Basic
    @Column(name = "Custom3")
    public String getCustom3() {
        return custom3;
    }

    public void setCustom3(String custom3) {
        this.custom3 = custom3;
    }

    @Basic
    @Column(name = "Custom4")
    public String getCustom4() {
        return custom4;
    }

    public void setCustom4(String custom4) {
        this.custom4 = custom4;
    }

    @Basic
    @Column(name = "Custom5")
    public String getCustom5() {
        return custom5;
    }

    public void setCustom5(String custom5) {
        this.custom5 = custom5;
    }

    @Basic
    @Column(name = "Custom6")
    public String getCustom6() {
        return custom6;
    }

    public void setCustom6(String custom6) {
        this.custom6 = custom6;
    }

    @Basic
    @Column(name = "Custom7")
    public String getCustom7() {
        return custom7;
    }

    public void setCustom7(String custom7) {
        this.custom7 = custom7;
    }

    @Basic
    @Column(name = "Custom8")
    public String getCustom8() {
        return custom8;
    }

    public void setCustom8(String custom8) {
        this.custom8 = custom8;
    }

    @Basic
    @Column(name = "Custom9")
    public String getCustom9() {
        return custom9;
    }

    public void setCustom9(String custom9) {
        this.custom9 = custom9;
    }

    @Basic
    @Column(name = "Custom10")
    public String getCustom10() {
        return custom10;
    }

    public void setCustom10(String custom10) {
        this.custom10 = custom10;
    }

    @Basic
    @Column(name = "Custom11")
    public String getCustom11() {
        return custom11;
    }

    public void setCustom11(String custom11) {
        this.custom11 = custom11;
    }

    @Basic
    @Column(name = "Custom12")
    public String getCustom12() {
        return custom12;
    }

    public void setCustom12(String custom12) {
        this.custom12 = custom12;
    }

    @Basic
    @Column(name = "Custom13")
    public String getCustom13() {
        return custom13;
    }

    public void setCustom13(String custom13) {
        this.custom13 = custom13;
    }

    @Basic
    @Column(name = "Custom14")
    public String getCustom14() {
        return custom14;
    }

    public void setCustom14(String custom14) {
        this.custom14 = custom14;
    }

    @Override
    public String toString() {
        return "VueGlobaleEntity{" +
                "prevision=" + prevision +
                ", env='" + env + '\'' +
                ", date=" + date +
                ", site='" + site + '\'' +
                ", id=" + id +
                ", custom1='" + custom1 + '\'' +
                ", custom2='" + custom2 + '\'' +
                ", custom3='" + custom3 + '\'' +
                ", custom4='" + custom4 + '\'' +
                ", custom5='" + custom5 + '\'' +
                ", custom6='" + custom6 + '\'' +
                ", custom7='" + custom7 + '\'' +
                ", custom8='" + custom8 + '\'' +
                ", custom9='" + custom9 + '\'' +
                ", custom10='" + custom10 + '\'' +
                ", custom11='" + custom11 + '\'' +
                ", custom12='" + custom12 + '\'' +
                ", custom13='" + custom13 + '\'' +
                ", custom14='" + custom14 + '\'' +
                '}';
    }
}
