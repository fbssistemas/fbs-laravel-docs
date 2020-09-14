<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiberacaoController extends Controller
{
    public function getAll()
    {
        if (!$token = request()->input('token')) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized']);
        }

        if ($token !== env('APP_TOKEN')) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized']);
        }

        $empresas = DB::select('SELECT CODIGO, CPFCNPJ, LIBERADO, VERSAO FROM pfj');
        $result = [];
        foreach ($empresas as $empresa) {
            $result[] = [
                'cpf_cnpj' => $empresa->CPFCNPJ,
                'liberado' => $empresa->LIBERADO,
                'versao' => $empresa->VERSAO,
            ];
            $filiais = DB::select('SELECT CPFCNPJ FROM pfjfilial WHERE PFJ = ?', [$empresa->CODIGO]);
            foreach ($filiais as $filial) {
                $result[] = [
                    'cpf_cnpj' => $filial->CPFCNPJ,
                    'liberado' => $empresa->LIBERADO,
                    'versao' => $empresa->VERSAO,
                ];
            }
        }
        return response()->json($result);
    }
}
