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
        $per_page = c::get('vimeo.videosperrequest');;
        $current_page =  get('page');

        //Request
        $vimeo = new \Vimeo\Vimeo($clientid, $clientsecret);
        $vimeo->setToken($token);
        $response = $vimeo->request('/me/videos', array('per_page' => $per_page, 'page'  => $current_page), 'GET');

        //Sort
        $videoitems = (array)$response['body']['data'];
        foreach ($videoitems as $videoitem) {
          //name
          $video['name'] = (string)$videoitem['name'];
          //videos
          foreach ($videoitem['files'] as $index => $item):
            $video[$item['quality']] = (string)$item['link'];
          endforeach;
          //thumbnails
          foreach ((array)$videoitem['pictures']['sizes'] as $item):
            $video['thumbnail'.$item['width']] = (string)$item['link'].'&';
          endforeach;
          //$video['html'] = $videoitem['embed']['html'];
          $videos[] = $video;
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
        $json->videos = $videos;
        return new Response(json_encode($json), 'json');

        }
      )
    )
);
