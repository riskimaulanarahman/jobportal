<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('code_job')->unique();
            $table->string('category');
            $table->enum('contract_status', ['full-time', 'contract']);
            $table->string('location');
            $table->integer('experience_years');
            $table->text('job_description');
            $table->json('skills_required'); // Using JSON to store multiple skills
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
