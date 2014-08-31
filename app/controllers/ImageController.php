<?php

use Intervention\Image\ImageManager;

class ImageController extends BaseController {

    /**
     * Showing list of public images (marked as 0 in private table).
     * Pagination by 42 items per page (infinite scrolling).
     *
     * @return object View
     */
    public function index()
    {
        return View::make('images/list')
                    ->with('title', 'List of images')
                    ->with('images', Images::orderBy('created_at', 'desc')
                                            ->where('private', 0)
                                            ->paginate('42'));
    }

    /**
     * Show image by id.
     * Additional information about image - showing user.
     *
     * @param  int $id
     * @return object View
     */
    public function show($id)    {
        

        return View::make('images/show')
                    ->with('title', 'Your images')
                    ->with('image', Images::findOrFail($id))
                    ->with('user_image', 'anonymous');
    }
    

    

    /**
     * Uploading multiple images method.
     *
     * @return object Redirect
     */
    public function upload()
    {
        $files = Input::file('file');
        
        $serializedFile = array();

        foreach ($files as $file) {
        
            $validation = Images::validateImage(array('file' => $file,
                                                      'text' => Input::get('text') ?: 'You must write something!', 
                                                      'resizew' => Input::get('resizew') ?: 500,
                                                      'resizeh'=> Input::get('resizeh') ?:500,
                                                      'posx' => Input::get('posx') ?: 200,
                                                      'posy' => Input::get('posy') ?: 300,
                                                      'sizefont' => Input::get('sizefont') ?: 30,
                                                      'angle' => Input::get('angle') ?: 45));            

            if (! $validation->fails()) {
                
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension();
                $folderName      = str_random(12);
                $destinationPath = 'uploads/' . $folderName;

                // Move file to generated folder

                $file->move($destinationPath, $fileName);

                // And save as miniature
                
                $img = Image::make($destinationPath . '/' . $fileName);

                // Saving image with some features

                $img->resize(Input::get('resizew') ?: 500, Input::get('resizeh') ?: 500);
                $img->text(Input::get('text') ?: 'You must write something!', Input::get('posx') ?: 200, Input::get('posy') ?: 300, function($font) {
                    $font->file(public_path('assets/fonts/wood.ttf'));
                    $font->size(Input::get('sizefont') ?: 30);
                    $font->color(Input::get('img_color','#630310'));
                    $font->align(Input::get('align', 'center'));
                    $font->valign(Input::get('valign', 'top'));
                    $font->angle(Input::get('angle') ?: 45);
                });

                //Saving image in different formats
                $img->save($destinationPath . '/min_' . $fileName);
                $img->save($destinationPath . '/min_' . $fileName.'.png');
                $img->save($destinationPath . '/min_' . $fileName.'.jpeg');
                $img->save($destinationPath . '/min_' . $fileName.'.jpg');


                // Insert image information to database
                Images::insertImage($folderName, $fileName);
            } else {
                return Redirect::route('main')
                        ->with('status', 'alert-danger')
                        ->with('image-message', 'There is a problem uploading your image!')
                        ->withErrors($validation->errors());
            }

            $serializedFile[] = $folderName;
        }

        return Redirect::route('main')
                        ->with('status', 'alert-success')
                        ->with('files', $serializedFile)
                        ->with('image-message', 'Congratulations! Your image(s) has been added');
    }


    /**
     * Dowload files with different formats.
     *
     * @param  int $id
     * @param  int $img_big
     * @param  int $format     
     * @return object download
     *
     */
    
    public function download($id,$img_big,$format = null)
    {
        if($format != null){
            $format = ".".$format;
        }
        else{
            $format = "";
        }

        $file= public_path(). "/uploads/".$id."/".$img_big."".$format;
        $headers = array(
              'Content-Type: application/image',
            );


        return Response::download($file, 'image'.$format, $headers);
        
    }

   

}