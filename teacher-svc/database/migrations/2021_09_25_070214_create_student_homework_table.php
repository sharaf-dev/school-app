<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\StudentHomework;

class CreateStudentHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_homework', function (Blueprint $table) {
            $table->id();
            $table->text('link')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('homework_id')->references('id')->on('homeworks');
            $table->foreignId('student_id');
            $table->tinyInteger('status')->default(StudentHomework::STATUS_NEW);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_homework');
    }
}
