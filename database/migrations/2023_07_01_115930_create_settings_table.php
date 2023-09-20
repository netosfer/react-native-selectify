<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
			$table->string("lang")->default("en");
			$table->string("uniq_key");
			$table->string("logo")->nullable();
			$table->string("footer_logo")->nullable();
			$table->string("favicon")->nullable();
			$table->string("site_title");
			$table->text("site_description");
			$table->string("admin_email");
			$table->text("copyright");
			$table->boolean("cookie_alert")->nullable();
			$table->string("color")->nullable();
			$table->longText("html_codes")->nullable();
			$table->longText("social_links")->nullable();
			$table->longText("smtp_configurations")->nullable();
			$table->text("google_recaptcha")->nullable();
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
        Schema::dropIfExists('settings');
    }
}
