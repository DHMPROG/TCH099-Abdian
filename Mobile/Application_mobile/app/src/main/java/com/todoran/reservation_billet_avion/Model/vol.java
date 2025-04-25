package com.todoran.reservation_billet_avion.Model;

import java.io.Serializable;
import java.util.Date;

public class vol implements Serializable {
    private int id;
    private String airline;
    private String flightNumber;
    private String aircraftModele;
    private Date departureDate;
    private String departureTime;
    private String departureAirport;
    private String departureCode;
    private Date arrivalDate;
    private String arrivalTime;
    private String arrivalAirport;
    private String arrivalCode;
    private String duration;
    private String stops;
    private String stopDetails;
    private double price;

    public vol() {}

    // Constructor
    public vol(int id, String airline, String flightNumber, String aircraftModele, Date departureDate, String departureTime,
               String departureAirport, String departureCode, Date arrivalDate, String arrivalTime, String arrivalAirport,
               String arrivalCode, String duration, String stops, String stopDetails, double price) {
        this.id = id;
        this.airline = airline;
        this.flightNumber = flightNumber;
        this.aircraftModele = aircraftModele;
        this.departureDate = departureDate;
        this.departureTime = departureTime;
        this.departureAirport = departureAirport;
        this.departureCode = departureCode;
        this.arrivalDate = arrivalDate;
        this.arrivalTime = arrivalTime;
        this.arrivalAirport = arrivalAirport;
        this.arrivalCode = arrivalCode;
        this.duration = duration;
        this.stops = stops;
        this.stopDetails = stopDetails;
        this.price = price;
    }

    // Getters and Setters
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getAirline() {
        return airline;
    }

    public void setAirline(String airline) {
        this.airline = airline;
    }

    public String getFlightNumber() {
        return flightNumber;
    }

    public void setFlightNumber(String flightNumber) {
        this.flightNumber = flightNumber;
    }

    public String getAircraftModele() {
        return aircraftModele;
    }

    public void setAircraftModele(String aircraftModele) {
        this.aircraftModele = aircraftModele;
    }

    public Date getDepartureDate() {
        return departureDate;
    }

    public void setDepartureDate(Date departureDate) {
        this.departureDate = departureDate;
    }

    public String getDepartureTime() {
        return departureTime;
    }

    public void setDepartureTime(String departureTime) {
        this.departureTime = departureTime;
    }

    public String getDepartureAirport() {
        return departureAirport;
    }

    public void setDepartureAirport(String departureAirport) {
        this.departureAirport = departureAirport;
    }

    public String getDepartureCode() {
        return departureCode;
    }

    public void setDepartureCode(String departureCode) {
        this.departureCode = departureCode;
    }

    public Date getArrivalDate() {
        return arrivalDate;
    }

    public void setArrivalDate(Date arrivalDate) {
        this.arrivalDate = arrivalDate;
    }

    public String getArrivalTime() {
        return arrivalTime;
    }

    public void setArrivalTime(String arrivalTime) {
        this.arrivalTime = arrivalTime;
    }

    public String getArrivalAirport() {
        return arrivalAirport;
    }

    public void setArrivalAirport(String arrivalAirport) {
        this.arrivalAirport = arrivalAirport;
    }

    public String getArrivalCode() {
        return arrivalCode;
    }

    public void setArrivalCode(String arrivalCode) {
        this.arrivalCode = arrivalCode;
    }

    public String getDuration() {
        return duration;
    }

    public void setDuration(String duration) {
        this.duration = duration;
    }

    public String getStops() {
        return stops;
    }

    public void setStops(String stops) {
        this.stops = stops;
    }

    public String getStopDetails() {
        return stopDetails;
    }

    public void setStopDetails(String stopDetails) {
        this.stopDetails = stopDetails;
    }

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
    }
}

