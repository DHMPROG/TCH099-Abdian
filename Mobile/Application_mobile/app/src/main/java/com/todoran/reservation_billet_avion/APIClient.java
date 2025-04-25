package com.todoran.reservation_billet_avion;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.util.Log;


import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;

import org.json.JSONException;
import org.json.JSONObject;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;
import java.io.IOException;
public class APIClient {
    private static final String URL = "http://10.0.2.2:8000";
    private OkHttpClient client;

    public APIClient(){
        client = new OkHttpClient();
    }
    //Recupere le JSON a l'aide de fetchJson
    public void fetchJson(Callback callback){
        Request request = new Request.Builder().url(URL).addHeader("Accept", "application/json").build();
        Log.d("APIClient", "URL de la requête : " + request.url()); // Log de l'URL
        client.newCall(request).enqueue(callback);
    }
}
