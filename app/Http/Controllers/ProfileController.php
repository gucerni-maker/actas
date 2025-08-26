<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function showFirma()
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $user = auth()->user();
        return view('profile.firma', compact('user'));
    }

    public function uploadFirma(Request $request)
{
    // Verificar que el usuario sea administrador
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }

    $request->validate([
        'firma' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:max_width=500,max_height=200',
    ], [
        'firma.required' => 'Debe seleccionar una imagen de firma.',
        'firma.image' => 'El archivo debe ser una imagen.',
        'firma.mimes' => 'La imagen debe ser en formato PNG, JPG o JPEG.',
        'firma.max' => 'La imagen no debe superar 2MB.',
        'firma.dimensions' => 'La imagen no debe superar 500x200 píxeles.',
    ]);

    $user = auth()->user();

    // Logging para diagnóstico
    \Log::info('Intentando cargar firma para usuario: ' . $user->id);

    // Verificar que el directorio exista y tenga permisos correctos
    $directorioFirmas = storage_path('app/public/firmas');
    if (!file_exists($directorioFirmas)) {
        \Log::info('Creando directorio de firmas: ' . $directorioFirmas);
        mkdir($directorioFirmas, 0755, true);
    }
    
    // Verificar permisos del directorio
    if (!is_writable($directorioFirmas)) {
        \Log::error('Directorio de firmas no tiene permisos de escritura: ' . $directorioFirmas);
        return redirect()->back()->with('error', 'No se puede escribir en el directorio de firmas. Contacte al administrador.');
    }

    // Guardar la nueva firma
    if ($request->hasFile('firma')) {
        $archivo = $request->file('firma');
        
        \Log::info('Detalles del archivo:', [
            'original_name' => $archivo->getClientOriginalName(),
            'extension' => $archivo->getClientOriginalExtension(),
            'size' => $archivo->getSize(),
            'mime_type' => $archivo->getMimeType()
        ]);
        
        $nombreArchivo = 'firma_' . $user->id . '_' . time() . '.' . $archivo->getClientOriginalExtension();
        $rutaRelativa = 'public/firmas/' . $nombreArchivo;
        $rutaFisica = storage_path('app/' . $rutaRelativa);
        
        \Log::info('Ruta donde se guardará el archivo: ' . $rutaFisica);
        
        try {
            // Mover el archivo físicamente
            if ($archivo->move(dirname($rutaFisica), basename($rutaFisica))) {
                \Log::info('Archivo movido exitosamente a: ' . $rutaFisica);
                
                // Verificar que el archivo exista físicamente
                if (file_exists($rutaFisica)) {
                    \Log::info('Archivo confirmado físicamente en: ' . $rutaFisica);
                    
                    // Eliminar firma anterior si existe
                    if ($user->ruta_firma && Storage::exists($user->ruta_firma)) {
                        \Log::info('Eliminando firma anterior: ' . $user->ruta_firma);
                        Storage::delete($user->ruta_firma);
                    }
                    
                    // Actualizar el usuario con la ruta de la firma
                    $user->update(['ruta_firma' => $rutaRelativa]);
                    
                    return redirect()->back()->with('success', 'Firma cargada exitosamente.');
                } else {
                    \Log::error('Archivo no encontrado después de mover: ' . $rutaFisica);
                    return redirect()->back()->with('error', 'Error al guardar la firma. Archivo no encontrado.');
                }
            } else {
                \Log::error('Error al mover el archivo a: ' . $rutaFisica);
                return redirect()->back()->with('error', 'Error al guardar la firma en el servidor.');
            }
        } catch (\Exception $e) {
            \Log::error('Excepción al guardar la firma: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al procesar la firma: ' . $e->getMessage());
        }
    } else {
        \Log::error('No se recibió archivo de firma');
        return redirect()->back()->with('error', 'No se recibió ningún archivo de firma.');
    }
}

    public function deleteFirma()
    {

        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $user = auth()->user();

        // Eliminar firma si existe
        if ($user->ruta_firma && Storage::exists($user->ruta_firma)) {
            Storage::delete($user->ruta_firma);
        }

        // Actualizar el usuario
        $user->update(['ruta_firma' => null]);

        return redirect()->back()->with('success', 'Firma eliminada exitosamente.');
    }


    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
