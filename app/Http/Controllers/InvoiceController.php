<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        // No middleware here - we'll do the check in each method
    }

    private function checkAuthentication()
    {
        if (!Session::has('user_authenticated') || Session::get('user_authenticated') !== true) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
        return null;
    }

    public function index()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $invoices = Invoice::with('customer')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        $customers = Customer::all();
        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        $invoice = Invoice::create([
            'customer_id' => $request->customer_id,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'total_amount' => $request->total_amount,
            'gst_amount' => $request->gst_amount,
        ]);

        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'amount' => $item['amount'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        return view('invoices.show', compact('id'));
    }

    public function edit($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        return view('invoices.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function downloadPdf($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);
        
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_no . '.pdf');
    }
}

