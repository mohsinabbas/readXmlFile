<?php

$yourStartingPath = $_SERVER['DOCUMENT_ROOT'].'/readXmlFile';
$directories = scandir($yourStartingPath);

$html = '';

foreach($directories as $directory){
	if($directory=='.' or $directory=='..' or !is_dir($directory)){
		//do nothing
	}else{		
		$filesArray = listFiles($directory); 
		$html .= '<p>Folder Name :'.$directory.'</p>';
		
		
		foreach($filesArray as $file)
		{	
			if($file=='.' or $file=='..'){
				//do nothing
			}
			else
			{	
				$path = $yourStartingPath."/$directory/".$file;				
				$xmlArray = readXml($path);
								
				foreach($xmlArray as $child)
			    {
					
					if($child->getName() == 'u')
					{
						$html .= '<p>URL : '.$child.'</p>';
					}
					elseif($child->getName() == 'o')
					{
						$html .= '<p>Grade : '.$child.'</p>';
					}
					elseif($child->getName() == 'g')
					{	
						$table = '<table width="100%" border="1" cellspacing="0" cellpadding="0">
										<tr>
											<th>Label</th>
											<th>Score</th>
											<th>Message</th>
											<th>components</th>
										</tr>';
						foreach($child as $content)
			    		{							
							$label = $content->getName();
							$lab = replaceKey($label);
							$tds = $ul = '';							
							foreach($content as $scores)
				    		{
								if($scores->getName() == 'components')
								{
									$ul .= '<ul>';
									foreach($scores as $components)
				    				{
										$ul .= '<li>'.$components.'</li>';
									}	
									$ul .= '</ul>';									
									$tds .= '<td>'.$ul.'</td>';
								}
								else
								{
									$tds .= '<td>'.$scores.'</td>';
								}								
								
							}
							$table .= '<tr>
										<td>'.$lab.'</td>
										'.$tds.'
								  </tr>';
						}
							
						$table .= '</table>';
						
						$html .= $table;						
					}//else
					
			  	}//foreach
				
				
			}
			
			
		}//end of foreach
		
		
		
	}//end of else
	
} //end of foreach

echo $html;	


function listFiles($dir)
{
	$files = scandir($dir, 1);
	
	return $files;
}

function readXml($path)
{	
	$xml=simplexml_load_file($path);
	$value = $xml->children();

	return $value;
}


function replaceKey($key)
{
	$labels = array('ynumreq' => 'Make fewer HTTP Requests',
					'ycdn' => 'Use a Content Delivery Network(CDN)',
					'yemptysrc' => 'Avoid empty src or href',
					'yexpires' => 'Add Expires headers',
					'ycompress' => 'Compress components with gzip',
					'ycsstop' => 'Put CSS at top',
					'yjsbottom' => 'Put JavaScript at bottom',
					'yexpressions' => 'Avoid CSS expressions',
					'yexternal' => 'Make JavaScript and CSS external',
					'ydns' => 'Reduce DNS lookups',
					'yminify' => 'Minify JavaScript and CSS',
					'yredirects' => 'Avoid URL redirects',
					'ydupes' => 'Remove duplicate JavasScript and CSS',
					'yetags' => 'Configure entity tags (ETags)',
					'yxhr' => 'Make AJAX cacheable',
					'yxhrmethod' => 'Use GET for AJAX requests',
					'ymindom' => 'Reduce the number of DOM elements',
					'yno404' => 'Avoid HTTP 404 (Not Found) error',
					'ymincookie' => 'Reduce cookie size',
					'ycookiefree' => 'Use cookie-free domains',
					'ynofilter' => 'Avoid AlphaImageLoader filter',
					'yimgnoscale' => 'Do not scale images in HTML',
					'yfavicon' => 'Make favicon small and cacheable');
		
		
	$value = '';				
	foreach($labels as $orgKey => $replaceVal)
	{
		if($orgKey == $key)		
		$value = $replaceVal;		
	}				
		
		
	return $value;	
		
}


 ?>