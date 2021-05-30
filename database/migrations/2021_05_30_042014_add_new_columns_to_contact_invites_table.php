<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToContactInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_invites', function (Blueprint $table) {
            $table->integer('direct_invite')->default(0);
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->text('invite_link')->nullable();

            $table->foreign('contact_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_invites', function (Blueprint $table) {
            $table->dropColumn('direct_invite');
            $table->dropColumn('contact_id');
        });
    }
}
