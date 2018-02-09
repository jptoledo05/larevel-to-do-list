<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Task;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('note');
            $table->date('due_date');
            $table->timestamps();
        });

        Task::create([
            'title' => 'Task 1',
            'description' => 'Create to do list app',
            'note' => '',
            'due_date' => '2016-02-15',
            ]);

        Task::create([
            'title' => 'Task 2',
            'description' => 'Create application',
            'note' => '',
            'due_date' => '2016-02-14',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks');
    }
}