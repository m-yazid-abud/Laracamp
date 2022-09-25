<?php

namespace Database\Seeders;

use App\Models\Camp_benefit;
use App\Models\CampBenefit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $benefitsGilaBelajar = [
            'Pro Techstack Kit',
            'iMac Pro 2021 & Display',
            '1-1 Mentoring Program',
            'Final Project Certificate',
            'Offline Course Videos',
            'Future Job Opportunity',
            'Premium Design Kit',
            'Website Builder',
        ];

        $benefitsBaruMulai = [
            '1-1 Mentoring Program',
            'Final Project Certificate',
            'Offline Course Videos',
            'Offline Course Videos',
        ];

        $benefits = [];

        foreach ($benefitsGilaBelajar as $key => $benefit) {

            $arr = [
                "camp_id" => 1,
                "name" => $benefit,
                "created_at" => Date("Y-m-d H:i:s", time()),
                "updated_at" => Date("Y-m-d H:i:s", time()),
            ];

            array_push($benefits, $arr);
        };

        foreach ($benefitsBaruMulai as $key => $benefit) {

            $arr = [
                "camp_id" => 2,
                "name" => $benefit,
                "created_at" => Date("Y-m-d H:i:s", time()),
                "updated_at" => Date("Y-m-d H:i:s", time()),
            ];

            array_push($benefits, $arr);
        };

        CampBenefit::insert($benefits);
    }
}
