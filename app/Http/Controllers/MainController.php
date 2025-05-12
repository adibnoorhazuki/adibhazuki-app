<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct(
        protected $model = FileUpload::class
    )
    {}

    public function index()
    {
        $data = $this->model::orderByDesc('id')->get();

        return view('welcome', compact('data'));
    }
}
