<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCvPackageRelatedColumnsFromCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('cvs_package_id');
            $table->dropColumn('cvs_package_start_date');
            $table->dropColumn('cvs_package_end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('cvs_package_id')->after('package_start_date')->nullable()->constrained();
            $table->timestamp('cvs_package_start_date')->nullable()->after('cvs_package_id');
            $table->timestamp('cvs_package_end_date')->nullable()->after('cvs_package_start_date');
        });
    }
}
