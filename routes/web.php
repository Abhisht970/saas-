<?php

use App\Http\Controllers\AccountController;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Tenant;
use App\Services\TenantProvisioner;
use Illuminate\Validation\Rule;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AccountFieldController;
use App\Http\Controllers\DynamicObjectController;
use App\Http\Controllers\DynamicFieldController;
use App\Http\Controllers\DynamicRecordController;


Route::domain('admin.localhost')->group(function () {

    Route::get('/login', fn() => view('admin.login'))->name('admin.login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('super')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/tenants');
        }

        return back()->withErrors(['email' => 'Email ya password galat hai'])->onlyInput('email');
    });

    Route::post('/logout', function (Request $request) {
        Auth::guard('super')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    });

    Route::middleware('auth:super')->group(function () {

        Route::get('/', fn() => redirect('/tenants'));

        Route::get('/tenants', fn() => view('admin.tenants', [
            'tenants' => Tenant::on('mysql')->latest()->get(),
        ]));

        Route::post('/tenants', function (Request $request, TenantProvisioner $provisioner) {
            $data = $request->validate([
                'name' => 'required|string|max:100',
                'subdomain' => ['required', 'alpha_dash', 'max:50'],
                'admin_email' => 'required|email',
                'admin_password' => 'required|min:8',
            ]);

            $domain = strtolower($data['subdomain']) . '.localhost';

            if (Tenant::on('mysql')->where('domain', $domain)->exists()) {
                return back()->withErrors(['subdomain' => "Domain $domain already exists."])->withInput();
            }

            $provisioner->create($data['name'], $domain, $data['admin_email'], $data['admin_password']);

            return redirect('/tenants')->with('ok', "Tenant ready: $domain");
        });
    });
});



Route::middleware('tenant')->group(function () {

    Route::get('/whoami', fn() => [
        'tenant' => app('currentTenant')->name,
        'database' => DB::connection('tenant')->getDatabaseName(),
    ]);

    Route::get('/login', fn() => view('auth.login'))->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Email ya password galat hai'])->onlyInput('email');
    });

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard'));

        Route::get('/leads/add/{name}', function ($name) {
            Lead::create(['name' => $name]);
            return redirect('/leads');
        });

        // Leads routes
        Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
        Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
        Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
        Route::get('/leads/{lead}/convert-to-account', [LeadController::class, 'convertToAccount'])->name('leads.convert-to-account');

        Route::get('leads/form', [LeadController::class, 'lead_form'])->name('leads.form');
        Route::get('/leads/form/create', [LeadController::class, 'lead_form_create'])->name('leads.form.create');
        Route::post('/leads/form', [LeadController::class, 'lead_form_store'])->name('leads.form.store');
        Route::get('/leads/form/{id}/edit', [LeadController::class, 'lead_form_edit'])->name('leads.form.edit');

        //accounts
        Route::resource('accounts', AccountController::class);
        Route::get('/account-fields', [AccountFieldController::class, 'index'])->name('account-fields.index');
        Route::get('/account-fields/create', [AccountFieldController::class, 'create'])->name('account-fields.create');
        Route::post('/account-fields', [AccountFieldController::class, 'store'])->name('account-fields.store');

        Route::resource(
            'dynamic-objects',
            DynamicObjectController::class
        );

        Route::get(
            '/dynamic-objects/{dynamicObject}/fields/create',
            [DynamicFieldController::class, 'create']
        )->name('dynamic-fields.create');

        Route::post(
            '/dynamic-objects/{dynamicObject}/fields',
            [DynamicFieldController::class, 'store']
        )->name('dynamic-fields.store');


        Route::get(
            '/objects/{objectKey}/create',
            [DynamicRecordController::class, 'create']
        )->name('dynamic-records.create');

        Route::post(
            '/objects/{objectKey}',
            [DynamicRecordController::class, 'store']
        )->name('dynamic-records.store');
    });

    Route::get(
        '/objects/{objectKey}',
        [DynamicRecordController::class, 'index']
    )->name('dynamic-records.index');

    Route::get(
    '/objects/{objectKey}/{record}',
    [DynamicRecordController::class, 'show']
)->name('dynamic-records.show');
});