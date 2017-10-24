<?php

include 'conn.php';

memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect");
//缓存服务器中，都是键值对，这里我们设定唯一的键
$key = md5('1');
$cache_result = array();
//根据键，从缓存服务器中获取它的值
$cache_result = $memcache->get($key);
//如果存在该键对应的值，说明缓存中存在该内容
if($cache_result){
	//那我们直接取出缓存的内容就可以了
	$demos_result=$cache_result;
} else {
	//如果缓存中没有该键对应的值数据，说明请求是第一次到达
	//首先，我们需要从数据库中取出该值
	$v=mysql_query("select * from testmem where id=1");
	while($row=mysql_fetch_array($v)){
		//取出的内容就是我们需要的
		$demos_result[]=$row;
	}
	//最后，将这次从数据库取出的内容，放到Memcached缓存服务器，这里就是缓存的精髓
	$memcache->set($key, $demos_result, MEMCACHE_COMPRESSED, 1200);
}

echo json_encode($demos_result);
