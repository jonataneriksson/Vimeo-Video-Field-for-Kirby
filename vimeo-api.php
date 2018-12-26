<?php

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* !API */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

kirby()->routes(
  array(
    array(
      'pattern' => 'vimeo.json',
      'action'  => function() {

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
        /* !Return object */
        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        $json = (object)[];
        $before = microtime(true);

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
        /* !Vimeo API load */
        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        require_once 'vendor/autoload.php';

        //Initialize
        $clientid = c::get('vimeo.clientid');
        $clientsecret = c::get('vimeo.clientsecret');
        $token = c::get('vimeo.token');
        $per_page = c::get('vimeo.videosperrequest');
        $current_page =  get('page');
        $privacy = c::get('vimeo.privacy');
        $query = c::get('vimeo.query');

        $params = [
          'page'  => $current_page,
          'per_page' => $per_page,
          'query' => $query
        ];

        //Request
        $vimeo = new \Vimeo\Vimeo($clientid, $clientsecret);
        $vimeo->setToken($token);
        $response = $vimeo->request('/me/videos', $params, 'GET');
        //Sort
        if(isset($response['body']['data'])){
          $videoitems = (array)$response['body']['data'];

          foreach ($videoitems as $videoitem) {
            //name
              $video['name'] = (string)$videoitem['name'];
              $video['duration'] = (string)$videoitem['duration'];
              $video['width'] = (string)$videoitem['width'];
              $video['height'] = (string)$videoitem['height'];
              //videos
              foreach ($videoitem['files'] as $index => $item):
                $video[$item['quality']] = (string)$item['link'];
              endforeach;
              //thumbnails
              foreach ((array)$videoitem['pictures']['sizes'] as $item):
                $video['thumbnail'.$item['width']] = (string)$item['link'].'&';
              endforeach;
              //Return
              $json->videos[] = $video;
          }

          //Meta
          $total = $response['body']['total'];
          $pages = ceil($total/$per_page);
          $pagesleft = $pages;
          $after = microtime(true);
          $meta['loadtime'] = $after - $before;
          $meta['pages'] = ceil($total/$per_page);
          $meta['totalvideos'] = $total;

          //Response
          $json->meta = $meta;
          //$json->videos = $videos;
        }

        return new Response(json_encode($json), 'json');

        }
      )
    )
);
