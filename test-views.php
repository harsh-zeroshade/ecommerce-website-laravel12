<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Share an empty ViewErrorBag so the form partials' $errors reference doesn't fail
\Illuminate\Support\Facades\View::share('errors', new \Illuminate\Support\View\ErrorBag());

$tests = [
    'admin.products.create' => ['categories' => \App\Models\Category::all()],
    'admin.products.edit'   => ['categories' => \App\Models\Category::all(), 'product' => \App\Models\Product::first() ?? new \App\Models\Product()],
    'admin.categories.create' => [],
    'admin.categories.edit'   => ['category' => \App\Models\Category::first() ?? new \App\Models\Category()],
    'admin.users.create' => [],
    'admin.users.edit'   => ['user' => \App\Models\User::first() ?? new \App\Models\User()],
];

foreach ($tests as $name => $data) {
    try {
        view($name, $data)->render();
        echo "[OK]    $name\n";
    } catch (\Throwable $e) {
        echo "[FAIL]  $name — {$e->getMessage()}\n";
    }
}
