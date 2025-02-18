<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
// use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        if (!session()->has('vehicle')) {
            return redirect()->back()->with('error', 'No booking data found. Please book a ticket first.');
        }

        $data = [
            'vehicle' => session('vehicle'),
            'route' => session('route'),
            'bookingDate' => session('bookingDate'),
            'trip' => session('trip'),
            'seatsData' => session('seatsData'),
            'passenger_name' => session('passenger_name'),
            'passenger_phone' => session('passenger_phone'),
        ];

        $pdf = FacadePdf::loadView('admin.pages.ticketBooking.print', $data);
        return $pdf->download('ticket.pdf');
    }
}