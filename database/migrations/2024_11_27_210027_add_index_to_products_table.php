<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add indexes on customer_name customer_email and description of the Order Table
 *
 * @class AddIndexToOrdersTable
 * @package
 */
class AddIndexToProductsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(
                ['product_name', 'sku', 'description'],
                'product_name_sku_description_index'
            );
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('product_name_sku_description_index');
        });
    }
}
