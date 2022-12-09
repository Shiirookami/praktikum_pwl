<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('home',compact('user'));
    }

    public function books()
    {
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user','books'));
    }

    public function submit_book(Request $req)
    {
        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
        ]);
        $book = new Book;
        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if ($req->hasFile('cover')) {
            $extension = $req->file('cover')->extendsion();
            $filename = 'cover_buku_'.time().'.'.$extension;
            $req->file('cover')->storeAs('public/cover_buku',$filename);

            $book->cover =$filename;

        }
        $book->save();
        $notification = array(
            'message'           => 'Data Berhasil disimpan',
            'alert-type'        => 'succes',
        );
        return redirect()->route('admin.books')->with($notification);
    }

    public function getDataBuku($id)
    {
        $buku = Book::find($id);
        return response()->json($buku);
    }

    public function update_book(Request $req)
    {
        $book = Book::find($req->get('id'));
        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
        ]);
        $book = new Book;
        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if ($req->hasFile('cover')) {
            $extension = $req->file('cover')->extendsion();
            $filename = 'cover_buku_'.time().'.'.$extension;
            $req->file('cover')->storeAs('public/cover_buku',$filename);
            Storage::delete('public/cover_buku/'.$req->get('old_cover'));
            $book->cover =$filename;

        }
        $book->save();
        $notification = array(
            'message'           => 'Data Buku Berhasil Ditambhkan',
            'alert-type'        => 'succes',
        );
        return redirect()->route('admin.books')->with($notification);
    }
    public function delete_book($id)
    {
        $book = Book::find($id);
        Storage::delete('public/cover_buku/'.$book->cover);
        $book->delete();

        $succes = true;
        $message = "data berhasil dihapus";

        return response()->json([
            'succes' => $succes,
            'message' => $message,
        ]);
    }
}
