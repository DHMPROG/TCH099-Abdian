package com.todoran.reservation_billet_avion.View;

import android.annotation.SuppressLint;
import android.os.Build;
import android.os.Bundle;
import android.content.Intent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import android.view.MenuItem;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.lifecycle.ViewModelProvider;
import androidx.appcompat.widget.Toolbar;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

import com.todoran.reservation_billet_avion.Model.Utilisateur;
import com.todoran.reservation_billet_avion.R;
import com.todoran.reservation_billet_avion.ViewModel.UtilisateurViewModel;

public class InscriptionActivity extends AppCompatActivity {

    private EditText nomEditText, prenomEditText, ageEditText, phoneEditText, emailAddressEditText, motDePasseEditText;
    private Button buttonAccueil;
    private TextView textViewInscription;
    private UtilisateurViewModel utilisateurViewModel;

    @SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_inscription);
        utilisateurViewModel = new ViewModelProvider(this).get(UtilisateurViewModel.class);

        // Initialisation de la Toolbar
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true); // Affiche la flèche de retour
        // Personnaliser ou supprimer le titre
        getSupportActionBar().setTitle("");  // Supprime le titre

        getSupportActionBar().setHomeAsUpIndicator(R.drawable.ic_arrow_back); // Remplace par ton icône


        nomEditText = findViewById(R.id.editTextNom);
        prenomEditText = findViewById(R.id.editTextPrenom);
        emailAddressEditText = findViewById(R.id.editTextTextEmailAddress2);
        ageEditText = findViewById(R.id.editTextAge);
        phoneEditText = findViewById(R.id.editTextPhone);
        motDePasseEditText= findViewById(R.id.editTextMotDePasse2);
        buttonAccueil = findViewById(R.id.buttonAccueil2);

        buttonAccueil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                registreUtilisateur();
            }
        });
    }
    private void registreUtilisateur() {
        String nom = nomEditText.getText().toString();
        String prenom = prenomEditText.getText().toString();
        String email = emailAddressEditText.getText().toString();
        int age = Integer.parseInt(ageEditText.getText().toString());
        String telephone = phoneEditText.getText().toString();
        String mdp =  motDePasseEditText.getText().toString();

        Utilisateur utilisateur = new Utilisateur(nom, prenom, email, telephone, age , mdp);

        utilisateurViewModel.registreUtilisateur(utilisateur, new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(InscriptionActivity.this, "Erreur d'inscription", Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                if (response.isSuccessful()) {
                    runOnUiThread(() -> {
                        Toast.makeText(InscriptionActivity.this, "Inscription réussie", Toast.LENGTH_SHORT).show();

                        //Aller vers AccueilActivity après l'inscription réussie
                        Intent intent = new Intent(InscriptionActivity.this, AccueilActivity.class);
                        startActivity(intent);
                        finish(); //Ferme l'activité actuelle pour éviter le retour à l'inscription
                    });
                } else {
                    runOnUiThread(() -> Toast.makeText(InscriptionActivity.this, "Échec de l'inscription", Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
    // Méthode pour gérer la flèche de retour
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == android.R.id.home) {
            getOnBackPressedDispatcher().onBackPressed(); // Retour à l'activité précédente
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}