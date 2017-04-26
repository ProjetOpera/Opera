package com.msia.cp.entities;

import javax.persistence.*;
import java.sql.Timestamp;

/**
 * Created by Cendri on 26/04/2017.
 */
@Entity
@Table(name = "cp_logs", schema = "capacityplanning", catalog = "")
public class LogsEntity {
    private Timestamp date;
    private String level;
    private String classe;
    private String line;
    private String message;

    @Id
    @Column(name = "Date_logs")
    public Timestamp getDate() {
        return date;
    }

    public void setDate(Timestamp date) {
        this.date = date;
    }

    @Basic
    @Column(name = "Level")
    public String getLevel() {
        return level;
    }

    public void setLevel(String level) {
        this.level = level;
    }

    @Basic
    @Column(name = "Classe")
    public String getClasse() {
        return classe;
    }

    public void setClasse(String classe) {
        this.classe = classe;
    }

    @Basic
    @Column(name = "Line")
    public String getLine() {
        return line;
    }

    public void setLine(String line) {
        this.line = line;
    }

    @Basic
    @Column(name = "Message")
    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    @Override
    public String toString() {
        return "LogsEntity{" +
                "date=" + date +
                ", level='" + level + '\'' +
                ", classe='" + classe + '\'' +
                ", line='" + line + '\'' +
                ", message='" + message + '\'' +
                '}';
    }
}
