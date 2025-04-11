<?php 


class Vol {
    // ✅ Propriétés
    private int $id;
    private string $airline;
    private string $flightNumber;
    private string $departureDate;
    private string $departureTime;
    private string $departureAirport;
    private string $departureCode;
    private string $arrivalDate;
    private string $arrivalTime;
    private string $arrivalAirport;
    private string $arrivalCode;
    private string $duration;
    private string $stops;
    private ?string $stopDetails;
    private float $price;

    // ✅ Constructeur
    public function __construct(
        int $id,
        string $airline,
        string $flightNumber,
        string $departureDate,
        string $departureTime,
        string $departureAirport,
        string $departureCode,
        string $arrivalDate,
        string $arrivalTime,
        string $arrivalAirport,
        string $arrivalCode,
        string $duration,
        string $stops,
        ?string $stopDetails,
        float $price
    ) {
        $this->id = $id;
        $this->airline = $airline;
        $this->flightNumber = $flightNumber;
        $this->departureDate = $departureDate;
        $this->departureTime = $departureTime;
        $this->departureAirport = $departureAirport;
        $this->departureCode = $departureCode;
        $this->arrivalDate = $arrivalDate;
        $this->arrivalTime = $arrivalTime;
        $this->arrivalAirport = $arrivalAirport;
        $this->arrivalCode = $arrivalCode;
        $this->duration = $duration;
        $this->stops = $stops;
        $this->stopDetails = $stopDetails;
        $this->price = $price;
    }

    public static function getVolsByDepartureAndArrival(PDO $pdo, string $departureCode, string $arrivalCode): array {
        $sql = "SELECT * FROM vols WHERE departure_code = ? AND arrival_code = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$departureCode, $arrivalCode]);
    
        $vols = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vols[] = new Vol(
                $row['id'],
                $row['airline'],
                $row['flight_number'],
                $row['departure_date'],
                $row['departure_time'],
                $row['departure_airport'],
                $row['departure_code'],
                $row['arrival_date'],
                $row['arrival_time'],
                $row['arrival_airport'],
                $row['arrival_code'],
                $row['duration'],
                $row['stops'],
                $row['stop_details'],
                $row['price']
            );
        }
    
        return $vols;
    }

    public static function getVolsByDepartureArrivalAndDate(PDO $pdo, string $departureCode, string $arrivalCode, string $date): array {
        $sql = "SELECT * FROM vols WHERE departure_code = ? AND arrival_code = ? AND departure_date = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$departureCode, $arrivalCode, $date]);
    
        $vols = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vols[] = new Vol(
                $row['id'],
                $row['airline'],
                $row['flight_number'],
                $row['departure_date'],
                $row['departure_time'],
                $row['departure_airport'],
                $row['departure_code'],
                $row['arrival_date'],
                $row['arrival_time'],
                $row['arrival_airport'],
                $row['arrival_code'],
                $row['duration'],
                $row['stops'],
                $row['stop_details'],
                $row['price']
            );
        }
    
        return $vols;
    }
    


    // ✅ Getters (tu peux ajouter des setters si tu veux modifier les données)
    public function getId(): int { return $this->id; }
    public function getAirline(): string { return $this->airline; }
    public function getFlightNumber(): string { return $this->flightNumber; }
    public function getDepartureDate(): string { return $this->departureDate; }
    public function getDepartureTime(): string { return $this->departureTime; }
    public function getDepartureAirport(): string { return $this->departureAirport; }
    public function getDepartureCode(): string { return $this->departureCode; }
    public function getArrivalDate(): string { return $this->arrivalDate; }
    public function getArrivalTime(): string { return $this->arrivalTime; }
    public function getArrivalAirport(): string { return $this->arrivalAirport; }
    public function getArrivalCode(): string { return $this->arrivalCode; }
    public function getDuration(): string { return $this->duration; }
    public function getStops(): string { return $this->stops; }
    public function getStopDetails(): ?string { return $this->stopDetails; }
    public function getPrice(): float { return $this->price; }
}





?>