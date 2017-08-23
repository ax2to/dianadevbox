<?php

use App\Models\WorkLogModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntervalTimestampToWorklogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worklogs', function (Blueprint $table) {
            $table->string('worked_interval');
            $table->string('worked_timestamp');
        });
        $workLogs = WorkLogModel::where('in_progress', false)->get();
        foreach ($workLogs as $workLog) {
            $interval = new DateInterval($workLog->worked);
            $workLog->worked = $workLog->convertDateInterval2String($interval);
            $workLog->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('worklogs')
            ->where('in_progress', false)
            ->update(['worked' => DB::raw('worked_interval')]);
        Schema::table('worklogs', function (Blueprint $table) {
            $table->dropColumn('worked_interval');
            $table->dropColumn('worked_timestamp');
        });
    }
}
