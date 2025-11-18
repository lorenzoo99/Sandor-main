<?php

namespace App\Http\Controllers;

use App\Models\FacturaVenta;
use App\Models\DetalleFacturaVenta;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    public function crear()
    {
        $clientes = Cliente::all();
        return view('facturas.crear', compact('clientes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:Cliente,id_cliente',
            'subtotal' => 'required|numeric',
            'iva' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $factura = FacturaVenta::create([
            'numero_factura' => 'FV-' . time(),
            'fecha_emision' => now(),
            'id_cliente' => $request->id_cliente,
            'subtotal' => $request->subtotal,
            'iva' => $request->iva,
            'total' => $request->total,
            'estado' => 'PENDIENTE',
            'id_usuario' => Auth::user()->id_usuario,
            'prefijo' => 'FV',
            'numero_resolucion' => '18760000001',
            'medio_pago' => 'Transferencia',
            'forma_pago' => 'Contado',
            'moneda' => 'COP'
        ]);

        // Aquí simularemos generación de XML UBL (más adelante lo haremos completo)
        $xml = view('facturas.xml', compact('factura'))->render();

        // Enviar a la DIAN (sandbox)
        $response = Http::withHeaders([
            'Authorization' => 'Bearer TU_TOKEN_AQUI',
            'Content-Type' => 'application/json',
        ])->post('https://vpfe-hab.dian.gov.co/api/v1/invoice', [
            'testSetId' => 'd527c4df-fb54-41ea-b6f6-bc7a49e68694',
            'document' => base64_encode($xml),
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $factura->update([
                'cufe' => $data['cufe'] ?? null,
                'estado' => 'ENVIADA'
            ]);
            return redirect()->back()->with('success', 'Factura enviada correctamente.');
        }

        return redirect()->back()->with('error', 'Error al enviar a la DIAN: ' . $response->body());
    }
}
