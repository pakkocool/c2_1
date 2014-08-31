<?php

class Images extends Eloquent {
    protected $guarded = array(
        'id',
        'created_at',
        'updated_at'
    );

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * Uploading image validation rules.
     *
     * @var array
     */
    public static $rules = array(
        'file' => 'required|mimes:jpeg,jpg,png|max:3000',
        'text' => 'max:300',
        'resizew' => 'numeric|min:100|max:700',
        'resizeh' => 'numeric|min:100|max:700',
        'posx' =>  'numeric|min:1|max:500',
        'posy' =>  'numeric|min:1|max:500',
        'sizefont' =>  'numeric|between:5,500',
        'angle' =>  'numeric|between:-360,360',
    );

    /**
     * Validate image method.
     *
     * @param  file $data
     * @return object Validator
     */
    public static function validateImage($data)
    {
        return Validator::make($data, static::$rules);
    }

    /**
     * Insert image to database table;
     *
     * @param  string $folderName
     * @param  string $fileName
     * @return array
     */
    public static function insertImage($folderName, $fileName)
    {
        return Images::insert(array(
                    'id'         => $folderName,
                    'user_id'    =>  0,
                    'img_big'    => $fileName,
                    'img_min'    => 'min_' . $fileName,
                    'ip'         => Request::getClientIp(),
                    'private'    => Input::get('private') ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Relation with Users table.
     *
     * @return void
     */
    /*public function users()
    {
        return $this->belongsTo('Users', 'user_id');
    }*/

    /**
     * Relation with Votes table.
     *
     * @return void
     */
    /*public function votes()
    {
        return $this->hasMany('Votes');
    }*/
}