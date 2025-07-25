<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductDashboardController;
use App\Http\Controllers\DesignController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\InvoiceController as CustomerInvoiceController;

Route::get('/', [\App\Http\Controllers\ProductDashboardController::class, '__invoke'])->name('customer.dashboard');

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return view('dashboard');
    } elseif (Auth::check()) {
        return app(\App\Http\Controllers\ProductDashboardController::class)->__invoke();
    } else {
        return redirect()->route('customer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        if (Auth::user()->role === 'admin') {
            return view('admin.dashboard');
        }
        abort(403);
    });
    Route::get('/admin/chat', function () {
        if (Auth::user()->role === 'admin') {
            return view('admin.chat');
        }
        abort(403);
    });
    Route::get('/admin/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{design}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{design}', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{design}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/admin/custom-design-types/edit', [AdminProductController::class, 'editCustomTypes'])->name('admin.custom-types.edit');
    Route::put('/admin/custom-design-types', [AdminProductController::class, 'updateCustomTypes'])->name('admin.custom-types.update');
    Route::get('/admin/products', [\App\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::post('/admin/products', [\App\Http\Controllers\Admin\ProductController::class, 'store']);
    Route::put('/admin/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::delete('/admin/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy']);
    
    // Reports Route
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/download-pdf', [\App\Http\Controllers\Admin\ReportController::class, 'downloadPdf'])->name('admin.reports.downloadPdf');

    // Invoice Routes
    Route::get('/admin/invoices', [InvoiceController::class, 'index'])->name('admin.invoices.index');
    Route::get('/admin/invoices/create', [InvoiceController::class, 'create'])->name('admin.invoices.create');
    Route::post('/admin/invoices', [InvoiceController::class, 'store'])->name('admin.invoices.store');
    Route::get('/admin/invoices/{invoice}', [InvoiceController::class, 'show'])->name('admin.invoices.show');
    Route::get('/admin/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('admin.invoices.edit');
    Route::put('/admin/invoices/{invoice}', [InvoiceController::class, 'update'])->name('admin.invoices.update');
    Route::delete('/admin/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('admin.invoices.destroy');
    Route::get('/admin/invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('admin.invoices.pdf');
    Route::patch('/admin/invoices/{invoice}/send', [InvoiceController::class, 'sendInvoice'])->name('admin.invoices.send');
    Route::patch('/admin/invoices/{invoice}/mark-paid', [InvoiceController::class, 'markAsPaid'])->name('admin.invoices.mark-paid');

    // Chat Routes
    Route::get('/chat/{design}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show')->middleware('auth');
    Route::post('/chat/{conversation}/messages', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store')->middleware('auth');

    // Pusher Authorization
    Route::post('/broadcasting/auth', function () {
        return Broadcast::auth(request());
    })->middleware('auth');

    Route::get('/designs', [DesignController::class, 'index'])->name('designs.index');
    Route::post('/designs', [DesignController::class, 'store'])->name('designs.store');
    Route::post('/designs/custom', [DesignController::class, 'storeCustom'])->name('designs.store.custom');
    Route::delete('/designs/{design}', [DesignController::class, 'destroy'])->name('designs.destroy');
    Route::post('/designs/payment', [DesignController::class, 'uploadPaymentProof'])->name('designs.payment.upload');
    Route::get('/products/{id}', [\App\Http\Controllers\ProductDashboardController::class, 'show'])->middleware(['auth', 'verified']);

    // Customer Invoice Route
    Route::get('/invoices/{invoice}', [CustomerInvoiceController::class, 'show'])->name('invoices.show');

    // WhatsApp Settings Routes
    Route::get('/admin/settings/whatsapp', [\App\Http\Controllers\Admin\SettingsController::class, 'editWhatsapp'])->name('admin.settings.whatsapp.edit');
    Route::post('/admin/settings/whatsapp', [\App\Http\Controllers\Admin\SettingsController::class, 'updateWhatsapp'])->name('admin.settings.whatsapp.update');
});

require __DIR__.'/auth.php';
