package com.todoran.reservation_billet_avion;

import com.todoran.reservation_billet_avion.Model.vol;

import java.util.List;

public class ListeVolsSingleton {
    private static ListeVolsSingleton instance;
    private List<vol> listeVols;

    private ListeVolsSingleton() {}

    public static ListeVolsSingleton getInstance() {
        if (instance == null) {
            instance = new ListeVolsSingleton();
        }
        return instance;
    }

    public void setListeVols(List<vol> listeVols) {
        this.listeVols = listeVols;
    }

    public List<vol> getListeVols() {
        return listeVols;
    }
}
