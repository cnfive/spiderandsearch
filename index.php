<?php
header('Content-Type: text/html; charset=UTF-8');
$query = isset($_REQUEST['q']) ? $_REQUEST['q'] : false;
$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : false;
//$query=
?>
<html>
  <head>
    <title>购物搜索</title>
    <style>
    <!--
    li { width:20px;padding:10px;margin:10px; border:1px solid blue;float:left;list-style:none;text-align:center;
       border-radius:5px;
       }
    #logo{ margin-left:auto;
            margin-right:auto;
            margin-top:0px;
text-align:center;


}
   
    -->
    </style>
  </head>
  <body>
        <img src="/ui/alateng.jpg" id="logo">
    <form  accept-charset="UTF-8" method="get">
      <label for="q">Search:</label>
      <input id="q" name="q" type="text" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'utf-8'); ?>"/>
      <input type="submit"/>
    </form>

<?php

class SolrSearch
{
    private $client= null;
    private $option= array('hostname' => '127.0.0.1', 'port' => '8983', 'login' => 'cnfive', 'password' => '108514901', 'path' => 'solr/spider_core', 'wt' => 'json');
    private $timeout= 500;

    function __construct($option = array())
    {
        if (false === empty($option)) $this->option = $option;
        $this->client = new SolrClient($this->option);
      //  var_dump($this->client);
    }

    public function tlist($params)
    {
        $conditions= (isset($params['conditions']) && !empty($params['conditions'])) ? trim($params['conditions']) : 'id:*';
        $start= (isset($params['start']) && !empty($params['start'])) ? intval($params['start']) : 0;
        $perPageCount=(isset($params['pagesize']) && !empty($params['pagesize'])) ? intval($params['pagesize']) : 30;
        $fieldstr=(isset($params['fieldstr']) && !empty($params['fieldstr'])) ? $params['fieldstr'] : 'id';
        $sort=(isset($params['sort']) && !empty($params['sort'])) ? $params['sort'] : '';
        $wt=(isset($params['wt'])) ? $params['wt'] : '';
        $ishighlight=(isset($params['ishighlight'])) ? $params['ishighlight'] : 0;
        $highlightfield=(isset($params['highlightfield'])) ? trim($params['highlightfield']) : '';

        $info=array('qtime' => 0, 'numFound' => 0, 'list' => array());
//查询
        try {
            $query = new SolrQuery();
            $query->setQuery($conditions)->setStart($start)->setRows($perPageCount)->setTimeAllowed($this->timeout);
            $query->addField($fieldstr); //显示的字段
            if (!empty($sort)) $query->setParam('sort', $sort);
            if ($ishighlight) {
//设置高亮
                $query->setHighlight(true);
                $query->setHighlightSimplePre('<span style="color:red">');
                $query->setHighlightSimplePost('</span>');
//高亮字段
                $highlightfield_arr = explode(',', $highlightfield);
                if (count($highlightfield_arr) > 0) {
                    foreach ($highlightfield_arr as $vv) {
                        $query->addHighlightField($vv);
                    }
                } else {
                    $info = array('qtime' => 0, 'numFound' => 0, 'list' => array(), 'msg' => '开启高亮显示，确没有合法的高亮字段');
                    return $info;
                }

                $query->setHighlightUsePhraseHighlighter(true);
                $query_response = $this->client->query($query);
            } else {
                $query_response = $this->client->query($query);
            }

            $query_response = $this->client->query($query);
            if ($query_response->getHttpStatus() == 200 && $query_response->success() == 1) {
                $response = json_decode(json_encode($query_response->getResponse()), true);
//高亮处理
                if ($ishighlight && count($highlightfield_arr) > 0) {
                    if (is_array($highlightfield_arr) && count($highlightfield_arr) > 0) {
                        foreach ($response['response']['docs'] as &$val) {
                            foreach ($highlightfield_arr as $vv) {
                                if (isset($response['highlighting'][$val['id']][$vv][0])) {
                                    $val[$vv] = $response['highlighting'][$val['id']][$vv][0];
                                }

                            }
                        }
                    } else {
                        $info = array('qtime' => 0, 'numFound' => 0, 'list' => array(), 'msg' => '开启高亮显示，确没有合法的高亮字段');
                        return $info;
                    }
                }

                $info = array('qtime' => $response['responseHeader']['QTime'], 'numFound' => $response['response']['numFound'], 'list' => $response['response']['docs']);
            } else {
                $info = array('qtime' => 0, 'numFound' => 0, 'list' => array());
            }
        } catch (Exception $e) {
            $info = array('qtime' => 0, 'numFound' => 0, 'list' => array());
        }
        return $info;
    }

    public function addDocument($data)
    {

    }
}

$obj= new SolrSearch();
$param= array();
if (!empty($query))
{
   $param['conditions']="s_title:".$query;
   $param['start']= $start;
   $param['fieldstr']= 'id,s_price,s_title,s_img,s_url,last_modify_date';
//$param['sort'] = 'id desc';
   $param['pagesize'] = 10;
  // $params['start']=$start ;
    //$perPageCount=
   $param['ishighlight']= true;
   $param['highlightfield'] = 'id,s_title';
   $res= $obj->tlist($param);
//echo '<pre>';
   echo "查找 <em style='color:red;'> ".$query."</em>  耗时：".$res["qtime"]."毫秒"." 找到".$res["numFound"]."条";
//print_r($res);
//echo '</pre>';
   $output="";
   foreach($res["list"] as $item )
       $output=$output."<p><a href='show.php?id=".$item["id"]."' target=_blank>".$item["s_title"]."</a><br>"."<img src='".$item["s_img"]."'><br>单价：".$item["s_price"]."  <a href='".$item["s_url"]."' target='_blank'>原址</a><br>".$item["last_modify_date"]."</p>";
       //$output=$output.$item["last_modify_date"]."</p>";
       echo $output;
    
    //输出分页
   echo "<ul id='pager'>";
   $pagecount=10  ;//10页
   if (ceil($res["numFound"]/$param['pagesize'])<$pagecount)
   {   
        $pagecount=ceil($res["numFound"]/$param['pagesize']);
   }
       
   for( $i=1;$i<= $pagecount;$i++)
       echo "<li><a href=s.php?q=".$query."&start=".$i." target=_self >".$i."</a></li>";
   echo "</ul>";
} 
?>
    </body></html>