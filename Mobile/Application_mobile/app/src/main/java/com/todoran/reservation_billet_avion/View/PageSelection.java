package com.todoran.reservation_billet_avion.View;

import android.os.Bundle;
import android.view.MenuItem;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.todoran.reservation_billet_avion.ListeVolsSingleton;
import com.todoran.reservation_billet_avion.Model.vol;
import com.todoran.reservation_billet_avion.R;
import com.todoran.reservation_billet_avion.ViewModel.VolAdapter;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;
import android.view.MenuItem;

public class PageSelection extends AppCompatActivity {

    private RecyclerView recyclerViewFlights;
    private VolAdapter volAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_flight_search);

        // Initialiser le RecyclerView
        recyclerViewFlights = findViewById(R.id.recyclerViewFlights);
        recyclerViewFlights.setLayoutManager(new LinearLayoutManager(this));
        List<vol> la_liste = ListeVolsSingleton.getInstance().getListeVols();
        int totalPassagers = getIntent().getIntExtra("totalPassagers", 1); // Valeur par défaut : 1


        // Configurer l'adaptateur
        volAdapter = new VolAdapter(la_liste, this, totalPassagers);
        recyclerViewFlights.setAdapter(volAdapter);


    }


}
