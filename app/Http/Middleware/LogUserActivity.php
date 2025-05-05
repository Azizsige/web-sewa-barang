<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $userBefore = $request->user(); // Ambil user sebelum request (untuk logout)

        Log::info('LogUserActivity: Before request', [
            'route' => $request->route()->getName() ?? $request->path(),
            'method' => $request->method(),
            'user_before' => $userBefore ? $userBefore->id : 'null',
        ]);

        $response = $next($request);

        // Ambil user setelah request diproses (untuk login)
        $userAfter = $request->user();

        Log::info('LogUserActivity: After request', [
            'route' => $request->route()->getName() ?? $request->path(),
            'method' => $request->method(),
            'user_after' => $userAfter ? $userAfter->id : 'null',
        ]);

        // Log login setelah autentikasi berhasil
        if ($request->isMethod('post') && $request->path() === 'login') {
            if ($userAfter && $userAfter->role === 'admin') {
                ActivityLog::create([
                    'user_id' => $userAfter->id,
                    'action' => 'login',
                    'description' => 'Admin ' . $userAfter->name . ' login.',
                ]);
                Log::info('LogUserActivity: Login recorded', [
                    'user_id' => $userAfter->id,
                ]);
            } else {
                Log::warning('LogUserActivity: Login not recorded - user not admin or not authenticated', [
                    'user_after' => $userAfter ? $userAfter->toArray() : 'null',
                ]);
            }
        }

        // Log logout atau update profile
        if ($userBefore && $userBefore->role === 'admin') {
            if ($request->isMethod('post') && $request->route()->getName() === 'logout') {
                ActivityLog::create([
                    'user_id' => $userBefore->id,
                    'action' => 'logout',
                    'description' => 'Admin ' . $userBefore->name . ' logout.',
                ]);
                Log::info('LogUserActivity: Logout recorded', [
                    'user_id' => $userBefore->id,
                ]);
            } elseif ($request->isMethod('put') && $request->route()->getName() === 'profile.update') {
                $oldUser = $userBefore->replicate();
                $newUser = $userAfter ? $userAfter->refresh() : $userBefore;
                $changes = array_diff_assoc($newUser->getAttributes(), $oldUser->getAttributes());
                ActivityLog::create([
                    'user_id' => $userBefore->id,
                    'action' => 'updated',
                    'model_type' => 'User',
                    'model_id' => $userBefore->id,
                    'old_values' => array_intersect_key($oldUser->getAttributes(), $changes),
                    'new_values' => array_intersect_key($newUser->getAttributes(), $changes),
                    'description' => 'Admin ' . $userBefore->name . ' update profile.',
                ]);
                Log::info('LogUserActivity: Profile update recorded', [
                    'user_id' => $userBefore->id,
                ]);
            }
        }

        return $response;
    }
}
