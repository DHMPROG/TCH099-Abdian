package com.todoran.reservation_billet_avion.View;

import android.os.Bundle;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProvider;
import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

import java.io.IOException;

import com.todoran.reservation_billet_avion.R;
import com.todoran.reservation_billet_avion.UtilisateurDepot;
import com.todoran.reservation_billet_avion.ViewModel.LoginCallback;
import com.todoran.reservation_billet_avion.ViewModel.UtilisateurViewModel;

public class ConnexionActivity extends AppCompatActivity implements View.OnClickListener {

    private EditText emailEditText, motdepasseEditText;
    private Button btnAccueil, btnInscription;
    private TextView textViewConnexion;
    private UtilisateurViewModel utilisateurViewModel;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_connexion);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        btnAccueil = findViewById(R.id.buttonAccueil); // on pointe sur le bouton Accueil déjà crée dans le XML
        btnAccueil.setOnClickListener(this); // on enregistre le bouton Accueil comme écouteur

        btnInscription = findViewById(R.id.buttonInscription); // Pointe sur le bouton Inscription déjà crée dans le XML
        btnInscription.setOnClickListener(this); // Enregistre le bouton Inscription comme écouteur

        emailEditText = findViewById(R.id.editTextTextEmailAddress);
        motdepasseEditText = findViewById(R.id.editTextMotDePasse);

        textViewConnexion = findViewById(R.id.textViewConnexion);

        utilisateurViewModel = new ViewModelProvider(this).get(UtilisateurViewModel.class);
    }



    @Override
    public void onClick(View v) {
        if (v.getId() == R.id.buttonAccueil) {
            String email = emailEditText.getText().toString().trim();
            String password = motdepasseEditText.getText().toString().trim();

            UtilisateurDepot.loginUser(email, password, new LoginCallback() {
                @Override
                public void onSuccess() {
                    runOnUiThread(() -> {
                        Log.d("ConnexionActivity", "Connexion réussie, lancement de l'AccueilActivity...");
                        Intent intention = new Intent(ConnexionActivity.this, AccueilActivity.class);
                        startActivity(intention);
                        finish();
                    });
                }

                @Override
                public void onFailure(String errorMessage) {
                    runOnUiThread(() -> {
                        Log.d("ConnexionActivity", "Erreur de connexion : " + errorMessage);
                        Toast.makeText(ConnexionActivity.this, "Erreur : " + errorMessage, Toast.LENGTH_LONG).show();
                    });
                }
            });
        }


        if (v.getId() == R.id.buttonInscription) {
            Intent intent = new Intent(ConnexionActivity.this, InscriptionActivity.class);
            startActivity(intent);
        }
    }
}