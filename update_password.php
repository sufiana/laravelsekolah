<?php
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\models\User;

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = User::where('email', 'raffialfarizky@gmail.com')->first();
if ($user) {
    $user->password_hash = Hash::make('developer123');
    $user->save();
    echo "Password updated for " . $user->email . "\n";
} else {
    echo "User not found\n";
}
?>