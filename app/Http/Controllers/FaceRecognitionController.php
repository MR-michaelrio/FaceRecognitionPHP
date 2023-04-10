<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Intervention\Image\ImageManagerStatic as Image;
use face_recognition\FaceRecognition;

class FaceRecognitionController extends Controller
{
    public function facerecognition(Request $request)
    {
        $data = $request->input('image');
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = base64_decode($data);
        $filename = 'image-' . time() . '.png';
        file_put_contents(public_path('images/' . $filename), $data);
        $client = new Client(['base_uri' => 'http://localhost:8000']);
        try {
            $response = $client->request('POST', '/face_recognition', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen(public_path('images/' . $filename), 'r'),
                        'filename' => $filename,
                    ],
                ],
            ]);

            unlink(public_path('images/' . $filename));
            $responseData = json_decode($response->getBody()->getContents(),true);

            if ($responseData['face'] == 'Recognize') {
                $message = 'Face recognized!';
            }elseif($responseData['face'] == 'NoRecognize'){
                $message = 'Face Not Recognized!';
            }
    
            return view('face-recognition')->with([
                'result' => $responseData,
                'message' => $message,
            ]);
            
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

}
