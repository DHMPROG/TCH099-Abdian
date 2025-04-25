package com.todoran.reservation_billet_avion.ViewModel;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.todoran.reservation_billet_avion.Model.vol;
import com.todoran.reservation_billet_avion.R;
import com.todoran.reservation_billet_avion.View.PaiementActivity;

import java.util.List;

public class VolAdapter extends RecyclerView.Adapter<VolAdapter.FlightViewHolder> {

    private List<vol> flightList;
    private Context context;

    private int totalPassagers;

    // Constructeur
    public VolAdapter(List<vol> flightList, Context context, int totalPassagers) {
        this.flightList = flightList;
        this.context = context;
        this.totalPassagers = totalPassagers;
    }

    @NonNull
    @Override
    public FlightViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_flight, parent, false);
        return new FlightViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull FlightViewHolder holder, int position) {
        vol currentVol = flightList.get(position);

        // Remplir les données dans les vues
        holder.airlineLogo.setImageResource(R.drawable.ic_airline_logo); // Placeholder pour le logo
        holder.airlineName.setText(currentVol.getAirline());
        holder.flightDetails.setText(currentVol.getDepartureAirport() + " ➜ " + currentVol.getArrivalAirport());
        holder.flightDuration.setText(currentVol.getDuration());
        holder.flightClass.setText(currentVol.getStops() != null ? currentVol.getStops() : "Non-stop");
        holder.flightPrice.setText("$" + currentVol.getPrice());

        holder.itemView.setOnClickListener(v -> {
            Intent intent = new Intent(context, PaiementActivity.class);
            intent.putExtra("vol", currentVol);
            intent.putExtra("totalPassagers", totalPassagers);
            context.startActivity(intent);
        });
    }

    @Override
    public int getItemCount() {
        return flightList.size();
    }

    public static class FlightViewHolder extends RecyclerView.ViewHolder {

        ImageView airlineLogo;
        TextView airlineName, flightDetails, flightDuration, flightClass, flightPrice;

        public FlightViewHolder(@NonNull View itemView) {
            super(itemView);

            // Initialisation des vues
            airlineLogo = itemView.findViewById(R.id.airlineLogo);
            airlineName = itemView.findViewById(R.id.airlineName);
            flightDetails = itemView.findViewById(R.id.flightDetails);
            flightDuration = itemView.findViewById(R.id.flightDuration);
            flightClass = itemView.findViewById(R.id.flightClass);
            flightPrice = itemView.findViewById(R.id.flightPrice);
        }
    }
}