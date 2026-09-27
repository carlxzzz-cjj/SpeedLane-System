<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VehicleModelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vehicle_models')->delete();
        
        \DB::table('vehicle_models')->insert(array (
            0 => 
            array (
                'id' => 1,
                'brand' => 'Toyota',
                'name' => 'Vios',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            1 => 
            array (
                'id' => 2,
                'brand' => 'Toyota',
                'name' => 'Corolla Altis',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            2 => 
            array (
                'id' => 3,
                'brand' => 'Toyota',
                'name' => 'Camry',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            3 => 
            array (
                'id' => 4,
                'brand' => 'Toyota',
                'name' => 'Wigo',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            4 => 
            array (
                'id' => 5,
                'brand' => 'Toyota',
                'name' => 'Yaris Cross',
                'year_model' => '2023-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            5 => 
            array (
                'id' => 6,
                'brand' => 'Toyota',
                'name' => 'Avanza',
                'year_model' => '2012-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            6 => 
            array (
                'id' => 7,
                'brand' => 'Toyota',
                'name' => 'Veloz',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            7 => 
            array (
                'id' => 8,
                'brand' => 'Toyota',
                'name' => 'Innova',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            8 => 
            array (
                'id' => 9,
                'brand' => 'Toyota',
                'name' => 'Innova Zenix',
                'year_model' => '2023-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            9 => 
            array (
                'id' => 10,
                'brand' => 'Toyota',
                'name' => 'Fortuner',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            10 => 
            array (
                'id' => 11,
                'brand' => 'Toyota',
                'name' => 'RAV4',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            11 => 
            array (
                'id' => 12,
                'brand' => 'Toyota',
                'name' => 'Corolla Cross',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            12 => 
            array (
                'id' => 13,
                'brand' => 'Toyota',
                'name' => 'Land Cruiser Prado',
                'year_model' => '2010-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            13 => 
            array (
                'id' => 14,
                'brand' => 'Toyota',
                'name' => 'Land Cruiser 300',
                'year_model' => '2021-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            14 => 
            array (
                'id' => 15,
                'brand' => 'Toyota',
                'name' => 'Hilux',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            15 => 
            array (
                'id' => 16,
                'brand' => 'Toyota',
                'name' => 'Hiace Commuter',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            16 => 
            array (
                'id' => 17,
                'brand' => 'Toyota',
                'name' => 'Hiace GL Grandia',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            17 => 
            array (
                'id' => 18,
                'brand' => 'Toyota',
                'name' => 'Super Grandia',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            18 => 
            array (
                'id' => 19,
                'brand' => 'Toyota',
                'name' => 'Alphard',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            19 => 
            array (
                'id' => 20,
                'brand' => 'Toyota',
                'name' => 'GR Supra',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            20 => 
            array (
                'id' => 21,
                'brand' => 'Toyota',
                'name' => 'GR86',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            21 => 
            array (
                'id' => 22,
                'brand' => 'Toyota',
                'name' => 'GR Yaris',
                'year_model' => '2021-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            22 => 
            array (
                'id' => 23,
                'brand' => 'Honda',
                'name' => 'City',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            23 => 
            array (
                'id' => 24,
                'brand' => 'Honda',
                'name' => 'City Hatchback',
                'year_model' => '2021-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            24 => 
            array (
                'id' => 25,
                'brand' => 'Honda',
                'name' => 'Civic',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            25 => 
            array (
                'id' => 26,
                'brand' => 'Honda',
                'name' => 'Accord',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            26 => 
            array (
                'id' => 27,
                'brand' => 'Honda',
                'name' => 'Brio',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            27 => 
            array (
                'id' => 28,
                'brand' => 'Honda',
                'name' => 'BR-V',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            28 => 
            array (
                'id' => 29,
                'brand' => 'Honda',
                'name' => 'HR-V',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            29 => 
            array (
                'id' => 30,
                'brand' => 'Honda',
                'name' => 'CR-V',
                'year_model' => '2017-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            30 => 
            array (
                'id' => 31,
                'brand' => 'Honda',
                'name' => 'Civic Type R',
                'year_model' => '2017-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            31 => 
            array (
                'id' => 32,
                'brand' => 'Mitsubishi',
                'name' => 'Mirage G4',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            32 => 
            array (
                'id' => 33,
                'brand' => 'Mitsubishi',
                'name' => 'Mirage Hatchback',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            33 => 
            array (
                'id' => 34,
                'brand' => 'Mitsubishi',
                'name' => 'Xpander',
                'year_model' => '2018-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            34 => 
            array (
                'id' => 35,
                'brand' => 'Mitsubishi',
                'name' => 'Xpander Cross',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            35 => 
            array (
                'id' => 36,
                'brand' => 'Mitsubishi',
                'name' => 'Xforce',
                'year_model' => '2024-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            36 => 
            array (
                'id' => 37,
                'brand' => 'Mitsubishi',
                'name' => 'Montero Sport',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            37 => 
            array (
                'id' => 38,
                'brand' => 'Mitsubishi',
                'name' => 'Triton / Strada',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            38 => 
            array (
                'id' => 39,
                'brand' => 'Mitsubishi',
                'name' => 'L300',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            39 => 
            array (
                'id' => 40,
                'brand' => 'Nissan',
                'name' => 'Almera',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            40 => 
            array (
                'id' => 41,
                'brand' => 'Nissan',
                'name' => 'Kicks e-POWER',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            41 => 
            array (
                'id' => 42,
                'brand' => 'Nissan',
                'name' => 'Terra',
                'year_model' => '2018-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            42 => 
            array (
                'id' => 43,
                'brand' => 'Nissan',
                'name' => 'Navara',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            43 => 
            array (
                'id' => 44,
                'brand' => 'Nissan',
                'name' => 'Urvan NV350',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            44 => 
            array (
                'id' => 45,
                'brand' => 'Nissan',
                'name' => 'Patrol Royale',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            45 => 
            array (
                'id' => 46,
                'brand' => 'Nissan',
                'name' => 'GT-R',
                'year_model' => '2008-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            46 => 
            array (
                'id' => 47,
                'brand' => 'Nissan',
                'name' => 'Z',
                'year_model' => '2023-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            47 => 
            array (
                'id' => 48,
                'brand' => 'Ford',
                'name' => 'Territory',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            48 => 
            array (
                'id' => 49,
                'brand' => 'Ford',
                'name' => 'Everest',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            49 => 
            array (
                'id' => 50,
                'brand' => 'Ford',
                'name' => 'Ranger',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            50 => 
            array (
                'id' => 51,
                'brand' => 'Ford',
                'name' => 'Ranger Raptor',
                'year_model' => '2018-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            51 => 
            array (
                'id' => 52,
                'brand' => 'Ford',
                'name' => 'Mustang',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            52 => 
            array (
                'id' => 53,
                'brand' => 'Ford',
                'name' => 'Explorer',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            53 => 
            array (
                'id' => 54,
                'brand' => 'Isuzu',
                'name' => 'D-Max',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            54 => 
            array (
                'id' => 55,
                'brand' => 'Isuzu',
                'name' => 'mu-X',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            55 => 
            array (
                'id' => 56,
                'brand' => 'Isuzu',
                'name' => 'Traviz',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            56 => 
            array (
                'id' => 57,
                'brand' => 'Hyundai',
                'name' => 'Accent',
                'year_model' => '2011-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            57 => 
            array (
                'id' => 58,
                'brand' => 'Hyundai',
                'name' => 'Elantra',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            58 => 
            array (
                'id' => 59,
                'brand' => 'Hyundai',
                'name' => 'Creta',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            59 => 
            array (
                'id' => 60,
                'brand' => 'Hyundai',
                'name' => 'Tucson',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            60 => 
            array (
                'id' => 61,
                'brand' => 'Hyundai',
                'name' => 'Santa Fe',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            61 => 
            array (
                'id' => 62,
                'brand' => 'Hyundai',
                'name' => 'Palisade',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            62 => 
            array (
                'id' => 63,
                'brand' => 'Hyundai',
                'name' => 'Stargazer',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            63 => 
            array (
                'id' => 64,
                'brand' => 'Hyundai',
                'name' => 'Staria',
                'year_model' => '2021-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            64 => 
            array (
                'id' => 65,
                'brand' => 'Hyundai',
                'name' => 'Ioniq 5',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            65 => 
            array (
                'id' => 66,
                'brand' => 'Kia',
                'name' => 'Soluto',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            66 => 
            array (
                'id' => 67,
                'brand' => 'Kia',
                'name' => 'Picanto',
                'year_model' => '2011-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            67 => 
            array (
                'id' => 68,
                'brand' => 'Kia',
                'name' => 'Stonic',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            68 => 
            array (
                'id' => 69,
                'brand' => 'Kia',
                'name' => 'Seltos',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            69 => 
            array (
                'id' => 70,
                'brand' => 'Kia',
                'name' => 'Sportage',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            70 => 
            array (
                'id' => 71,
                'brand' => 'Kia',
                'name' => 'Sorento',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            71 => 
            array (
                'id' => 72,
                'brand' => 'Kia',
                'name' => 'Carnival',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            72 => 
            array (
                'id' => 73,
                'brand' => 'Kia',
                'name' => 'EV6',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            73 => 
            array (
                'id' => 74,
                'brand' => 'Mazda',
                'name' => 'Mazda 2',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            74 => 
            array (
                'id' => 75,
                'brand' => 'Mazda',
                'name' => 'Mazda 3',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            75 => 
            array (
                'id' => 76,
                'brand' => 'Mazda',
                'name' => 'Mazda 6',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            76 => 
            array (
                'id' => 77,
                'brand' => 'Mazda',
                'name' => 'CX-3',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            77 => 
            array (
                'id' => 78,
                'brand' => 'Mazda',
                'name' => 'CX-30',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            78 => 
            array (
                'id' => 79,
                'brand' => 'Mazda',
                'name' => 'CX-5',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            79 => 
            array (
                'id' => 80,
                'brand' => 'Mazda',
                'name' => 'CX-8',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            80 => 
            array (
                'id' => 81,
                'brand' => 'Mazda',
                'name' => 'CX-9',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            81 => 
            array (
                'id' => 82,
                'brand' => 'Mazda',
                'name' => 'MX-5 Miata',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            82 => 
            array (
                'id' => 83,
                'brand' => 'Mazda',
                'name' => 'BT-50',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            83 => 
            array (
                'id' => 84,
                'brand' => 'Suzuki',
                'name' => 'S-Presso',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            84 => 
            array (
                'id' => 85,
                'brand' => 'Suzuki',
                'name' => 'Celerio',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            85 => 
            array (
                'id' => 86,
                'brand' => 'Suzuki',
                'name' => 'Swift',
                'year_model' => '2011-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            86 => 
            array (
                'id' => 87,
                'brand' => 'Suzuki',
                'name' => 'Dzire',
                'year_model' => '2018-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            87 => 
            array (
                'id' => 88,
                'brand' => 'Suzuki',
                'name' => 'Ertiga',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            88 => 
            array (
                'id' => 89,
                'brand' => 'Suzuki',
                'name' => 'XL7',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            89 => 
            array (
                'id' => 90,
                'brand' => 'Suzuki',
                'name' => 'Jimny 3-Door',
                'year_model' => '2018-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            90 => 
            array (
                'id' => 91,
                'brand' => 'Suzuki',
                'name' => 'Jimny 5-Door',
                'year_model' => '2024-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            91 => 
            array (
                'id' => 92,
                'brand' => 'Suzuki',
                'name' => 'APV',
                'year_model' => '2005-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            92 => 
            array (
                'id' => 93,
                'brand' => 'Subaru',
                'name' => 'XV / Crosstrek',
                'year_model' => '2012-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            93 => 
            array (
                'id' => 94,
                'brand' => 'Subaru',
                'name' => 'Forester',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            94 => 
            array (
                'id' => 95,
                'brand' => 'Subaru',
                'name' => 'Outback',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            95 => 
            array (
                'id' => 96,
                'brand' => 'Subaru',
                'name' => 'WRX',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            96 => 
            array (
                'id' => 97,
                'brand' => 'Subaru',
                'name' => 'BRZ',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            97 => 
            array (
                'id' => 98,
                'brand' => 'Geely',
                'name' => 'Coolray',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            98 => 
            array (
                'id' => 99,
                'brand' => 'Geely',
                'name' => 'Emgrand',
                'year_model' => '2022-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            99 => 
            array (
                'id' => 100,
                'brand' => 'Geely',
                'name' => 'Okavango',
                'year_model' => '2020-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            100 => 
            array (
                'id' => 101,
                'brand' => 'MG',
                'name' => 'MG ZS',
                'year_model' => '2018-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            101 => 
            array (
                'id' => 102,
                'brand' => 'MG',
                'name' => 'MG 5',
                'year_model' => '2019-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            102 => 
            array (
                'id' => 103,
                'brand' => 'BMW',
                'name' => '3 Series',
                'year_model' => '2012-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            103 => 
            array (
                'id' => 104,
                'brand' => 'BMW',
                'name' => '5 Series',
                'year_model' => '2010-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            104 => 
            array (
                'id' => 105,
                'brand' => 'BMW',
                'name' => 'X1',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            105 => 
            array (
                'id' => 106,
                'brand' => 'BMW',
                'name' => 'X3',
                'year_model' => '2017-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            106 => 
            array (
                'id' => 107,
                'brand' => 'BMW',
                'name' => 'X5',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            107 => 
            array (
                'id' => 108,
                'brand' => 'Mercedes-Benz',
                'name' => 'C-Class',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            108 => 
            array (
                'id' => 109,
                'brand' => 'Mercedes-Benz',
                'name' => 'E-Class',
                'year_model' => '2016-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            109 => 
            array (
                'id' => 110,
                'brand' => 'Mercedes-Benz',
                'name' => 'S-Class',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            110 => 
            array (
                'id' => 111,
                'brand' => 'Mercedes-Benz',
                'name' => 'GLC',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            111 => 
            array (
                'id' => 112,
                'brand' => 'Lexus',
                'name' => 'IS',
                'year_model' => '2013-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            112 => 
            array (
                'id' => 113,
                'brand' => 'Lexus',
                'name' => 'ES',
                'year_model' => '2018-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            113 => 
            array (
                'id' => 114,
                'brand' => 'Lexus',
                'name' => 'RX',
                'year_model' => '2015-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            114 => 
            array (
                'id' => 115,
                'brand' => 'Lexus',
                'name' => 'NX',
                'year_model' => '2014-2026',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
        ));
        
        
    }
}