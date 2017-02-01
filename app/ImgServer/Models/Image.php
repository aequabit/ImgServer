<?php
/**
 * This is the Image model which accesses the database and reads data from the 'images' table
 */
namespace ImgServer\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Image extends Eloquent {
  public $fillable = [ 'hash', 'mime_type', 'url', 'delkey' ];
}
