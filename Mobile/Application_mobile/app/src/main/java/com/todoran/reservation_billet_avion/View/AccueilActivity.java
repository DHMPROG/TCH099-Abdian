package com.todoran.reservation_billet_avion.View;

import static com.todoran.reservation_billet_avion.Model.Dao.HttpJsonService.VolsJsonVersClasses;

import android.app.DatePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.todoran.reservation_billet_avion.Model.vol;
import com.todoran.reservation_billet_avion.R;

import java.io.IOException;
import java.io.Serializable;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

public class AccueilActivity extends AppCompatActivity {

    private Spinner  spinnerClasse;
    private EditText spinnerDepart, spinnerDestination;
    private TextView viewTextDateDepart, viewTextDateRetour;
    private TextView textViewMoins1, textViewPlus1, textViewAdult;
    private TextView textViewMoins2, textViewPlus2, textViewEnfant;
    private Button buttonRechercher;

    private int nbAdult = 1;
    private int nbEnfant = 1;
    private Calendar calendarDepart = Calendar.getInstance();
    private Calendar calendarRetour = Calendar.getInstance();
    private SimpleDateFormat dateFormat = new SimpleDateFormat("dd MMM yyyy", Locale.getDefault());

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_accueil);

        spinnerDepart = findViewById(R.id.spinnerDepart);
        spinnerDestination = findViewById(R.id.spinnerDestination);
        spinnerClasse = findViewById(R.id.spinnerClasse);

        viewTextDateDepart = findViewById(R.id.viewTextDateDepart);


        textViewMoins1 = findViewById(R.id.textViewMoins1);
        textViewPlus1 = findViewById(R.id.textViewPlus1);
        textViewAdult = findViewById(R.id.textViewAdult);

        textViewMoins2 = findViewById(R.id.textViewMoins2);
        textViewPlus2 = findViewById(R.id.textViewPlus2);
        textViewEnfant = findViewById(R.id.textViewEnfant);

        buttonRechercher = findViewById(R.id.buttonRechercher);

        // DatePicker pour la date de dÃ©part
        viewTextDateDepart.setOnClickListener(v -> showDatePickerDialog(calendarDepart, viewTextDateDepart));



        updatePassengerText();

        // Gestion du + / - pour adulte
        textViewPlus1.setOnClickListener(v -> {
            nbAdult++;
            updatePassengerText();
        });
        textViewMoins1.setOnClickListener(v -> {
            if (nbAdult > 0) nbAdult--;
            updatePassengerText();
        });

        // Gestion du + / - pour enfant
        textViewPlus2.setOnClickListener(v -> {
            nbEnfant++;
            updatePassengerText();
        });
        textViewMoins2.setOnClickListener(v -> {
            if (nbEnfant > 0) nbEnfant--;
            updatePassengerText();
        });

        buttonRechercher.setOnClickListener

                (v -> {



            String depart = spinnerDepart.getText().toString().trim();
            String destination = spinnerDestination.getText().toString().trim();
            String dateDepart = viewTextDateDepart.getText().toString();

            String classe = spinnerClasse.getSelectedItem().toString();
            int totalPassagers = nbAdult + nbEnfant;

            String parametre= "depart=" + depart + "&arivee=" + destination + "&date=" + dateDepart ;



                    new Thread(() -> {
                        try {
                            List<vol> la_liste = VolsJsonVersClasses(parametre);

                            runOnUiThread(() -> {
                                if (la_liste != null) {
                                    Intent intent = new Intent(AccueilActivity.this, PageSelection.class);
                                    intent.putExtra("depart", depart);
                                    intent.putExtra("destination", destination);
                                    intent.putExtra("dateDepart", dateDepart);
                                    intent.putExtra("classe", classe);
                                    intent.putExtra("nbAdult", nbAdult);
                                    intent.putExtra("nbEnfant", nbEnfant);
                                    intent.putExtra("totalPassagers", totalPassagers);
                                    intent.putExtra("liste", (Serializable) la_liste);

                                    startActivity(intent);
                                } else {
                                    Toast.makeText(this, "Aucun vol trouvé.", Toast.LENGTH_SHORT).show();
                                }
                            });
                        } catch (IOException | org.json.JSONException e) {
                            e.printStackTrace();
                            runOnUiThread(() ->
                                    Toast.makeText(this, "Erreur lors de la récupération des vols.", Toast.LENGTH_SHORT).show()
                            );
                        }
                    }).start();
                });
    }

    private void showDatePickerDialog(Calendar calendar, TextView targetTextView) {
        new DatePickerDialog(this, (DatePicker view, int year, int month, int dayOfMonth) -> {
            calendar.set(year, month, dayOfMonth);
            targetTextView.setText(dateFormat.format(calendar.getTime()));
        }, calendar.get(Calendar.YEAR), calendar.get(Calendar.MONTH), calendar.get(Calendar.DAY_OF_MONTH)).show();
    }

    private void updatePassengerText() {
        textViewAdult.setText(nbAdult + " Adulte" + (nbAdult > 1 ? "s" : ""));
        textViewEnfant.setText(nbEnfant + " Enfant" + (nbEnfant > 1 ? "s" : ""));
    }
}