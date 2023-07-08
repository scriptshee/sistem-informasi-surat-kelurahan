<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('perihal');
            $table->string('pengirim');
            $table->bigInteger('penerima');
            $table->integer('kategori_id');
            $table->integer('atas_nama');
            $table->string('file');
            $table->boolean('disposisi')->default(false);
            $table->integer('approved_by')->nullable();
            $table->enum('status', ['new', 'process', 'disposition', 'rejected', 'finis'])->default('new');
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
        Schema::dropIfExists('surat_masuk');
    }
};
