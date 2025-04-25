package com.todoran.reservation_billet_avion.ViewModel;



public interface LoginCallback {
    void onSuccess();
    void onFailure(String errorMessage);
}