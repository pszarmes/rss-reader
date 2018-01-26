<!DOCTYPE html>
<html lang="en" style="min-height:100%;height:100%;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            body { font-size: 170%; background-color: lightblue}
            a:visited { color: #a3bcd1; }
            .article {
              /*border: solid black 1px;*/
              padding: 1em 1.5em;
              background: #fff;
              padding-bottom: 0.5em;
              margin-bottom: 1em;
              -webkit-border-bottom-right-radius: 3px;
              -webkit-border-bottom-left-radius: 3px;
              -moz-border-radius-bottomright: 3px;
              -moz-border-radius-bottomleft: 3px;
              border-bottom-right-radius: 3px;
              border-bottom-left-radius: 3px;
              -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.18);
              -moz-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.18);
              box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.18);
              border-radius: 0.5em;
            }
        </style>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript">
            function load_rightpanel(itemURL) {
                $("#include").html('<object data="'+itemURL+'" style="width:100%;height:100vh;">');
            }
        </script> 
    </head>
    <body style="min-height:100%;height:100%;">
        <div class="container-fluid" style="width:100%;height:100%;">
            <div class="row" style="min-height:100%;height:100%;padding:10px">
                <div class="col-md-3">
                    <div class="row article" id="search_box" style="background-color:lightgray;border: solid gray 1px;">
                        <form role="form" method="post" action="index.php">
                            <div class="input-group stylish-input-group">
                                <input type="text" class="form-control" name="RSSurl" placeholder="Enter RSS url" >
                                <span class="input-group-addon">
                                <button type="submit" style="border:0;background:transparent;">
                                <span class="glyphicon glyphicon-search"></span>
                                </button>  
                                </span>
                            </div>
                        </form>&nbsp;example: http://feeds.bbci.co.uk/news/world/rss.xml
                    </div>

                <?php
                    $RSSurl = $_POST['RSSurl'];
                   
                    function getFreshContent($RSSurl) {
                        $html = "";
                        
                        function getFeed($url){
                            $rss = simplexml_load_file($url);

                            if (isset($rss->channel->image->url)){
                                $html .= '<p align="center"><br><img src='.htmlspecialchars($rss->channel->image->url).'><br>';
                            }
                            $html .= '<b>'.htmlspecialchars($rss->channel->title).'</b><br>'.htmlspecialchars($rss->channel->description).'<hr></p>';
                           
                            // $html .= '<ul>';
                            foreach($rss->channel->item as $item) {
                                $count++;
                                if($count > 7){
                                    break;
                                }
                                $html .= '<div class="article"><a href="javascript:load_rightpanel(\''.htmlspecialchars($item->link).'\');">'.htmlspecialchars($item->title).'</a>';
                                if (isset($item->author)){
                                    $html .= '<br><i>'.htmlspecialchars($item->author).'</i>';
                                }
                                $html .= '<br>'.strip_tags($item->description).'</div>';
                            }
                            // $html .= '</ul>';
                            return $html;
                        }
                        $html .= getFeed($RSSurl);
                        return $html;
                    }

                    if (isset($RSSurl)){
                        print getFreshContent($RSSurl);
                    }

                ?>
                </div>

                <div id="include" class="col-md-9"><img src="rss-reader-logo-icon.png" style="display:block;margin:0 auto;padding:30px"></div>
            </div>   
        </div>
    </body>
</html>