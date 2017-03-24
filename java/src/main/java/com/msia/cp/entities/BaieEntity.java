package com.msia.cp.entities;

import javax.persistence.*;
import java.sql.Timestamp;

/**
 * Created by A618735 on 24/03/2017.
 */
@Entity
@Table(name = "baie", schema = "inv_san", catalog = "")
public class BaieEntity {
    private long id;
    private String name;
    private String role;
    private String situationsi;
    private String localisation;
    private String ville;
    private String model;
    private String systemstatus;
    private long nombreluns;
    private long nombreclients;
    private String version;
    private Timestamp dateReleve;

    @Id
    @Column(name = "id")
    public long getId() {
        return id;
    }

    public void setId(long id) {
        this.id = id;
    }

    @Basic
    @Column(name = "name")
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    @Basic
    @Column(name = "role")
    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    @Basic
    @Column(name = "situationsi")
    public String getSituationsi() {
        return situationsi;
    }

    public void setSituationsi(String situationsi) {
        this.situationsi = situationsi;
    }

    @Basic
    @Column(name = "localisation")
    public String getLocalisation() {
        return localisation;
    }

    public void setLocalisation(String localisation) {
        this.localisation = localisation;
    }

    @Basic
    @Column(name = "ville")
    public String getVille() {
        return ville;
    }

    public void setVille(String ville) {
        this.ville = ville;
    }

    @Basic
    @Column(name = "model")
    public String getModel() {
        return model;
    }

    public void setModel(String model) {
        this.model = model;
    }

    @Basic
    @Column(name = "systemstatus")
    public String getSystemstatus() {
        return systemstatus;
    }

    public void setSystemstatus(String systemstatus) {
        this.systemstatus = systemstatus;
    }

    @Basic
    @Column(name = "nombreluns")
    public long getNombreluns() {
        return nombreluns;
    }

    public void setNombreluns(long nombreluns) {
        this.nombreluns = nombreluns;
    }

    @Basic
    @Column(name = "nombreclients")
    public long getNombreclients() {
        return nombreclients;
    }

    public void setNombreclients(long nombreclients) {
        this.nombreclients = nombreclients;
    }

    @Basic
    @Column(name = "version")
    public String getVersion() {
        return version;
    }

    public void setVersion(String version) {
        this.version = version;
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

        BaieEntity that = (BaieEntity) o;

        if (id != that.id) return false;
        if (nombreluns != that.nombreluns) return false;
        if (nombreclients != that.nombreclients) return false;
        if (name != null ? !name.equals(that.name) : that.name != null) return false;
        if (role != null ? !role.equals(that.role) : that.role != null) return false;
        if (situationsi != null ? !situationsi.equals(that.situationsi) : that.situationsi != null) return false;
        if (localisation != null ? !localisation.equals(that.localisation) : that.localisation != null) return false;
        if (ville != null ? !ville.equals(that.ville) : that.ville != null) return false;
        if (model != null ? !model.equals(that.model) : that.model != null) return false;
        if (systemstatus != null ? !systemstatus.equals(that.systemstatus) : that.systemstatus != null) return false;
        if (version != null ? !version.equals(that.version) : that.version != null) return false;
        if (dateReleve != null ? !dateReleve.equals(that.dateReleve) : that.dateReleve != null) return false;

        return true;
    }

    @Override
    public int hashCode() {
        int result = (int) (id ^ (id >>> 32));
        result = 31 * result + (name != null ? name.hashCode() : 0);
        result = 31 * result + (role != null ? role.hashCode() : 0);
        result = 31 * result + (situationsi != null ? situationsi.hashCode() : 0);
        result = 31 * result + (localisation != null ? localisation.hashCode() : 0);
        result = 31 * result + (ville != null ? ville.hashCode() : 0);
        result = 31 * result + (model != null ? model.hashCode() : 0);
        result = 31 * result + (systemstatus != null ? systemstatus.hashCode() : 0);
        result = 31 * result + (int) (nombreluns ^ (nombreluns >>> 32));
        result = 31 * result + (int) (nombreclients ^ (nombreclients >>> 32));
        result = 31 * result + (version != null ? version.hashCode() : 0);
        result = 31 * result + (dateReleve != null ? dateReleve.hashCode() : 0);
        return result;
    }
}
