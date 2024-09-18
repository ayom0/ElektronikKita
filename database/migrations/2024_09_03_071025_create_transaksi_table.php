<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi'); // Primary key with 'id_transaksi'
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('recipient_name');
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2);
            $table->decimal('total', 15, 2);
            $table->enum('payment_status', ['pending', 'succes', 'gagal'])->default('pending'); // Kolom status pembayaran
            $table->string('snap_token')->nullable(); // Tambahkan kolom snap_token
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi'); // Drops transaksi table
    }
}
