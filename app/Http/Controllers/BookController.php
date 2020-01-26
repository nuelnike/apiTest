<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response; 
use Illuminate\Support\Facades\URL; 
use DB;
use App\Books;
use App\Http\Resources\BooksCollection;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $books = Books::get(); 

        if ($books != '[]' ) { 
        return BooksCollection::collection($books);
        } else{
        return response()->json([
        "status_code" => "200",
        "status" => "success", 
        "data" => "[]"
        ]);
         }

    }

    public function externalBooks()
    { 
    $json = json_decode(file_get_contents('https://www.anapioficeandfire.com/api/books'), true);
    return response()->json([ 
                           "status_code" => "200", 
                           "status" => "success",  
                           "data" => $json,  
                           ]); 
      
    }

    public function getexternalBook($id)
    { 
    $json = json_decode(file_get_contents('https://www.anapioficeandfire.com/api/books/'.$id.''), true);
    return response()->json([ 
                           "status_code" => "200", 
                           "status" => "success",  
                           "data" => $json,  
                           ]); 
    }
 
    
// Alternative to fire and ice

    public function externalPosts()
    { 
    $json = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
    return response()->json([ 
                           "status_code" => "200", 
                           "status" => "success",  
                           "data" => $json,  
                           ]); 
      
    }

    public function getexternalPost($id)
    { 
    $json = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts/'.$id.''), true);
    return response()->json([ 
                           "status_code" => "200", 
                           "status" => "success",  
                           "data" => $json,  
                           ]); 
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function create(Request $request)
    {
    $book = new Books;
    $book->name = $request->name;
    $book->isbn = $request->isbn;
    $book->authors = $request->authors;
    $book->country = $request->country;
    $book->number_of_pages = $request->number_of_pages;
    $book->publisher = $request->publisher;
    $book->release_date = $request->release_date; 
    $book->save();

    $newItem = array('name' => $request->name,'isbn' => $request->isbn, 'authors' => $request->authors);

    return response()->json([ 
                           "status_code" => "201", 
                           "status" => "success",  
                           "data" => array('book' => $newItem),
                           "number_of_pages" => $request->number_of_pages, 
                           "publisher" => $request->publisher, 
                           "country" => $request->country,
                           "release_date" => $request->release_date,  
                           ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 public function show($id)
    {
if (Books::where('id', $id)->exists()) {

 $book = Books::where('id', $id)->first(); 
 $dataItem = array('id' => $book->id,'name' => $book->name,'isbn' => $book->isbn, 'authors' => array($book->authors) );
 return response()->json([ 
                           "status_code" => "200", 
                           "status" => "success",  
                           "data" => $dataItem,
                           "number_of_pages" => $book->number_of_pages, 
                           "publisher" => $book->publisher, 
                           "country" => $book->country,
                           "release_date" => $book->release_date,  
                           ]); 

 }  else {
 return response()->json([
                           "status_code" => "200",
                           "status" => "success",
                           "message" => "Book not found",
                           "data" => "[]"
                            ]);
}
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
 if (Books::where('id', $id)->exists()) { 

 DB::update('update books set name = ?, isbn = ?, authors = ?, country = ?, number_of_pages = ?, publisher = ?, release_date = ? where id = ?', [$request->name,$request->isbn,$request->authors,$request->country,$request->number_of_pages,$request->publisher,$request->release_date,$id]);  
$ToReturn = array(
                "id" => $id, 
                "name" => $request->name,
                "isbn" => $request->isbn,
                "authors" => $request->authors,
                "country" => $request->country,
                "number_of_pages" => $request->number_of_pages,
                "publisher" => $request->publisher,
                "release_date" => $request->release_date 
                );

return response()->json([ 
                 "status_code" => "200",
                 "status" => "success", 
                 "message" => "The book My First Book was updated successfully", 
                 "data" => $ToReturn
                ]);
 } else {
 return response()->json([
                 "status_code" => "200",
                 "status" => "success",
                 "message" => "Book not found",
                 "data" => "[]"
]);
}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
    $article = Books::findOrFail($id);
    $article->delete();

    return response()->json([
        "status_code" => "204",
        "status" => "success",
        "message" => "The book My First Book was deleted successfully",
        "data" => "[]"
    ]);

    }
}
