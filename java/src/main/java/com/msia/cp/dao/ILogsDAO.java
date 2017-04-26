package com.msia.cp.dao;

import java.util.ArrayList;

/**
 * Created by Cendri on 26/04/2017.
 */
public interface ILogsDAO {
    public ArrayList findAllLogs();
    public void deleteLogs();
}
