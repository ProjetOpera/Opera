package com.msia.cp.dao;

import com.msia.cp.entities.VueGlobaleEntity;

import java.util.ArrayList;

/**
 * Created by Cendri on 30/03/2017.
 */
public interface IVueGlobaleDAO {
    public ArrayList findAllVueGlobale();
    public void createVueGloable(VueGlobaleEntity vue);
}
