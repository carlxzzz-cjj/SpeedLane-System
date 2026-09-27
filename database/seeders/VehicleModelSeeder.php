<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleData = [
            "Toyota" => ["Vios", "Fortuner", "Hilux", "Innova", "Avanza", "RAV4", "Corolla Altis", "Hiace", "Wigo", "Land Cruiser", "Camry", "Yaris Cross", "Veloz", "Raize", "Zenix"],
            "Mitsubishi" => ["Montero Sport", "Xpander", "Strada", "Mirage", "Mirage G4", "L300", "Outlander", "Triton", "Xforce"],
            "Honda" => ["Civic", "City", "CR-V", "BR-V", "HR-V", "Brio", "Jazz", "Accord", "Pilot"],
            "Ford" => ["Ranger", "Everest", "Territory", "Explorer", "Mustang", "Ranger Raptor", "Expedition"],
            "Isuzu" => ["D-Max", "mu-X", "Traviz", "N-Series"],
            "Nissan" => ["Navara", "Terra", "Almera", "Urvan", "Patrol", "Kicks", "Livina", "Z"],
            "Suzuki" => ["Ertiga", "Jimny", "Swift", "Dzire", "XL7", "APV", "S-Presso", "Celerio"],
            "Hyundai" => ["Stargazer", "Creta", "Tucson", "Santa Fe", "H-100", "Staria", "Elantra", "Ioniq 5"],
            "Kia" => ["Seltos", "Stonic", "Carnival", "Soluto", "K2500", "EV6", "Sportage"],
            "Mazda" => ["Mazda2", "Mazda3", "Mazda6", "CX-3", "CX-30", "CX-5", "CX-8", "CX-9", "MX-5"],
            "Subaru" => ["Forester", "XV / Crosstrek", "Outback", "WRX", "BRZ"],
            "Chevrolet" => ["Trailblazer", "Tracker", "Colorado", "Suburban", "Tahoe", "Corvette"],
            "BMW" => ["3 Series", "5 Series", "7 Series", "X1", "X3", "X5", "X7", "M3", "M5"],
            "Mercedes-Benz" => ["A-Class", "C-Class", "E-Class", "S-Class", "GLA", "GLC", "GLE", "GLS", "G-Class"],
            "Lexus" => ["IS", "ES", "LS", "NX", "RX", "GX", "LX"],
            "Volkswagen" => ["Sanatana", "Lavida", "Lamando", "T-Cross", "Multivan Kombi"],
            "Porsche" => ["911", "718 Cayman", "718 Boxster", "Macan", "Cayenne", "Panamera", "Taycan"],
            "Tesla" => ["Model 3", "Model Y", "Model S", "Model X", "Cybertruck"],
            "BYD" => ["Atto 3", "Dolphin", "Seal", "Han", "Tang", "Seagull"],
            "Other" => ["Other Model"]
        ];

        foreach ($vehicleData as $brand => $models) {
            foreach ($models as $model) {
                DB::table('vehicle_models')->updateOrInsert(
                    ['brand' => $brand, 'name' => $model],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
    