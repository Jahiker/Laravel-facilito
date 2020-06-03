<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\UserEmailWelcome;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    Artisan::call('user:mail', [
        'id' => 46,
        '--flag' => 'Flag User'
    ]);

    return view('welcome');
})->middleware('language');

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('posts', 'PostController');
    Route::get('/my/posts', 'PostController@myPosts')->name('posts.my');
});

Route::get('/mail', function () {
    UserEmailWelcome::dispatch(User::find(1));
    return "done";
});

Route::get('/contact', function(){
    return view('mails.form');
})->name('contact');

Route::post('/sent', function(Request $request){
    $name =  $request->input('name');
    $email = $request->input('email');
    $content = $request->input('content');

    Mail::to($email)->send(new ContactMessage($name, $email, $content));

    return redirect()->route('contact')->with([
        'message' => 'El correo ha sido enviado'
    ]);

})->name('sent');



// Route::group(['prefix' => 'admin'], function () {
    // Las rutas con where definen restricciones al parametro de la misma
//     Route::get('name/{name?}', function ($name = "Usuario") {
//         $today = today();
//         return $name.' Hoy es '.$today;
//     })->where('name', '[A-Za-z]+')->name('name');

// });
// Las rutas any, independientemente de si la peticion es get, post, put o delete, ejecuta lo que esta dentro de la funcion
// Route::any('/foo', function () {
    // la propiedad name define un nombre a la ruta para ser utilizada de forma mas facil si la url es muy larga
//     return '/foo';
// })->name('foo');

// Solo ejecuta la funcion si la peticion coincide con las definidas en el arreglo
// Route::match(['put', 'post'], '/match', function () {
//     return 'match';
// });

// Al acceeder a la ruta te redireciona inmediatamente a la ruta especificada
// Route::redirect('/foo', '/admin/name/redirect', 301);

// Retornando una vista desde la ruta
// Route::get('/views', function () {
//     $name = 'Jahiker';
//     $secondName = 'Rojas';
//     $array = [1,2,3,4,5,6];
//     $number = 1;
//     return view('view', compact('name', 'secondName', 'array', 'number'));
// });

// Ruta para vista vue
// Route::view('/vue', 'vue');

// Ruta para probar la base de datos
// Route::get('/db', function () {
//     try {
//         DB::connection();
//     } catch (\Exception$e) {
//         die('Error de conexion a la base de datos'.' '.$e);
//     }
// });

// Ruta para obtener todos los usuarios con sus respectivos post
// Route::get('/users', function () {

    // dd(User::with(['posts'])->first()->posts->first->id);

//     $user = User::with(['posts' => function($query){
//         $query->where('id', 121);
//     }])->where('id', 1)->get();
//     dd($user);

// });

// Ruta pruebas query builder
// Route::get('/query', function () {
    // $users = DB::table('users')->where('email', 'valerie.king@example.org')->first();
//     $users = DB::table('users')
//     ->join('posts', 'users.id', 'posts.user_id')
//     ->select('users.id', 'users.name', 'posts.title', 'posts.content')
//     ->get();
//     dd($users);
// });

