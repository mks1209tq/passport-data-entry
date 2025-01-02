public function index(Request $request): View
    {
        $passportDataEntries = Passport::all()->where('is_data_entered', false)->where('user_id', auth()->user()->id);

        return view('apps.hr.passport.data-entry.index', compact('passportDataEntries'));
    }



