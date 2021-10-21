<?php

namespace App\Http\Controllers;

use App\Encryption as EncryptionModel;
use App\Http\Requests\Encryption;
use Illuminate\Http\Request;
use \Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class EncryptController extends Controller
{
    private $model = EncryptionModel::class;
    public function index()
    {
        return view('encrypt');
    }
    public function view($id)
    {
        $encryption = $this->model::findOrFail($id);
        if (Auth::user()->id != $encryption->user_id) return abort(401);

        return view('encrypt', ['data' => $encryption]);
    }
    public function encryptRSA(Encryption $request)
    {
        $validated = $request->validated();
        if ($request->encrypt_id) {
            if ($this->model::find($request->encrypt_id, 'user_id')->user_id != Auth::user()->id)
                return response()->json(['message' => 'Unauthorized'], 401);
        }
        $ciphertext = $this->vigenere($request->key, $request->message);
        $cipherkey = $this->RSA($request->key, $request->public_key);
        $data = [
            'user_id' => Auth::user()->id,
            'key' => trim($request->key),
            'message' => trim($request->message),
            'cipherkey' => trim($cipherkey),
            'ciphertext' => trim($ciphertext),
            'p' => $request->p,
            'q' => $request->q,
            'k' => $request->k,
            'factor_k' => $request->factor_k,
            'public_key' => trim($request->public_key),
            'private_key' => trim($request->private_key)
        ];
        try {
            if (!$request->encrypt_id) {
                $data['created_at'] = \Carbon\Carbon::now(); # new \Datetime()
                $id = $this->model::insertGetId($data);
                $data['encrypt_id'] = $id;
            } else {
                $this->model::where('id', $request->encrypt_id)->update($data);
                $data['encrypt_id'] = $request->encrypt_id;
            }
        } catch (Throwable $e) {
            report($e);
            return false;
        }
        return response()->json(['success' => true, 'data' => $data], 200);
    }
    public function steganography(Request $request)
    {
        if ($this->model::find($request->encrypt_id, 'user_id')->user_id != Auth::user()->id)
            return response()->json(['message' => 'Unauthorized'], 401);
        $fileName =  "image-" . Auth::user()->name . time();

        $request->image->storeAs('public', $fileName . '.' . $request->image->getClientOriginalExtension());
        // dd(getimagesize($request->image));
        if ($request->image->getClientOriginalExtension() == "jpg" || $request->image->getClientOriginalExtension() == "jpeg")
            $img = imagecreatefromjpeg($request->image);
        else if ($request->image->getClientOriginalExtension() == "png")
            $img = imagecreatefrompng($request->image);

        $encrypt = $this->model::findOrFail($request->encrypt_id);
        $cipherkey_l = str_pad(strlen($encrypt->cipherkey), 6, '0', STR_PAD_LEFT);
        $ciphertext_l = str_pad(strlen($encrypt->ciphertext), 6, '0', STR_PAD_LEFT);
        $text_length = $this->toBin($cipherkey_l . "-" . $ciphertext_l);
        $cipherkey_bin = $this->strigToBinary($encrypt->cipherkey);
        $ciphertext_bin = $this->strigToBinary($encrypt->ciphertext);
        $max_l = (strlen($cipherkey_bin) > strlen($ciphertext_bin)) ? strlen($cipherkey_bin) : strlen($ciphertext_bin);
        $y = 0;
        $i = 0;
        // dd((strlen($cipherkey_bin) > strlen($ciphertext_bin)) ? strlen($cipherkey_bin) : strlen($ciphertext_bin));
        while ($y < getimagesize($request->image)[1] && $i < $max_l) {
            $x = 0;
            while ($x < getimagesize($request->image)[0] && $i < $max_l) {
                $rgb = imagecolorat($img, $x, $y);

                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                if ($i < strlen($text_length)) {
                    $r_bin = $this->toBin($r);
                    $r_bin[strlen($r_bin) - 1] = $text_length[$i];
                    $r = $this->toString($r_bin);
                }
                if ($i < strlen($cipherkey_bin)) {
                    $g_bin = $this->toBin($g);
                    $g_bin[strlen($g_bin) - 1] = $cipherkey_bin[$i];
                    $g = $this->toString($g_bin);
                }
                if ($i < strlen($ciphertext_bin)) {
                    $b_bin = $this->toBin($b);
                    $b_bin[strlen($b_bin) - 1] = $ciphertext_bin[$i];
                    $b = $this->toString($b_bin);
                }

                imagesetpixel($img, $x, $y, imagecolorallocate($img, $r, $g, $b));

                $i++;
                $x++;
            }
            $y++;
        }
        try {
            if ($request->image->getClientOriginalExtension() == "jpg" || $request->image->getClientOriginalExtension() == "jpeg")
                imagejpeg($img, storage_path('app/public/' . $fileName . '_encrypted.' . $request->image->getClientOriginalExtension()));
            else if ($request->image->getClientOriginalExtension() == "png")
                imagepng($img, storage_path('app/public/' . $fileName . '_encrypted.' . $request->image->getClientOriginalExtension()));

            $data = [
                'original_img' => $fileName . '.' . $request->image->getClientOriginalExtension(),
                'encrypted_img' => $fileName . '_encrypted.' . $request->image->getClientOriginalExtension(),
                'upload_at' => \Carbon\Carbon::now()
            ];
            $this->model::where('id', $request->encrypt_id)->update($data);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
        // imagepng($img);

        return response()->json(['success' => true, 'data' => $data], 200);
    }
    private function strigToBinary($string)
    {
        $characters = str_split($string);

        $binary = [];
        foreach ($characters as $character) {
            $data = unpack('H*', $character);
            $binary[] = str_pad(base_convert($data[1], 16, 2), 8, 0, STR_PAD_LEFT);
        }

        return implode('', $binary);
    }
    private function toBin($a)
    {
        return str_pad(decbin($a), 8, 0, STR_PAD_LEFT);
    }
    private function toString($a)
    {
        return bindec($a);
    }
    private function maxint()
    {
        $bits = 1;
        $prev = 0;
        $sumM1 = 1;
        $sum = 2;

        while ($sumM1 < $sum) {
            $bits++;
            $prev = $sum;
            $sumM1 = $sumM1 + $sum;
            $sum = $sumM1 + 1;
        }
        return $prev - 1;
    }
    private function vigenere($key, $text)
    {
        // change key to strtolower for simplicity
        $pswd = str_replace(" ", "", $key);
        $pswd = strtolower($pswd);

        // intialize variables
        $code = "";
        $ki = 0;
        $kl = strlen($pswd);
        $length = strlen($text);

        // iterate over each line in text
        for ($i = 0; $i < $length; $i++) {
            // if the letter is alpha, encrypt it
            if (ctype_alpha($text[$i])) {
                // strtoupper
                if (ctype_upper($text[$i])) {
                    $text[$i] = chr(((ord($pswd[$ki]) - ord("a") + ord($text[$i]) - ord("A")) % 26) + ord("A"));
                }

                // strtolower
                else {
                    $text[$i] = chr(((ord($pswd[$ki]) - ord("a") + ord($text[$i]) - ord("a")) % 26) + ord("a"));
                }

                // update the index of key
                $ki++;

                if ($ki >= $kl) {
                    $ki = 0;
                }
            }
        }

        // return the encrypted code
        return $text;
    }
    private function RSA($text, $publicKey)
    {
        // $cipherKey = str_replace(" ", "", $text);
        $cipherKey = $text;
        $publicKey = str_replace("{", "", $publicKey);
        $publicKey = str_replace("}", "", $publicKey);
        $publicKey = str_replace(" ", "", $publicKey);
        $publicKey = explode(",", $publicKey);

        $e = $publicKey[0];
        $N = $publicKey[1];
        //$d = form.d.value
        $s = $cipherKey;
        $MAX_INT = $this->maxint();
        $blocksize = 0;
        $max = 255;
        while ($max < $N && $max < $MAX_INT) {
            $max = 1001 * $max;
            $blocksize++;
        }

        $offset = 0;
        $j = 0;
        $t = 0;
        $m = 0;
        $M = "";
        while ($offset >= 0) {
            $t = $this->ordutf8($s, $offset);
            $M .= $t . " ";
        }


        $m = explode(" ", $M);
        $t = "";
        $chr = "";
        $i = 0;
        while ($i < (count($m) - 1)) {

            $t .= $this->PowerMod($m[$i], $e, $N);
            //$t = (string)$t;
            $chr .= "&#" . $t;
            $chr .= " ";
            $t .= " ";
            $i++;
        }

        //echo $chr;
        return $t;
    }

    private function PowerMod($x, $p, $N)
    // Compute x^p mod N
    {
        $A = 1;
        $m = $p;
        $t = $x;

        while ($m > 0) {
            $k = floor($m / 2);
            $r = $m - 2 * $k;
            if ($r == 1)
                $A = ($A * $t) % $N;
            $t = ($t * $t) % $N;
            $m = $k;
        }

        return $A;
    }

    //

    private function ordutf8($string, &$offset)
    {
        $code = ord(substr($string, $offset, 1));
        if ($code >= 128) {                                                                            //otherwise 0xxxxxxx
            if ($code < 224) $bytesnumber = 2;                                                      //110xxxxx
            else if ($code < 240) $bytesnumber = 3;                                                 //1110xxxx
            else if ($code < 248) $bytesnumber = 4;                                                 //11110xxx
            $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
            for ($i = 2; $i <= $bytesnumber; $i++) {
                $offset++;
                $code2 = ord(substr($string, $offset, 1)) - 128;        //10xxxxxx
                $codetemp = $codetemp * 64 + $code2;
            }
            $code = $codetemp;
        }
        $offset += 1;
        if ($offset >= strlen($string)) $offset = -1;
        return $code;
    }
}
