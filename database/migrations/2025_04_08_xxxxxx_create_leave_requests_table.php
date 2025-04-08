<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Liên kết với bảng users
            $table->date('start_date'); // Ngày bắt đầu nghỉ
            $table->date('end_date'); // Ngày kết thúc nghỉ
            $table->string('status')->default('pending'); // Trạng thái: pending, approved, rejected
            $table->text('reason')->nullable(); // Lý do xin nghỉ (tùy chọn)
            $table->timestamps();
            
            // Ràng buộc khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leave_requests');
    }
}