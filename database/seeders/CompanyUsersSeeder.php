<?php

namespace Database\Seeders;

use App\Company;
use App\Models\CompanyUser;
use Illuminate\Database\Seeder;

class CompanyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Company::all() as $company) {
            CompanyUser::updateOrCreate(
                [
                    'company_id' => $company->id,
                    'email' => $company->email,
                ],
                [
                    'name' => $company->name,
                    'password' => $company->password,
                    'role' => 'admin',
                    'accepted_at' => now()
                ]
            );
        }
    }
}
