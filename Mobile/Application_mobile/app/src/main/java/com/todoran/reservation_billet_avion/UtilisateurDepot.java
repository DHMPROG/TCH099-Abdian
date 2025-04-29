package com.todoran.reservation_billet_avion;



import android.util.Log;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;

import com.fasterxml.jackson.core.type.TypeReference;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.todoran.reservation_billet_avion.Model.Utilisateur;
import com.todoran.reservation_billet_avion.ViewModel.LoginCallback;

import java.io.IOException;
import java.util.List;


import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.OkHttpClient;
import okhttp3.RequestBody;
import okhttp3.Request;
import okhttp3.MediaType;
import okhttp3.Response;
public class UtilisateurDepot {
    //private final APIClient apiClient;
    private final OkHttpClient client;
    private final MutableLiveData<List<Utilisateur>> utilisateurListLiveData = new MutableLiveData<>();
    private static final String BASE_URL = "http://10.0.2.2:8000/api/users"; //Remplacer le url relle en string(C'est le serveur local JSON)
    private static final MediaType JSON = MediaType.get("application/json; charset=utf-8");
    public UtilisateurDepot() {
        Log.d("UtilisateurDepot", "Constructeur appelé !"); // Vérifier si le constructeur est bien exécuté
        client = new OkHttpClient();
        //apiClient = new APIClient();
        //loadUsers();
    }





    public LiveData<List<Utilisateur>> getUtilisateurs(){
        return utilisateurListLiveData;
    }


        // Méthode pour effectuer l'inscription avec des paramètres
        public static void registerUser(String prenom, String nom, String email, String motDePasse, String telephone,int age, Callback callback) {
            new Thread(() -> {
                OkHttpClient client = new OkHttpClient();

                String json = "{"
                        + "\"prenom\": \"" + prenom + "\","
                        + "\"nom\": \"" + nom + "\","
                        + "\"email\": \"" + email + "\","
                        + "\"motDePasse\": \"" + motDePasse + "\","
                        + "\"telephone\": \"" + telephone + "\""
                        + "\"age\": " + age
                        + "}";

                RequestBody body = RequestBody.create(json, MediaType.get("application/json; charset=utf-8"));
                Request request = new Request.Builder()
                        .url(BASE_URL + "/?action=register")
                        .post(body)
                        .build();

                try (Response response = client.newCall(request).execute()) {
                    if (response.isSuccessful()) {
                        Log.d("UtilisateurDepot", "Inscription réussie : " + response.body().string());
                        if (callback != null) {
                            callback.onResponse(null, response);
                        }
                    } else {
                        Log.d("UtilisateurDepot", "Erreur : " + response.code());
                        if (callback != null) {
                            callback.onFailure(null, new IOException("Erreur : " + response.code()));
                        }
                    }
                } catch (IOException e) {
                    Log.e("UtilisateurDepot", "Exception : " + e.getMessage());
                    if (callback != null) {
                        callback.onFailure(null, e);
                    }
                }
            }).start();
        }


    public static void loginUser(String email, String motDePasse, LoginCallback callback) {
        new Thread(() -> {
            OkHttpClient client = new OkHttpClient();

            String json = "{"
                    + "\"email\": \"" + email + "\","
                    + "\"motDePasse\": \"" + motDePasse + "\""
                    + "}";

            RequestBody body = RequestBody.create(json, MediaType.get("application/json; charset=utf-8"));
            Request request = new Request.Builder()
                    .url(BASE_URL + "/?action=login")
                    .post(body)
                    .build();

            try (Response response = client.newCall(request).execute()) {
                if (response.isSuccessful()) {
                    System.out.println("Connexion réussie : " + response.body().string());
                    callback.onSuccess(); // Notifie le succès
                } else {
                    System.out.println("Erreur : " + response.code());
                    callback.onFailure("Erreur : " + response.code());
                }
            } catch (IOException e) {
                e.printStackTrace();
                callback.onFailure(e.getMessage());
            }
        }).start();
    }

}

