<?php

namespace App\Http\Controllers;

use App\Models\Control;
use Illuminate\Http\Request;

class ControlController extends Controller
{
    public function update(Control $control)
    {
        $control->update(['count' => $control->count + 1]);
        return $control;
    }
}
