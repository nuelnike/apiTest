##TOOLS

Xampp

Laravel 6.0

Mysql database

##CONTROLLERS

BooksController.php

##MODEL

Books.php

##API ROUTES

Route::get('/external-books/', 'BookController@externalBooks');

Route::get('/external-books/{id}', 'BookController@getexternalBook');

Route::get('/v1/books', 'BookController@index');

Route::get('/v1/books/{book}', 'BookController@show');

Route::post('/v1/books', 'BookController@create');

Route::patch('/v1/books/{book}', 'BookController@update');

Route::delete('/v1/books/{book}', 'BookController@delete');

##Alternative external api if fire and ice is unavailable

Route::get('/external-posts/', 'BookController@externalPosts');

Route::get('/external-posts/{id}', 'BookController@getexternalPosts');

##Test URL
1. Fire and ice

GET http://localhost:8080/api/external-books/

GET http://localhost:8080/api/external-books/1

1B. Json Placeholder (Alternative if fire and ice fails)

GET http://localhost:8080/api/external-post/

GET http://localhost:8080/api/external-posts/1


##INSTRUCTIONS

Rename file env and editorconfig to .env and .editorconfig
remember to run composer update command to load the vendor folder.

##INCLUDES

A Mysql database was included for quick setup. It is located in database/rest_api_test.sql

##CONFIGURATIONS

1. Create a new database with the name rest_api_test.

2. Import/upload the mysql file in database/restful_api_test.SQL

3. Run the php artisan command to start server or launch xampp and start you apache and mysql

4. Test endpoints with specified URL as specified in the assessment test.

##IMPLEMENTATIONS

1. External Api Call
Note: the fire and ice Api is not stable. ensure the api is available before trying out.
This can be achieved using two methods, either through installation of Guzzle package or through an external http request via controller to fire and ice api. In this app,  the simple external http request call was made to fire and ice api end using the sample code below:

To fetch all books 

$json = json_decode(file_get_contents('https://www.anapioficeandfire.com/api/books'), true);

To get a specific book, an ID is passed to the controller from which an external http request will be made with the specified ID to retrieve a specific record as shown bellow

$json = json_decode(file_get_contents('https://www.anapioficeandfire.com/api/books/'.$id.''), true);


##CRUD IMPLEMENTATIONS

All returned results has been formatted to a json format to be exact as specified in the test assessment.
This involved addition of two meta data which are "status_code" to the json results returned.

2. SHOW ALL

First we make a GET request to our api endpoint 'index' in our controller. we then create a resource file named BookCollection which we will use in our BooksController to retrieve all available data in the table books from our database which we have formated its output result as specified in the assessment test.

##Result

note: laravel-6 dont recognize (null) or (empty) so passing [] inplace of null or empty.

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

3. CREATE 

When a new record is sent which is a POST request, its received by the api endpoint 'CREATE' in our BooksController. The record is further processed to the database and on success completion,  returns a json resultformatted to be exact as specified in the assessment test.

##Result

    return response()->json([ 
                           "status_code" => "201", 
                           "status" => "success",  
                           "data" => array('book' => $newItem),
                           "number_of_pages" => $request->number_of_pages, 
                           "publisher" => $request->publisher, 
                           "country" => $request->country,
                           "release_date" => $request->release_date,  
                           ]); 

4. READ

To retrieve a particular record, a GET request is made to the api endpoint 'SHOW' in our controller must have the id of the requested record. If the id exists in the database, it returns a formatted json result as specified but if id don't exist, it also returns a formatted json result as specified in the assessment test.

##Result

if (Books::where('id', $id)->exists()) {
 return response()->json([ 
                           "status_code" => "200", 
                           "status" => "success",  
                           "data" => $dataItem,
                           "number_of_pages" => $book->number_of_pages, 
                           "publisher" => $book->publisher, 
                           "country" => $book->country,
                           "release_date" => $book->release_date,  
                           ]); 
}
else{
 return response()->json([
                           "status_code" => "200",
                           "status" => "success",
                           "message" => "Book not found",
                           "data" => "[]"
                            ]);
}

5. UPDATE

Data is sent to our endpoint 'UPDATE' in our controller from a PATCH request to the database with the id of record to update. At success returns a formatted json result as specified in the assessment test.

##Result

 if (Books::where('id', $id)->exists()) { 

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

5. DELETE

The id of the record to be deleted is sent to the api endpoint 'DELETE' in our controller, if id exists, removes data from the database. After which a success result that has been formatted as specified in the assessment test.

##Result

return response()->json([
        "status_code" => "204",
        "status" => "success",
        "message" => "The book My First Book was deleted successfully",
        "data" => "[]"
    ]);
