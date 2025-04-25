package com.todoran.reservation_billet_avion.ViewModel;

import java.util.List;
import okhttp3.Callback;
import androidx.lifecycle.ViewModel;
import androidx.lifecycle.LiveData;

import com.todoran.reservation_billet_avion.Model.Utilisateur;
import com.todoran.reservation_billet_avion.UtilisateurDepot;

public class UtilisateurViewModel extends ViewModel {
    private final UtilisateurDepot utilisateurDepot;

    public UtilisateurViewModel(){
        utilisateurDepot = new UtilisateurDepot();
    }
    public LiveData<List<Utilisateur>>getUtilisateurs(){
        return utilisateurDepot.getUtilisateurs();
    }
    public void authenticate(String email, String password, LoginCallback callback) {
        UtilisateurDepot.loginUser(email, password, callback);
    }
    public void registreUtilisateur(Utilisateur utilisateur, Callback callback){
        UtilisateurDepot.registerUser(utilisateur.getPrenom(),utilisateur.getNom(), utilisateur.getEmail(), utilisateur.getMotDePasse(), utilisateur.getTelephone(), callback);
    }
}
