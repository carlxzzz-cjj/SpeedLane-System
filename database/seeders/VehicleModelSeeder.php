<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleData = [
            "Toyota" => [
                ["name" => "Vios", "type" => "Sedan", "years" => "2013-2026"],
                ["name" => "Corolla Altis", "type" => "Sedan", "years" => "2014-2026"],
                ["name" => "Camry", "type" => "Sedan", "years" => "2015-2026"],
                ["name" => "Wigo", "type" => "Hatchback", "years" => "2014-2026"],
                ["name" => "Yaris Cross", "type" => "Crossover", "years" => "2023-2026"],
                ["name" => "Avanza", "type" => "MPV", "years" => "2012-2026"],
                ["name" => "Veloz", "type" => "MPV", "years" => "2022-2026"],
                ["name" => "Innova", "type" => "MPV", "years" => "2016-2026"],
                ["name" => "Innova Zenix", "type" => "MPV", "years" => "2023-2026"],
                ["name" => "Fortuner", "type" => "SUV", "years" => "2016-2026"],
                ["name" => "RAV4", "type" => "SUV", "years" => "2019-2026"],
                ["name" => "Corolla Cross", "type" => "Crossover", "years" => "2020-2026"],
                ["name" => "Land Cruiser Prado", "type" => "SUV", "years" => "2010-2026"],
                ["name" => "Land Cruiser 300", "type" => "SUV", "years" => "2021-2026"],
                ["name" => "Hilux", "type" => "Pickup", "years" => "2015-2026"],
                ["name" => "Hiace Commuter", "type" => "Van", "years" => "2014-2026"],
                ["name" => "Hiace GL Grandia", "type" => "Van", "years" => "2019-2026"],
                ["name" => "Super Grandia", "type" => "Van", "years" => "2019-2026"],
                ["name" => "Alphard", "type" => "Van", "years" => "2015-2026"],
                ["name" => "GR Supra", "type" => "Sports Car", "years" => "2019-2026"],
                ["name" => "GR86", "type" => "Sports Car", "years" => "2022-2026"],
                ["name" => "GR Yaris", "type" => "Sports Car", "years" => "2021-2026"],
            ],
            "Porsche" => [
                ["name" => "911 Carrera / GT3", "type" => "Sports Car", "years" => "2012-2026"],
                ["name" => "718 Cayman", "type" => "Sports Car", "years" => "2016-2026"],
                ["name" => "718 Boxster", "type" => "Sports Car", "years" => "2016-2026"],
                ["name" => "Taycan", "type" => "Sports Car", "years" => "2020-2026"],
                ["name" => "Panamera", "type" => "Sedan", "years" => "2017-2026"],
                ["name" => "Macan", "type" => "SUV", "years" => "2015-2026"],
                ["name" => "Cayenne", "type" => "SUV", "years" => "2011-2026"],
            ],
            "Ford" => [
                ["name" => "Mustang", "type" => "Sports Car", "years" => "2015-2026"],
                ["name" => "Territory", "type" => "Crossover", "years" => "2020-2026"],
                ["name" => "Everest", "type" => "SUV", "years" => "2015-2026"],
                ["name" => "Ranger", "type" => "Pickup", "years" => "2015-2026"],
                ["name" => "Ranger Raptor", "type" => "Pickup", "years" => "2018-2026"],
                ["name" => "Explorer", "type" => "SUV", "years" => "2016-2026"],
                ["name" => "Expedition", "type" => "SUV", "years" => "2018-2026"],
            ],
            "Chevrolet" => [
                ["name" => "Corvette C8", "type" => "Sports Car", "years" => "2020-2026"],
                ["name" => "Camaro", "type" => "Sports Car", "years" => "2016-2026"],
                ["name" => "Trailblazer", "type" => "SUV", "years" => "2017-2026"],
                ["name" => "Tracker", "type" => "Crossover", "years" => "2021-2026"],
                ["name" => "Suburban", "type" => "SUV", "years" => "2015-2026"],
                ["name" => "Tahoe", "type" => "SUV", "years" => "2021-2026"],
            ],
            "Dodge" => [
                ["name" => "Challenger SRT / Hellcat", "type" => "Sports Car", "years" => "2015-2026"],
                ["name" => "Charger", "type" => "Sports Car", "years" => "2015-2026"],
                ["name" => "Durango", "type" => "SUV", "years" => "2014-2026"],
            ],
            "Nissan" => [
                ["name" => "GT-R (R35)", "type" => "Supercar", "years" => "2008-2026"],
                ["name" => "Z", "type" => "Sports Car", "years" => "2023-2026"],
                ["name" => "Almera", "type" => "Sedan", "years" => "2015-2026"],
                ["name" => "Kicks e-POWER", "type" => "Crossover", "years" => "2022-2026"],
                ["name" => "Terra", "type" => "SUV", "years" => "2018-2026"],
                ["name" => "Navara", "type" => "Pickup", "years" => "2015-2026"],
                ["name" => "Urvan NV350", "type" => "Van", "years" => "2015-2026"],
                ["name" => "Patrol Royale", "type" => "SUV", "years" => "2014-2026"],
            ],
            "Honda" => [
                ["name" => "Civic Type R (FL5 / FK8)", "type" => "Sports Car", "years" => "2017-2026"],
                ["name" => "NSX", "type" => "Supercar", "years" => "2017-2024"],
                ["name" => "City", "type" => "Sedan", "years" => "2014-2026"],
                ["name" => "City Hatchback", "type" => "Hatchback", "years" => "2021-2026"],
                ["name" => "Civic", "type" => "Sedan", "years" => "2016-2026"],
                ["name" => "Accord", "type" => "Sedan", "years" => "2015-2026"],
                ["name" => "Brio", "type" => "Hatchback", "years" => "2014-2026"],
                ["name" => "BR-V", "type" => "MPV", "years" => "2016-2026"],
                ["name" => "HR-V", "type" => "Crossover", "years" => "2015-2026"],
                ["name" => "CR-V", "type" => "SUV", "years" => "2017-2026"],
            ],
            "Subaru" => [
                ["name" => "BRZ", "type" => "Sports Car", "years" => "2013-2026"],
                ["name" => "WRX / WRX STI", "type" => "Sports Car", "years" => "2015-2026"],
                ["name" => "XV / Crosstrek", "type" => "Crossover", "years" => "2012-2026"],
                ["name" => "Forester", "type" => "SUV", "years" => "2014-2026"],
                ["name" => "Outback", "type" => "Crossover", "years" => "2015-2026"],
            ],
            "Mazda" => [
                ["name" => "MX-5 Miata", "type" => "Sports Car", "years" => "2015-2026"],
                ["name" => "Mazda 3", "type" => "Sedan", "years" => "2014-2026"],
                ["name" => "Mazda 6", "type" => "Sedan", "years" => "2014-2026"],
                ["name" => "CX-30", "type" => "Crossover", "years" => "2020-2026"],
                ["name" => "CX-5", "type" => "SUV", "years" => "2013-2026"],
                ["name" => "CX-60 / CX-90", "type" => "SUV", "years" => "2023-2026"],
                ["name" => "BT-50", "type" => "Pickup", "years" => "2013-2026"],
            ],
            "BMW" => [
                ["name" => "M3 / M4", "type" => "Sports Car", "years" => "2015-2026"],
                ["name" => "M2 / M5", "type" => "Sports Car", "years" => "2016-2026"],
                ["name" => "Z4 Roadster", "type" => "Sports Car", "years" => "2019-2026"],
                ["name" => "3 Series", "type" => "Sedan", "years" => "2012-2026"],
                ["name" => "5 Series", "type" => "Sedan", "years" => "2010-2026"],
                ["name" => "7 Series", "type" => "Sedan", "years" => "2016-2026"],
                ["name" => "X1 / X3", "type" => "SUV", "years" => "2015-2026"],
                ["name" => "X5 / X7", "type" => "SUV", "years" => "2013-2026"],
            ],
            "Mercedes-Benz" => [
                ["name" => "AMG GT / SL Roadster", "type" => "Sports Car", "years" => "2016-2026"],
                ["name" => "C-Class / C63 AMG", "type" => "Sedan", "years" => "2014-2026"],
                ["name" => "E-Class", "type" => "Sedan", "years" => "2016-2026"],
                ["name" => "S-Class", "type" => "Sedan", "years" => "2013-2026"],
                ["name" => "GLA / GLC / GLE", "type" => "SUV", "years" => "2015-2026"],
                ["name" => "G-Class (G-Wagon)", "type" => "SUV", "years" => "2013-2026"],
            ],
            "Audi" => [
                ["name" => "R8", "type" => "Supercar", "years" => "2015-2024"],
                ["name" => "TT / RS3", "type" => "Sports Car", "years" => "2015-2026"],
                ["name" => "A4 / A6", "type" => "Sedan", "years" => "2016-2026"],
                ["name" => "Q3 / Q5 / Q7 / Q8", "type" => "SUV", "years" => "2015-2026"],
            ],
            "Ferrari" => [
                ["name" => "488 / F8 Tributo / 296 GTB", "type" => "Supercar", "years" => "2016-2026"],
                ["name" => "Roma / Portofino", "type" => "Sports Car", "years" => "2018-2026"],
                ["name" => "Purosangue", "type" => "SUV", "years" => "2023-2026"],
            ],
            "Lamborghini" => [
                ["name" => "Huracan / Revuelto", "type" => "Supercar", "years" => "2015-2026"],
                ["name" => "Urus", "type" => "SUV", "years" => "2018-2026"],
            ],
            "Jeep" => [
                ["name" => "Wrangler Rubicon", "type" => "SUV", "years" => "2012-2026"],
                ["name" => "Gladiator", "type" => "Pickup", "years" => "2020-2026"],
                ["name" => "Grand Cherokee", "type" => "SUV", "years" => "2015-2026"],
            ],
            "Land Rover" => [
                ["name" => "Defender 90/110/130", "type" => "SUV", "years" => "2020-2026"],
                ["name" => "Range Rover / Sport", "type" => "SUV", "years" => "2014-2026"],
                ["name" => "Evoque / Velar", "type" => "SUV", "years" => "2015-2026"],
            ],
            "BYD" => [
                ["name" => "Seal", "type" => "Sports Car", "years" => "2023-2026"],
                ["name" => "Atto 3", "type" => "Crossover", "years" => "2022-2026"],
                ["name" => "Dolphin", "type" => "Hatchback", "years" => "2023-2026"],
                ["name" => "Han", "type" => "Sedan", "years" => "2022-2026"],
            ],
            "Tesla" => [
                ["name" => "Model 3 / Performance", "type" => "Sedan", "years" => "2017-2026"],
                ["name" => "Model Y", "type" => "Crossover", "years" => "2020-2026"],
                ["name" => "Model S Plaid", "type" => "Sports Car", "years" => "2016-2026"],
                ["name" => "Model X", "type" => "SUV", "years" => "2016-2026"],
                ["name" => "Cybertruck", "type" => "Pickup", "years" => "2023-2026"],
            ],
        ];

        foreach ($vehicleData as $brand => $models) {
            foreach ($models as $model) {
                // Parse "2013-2026" into start and end year integers
                $yearParts = explode('-', $model['years']);
                $yearStart = isset($yearParts[0]) ? (int) trim($yearParts[0]) : null;
                $yearEnd   = isset($yearParts[1]) ? (int) trim($yearParts[1]) : null;

                DB::table('vehicle_models')->updateOrInsert(
                    ['brand' => $brand, 'name' => $model['name']],
                    [
                        'vehicle_type' => $model['type'],
                        'year_start'   => $yearStart,
                        'year_end'     => $yearEnd,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]
                );
            }
        }
    }
}