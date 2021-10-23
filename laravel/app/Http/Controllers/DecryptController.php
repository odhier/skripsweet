<?php

namespace App\Http\Controllers;

use App\Decryption;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DecryptController extends Controller
{
    private $model = Decryption::class;
    public function index()
    {
        return view('decrypt');
    }
    public function view($id)
    {
        $decryption = $this->model::findOrFail($id);
        if (Auth::user()->id != $decryption->user_id) return abort(401);

        return view('decrypt', ['data' => $decryption]);
    }
    public function history()
    {
        $decrypt = $this->model::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')->orderBy('updated_at', 'desc')->get();
        return view('decrypt_history', ['data' => $decrypt]);
    }
    public function decrypt(Request $request)
    {
        $textLength_bin = '';
        try {
            $fileName =  "image-" . Auth::user()->name . time();
            $request->file('image')->storeAs('public', $fileName . '.' . $request->image->getClientOriginalExtension());
        } catch (Throwable $e) {
            report($e);
            return "dadada";
        }
        if ($request->image->getClientOriginalExtension() == "jpg" || $request->image->getClientOriginalExtension() == "jpeg")
            $img = imagecreatefromjpeg($request->image);
        else if ($request->image->getClientOriginalExtension() == "png")
            $img = imagecreatefrompng($request->image);
        $y = 0;
        $i = 0;
        while ($y < getimagesize($request->image)[1] && $i < 104) {
            $x = 0;
            while ($x < getimagesize($request->image)[0] && $i < 104) {
                $rgb = imagecolorat($img, $x, $y);

                $r = ($rgb >> 16) & 0xFF;
                $r_bin = $this->toBin($r);
                $textLength_bin .= $r_bin[strlen($r_bin) - 1];
                $i++;
                $x++;
            }
            $y++;
        }
        $textLength = $this->binaryToString($textLength_bin);
        // dd($textLength);
        $textLength = explode("-", $textLength);
        $cipherText_bin = '';
        $cipherKey_bin = '';
        $max_l = ((intval($textLength[0]) > intval($textLength[1])) ? intval($textLength[0]) : intval($textLength[1])) * 8;
        $y = 0;
        $i = 0;
        while ($y < getimagesize($request->image)[1] && $i < $max_l) {
            $x = 0;
            while ($x < getimagesize($request->image)[0] && $i < $max_l) {
                $rgb = imagecolorat($img, $x, $y);

                $r = ($rgb >> 16) & 255;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                if ($i < (intval($textLength[0]) * 8)) {
                    //green is cipherkey
                    $g_bin = $this->toBin($g);
                    $cipherKey_bin .= $g_bin[strlen($g_bin) - 1];
                }
                if ($i < (intval($textLength[1]) * 8)) {
                    //blue is cipherkey
                    $b_bin = $this->toBin($b);
                    $cipherText_bin .= $b_bin[strlen($b_bin) - 1];
                }
                $i++;
                $x++;
            }
            $y++;
        }
        $cipherKey = $this->binaryToString($cipherKey_bin);
        $cipherText = $this->binaryToString($cipherText_bin);
        $key = $this->decryptRSA($cipherKey, $request->private_key);
        $message = $this->decryptVigenere($key, $cipherText);


        $data = [
            "user_id" => Auth::user()->id,
            "key" => $key,
            "message" => $message,
            "cipherkey" => $cipherKey,
            "ciphertext" => $cipherText,
            "private_key" => $request->private_key,
            "encrypted_img" => $fileName . '.' . $request->image->getClientOriginalExtension(),
            "upload_at" => \Carbon\Carbon::now(),
            "created_at" => \Carbon\Carbon::now()
        ];
        try {
            $id = $this->model::insertGetId($data);
            $data['encrypt_id'] = $id;
        } catch (Throwable $e) {
            dd($e);
            report($e);
            return false;
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }
    private function binaryToString($binary)
    {
        $binaries = str_split($binary, 8);;
        $string = null;
        foreach ($binaries as $binary) {
            $string .= pack('H*', dechex(bindec($binary)));
        }

        return $string;
    }
    private function toBin($a)
    {
        return str_pad(decbin($a), 8, 0, STR_PAD_LEFT);
    }
    private function toDec($a)
    {
        return bindec($a);
    }
    private function decryptRSA($C, $pk)
    {
        $pk = str_replace("{", "", $pk);
        $pk = str_replace("}", "", $pk);
        $pk = str_replace(" ", "", $pk);
        $pk = explode(",", $pk);
        $N = $pk[1];
        $d = $pk[0];
        $t = "";

        $re = "/\s+/";
        $spasi = array();
        $codeList = array();
        $codeList = explode(" ", $C);

        for ($i = 0; $i < count($codeList); $i++) {
            $t .= $this->PowerMod((int)($codeList[$i]), $d, $N) . " ";
        }
        $i = 0;
        $M = "";
        $width = 0;
        while (strlen($t) > 0) {
            $pos = strpos($t, " ");

            $m = substr($t, 0, $pos);

            while (strlen($m) > 0) {
                if (strlen($m) % 3 == 0)
                    $width = 3;
                else
                    $width = 2;
                $s = substr($m, 0, $width);

                while ($s[0] == "0") {
                    $s = substr($s, 1, strlen($s) - 1);
                }
                $M .= rawurldecode($this->Hex($s));

                $m = substr($m, $width, strlen($m));
            }
            $i = 1 + $pos;

            $t = substr($t, ($pos + 1), strlen($t));
        }

        return $M;
    }
    private function decryptVigenere($pswd, $text)
    {
        // change key to lowercase for simplicity
        $pswd = strtolower($pswd);

        // intialize variables
        $code = "";
        $ki = 0;
        $kl = strlen($pswd);
        $length = strlen($text);

        // iterate over each line in text
        for ($i = 0; $i < $length; $i++) {
            // if the letter is alpha, decrypt it
            if (ctype_alpha($text[$i])) {
                // uppercase
                if (ctype_upper($text[$i])) {
                    $x = (ord($text[$i]) - ord("A")) - (ord($pswd[$ki]) - ord("a"));

                    if ($x < 0) {
                        $x += 26;
                    }

                    $x = $x + ord("A");

                    $text[$i] = chr($x);
                }

                // lowercase
                else {
                    $x = (ord($text[$i]) - ord("a")) - (ord($pswd[$ki]) - ord("a"));

                    if ($x < 0) {
                        $x += 26;
                    }

                    $x = $x + ord("a");

                    $text[$i] = chr($x);
                }

                // update the index of key
                $ki++;
                if ($ki >= $kl) {
                    $ki = 0;
                }
            }
        }

        // return the decrypted text
        return $text;
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
    function Hex($n)
    {
        $digit = floor($n / 16);

        if ($digit == 0)
            return "%" . $this->HexDigit($n);
        else
            return $this->Hex($digit) . "" . $this->HexDigit($n - $digit * 16);
    }
    function HexDigit($n)
    {
        $equiv = array("A", "B", "C", "D", "E", "F");

        if ($n < 10)
            return $n;
        else if ($n < 16)
            return $equiv[$n - 10];
        else
            return "";
    }
}
