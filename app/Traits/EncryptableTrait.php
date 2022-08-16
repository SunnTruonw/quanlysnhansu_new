<?php
/**
 * Trait Elocrypt.
 */
namespace App\Traits;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

trait EncryptableTrait
{
    // public function getAttribute($key)
    // {
    //     $value = parent::getAttribute($key);

    //     if (in_array($key, $this->encryptable)) {
    //         $value = Crypt::decrypt($value);
    //     }
    // }

    // public function setAttribute($key, $value)
    // {
    //     if (in_array($key, $this->encryptable)) {
    //         $value = Crypt::encrypt($value);
    //     }

    //     return parent::setAttribute($key, $value);
    // }
}
