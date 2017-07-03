package com.msia.cp.entities;

import javax.persistence.*;
import java.io.Serializable;
import java.sql.Timestamp;

/**
 * Created by A618735 on 07/04/2017.
 */
@Entity
@Table(name = "inv_vcenter_cp", schema = "inv_datacenter", catalog = "")
public class VirtualEntity implements Serializable {
    @Id @GeneratedValue
    private Integer Id;
    private String vcenter;
    private String dataCenter;
    private String cluster;
    private Integer nbrHosts;
    private Integer nbrVMs;
    private Integer nbrVMsOn;
    private Integer vMsOnHosts;
    private Integer vCpUpCpu;
    private Integer totalMemoryPhyGb;
    private Integer usedMemoryGb;
    private Integer totalCpuMhz;
    private Integer usedCpuMhz;
    private Integer totalDiskspaceGb;
    private Integer usedDiskspaceGb;
    private Timestamp dateReleve;


    @Id
    @Column(name = "id_vcenter")
    public Integer getId() {
        return Id;
    }

    public void setId(Integer id) {
        Id = id;
    }

    @Basic
    @Column(name = "vcenter")
    public String getVcenter() {
        return vcenter;
    }

    public void setVcenter(String vcenter) {
        this.vcenter = vcenter;
    }

    @Basic
    @Column(name = "DataCenter")
    public String getDataCenter() {
        return dataCenter;
    }

    public void setDataCenter(String dataCenter) {
        this.dataCenter = dataCenter;
    }

    @Basic
    @Column(name = "Cluster")
    public String getCluster() {
        return cluster;
    }

    public void setCluster(String cluster) {
        this.cluster = cluster;
    }

    @Basic
    @Column(name = "NbrHosts")
    public Integer getNbrHosts() {
        return nbrHosts;
    }

    public void setNbrHosts(Integer nbrHosts) {
        this.nbrHosts = nbrHosts;
    }

    @Basic
    @Column(name = "NbrVMs")
    public Integer getNbrVMs() {
        return nbrVMs;
    }

    public void setNbrVMs(Integer nbrVMs) {
        this.nbrVMs = nbrVMs;
    }

    @Basic
    @Column(name = "NbrVMsOn")
    public Integer getNbrVMsOn() {
        return nbrVMsOn;
    }

    public void setNbrVMsOn(Integer nbrVMsOn) {
        this.nbrVMsOn = nbrVMsOn;
    }

    @Basic
    @Column(name = "VMsOnHosts")
    public Integer getvMsOnHosts() {
        return vMsOnHosts;
    }

    public void setvMsOnHosts(Integer vMsOnHosts) {
        this.vMsOnHosts = vMsOnHosts;
    }

    @Basic
    @Column(name = "vCPUpCPU")
    public Integer getvCpUpCpu() {
        return vCpUpCpu;
    }

    public void setvCpUpCpu(Integer vCpUpCpu) {
        this.vCpUpCpu = vCpUpCpu;
    }

    @Basic
    @Column(name = "Total_memory_phy_gb")
    public Integer getTotalMemoryPhyGb() {
        return totalMemoryPhyGb;
    }

    public void setTotalMemoryPhyGb(Integer totalMemoryPhyGb) {
        this.totalMemoryPhyGb = totalMemoryPhyGb;
    }

    @Basic
    @Column(name = "used_memory_gb")
    public Integer getUsedMemoryGb() {
        return usedMemoryGb;
    }

    public void setUsedMemoryGb(Integer usedMemoryGb) {
        this.usedMemoryGb = usedMemoryGb;
    }

    @Basic
    @Column(name = "total_cpu_mhz")
    public Integer getTotalCpuMhz() {
        return totalCpuMhz;
    }

    public void setTotalCpuMhz(Integer totalCpuMhz) {
        this.totalCpuMhz = totalCpuMhz;
    }

    @Basic
    @Column(name = "used_cpu_mhz")
    public Integer getUsedCpuMhz() {
        return usedCpuMhz;
    }

    public void setUsedCpuMhz(Integer usedCpuMhz) {
        this.usedCpuMhz = usedCpuMhz;
    }

    @Basic
    @Column(name = "total_diskspace_gb")
    public Integer getTotalDiskspaceGb() {
        return totalDiskspaceGb;
    }

    public void setTotalDiskspaceGb(Integer totalDiskspaceGb) {
        this.totalDiskspaceGb = totalDiskspaceGb;
    }

    @Basic
    @Column(name = "used_diskspace_gb")
    public Integer getUsedDiskspaceGb() {
        return usedDiskspaceGb;
    }

    public void setUsedDiskspaceGb(Integer usedDiskspaceGb) {
        this.usedDiskspaceGb = usedDiskspaceGb;
    }

    @Column(name = "date_releve")
    public Timestamp getDateReleve() {
        return dateReleve;
    }

    public void setDateReleve(Timestamp dateReleve) {
        this.dateReleve = dateReleve;
    }

    @Override
    public String toString() {
        return "VirtualEntity{" +
                "vcenter='" + vcenter + '\'' +
                ", dataCenter='" + dataCenter + '\'' +
                ", cluster='" + cluster + '\'' +
                ", nbrHosts=" + nbrHosts +
                ", nbrVMs=" + nbrVMs +
                ", nbrVMsOn=" + nbrVMsOn +
                ", vMsOnHosts=" + vMsOnHosts +
                ", vCpUpCpu=" + vCpUpCpu +
                ", totalMemoryPhyGb=" + totalMemoryPhyGb +
                ", usedMemoryGb=" + usedMemoryGb +
                ", totalCpuMhz=" + totalCpuMhz +
                ", usedCpuMhz=" + usedCpuMhz +
                ", totalDiskspaceGb=" + totalDiskspaceGb +
                ", usedDiskspaceGb=" + usedDiskspaceGb +
                ", dateReleve=" + dateReleve +
                '}';
    }

}
