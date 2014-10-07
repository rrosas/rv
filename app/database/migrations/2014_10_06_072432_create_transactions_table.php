<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('country', 100);
			$table->string('currency', 100)->nullable();
            $table->decimal('recharge_amount', 12, 4)->unsigned();
			$table->decimal('tax_amount', 12, 4)->unsigned();
			$table->decimal('total_amount', 12, 4)->unsigned();
			$table->string('card_type', 3);
			$table->integer('card_number')->unsigned();
			$table->integer('card_expiration');
			$table->integer('card_cvv');
            $table->string('ip', 15);
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
		Schema::table('transactions', function(Blueprint $table)
		{
			Schema::drop('transactions');
		});
	}

}
