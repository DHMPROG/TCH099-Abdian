package com.todoran.reservation_billet_avion.View;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.todoran.reservation_billet_avion.Model.vol;
import com.todoran.reservation_billet_avion.R;

public class PaiementActivity extends AppCompatActivity {

    private Button BoutonSoumettre;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_paiement);

        // Gestion des insets système (barres du haut/bas)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });


         BoutonSoumettre=findViewById(R.id.buttonSoumettre);

            vol selectedVol = (vol) getIntent().getSerializableExtra("vol");


            // Références aux TextView du bloc des détails
            TextView textViewFlightDetails = findViewById(R.id.textViewFlightDetails);
            TextView textViewPassengerCount = findViewById(R.id.textViewPassengerCount);
            TextView textViewTotalPrice = findViewById(R.id.textViewTotalPrice);


            textViewFlightDetails.setText("Vol sélectionné : " + selectedVol.getAirline() + " - " + selectedVol.getPrice() + "€");

        int totalPassagers = getIntent().getIntExtra("totalPassagers", 0);
        textViewPassengerCount.setText("Nombre de passagers : " + totalPassagers);


            double totalPrice = selectedVol.getPrice() * totalPassagers;
            textViewPassengerCount.setText("Nombre de passagers : " + totalPassagers);

            textViewTotalPrice.setText("Prix total : " + totalPrice + "€");




        BoutonSoumettre.setOnClickListener(v -> {
            if (validateEditTextFields()) {
                // Les champs sont valides, passez à l'étape suivante
                Intent intent = new Intent(PaiementActivity.this, FinalActivity.class);
                startActivity(intent);
            }
        });
        }


    private boolean validateEditTextFields() {
        EditText editTextCardNumber = findViewById(R.id.editTextCardNumber);
        EditText editTextCardHolder = findViewById(R.id.editTextHolderName);
        EditText editTextExpirationDate = findViewById(R.id.editTextExpiryDate);
        EditText editTextCVV = findViewById(R.id.editTextSecurityCode);

        // Vérification du numéro de carte
        String cardNumber = editTextCardNumber.getText().toString().trim();
        if (cardNumber.isEmpty() || cardNumber.length() != 16) {
            editTextCardNumber.setError("Numéro de carte invalide (16 chiffres requis)");
            return false;
        }

        // Vérification du nom du titulaire
        String cardHolder = editTextCardHolder.getText().toString().trim();
        if (cardHolder.isEmpty()) {
            editTextCardHolder.setError("Nom du titulaire requis");
            return false;
        }

        // Vérification de la date d'expiration
        String expirationDate = editTextExpirationDate.getText().toString().trim();
        if (!expirationDate.matches("(0[1-9]|1[0-2])/\\d{2}")) { // Format MM/YY
            editTextExpirationDate.setError("Date d'expiration invalide (format MM/YY)");
            return false;
        }

        // Vérification du CVV
        String cvv = editTextCVV.getText().toString().trim();
        if (cvv.isEmpty() || cvv.length() != 3) {
            editTextCVV.setError("CVV invalide (3 chiffres requis)");
            return false;
        }

        return true;
    }
    }
