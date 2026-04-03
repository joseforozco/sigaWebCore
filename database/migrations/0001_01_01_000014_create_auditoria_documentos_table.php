<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla: auditoria_documentos
     * Registro forense de documentos (snapshots JSON).
     */
    public function up(): void
    {
        Schema::create('auditoria_documentos', function (Blueprint $table) {
            $table->id();

            // Referencia al documento
            $table->string('documento_tipo', 20)
                  ->comment('Tipo: compra, venta, remision');
            $table->unsignedBigInteger('documento_id')
                  ->comment('ID del documento');
            $table->index(['documento_tipo', 'documento_id']);

            // Usuario que realizó el cambio
            $table->foreignId('usuario_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Detalles del cambio
            $table->string('campo_modificado', 100)
                  ->nullable()
                  ->comment('Nombre del campo que cambió');
            $table->text('valor_anterior')
                  ->nullable()
                  ->comment('Valor antes del cambio');
            $table->text('valor_nuevo')
                  ->nullable()
                  ->comment('Valor después del cambio');

            // Estado del documento
            $table->string('estado_documento', 20)
                  ->comment('Estado en que estaba el documento');

            // Acción realizada
            $table->string('accion', 50)
                  ->comment('Tipo de acción: create, update, confirm, cancel');

            // Observaciones
            $table->text('observacion')
                  ->nullable()
                  ->comment('Razón o nota del cambio');

            // IP y user agent
            $table->string('ip_address', 45)
                  ->nullable();
            $table->text('user_agent')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria_documentos');
    }
};
