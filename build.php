<?

function GetChildren($vals, &$i)
{
	$children = array();
	if ($vals[$i]['value'])
		array_push($children, $vals[$i]['value']);

	while (++$i < count($vals)) { // so pra nao botar while true ;-)
		switch ($vals[$i]['type']) {
		case 'cdata':
			array_push($children, $vals[$i]['value']);
			break;

		case 'complete':
			array_push($children, array('tag' => $vals[$i]['tag'], 'value' => $vals[$i]['value']));
			break;

		case 'open':
			array_push($children, array('tag' => $vals[$i]['tag'], 'children' => GetChildren($vals, $i)));
			break;

		case 'close':
			return $children;
		}
	}
}

function GetXMLTree($file)
{
	$data = implode('', file($file));
	$p = xml_parser_create();
	xml_parser_set_option($p, XML_OPTION_SKIP_WHITE, 0);
	xml_parse_into_struct($p, $data, &$vals, &$index);
	xml_parser_free($p);

	$tree = array();
	$i = 0;
	array_push($tree, array('tag' => $vals[$i]['tag'], 'children' => GetChildren($vals, $i)));
	return $tree;
}

function GetVocab($file) {
	$num = 0;

	for ($file = 1; $file <= 40; $file++) {
		$xmldict = GetXMLTree("dict/$file");

		for ($i = 0; $i < sizeof($xmldict[0]['children']); $i++) {
			if (strcasecmp($xmldict[0]['children'][$i]['tag'], "ENTRY"))
				continue;
			for ($j = 0; $j < sizeof($xmldict[0]['children'][$i]['children']); $j++) {
				$tag = $xmldict[0]['children'][$i]['children'][$j]['tag'];
				if (strlen($tag) == 1)
					continue;
				$value = $xmldict[0]['children'][$i]['children'][$j]['value'];
				$vocab[$num][$tag] = $value;
			}
			$num++;
		}
	}
	return $vocab;
}

$vocab = GetVocab($file);

?>
