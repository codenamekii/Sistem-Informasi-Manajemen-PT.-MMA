<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAccess
{
  /**
   * Cek apakah user boleh mengakses area tertentu.
   * Dipanggil via route middleware: role.access:nama_area
   *
   * @param string $area  Contoh: 'fasilitas', 'kerja_sama', 'jadwal', dll.
   */
  public function handle(Request $request, Closure $next, string $area): Response
  {
    $user = $request->user();

    // Belum login — biarkan middleware auth menangani
    if (!$user) {
      return $next($request);
    }

    if (!$user->canAccess($area)) {
      return redirect()
        ->route('dashboard')
        ->with('error', 'Anda tidak memiliki akses ke area tersebut.');
    }

    return $next($request);
  }
}