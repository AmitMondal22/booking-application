<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
// use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    function mainpage(): View
    {
        return view('comingsoon');
    }


    function err404(): View
    {
        return view('error_page.404');
    }

    // Return Type: Integer
    public function getAge(): int
    {
        return 30;
    }
    // Return Type: String

    public function getName(): string
    {
        return 'John Doe';
    }
    // Return Type: Boolean
    public function isActive(): bool
    {
        return true;
    }
    // Return Type: Array
    public function getColors(): array
    {
        return ['red', 'green', 'blue'];
    }
    // Return Type: Custom Class
    public function getUser(): User
    {
        return User::find(1);
    }
    // Return Type: Nullable
    public function findUserById($id): ?User
    {
        return User::find($id);
    }
    // Return Type: Collection
    public function getUsers(): Collection
    {
        return User::all();
    }
    // Return Type: Float
    public function calculatePrice(): float
    {
        return 19.99;
    }
    // Return Type: Void (No return value)


    public function logMessage(string $message): void
    {
        // Log the message, but don't return anything
        Log::info($message);
    }


    // Returning a View:
    public function showProfile(): View
    {
        return view('welcome');
    }


    // Returning JSON Response:
    // public function getJsonData(): Response
    // {
    //     $data = ['name' => 'John', 'age' => 30];
    //     return response()->json($data);
    // }
}
