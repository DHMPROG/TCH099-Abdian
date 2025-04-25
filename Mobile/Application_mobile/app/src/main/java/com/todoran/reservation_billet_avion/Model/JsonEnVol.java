package com.todoran.reservation_billet_avion.Model;

import android.util.Log;

import androidx.annotation.Nullable;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;

import org.json.JSONException;

import java.io.IOException;
import java.util.List;

import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import okhttp3.ResponseBody;

public class JsonEnVol
{



    private static String URL_POINT_ENTREE = "https://10.0.2.2:8000";
    // Exemple de JSON
    // Fonction pour convertir un JSON en tableau d'objets Vol
    public static List<vol> VolsJsonVersClasses(@Nullable String parametres) throws IOException, JSONException {
        OkHttpClient client = new OkHttpClient();

        if (parametres == null) {
            parametres = "";
        } else {
            parametres = "?" + parametres;
        }
        Request requete = new Request.Builder()
                .url(URL_POINT_ENTREE + "/api/vols" + parametres)
                .build();

        Response reponse = client.newCall(requete).execute();
        ResponseBody responseBody = reponse.body();
        String json = responseBody.string();

        List<vol> listesvols = null;

        Log.d("httpJsonServices:getVols", json);
        // Création de l'instance ObjectMapper

        if (json.length() > 0) {
            ObjectMapper objectMapper = new ObjectMapper();
            // Conversion du JSON en tableau d'objets Vol
            try {
                listesvols = objectMapper.readValue(json, objectMapper.getTypeFactory().constructCollectionType(List.class, vol.class));
            } catch (JsonProcessingException e) {
                throw new RuntimeException(e);
            }
            return listesvols;
        }

        return null;
    }
}
