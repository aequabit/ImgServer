<?php
/**
 * These are the app's routes.
 */
$app->get('/', function () use ($app, $config) {
    $app->response->redirect($config['settings']['homepage']);
});

$app->get('/:url', function ($url) use ($app) {
    $image = \ImgServer\Models\Image::where('url', $url)->first();

    if ($image == null) {
        $app->notFound();
    }

    $app->response->headers->set('Content-Type', $image->mime_type);
    $app->response->write(base64_decode($image->hash));
});

$app->map('/api/:action', function ($action) use ($app, $config) {
    /*
$path = 'myfolder/myimage.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
 */

 /*
  * Set response header to JSON
  */
    $app->response->headers->set('Content-Type', 'application/json');

/*
 * If an image is being deleted.
 */
    if ($action == 'delete') {
        if (!isset($_REQUEST['url']) || empty($_REQUEST['url'])) {
            return $app->response->write(json_encode([
                        'status' => 'error',
                        'response' => 'No URL given.',
                    ]));
        }
        $url = $_REQUEST['url'];

        if (!isset($_REQUEST['key']) || empty($_REQUEST['key'])) {
            return $app->response->write(json_encode([
                        'status' => 'error',
                        'response' => 'Invalid key given.',
                    ]));
        }
        $key = $_REQUEST['key'];

        $image = \ImgServer\Models\Image::where('url', $url)->first();

        if ($image == null) {
            return $app->response->write(json_encode([
                        'status' => 'error',
                        'response' => 'Image does not exist.',
                    ]));
        }

        if ($key != $image->delkey) {
            return $app->response->write(json_encode([
                      'status' => 'error',
                      'response' => 'Invalid key given.',
                  ]));
        }

        $image->delete();

        return $app->response->write(json_encode([
                    'status' => 'success',
                    'response' => 'Image deleted.',
              ]));
    } elseif ($action == 'make') {
      /*
       * Get and validate the api key.
       */
        if (!isset($_REQUEST['apikey'])) {
            return $app->response->write(json_encode([
                  'status' => 'error',
                  'response' => 'No API key given.',
              ]));
        }
        if (strlen($_REQUEST['apikey']) < 3 || $_REQUEST['apikey'] != $config['settings']['apikey']) {
            return $app->response->write(json_encode([
                  'status' => 'error',
                  'response' => 'Invalid API key.',
              ]));
        }
        $key = $_REQUEST['apikey'];

        if (!isset($_FILES['image'])) {
            return $app->response->write(json_encode([
                  'status' => 'error',
                  'response' => 'No image given.',
              ]));
        }

        $image = $_FILES['image'];
        $mime_type = $image['type'];
        $hash = base64_encode(file_get_contents($image['tmp_name']));
        $delkey = substr(
            str_shuffle(
                $config['settings']['random']['chars']
            ),
            rand(0, 62 - $config['settings']['random']['length']),
            $config['settings']['random']['length']
        );

        while (true) {
            $url = substr(
                str_shuffle(
                    $config['settings']['random']['chars']
                ),
                rand(0, 62 - $config['settings']['random']['length']),
                $config['settings']['random']['length']
            );
            if (\ImgServer\Models\Image::where('url', $url)->first() == null) {
                break;
            }
        }

        $entry = \ImgServer\Models\Image::create([
          'url' => $url,
        ]);
        $entry->update([
          'mime_type' => $mime_type,
          'hash' => $hash,
          'delkey' => $delkey,
        ]);

        $app->response->setStatus(201);

        return $app->response->write(json_encode([
          'status' => 'success',
          'response' => [
            'baseurl' => $app->config('baseUrl'),
            'url' => $url,
            'delkey' => $delkey
          ],
        ]));
    } else {
        return $app->response->write('invalid action');
    }
})->via('GET', 'POST');

$app->post('/api/get', function () use ($app) {
    echo 'Get: ';
});
