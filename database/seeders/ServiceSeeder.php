<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleTypes = [
            'Hatchback', 'Sedan', 'Coupe', 'Crossover', 'MPV', 
            'Wagon', 'SUV', 'Pickup Truck', 'Sports Car', 'Van'
        ];

        $speedlanePrices = [
            'ceramic_coating' => [
                'Hatchback'    => ['full_body' => 10000, 'front_half' => 6000, 'hood_fenders' => 4500, 'wheels' => 4000, 'glass' => 2500, 'trim' => 3500],
                'Sedan'        => ['full_body' => 11000, 'front_half' => 7000, 'hood_fenders' => 5000, 'wheels' => 4000, 'glass' => 2500, 'trim' => 3500],
                'Coupe'        => ['full_body' => 11000, 'front_half' => 7000, 'hood_fenders' => 5000, 'wheels' => 4000, 'glass' => 2500, 'trim' => 3500],
                'Crossover'    => ['full_body' => 12000, 'front_half' => 7500, 'hood_fenders' => 5500, 'wheels' => 4000, 'glass' => 2500, 'trim' => 3500],
                'MPV'          => ['full_body' => 12000, 'front_half' => 8000, 'hood_fenders' => 6000, 'wheels' => 4000, 'glass' => 2500, 'trim' => 3500],
                'Wagon'        => ['full_body' => 12000, 'front_half' => 7500, 'hood_fenders' => 5500, 'wheels' => 4000, 'glass' => 2500, 'trim' => 3500],
                'SUV'          => ['full_body' => 13000, 'front_half' => 7000, 'hood_fenders' => 6000, 'wheels' => 4000, 'glass' => 2500, 'trim' => 3500],
                'Pickup Truck' => ['full_body' => 13000, 'front_half' => 7500, 'hood_fenders' => 6000, 'wheels' => 4000, 'glass' => 2500, 'trim' => 4000],
                'Sports Car'   => ['full_body' => 14000, 'front_half' => 8000, 'hood_fenders' => 6000, 'wheels' => 4500, 'glass' => 2500, 'trim' => 3500],
                'Van'          => ['full_body' => 15000, 'front_half' => 8500, 'hood_fenders' => 6500, 'wheels' => 4000, 'glass' => 3000, 'trim' => 4000]
            ],
            'graphene_coating' => [
                'Hatchback'    => ['full_body' => 14000, 'front_half' => 10000, 'hood_fenders' => 5500, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'Sedan'        => ['full_body' => 15000, 'front_half' => 11000, 'hood_fenders' => 6000, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'Coupe'        => ['full_body' => 15000, 'front_half' => 11000, 'hood_fenders' => 6000, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'Crossover'    => ['full_body' => 17000, 'front_half' => 11500, 'hood_fenders' => 6500, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'MPV'          => ['full_body' => 18000, 'front_half' => 12000, 'hood_fenders' => 7000, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'Wagon'        => ['full_body' => 17000, 'front_half' => 11500, 'hood_fenders' => 6500, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'SUV'          => ['full_body' => 19000, 'front_half' => 12500, 'hood_fenders' => 8000, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'Pickup Truck' => ['full_body' => 19000, 'front_half' => 12000, 'hood_fenders' => 7500, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'Sports Car'   => ['full_body' => 20000, 'front_half' => 12000, 'hood_fenders' => 7500, 'wheels' => 5000, 'glass' => 2500, 'trim' => 5000],
                'Van'          => ['full_body' => 22000, 'front_half' => 13000, 'hood_fenders' => 8000, 'wheels' => 5000, 'glass' => 3000, 'trim' => 5500]
            ],
            'ppf' => [
                'Hatchback'    => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000],
                'Sedan'        => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000],
                'Coupe'        => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 1500, 'door_edges' => 1500, 'headlights' => 4000],
                'Crossover'    => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000],
                'MPV'          => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000],
                'Wagon'        => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000],
                'Sports Car'   => ['full_front' => 28000, 'hood_only' => 9000, 'front_bumper' => 9000, 'fenders_pair' => 9000, 'mirrors_pair' => 2500, 'door_cups' => 1500, 'door_edges' => 1500, 'headlights' => 4000],
                'Pickup Truck' => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000],
                'SUV'          => ['full_front' => 25000, 'hood_only' => 8000, 'front_bumper' => 8000, 'fenders_pair' => 8000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000],
                'Van'          => ['full_front' => 28000, 'hood_only' => 9000, 'front_bumper' => 9000, 'fenders_pair' => 9000, 'mirrors_pair' => 2500, 'door_cups' => 2000, 'door_edges' => 2000, 'headlights' => 4000]
            ],
            'interior_detailing' => [
                'Hatchback' => 5500, 'Coupe' => 6000, 'Sedan' => 6500, 'Crossover' => 6500, 'MPV' => 6500, 
                'Wagon' => 6500, 'SUV' => 6500, 'Pickup Truck' => 6500, 'Sports Car' => 7000, 'Van' => 8500
            ],
            'exterior_detailing' => [
                'Hatchback' => 5500, 'Coupe' => 6000, 'Sedan' => 6500, 'Crossover' => 6500, 'MPV' => 6500, 
                'Wagon' => 6500, 'SUV' => 6500, 'Pickup Truck' => 7000, 'Sports Car' => 7500, 'Van' => 8000
            ],
            'washover' => [
                'Hatchback'    => ['hood' => 7000, 'roof' => 7000, 'front_bumper' => 5500, 'rear_bumper' => 5500, 'fl_door' => 4500, 'fr_door' => 4500, 'rl_door' => 4500, 'rr_door' => 4500, 'fl_fender' => 4500, 'fr_fender' => 4500, 'rl_fender' => 4500, 'rr_fender' => 4500, 'trunk' => 5500, 'spot_repair' => 4000],
                'Sedan'        => ['hood' => 8000, 'roof' => 8000, 'front_bumper' => 6000, 'rear_bumper' => 6000, 'fl_door' => 5000, 'fr_door' => 5000, 'rl_door' => 5000, 'rr_door' => 5000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 6000, 'spot_repair' => 4500],
                'Coupe'        => ['hood' => 8000, 'roof' => 8000, 'front_bumper' => 6000, 'rear_bumper' => 6000, 'fl_door' => 6000, 'fr_door' => 6000, 'rl_door' => 6000, 'rr_door' => 6000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 6000, 'spot_repair' => 4500],
                'Crossover'    => ['hood' => 8000, 'roof' => 8000, 'front_bumper' => 6000, 'rear_bumper' => 6000, 'fl_door' => 5000, 'fr_door' => 5000, 'rl_door' => 5000, 'rr_door' => 5000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 6000, 'spot_repair' => 4500],
                'Wagon'        => ['hood' => 8000, 'roof' => 8500, 'front_bumper' => 6000, 'rear_bumper' => 6000, 'fl_door' => 5000, 'fr_door' => 5000, 'rl_door' => 5000, 'rr_door' => 5000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 6000, 'spot_repair' => 4500],
                'MPV'          => ['hood' => 8000, 'roof' => 8000, 'front_bumper' => 6000, 'rear_bumper' => 6000, 'fl_door' => 5000, 'fr_door' => 5000, 'rl_door' => 5000, 'rr_door' => 5000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 6000, 'spot_repair' => 4500],
                'Sports Car'   => ['hood' => 9000, 'roof' => 8000, 'front_bumper' => 7000, 'rear_bumper' => 7000, 'fl_door' => 6000, 'fr_door' => 6000, 'rl_door' => 6000, 'rr_door' => 6000, 'fl_fender' => 5500, 'fr_fender' => 5500, 'rl_fender' => 5500, 'rr_fender' => 5500, 'trunk' => 6000, 'spot_repair' => 5000],
                'Pickup Truck' => ['hood' => 8000, 'roof' => 7500, 'front_bumper' => 6000, 'rear_bumper' => 5000, 'fl_door' => 5000, 'fr_door' => 5000, 'rl_door' => 5000, 'rr_door' => 5000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 5000, 'spot_repair' => 4500],
                'SUV'          => ['hood' => 8000, 'roof' => 8000, 'front_bumper' => 6000, 'rear_bumper' => 6000, 'fl_door' => 5000, 'fr_door' => 5000, 'rl_door' => 5000, 'rr_door' => 5000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 6000, 'spot_repair' => 4500],
                'Van'          => ['hood' => 6000, 'roof' => 12000, 'front_bumper' => 6000, 'rear_bumper' => 6000, 'fl_door' => 5000, 'fr_door' => 5000, 'rl_door' => 5000, 'rr_door' => 5000, 'fl_fender' => 5000, 'fr_fender' => 5000, 'rl_fender' => 5000, 'rr_fender' => 5000, 'trunk' => 7000, 'spot_repair' => 5000]
            ],
            'undercoat' => [
                'Hatchback'    => ['epoxy' => 5000, 'rubberized' => 9500],
                'Sedan'        => ['epoxy' => 5500, 'rubberized' => 10000],
                'Coupe'        => ['epoxy' => 5500, 'rubberized' => 10000],
                'Crossover'    => ['epoxy' => 6000, 'rubberized' => 10000],
                'MPV'          => ['epoxy' => 6000, 'rubberized' => 10000],
                'Wagon'        => ['epoxy' => 6000, 'rubberized' => 10000],
                'Sports Car'   => ['epoxy' => 6000, 'rubberized' => 10000],
                'SUV'          => ['epoxy' => 6500, 'rubberized' => 10000],
                'Pickup Truck' => ['epoxy' => 7000, 'rubberized' => 11000],
                'Van'          => ['epoxy' => 7500, 'rubberized' => 12000]
            ]
        ];

        $getOptionMatrix = function ($categoryKey, $optionKey) use ($speedlanePrices, $vehicleTypes) {
            $matrix = [];
            foreach ($vehicleTypes as $vt) {
                if (isset($speedlanePrices[$categoryKey][$vt][$optionKey])) {
                    $matrix[$vt] = $speedlanePrices[$categoryKey][$vt][$optionKey];
                }
            }
            return $matrix;
        };

        $catalog = [
            [
                'name'           => 'Ceramic Coating Package',
                'description'    => 'Multi-layer nanotech ceramic protection for high-gloss finish and hydrophobic surface.',
                'notice'         => 'Select coverage options to view size-adjusted pricing.',
                'selection_type' => 'multi',
                'flat_price'     => 0,
                'pricing_matrix' => null,
                'options'        => [
                    ['name' => 'Full Body Ceramic Coating', 'price' => 10000, 'pricing_matrix' => $getOptionMatrix('ceramic_coating', 'full_body')],
                    ['name' => 'Front Half Ceramic Coating', 'price' => 6000, 'pricing_matrix' => $getOptionMatrix('ceramic_coating', 'front_half')],
                    ['name' => 'Hood & Fenders Coating', 'price' => 4500, 'pricing_matrix' => $getOptionMatrix('ceramic_coating', 'hood_fenders')],
                    ['name' => 'Wheels & Calipers Coating', 'price' => 4000, 'pricing_matrix' => $getOptionMatrix('ceramic_coating', 'wheels')],
                    ['name' => 'Glass & Windshield Coating', 'price' => 2500, 'pricing_matrix' => $getOptionMatrix('ceramic_coating', 'glass')],
                    ['name' => 'Exterior Trim Coating', 'price' => 3500, 'pricing_matrix' => $getOptionMatrix('ceramic_coating', 'trim')],
                ]
            ],
            [
                'name'           => 'Graphene Coating Package',
                'description'    => 'Advanced heat-reducing graphene formulation providing maximum scratch and water-spot resistance.',
                'notice'         => 'Includes multi-stage paint correction before application.',
                'selection_type' => 'multi',
                'flat_price'     => 0,
                'pricing_matrix' => null,
                'options'        => [
                    ['name' => 'Full Body Graphene Armor', 'price' => 14000, 'pricing_matrix' => $getOptionMatrix('graphene_coating', 'full_body')],
                    ['name' => 'Front Half Graphene Armor', 'price' => 10000, 'pricing_matrix' => $getOptionMatrix('graphene_coating', 'front_half')],
                    ['name' => 'Hood & Fenders Graphene', 'price' => 5500, 'pricing_matrix' => $getOptionMatrix('graphene_coating', 'hood_fenders')],
                    ['name' => 'Wheels Graphene Protection', 'price' => 5000, 'pricing_matrix' => $getOptionMatrix('graphene_coating', 'wheels')],
                    ['name' => 'Glass Graphene Protection', 'price' => 2500, 'pricing_matrix' => $getOptionMatrix('graphene_coating', 'glass')],
                    ['name' => 'Exterior Trim Graphene', 'price' => 5000, 'pricing_matrix' => $getOptionMatrix('graphene_coating', 'trim')],
                ]
            ],
            [
                'name'           => 'Paint Protection Film (PPF)',
                'description'    => 'Self-healing, ultra-clear protective film guarding against stone chips and physical abrasion.',
                'notice'         => 'High-impact panel and full front protection options.',
                'selection_type' => 'multi',
                'flat_price'     => 0,
                'pricing_matrix' => null,
                'options'        => [
                    ['name' => 'Full Front End PPF', 'price' => 25000, 'pricing_matrix' => $getOptionMatrix('ppf', 'full_front')],
                    ['name' => 'Hood Only PPF', 'price' => 8000, 'pricing_matrix' => $getOptionMatrix('ppf', 'hood_only')],
                    ['name' => 'Front Bumper PPF', 'price' => 8000, 'pricing_matrix' => $getOptionMatrix('ppf', 'front_bumper')],
                    ['name' => 'Fenders Pair PPF', 'price' => 8000, 'pricing_matrix' => $getOptionMatrix('ppf', 'fenders_pair')],
                    ['name' => 'Side Mirrors Pair PPF', 'price' => 2500, 'pricing_matrix' => $getOptionMatrix('ppf', 'mirrors_pair')],
                    ['name' => 'Door Cups PPF Set', 'price' => 2000, 'pricing_matrix' => $getOptionMatrix('ppf', 'door_cups')],
                    ['name' => 'Door Edges PPF Set', 'price' => 2000, 'pricing_matrix' => $getOptionMatrix('ppf', 'door_edges')],
                    ['name' => 'Headlights PPF Pair', 'price' => 4000, 'pricing_matrix' => $getOptionMatrix('ppf', 'headlights')],
                ]
            ],
            [
                'name'           => 'Interior Deep Detailing',
                'description'    => 'Deep steam sanitization, carpet extraction, leather feeding, and dashboard restoration.',
                'notice'         => 'Price dynamically adjusts based on vehicle size class.',
                'selection_type' => 'flat',
                'flat_price'     => 6500,
                'pricing_matrix' => $speedlanePrices['interior_detailing'],
                'options'        => []
            ],
            [
                'name'           => 'Exterior Paint Detailing',
                'description'    => 'Decontamination, clay bar treatment, multi-stage machine polishing, and synthetic sealant.',
                'notice'         => 'Price dynamically adjusts based on vehicle size class.',
                'selection_type' => 'flat',
                'flat_price'     => 6500,
                'pricing_matrix' => $speedlanePrices['exterior_detailing'],
                'options'        => []
            ],
            [
                'name'           => 'Washover & Panel Repainting',
                'description'    => 'Individual panel touch-up, spot repair, and premium urethane body paint refinishing.',
                'notice'         => 'Select individual body panels to calculate cost.',
                'selection_type' => 'multi',
                'flat_price'     => 0,
                'pricing_matrix' => null,
                'options'        => [
                    ['name' => 'Hood Panel Painting', 'price' => 8000, 'pricing_matrix' => $getOptionMatrix('washover', 'hood')],
                    ['name' => 'Roof Panel Painting', 'price' => 8000, 'pricing_matrix' => $getOptionMatrix('washover', 'roof')],
                    ['name' => 'Front Bumper Painting', 'price' => 6000, 'pricing_matrix' => $getOptionMatrix('washover', 'front_bumper')],
                    ['name' => 'Rear Bumper Painting', 'price' => 6000, 'pricing_matrix' => $getOptionMatrix('washover', 'rear_bumper')],
                    ['name' => 'Front Left Door Painting', 'price' => 5000, 'pricing_matrix' => $getOptionMatrix('washover', 'fl_door')],
                    ['name' => 'Front Right Door Painting', 'price' => 5000, 'pricing_matrix' => $getOptionMatrix('washover', 'fr_door')],
                    ['name' => 'Rear Left Door Painting', 'price' => 5000, 'pricing_matrix' => $getOptionMatrix('washover', 'rl_door')],
                    ['name' => 'Rear Right Door Painting', 'price' => 5000, 'pricing_matrix' => $getOptionMatrix('washover', 'rr_door')],
                    ['name' => 'Trunk / Tailgate Painting', 'price' => 6000, 'pricing_matrix' => $getOptionMatrix('washover', 'trunk')],
                    ['name' => 'Spot Paint Repair', 'price' => 4500, 'pricing_matrix' => $getOptionMatrix('washover', 'spot_repair')],
                ]
            ],
            [
                'name'           => 'Undercoating Rust Protection',
                'description'    => 'Corrosion barrier chassis protection using heavy-duty epoxy or rubberized compound.',
                'notice'         => 'Select preferred undercoating material.',
                'selection_type' => 'multi',
                'flat_price'     => 0,
                'pricing_matrix' => null,
                'options'        => [
                    ['name' => 'Epoxy Undercoating', 'price' => 6000, 'pricing_matrix' => $getOptionMatrix('undercoat', 'epoxy')],
                    ['name' => 'Rubberized Undercoating', 'price' => 10000, 'pricing_matrix' => $getOptionMatrix('undercoat', 'rubberized')],
                ]
            ],
        ];

        foreach ($catalog as $srvData) {
            $options = $srvData['options'] ?? [];
            unset($srvData['options']);

            $service = Service::updateOrCreate(
                ['name' => $srvData['name']],
                $srvData
            );

            foreach ($options as $optData) {
                $service->options()->updateOrCreate(
                    ['name' => $optData['name']],
                    $optData
                );
            }
        }
    }
}