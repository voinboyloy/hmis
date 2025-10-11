<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function printInvoice(Invoice $record)
    {
        $record->load(['patient', 'items.service', 'items.medication']);

        return view('print.invoice', [
            'invoice' => $record,
        ]);
    }
}
