<?php

namespace App\Http\Controllers;

use App\Forms\WorkLogForm;
use App\Models\WorkLogModel;
use App\Timesheet;
use App\User;
use Auth;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workLogs = WorkLogModel::where('company_id', Auth::user()->company_id)
            ->where('in_progress', false)
            ->orderBy('id', 'desc')
            ->paginate();

        return view('work-logs.index', compact('workLogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = new WorkLogForm(route('work-logs.store'));
        $form->getElement('issue_id')->setDefault(\request('issue_id', null));
        $form->getElement('worked')->setDefault('1H');
        $form->getElement('date')->setDefault(Carbon::now('America/Lima'));

        return view('work-logs.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workLog = new WorkLogModel();
        $workLog->fill($request->only($workLog->getFillable()));
        $workLog->date = (new Carbon($request->date, 'America/Lima'))->tz('UTC');
        $workLog->company_id = Auth::user()->company_id;
        $workLog->user_id = Auth::id();
        $workLog->save();

        return redirect()->route('work-logs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param WorkLogModel $workLog
     * @return \Illuminate\Http\Response
     */
    public function show(WorkLogModel $workLog)
    {
        return view('work-logs.show', compact('workLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkLogModel $workLog
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkLogModel $workLog)
    {
        $form = new WorkLogForm(route('work-logs.update', $workLog), 'PUT');
        $form->setModel($workLog);

        return view('work-logs.edit', compact('workLog', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param WorkLogModel $workLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkLogModel $workLog)
    {
        $workLog->fill($request->only($workLog->getFillable()));
        $workLog->date = (new Carbon($request->date, 'America/Lima'))->tz('UTC');
        $workLog->save();

        return redirect()->route('work-logs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function timesheet()
    {

        switch (\request('range', 'week')) {
            case 'day':
                $start = Carbon::now('America/Lima')->hour(0)->minute(0)->second(0);
                $start->addDay(\request('mod', 0));

                $end = clone $start;
                $end->hour(23)->minute(59)->second(59);
                break;
            case 'week':
                $start = Carbon::now('America/Lima')->hour(0)->minute(0)->second(0);
                $start->day($start->day - $start->dayOfWeek + 1);
                $start->addWeek(\request('mod', 0));

                $end = clone $start;
                $end->hour(23)->minute(59)->second(59);
                $end->addDay(6);
                break;
            case 'month':
                $start = Carbon::now('America/Lima')->hour(0)->minute(0)->second(0);
                $start->day(1);
                $start->addMonth(\request('mod', 0));

                $end = clone $start;
                $end->hour(23)->minute(59)->second(59);
                $end->day($start->daysInMonth);
                break;
        }

        $timesheet = new Timesheet($start, $end);
        if (\request('user_id', Auth::id()) != 'all') {
            $timesheet->setUser(User::find(\request('user_id', Auth::id())));
        }
        $timesheet->build();

        $users = ['all' => 'All'] + User::where('company_id', Auth::user()->company_id)
                ->orderBy('name')->orderBy('lastName')
                ->pluck('name', 'id')->toArray();
        $params = \request()->all();
        $mod = \request('mod', 0);
        return view('work-logs.timesheet', compact('timesheet', 'users', 'params', 'mod'));
    }
}